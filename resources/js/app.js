// Import statements
import './bootstrap';
import 'flowbite';

// Fungsi-fungsi utilitas
function formatNumber(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

function parseNumber(string) {
    return parseFloat(string.replace(/\./g, '').replace(',', '.')) || 0;
}

function formatRupiah(angka) {
    let number_string = angka.toString().replace(/[^,\d]/g, ''),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }
    return 'Rp ' + rupiah + (split[1] !== undefined ? ',' + split[1] : '');
}

function unformatRupiah(rupiahString) {
    return parseFloat(rupiahString.replace(/[^\d,]/g, '').replace(/\./g, '').replace(',', '.')) || 0;
}

function formatCurrency(inputDisplay, inputHidden) {
    let value = inputDisplay.value.replace(/[^,\d]/g, '');
    if (!value) {
        inputDisplay.value = '';
        inputHidden.value = '';
        return;
    }

    const numberString = value.replace(/[^,\d]/g, '').toString();
    const split = numberString.split(',');
    const sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    const ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        const separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;

    inputDisplay.value = 'Rp ' + rupiah;
    inputHidden.value = value;
}

// Fungsi-fungsi inisialisasi
function initializeDateCalculations() {
    const tanggalTransaksiInput = document.getElementById('tanggal_transaksi');
    const jatuhTempoInput = document.getElementById('jatuh_tempo');
    const jarakHariInput = document.getElementById('jarak_hari');

    function updateJarakHari() {
        const tanggalTransaksi = new Date(tanggalTransaksiInput.value);
        const jatuhTempo = new Date(jatuhTempoInput.value);

        if (tanggalTransaksi && jatuhTempo) {
            const diffTime = Math.abs(jatuhTempo - tanggalTransaksi);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            jarakHariInput.value = diffDays;
        }
    }

    function updateJatuhTempo() {
        const tanggalTransaksi = new Date(tanggalTransaksiInput.value);
        const jarakHari = parseInt(jarakHariInput.value, 10);

        if (tanggalTransaksi && !isNaN(jarakHari)) {
            const jatuhTempo = new Date(tanggalTransaksi);
            jatuhTempo.setDate(jatuhTempo.getDate() + jarakHari);
            jatuhTempoInput.value = jatuhTempo.toISOString().split('T')[0];
        }
    }

    tanggalTransaksiInput.addEventListener('change', updateJarakHari);
    jatuhTempoInput.addEventListener('change', updateJarakHari);
    jarakHariInput.addEventListener('input', updateJatuhTempo);
}

function initializeTaxCalculation() {
    const dppInput = document.getElementById('dpp');
    const ppnValueInput = document.getElementById('ppn_value');
    const totalPiutangInput = document.getElementById('total_piutang');
    const ppnCheckbox = document.getElementById('ppn_checkbox');
    const pajakTypeSelect = document.getElementById('pajak_type');
    const tarifSelect = document.getElementById('tarif');
  

    function updateTaxCalculation() {
        let dpp = parseNumber(dppInput.value);
        let ppnTotal = 0;
        let pphTotal = 0;

        // Cek jika PPN dicentang
        if (ppnCheckbox.checked) {
            const ppnValue = 11; // Misalnya PPN 10%
            ppnTotal = (dpp * ppnValue / 100); // Menghitung PPN
        }

        // Menghitung PPh dari pilihan
        const selectedPajak = pajakTypeSelect.value;
        if (selectedPajak !== "Tidak Ada" && tarifSelect.value) {
            const tarifValue = parseFloat(tarifSelect.value);
            pphTotal = (dpp * tarifValue / 100); // Menghitung PPh
        }

        // Update nilai PPN yang terhitung
        const ppnAfterTax = ppnTotal - pphTotal;
            ppnValueInput.value = formatNumber(ppnAfterTax.toFixed(2)); // Update nilai PPN

            // Hitung total piutang
            let totalPiutang = dpp + ppnAfterTax; // Total piutang = DPP + PPN setelah dikurangi PPh
            totalPiutangInput.value = formatNumber(totalPiutang.toFixed(2));
    }

    function handleDPPInput(e) {
        let value = e.target.value.replace(/\D/g, '');
        let formattedValue = value === '' ? '0' : formatNumber(parseInt(value, 10));
        e.target.value = formattedValue;
        updateTaxCalculation();
    }

    dppInput.addEventListener('input', handleDPPInput);
    ppnCheckbox.addEventListener('change', updateTaxCalculation);
    pajakTypeSelect.addEventListener('change', updateTaxCalculation);
    tarifSelect.addEventListener('change', updateTaxCalculation);

    updateTaxCalculation();
}

function initializeJenisTagihan() {
    const jenisTagihanSelect = document.getElementById('jenis_tagihan');
    const jumlahKaliContainer = document.getElementById('jumlah_kali_container');

    function toggleJumlahKali() {
        jumlahKaliContainer.style.display = jenisTagihanSelect.value === 'berulang' ? 'block' : 'none';
    }

    jenisTagihanSelect.addEventListener('change', toggleJumlahKali);
    toggleJumlahKali();
}



function initializeCurrencyInput() {
    
}

// Fungsi untuk menambah dan menghapus baris invoice
function addInvoiceRow() {
    const container = document.getElementById('invoice-container');
    const index = container.querySelectorAll('.invoice-row').length;
    const newRow = `
    <tr class="invoice-row">
        <td class="px-3 py-2">
            <input type="text" name="invoices[${index}][nomor_invoice]"
                class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
                placeholder="Nomor Invoice" required>
        </td>
        <td class="px-3 py-2">
            <input type="text" name="invoices[${index}][nama_pelanggan]"
                class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
                placeholder="Nama Pelanggan" readonly>
            <input type="hidden" name="invoices[${index}][idpelanggan]">
        </td>
        <td class="px-3 py-2">
            <input type="date" name="invoices[${index}][jatuh_tempo]"
                class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
                readonly>
        </td>
        <td class="px-3 py-2">
            <input type="text" name="invoices[${index}][piutang_belum_dibayar]"
                class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
                placeholder="Piutang Belum Dibayar" readonly>
        </td>
        <td class="px-3 py-2">
            <input type="text"
                class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
                placeholder="Diskon" readonly>
            <input type="hidden" name="invoices[${index}][diskon]">
        </td>
        <td class="px-3 py-2">
            <input type="text"
                class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
                placeholder="Denda" readonly>
            <input type="hidden" name="invoices[${index}][denda]">
        </td>
        <td class="px-3 py-2">
            <input type="text" name="invoices[${index}][amount_to_pay]"
                class="border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
                placeholder="Total Piutang" readonly>
        </td>
        <td class="px-3 py-2">
            <button type="button" class="text-red-600 hover:text-red-800" onclick="removeInvoiceRow(this)">
                <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
        </td>
    </tr>
`;
container.insertAdjacentHTML('beforeend', newRow);

}

function removeInvoiceRow(button) {
    const row = button.closest('.invoice-row');
    row.remove();
}

// Fungsi untuk menangani pengiriman formulir
function submitForm(action) {
    const form = document.getElementById('paymentForm');
    
    const procesUrl = form.getAttribute('data-proses-url');
    const storeUrl = form.getAttribute('data-store-url');

    if (action === 'proses') {
        form.action = procesUrl;
        form.method = 'GET';
    } else {
        form.action = storeUrl;
        form.method = 'POST';
    }
    form.submit();
}

function handleEnter(event, action) {
    if (event.key === 'Enter') {
        event.preventDefault();
        submitForm(action);
    }
}


// Inisialisasi semua komponen
document.addEventListener('DOMContentLoaded', function() {
  
   
    const currencyInputDisplay = document.getElementById('nominalDibayarDisplay');
    const currencyInputHidden = document.getElementById('nominalDibayar');

    if (currencyInputDisplay && currencyInputHidden) {
        currencyInputDisplay.addEventListener('input', function() {
            formatCurrency(currencyInputDisplay, currencyInputHidden);
        });
    }
    const arrows = document.querySelectorAll('.arrow');
    const sidebar = document.querySelector('.sidebar');

    arrows.forEach(arrow => {
        arrow.addEventListener('click', function(e) {
            e.stopPropagation(); // Prevent click event from propagating to parent elements
            const submenu = this.closest('li').querySelector('.sidebar-submenu');
            submenu.classList.toggle('active');
        });
    });

    sidebar.addEventListener('mouseleave', function() {
        document.querySelectorAll('.sidebar-submenu').forEach(submenu => {
            submenu.classList.remove('active');
        });
    });
    initializeDateCalculations();
    initializeTaxCalculation();
    initializeJenisTagihan();
    initializeSidebar();
    initializeCurrencyInput();

    // Inisialisasi tombol "Tambah Invoice"
    const addInvoiceBtn = document.getElementById('add-invoice-btn');
    if (addInvoiceBtn) {
        addInvoiceBtn.addEventListener('click', addInvoiceRow);
    }

    // Event listener untuk form handling
    document.querySelectorAll('input').forEach(input => {
        input.addEventListener('keydown', function(event) {
            handleEnter(event, 'store');
        });
    });
});

window.fetchPajakRates = function(type) {
    const tarifSelect = document.getElementById('tarif');
    tarifSelect.innerHTML = '<option value="">-- Pilih Tarif --</option>';

    if (type === 'Tidak Ada') {
        return; // Exit if the selected type is 'Tidak Ada'
    }

    // Fetch tax rates from the server
    fetch(`/api/pajak/${type}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success' && data.rates) {
                data.rates.forEach(rate => {
                    const option = document.createElement('option');
                    option.value = rate.nilai; // Set value to the rate's value
                    option.textContent = `${rate.nilai}%`; // Set display text
                    tarifSelect.appendChild(option); // Append option to select
                });
            }
        })
        .catch(error => {
            console.error('Error fetching tax rates:', error); // Log any errors
        });
}
// Ekspos fungsi yang perlu diakses secara global
window.addInvoiceRow = addInvoiceRow;
window.removeInvoiceRow = removeInvoiceRow;
window.submitForm = submitForm;
window.handleEnter = handleEnter;
window.formatRupiah = formatRupiah;
window.unformatRupiah = unformatRupiah;
window.formatCurrency = formatCurrency;