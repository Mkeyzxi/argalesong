// Import statements
import './bootstrap';
import 'flowbite';
import { formatRupiahWithRP, formatRupiah, unformatRupiah,submitForm, unformatRupiahWithFloat, formatRupiahWithFleksibel} from './script.mjs';
// Fungsi-fungsi utilitas
function formatNumber(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

function parseNumber(string) {
    return parseFloat(string.replace(/\./g, '').replace(',', '.')) || 0;
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



// function initializeTaxCalculation() {
//     const dppInput = document.getElementById('dpp');
//     const ppnValueInput = document.getElementById('ppn_value');
//     const totalPiutangInput = document.getElementById('total_piutang');
//     const ppnCheckbox = document.getElementById('ppn_checkbox');
//     const pajakTypeSelect = document.getElementById('pajak_type');
//     const tarifSelect = document.getElementById('tarif');
  

//     function updateTaxCalculation() {
//         let dpp = parseNumber(dppInput.value);
//         let ppnTotal = 0;
//         let pphTotal = 0;

//         // Cek jika PPN dicentang
//         if (ppnCheckbox.checked) {
//             const ppnValue = 11; // Misalnya PPN 10%
//             ppnTotal = (dpp * ppnValue / 100); // Menghitung PPN
//         }

//         // Menghitung PPh dari pilihan
//         const selectedPajak = pajakTypeSelect.value;
//         if (selectedPajak !== "Tidak Ada" && tarifSelect.value) {
//             const tarifValue = parseFloat(tarifSelect.value);
//             pphTotal = (dpp * tarifValue / 100); // Menghitung PPh
//         }

//         // Update nilai PPN yang terhitung
//         const ppnAfterTax = ppnTotal - pphTotal;
//             ppnValueInput.value = formatNumber(ppnAfterTax.toFixed(2)); // Update nilai PPN

//             // Hitung total piutang
//             let totalPiutang = dpp + ppnAfterTax; // Total piutang = DPP + PPN setelah dikurangi PPh
//             totalPiutangInput.value = formatNumber(totalPiutang.toFixed(2));
//     }

//     function handleDPPInput(e) {
//         let value = e.target.value.replace(/\D/g, '');
//         let formattedValue = value === '' ? '0' : formatNumber(parseInt(value, 10));
//         e.target.value = formattedValue;
//         updateTaxCalculation();
//     }

//     dppInput.addEventListener('input', handleDPPInput);
//     ppnCheckbox.addEventListener('change', updateTaxCalculation);
//     pajakTypeSelect.addEventListener('change', updateTaxCalculation);
//     tarifSelect.addEventListener('change', updateTaxCalculation);

//     updateTaxCalculation();
// }

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



function removeInvoiceRow(button) {
    const row = button.closest('.invoice-row');
    row.remove();
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
    // initializeDateCalculations();
    // initializeTaxCalculation();
    // initializeJenisTagihan();
    // initializeSidebar();
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


// Ekspos fungsi yang perlu diakses secara global
// window.addInvoiceRow = addInvoiceRow;
window.removeInvoiceRow = removeInvoiceRow;
window.submitForm = submitForm;
window.handleEnter = handleEnter;
window.formatRupiahWithFleksibel = formatRupiahWithFleksibel;
window.unformatRupiahWithFloat = unformatRupiahWithFloat;
window.formatCurrency = formatCurrency;