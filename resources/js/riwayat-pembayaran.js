import {formatRupiah, unformatRupiah, submitForm, submitChange} from './script.mjs';
// riwayatPembayaran
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("idcompany");
    const form = document.getElementById('filterForm');

    // Kirim form secara otomatis saat input berubah
    input.addEventListener("change", function () {
        form.submit();
    });

    
// Event listener for manual changes in diskon and denda
document.addEventListener("input", function (event) {
    if (
        event.target.classList.contains("diskon-input") ||
        event.target.classList.contains("denda-input")
    ) {
        updateRowTotal(event.target);
    }
});

});
// End riwayatPembayaran

