@extends('layouts.app')
@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden mt-14 lg:mt-20">
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Error!</p>
                <p>{{ $errors->first() }}</p>
            </div>
        @endif

        <div class="p-6 ">
            <h1 class="text-2xl font-bold mb-4">PEMBAYARAN PIUTANG</h1>
            <form method="POST" action="{{ route('pembayaran-piutang.proses') }}" id="paymentForm"
                data-store-url="{{ route('pembayaran-piutang.store') }}">
                @csrf
                <input type="hidden" name="_method" value="POST">

                <div class="flex items-center gap-3 mb-4 flex-wrap">
                    <div class="">
                        <label for="tanggal_transaksi" class="block text-sm font-medium text-gray-700 mb-1">Tanggal
                            Transaksi</label>
                        <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"
                            value="{{ old('tanggal_transaksi', now()->format('Y-m-d')) }}"
                            class="w-64 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            required>
                    </div>

                    <!-- Dropdown Pelanggan -->
                    <div class="mb-1">
                        <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Pilih Perusahaan</label>
                        <select name="company" id="company"
                            class="w-64 border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            onchange="loadCustomersByCompany(this.value)">
                            <option value="">-- Pilih Perusahaan --</option>
                            @foreach ($company as $perusahaan)
                                <option value="{{ $perusahaan->company_id }}"
                                    {{ $selectedCustomerId == $perusahaan->company_id ? 'selected' : '' }}>
                                    {{ $perusahaan->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-1">
                        <label for="customer" class="block text-sm font-medium text-gray-700 mb-1">Pilih Pelanggan</label>
                        <select name="customer" id="customer"
                            class="w-64 border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            onchange="loadInvoicesByCustomer(this.value)">
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->idpelanggan }}"
                                    {{ $selectedCustomerId == $customer->idpelanggan ? 'selected' : '' }}>
                                    {{ $customer->customer_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="overflow-x-auto mb-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nomor Invoice</th>

                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jatuh Tempo</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Piutang</th>
                                <th
                                    class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                                    Diskon</th>
                                <th
                                    class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                                    Denda</th>
                                <th
                                    class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">
                                    Total Piutang</th>
                                <th class="px-3 py-2"></th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="invoice-container">
                            <!-- Rows will be dynamically populated -->
                        </tbody>
                    </table>
                </div>

                <!-- Fields for Total Piutang and Payment -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="mode_bayar" class="block text-sm font-medium text-gray-700 mb-1">Mode Bayar</label>
                        <select id="mode_bayar" name="mode_bayar"
                            class="w-full p-2 bg-white border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Pilih Metode Pembayaran</option>
                            <option value="KAS">KAS</option>
                            <option value="BANK">BANK</option>
                        </select>
                    </div>
                    <div>
                        <label for="total_piutang" class="block text-sm font-medium text-gray-700 mb-1">Total Semua
                            Piutang</label>
                        <input type="text" id="total-piutang"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-lg font-bold"
                            placeholder="Total Piutang" readonly>
                        <input type="number" name="total_piutang" class="hidden" value="{{ old('total_piutang') }}">
                    </div>
                </div>

                <div class="mb-6">
                    <label for="nominal_dibayar" class="block text-sm font-medium text-gray-700 mb-1">Nominal yang
                        Dibayar</label>
                    <input type="text" id="nominalDibayarDisplay"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-lg font-bold"
                        placeholder="Nominal yang Dibayar">
                    <input type="number" name="nominal_dibayar" id="nominalDibayar" class="hidden"
                        value="{{ old('nominal_dibayar') }}">
                </div>

                <div class="flex justify-end space-x-2">

                    <button type="button" onclick="submitForm('store')"
                        class="active:scale-[.95] hover:bg-white hover:text-[#0F8114] transition-all text-white font-medium border-2 border-[#0F8114] rounded-md shadow-sm px-4 py-1 bg-[#0F8114]">Bayar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
{{-- @vite('resources/js/test.js') --}}

<script>
    function loadCustomersByCompany(companyId) {
        // Cari elemen dropdown pelanggan berdasarkan ID
        const customerDropdown = document.getElementById('customer');

        // Reset dropdown pelanggan
        customerDropdown.innerHTML = '<option value="">-- Pilih Pelanggan --</option>';

        if (!companyId) return;

        // Fetch customers by company ID
        fetch(`/api/customers-by-company/${companyId}`)
            .then(response => response.json())
            .then(data => {
                data.customers.forEach(customer => {
                    const option = document.createElement('option');
                    option.value = customer.idpelanggan;
                    option.textContent =
                        `${customer.customer_name}`;
                    customerDropdown.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading customers:', error);
            });
    }


    function loadInvoicesByCustomer(customerId) {
        const invoiceContainer = document.getElementById('invoice-container');
        invoiceContainer.innerHTML = '';

        if (!customerId) return;

        fetch(`/api/invoices-by-customer/${customerId}`)
            .then(response => response.json())
            .then(data => {
                let totalPiutang = 0;

                data.invoices.forEach((invoice, index) => {
                    totalPiutang += parseFloat(invoice.total);

                    const row = `
<tr class="invoice-row" data-total="${invoice.total}">
<td class="px-3 py-2">
    <input type="text" name="invoices[${index}][nomor_invoice]"
        class="invoice-input border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
        value="${invoice.no_invoice}" readonly>
</td>
<td class="px-3 py-2">
    <input type="date" name="invoices[${index}][jatuh_tempo]"
        class="invoice-input border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
        value="${invoice.tgl_jatuh_tempo}" readonly>
</td>
<td class="px-3 py-2">
    <input type="text"
        class="piutang-input border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
        value="${formatRupiah(parseFloat(invoice.tagihan))}" readonly>
    <input type="hidden" name="invoices[${index}][piutang_belum_dibayar]" class="piutang-value" value="${parseFloat(invoice.tagihan)}">
</td>
<td class="px-3 py-2">
<input type="text"
class="diskon-input border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
value="${formatRupiah(parseFloat(invoice.diskon))}"
onchange="updateRowTotal(this)"
onfocus="removeFormatting(this)"
onblur="applyFormatting(this)">
<input type="hidden" name="invoices[${index}][diskon]" class="diskon-value" value="${parseFloat(invoice.diskon)}">
</td>
<td class="px-3 py-2">
    <input type="text"
class="denda-input border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
value="${formatRupiah(parseFloat(invoice.denda))}"
onchange="updateRowTotal(this)"
onfocus="removeFormatting(this)"
onblur="applyFormatting(this)">
<input type="hidden" name="invoices[${index}][denda]" class="denda-value" value="${parseFloat(invoice.denda)}">
</td>
<td class="px-3 py-2">
    <input type="text"
        class="total-display border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
        value="${formatRupiah(parseFloat(invoice.total))}" readonly>
    <input type="hidden" name="invoices[${index}][total]" class="total-value" value="${parseFloat(invoice.total)}">
</td>
<td class="px-3 py-2">
    <button type="button" class="delete-btn" data-total="${parseFloat(invoice.total)}">
        <svg class="h-5 w-5 fill-red-600" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                clip-rule="evenodd" />
        </svg>
    </button>
</td>
</tr>`;

                    invoiceContainer.insertAdjacentHTML('beforeend', row);
                    const deleteButton = invoiceContainer.lastElementChild.querySelector('.delete-btn');
                    deleteButton.addEventListener('click', function() {
                        const row = this.closest('tr');
                        row.remove();
                        reindexInvoiceInputs();
                        updateTotalPiutang();
                    });
                    updateTotalPiutang();
                });

            });


    }

    function removeFormatting(input) {
        input.value = unformatRupiah(input.value);
    }

    function applyFormatting(input) {
        const value = parseInt(input.value) || 0;
        input.value = formatRupiah(value);
        const row = input.closest('tr');
        row.querySelector('.piutang-value').value = value;
        updatePenaltyAndDiscount(input, input.closest('tr').rowIndex);
    }

    function updateRowTotal(input) {
        const row = input.closest('tr');
        const piutangValue = parseInt(unformatRupiah(row.querySelector('.piutang-input').value)) || 0;
        const diskonValue = parseInt(unformatRupiah(row.querySelector('.diskon-input').value)) || 0;
        const dendaValue = parseInt(unformatRupiah(row.querySelector('.denda-input').value)) || 0;

        // Update hidden values
        row.querySelector('.diskon-value').value = diskonValue;
        row.querySelector('.denda-value').value = dendaValue;

        const newTotal = piutangValue - diskonValue + dendaValue;

        row.querySelector('.total-display').value = formatRupiah(newTotal);
        row.querySelector('.total-value').value = newTotal;

        updateTotalPiutang();
    }

    function updateTotalPiutang() {
        let total = 0;
        document.querySelectorAll('.total-value').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('total-piutang').value = formatRupiah(total);
        document.querySelector('input[name="total_piutang"]').value = total;
    }

    function formatRupiah(number) {
        const roundedNumber = Math.floor(number);
        return `Rp ${roundedNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
    }

    function unformatRupiah(rupiahString) {
        return parseInt(rupiahString.replace(/[^0-9]/g, ""), 10) || 0;
    }

    // Event listener for manual changes in diskon and denda
    document.addEventListener('input', function(event) {
        if (event.target.classList.contains('diskon-input') || event.target.classList.contains('denda-input')) {
            updateRowTotal(event.target);
        }
    });


    function formatRupiah(number) {
        const roundedNumber = Math.floor(number);
        return `Rp ${roundedNumber.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
    }

    function unformatRupiah(rupiahString) {
        return parseInt(rupiahString.replace(/[^0-9]/g, ""), 10) || 0;
    }

    function reindexInvoiceInputs() {
        const rows = document.querySelectorAll('.invoice-row');
        rows.forEach((row, index) => {
            const inputs = row.querySelectorAll('input[name^="invoices["]');
            inputs.forEach(input => {
                const oldName = input.name;
                const fieldName = oldName.match(/\[([^\]]+)\]$/)[1];
                input.name = `invoices[${index}][${fieldName}]`;
            });
        });
    }

    function submitForm(action) {
        const form = document.getElementById('paymentForm');
        if (action === 'proses') {
            form.action = form.dataset.prosesUrl;
        } else {
            form.action = form.dataset.storeUrl;
        }
        form.submit();
    }
</script>

@endpush









{{-- responsif dikit --}}

{{-- @extends('layouts.app')
@section('content')
    <div class="bg-white shadow-md rounded-lg overflow-hidden mx-auto max-w-7xl p-6">
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p class="font-bold">Error!</p>
                <p>{{ $errors->first() }}</p>
            </div>
        @endif

        <h1 class="text-2xl font-bold mb-6 text-center">PEMBAYARAN PIUTANG</h1>
        <form method="POST" action="{{ route('pembayaran-piutang.proses') }}" id="paymentForm"
            data-store-url="{{ route('pembayaran-piutang.store') }}">
            @csrf
            <input type="hidden" name="_method" value="POST">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label for="tanggal_transaksi" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Transaksi</label>
                    <input type="date" name="tanggal_transaksi" id="tanggal_transaksi"
                        value="{{ old('tanggal_transaksi', now()->format('Y-m-d')) }}"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        required>
                </div>

                <div>
                    <label for="company" class="block text-sm font-medium text-gray-700 mb-1">Pilih Perusahaan</label>
                    <select name="company" id="company"
                        class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        onchange="loadCustomersByCompany(this.value)">
                        <option value="">-- Pilih Perusahaan --</option>
                        @foreach ($company as $perusahaan)
                            <option value="{{ $perusahaan->company_id }}"
                                {{ $selectedCustomerId == $perusahaan->company_id ? 'selected' : '' }}>
                                {{ $perusahaan->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="customer" class="block text-sm font-medium text-gray-700 mb-1">Pilih Pelanggan</label>
                    <select name="customer" id="customer"
                        class="w-full border-gray-300 rounded-md shadow-sm p-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                        onchange="loadInvoicesByCustomer(this.value)">
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($customers as $customer)
                            <option value="{{ $customer->idpelanggan }}"
                                {{ $selectedCustomerId == $customer->idpelanggan ? 'selected' : '' }}>
                                {{ $customer->customer_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto mb-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Invoice</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jatuh Tempo</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Piutang</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Diskon</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Denda</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Total Piutang</th>
                            <th class="px-3 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200" id="invoice-container">
                        <!-- Rows will be dynamically populated -->
                    </tbody>
                </table>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="mode_bayar" class="block text-sm font-medium text-gray-700 mb-1">Mode Bayar</label>
                    <select id="mode_bayar" name="mode_bayar"
                        class="w-full p-2 bg-white border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="">Pilih Metode Pembayaran</option>
                        <option value="KAS">KAS</option>
                        <option value="BANK">BANK</option>
                    </select>
                </div>
                <div>
                    <label for="total_piutang" class="block text-sm font-medium text-gray-700 mb-1">Total Semua Piutang</label>
                    <input type="text" id="total-piutang"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-lg font-bold"
                        placeholder="Total Piutang" readonly>
                    <input type="number" name="total_piutang" class="hidden" value="{{ old('total_piutang') }}">
                </div>
            </div>

            <div class="mb-6">
                <label for="nominal_dibayar" class="block text-sm font-medium text-gray-700 mb-1">Nominal yang Dibayar</label>
                <input type="text" id="nominalDibayarDisplay"
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-lg font-bold"
                    placeholder="Nominal yang Dibayar">
                <input type="number" name="nominal_dibayar" id="nominalDibayar" class="hidden"
                    value="{{ old('nominal_dibayar') }}">
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" onclick="submitForm('store')"
                    class="active:scale-[.95] hover:bg-white hover:text-[#0F8114] transition-all text-white font-medium border-2 border-[#0F8114] rounded-md shadow-sm px-4 py-1 bg-[#0F8114]">Bayar</button>
            </div>
        </form>
    </div>
@endsection
@push('scripts')
@vite('resources/js/test.js')
@endpush --}}