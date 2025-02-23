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
{{-- @vite(['resources/js/app.js','resources/js/pembayaran.js']) --}}
@vite('resources/js/pembayaran.js')
{{-- @vite(['resources/js/app.js', 'resources/js/pembayaran.js']) --}}

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