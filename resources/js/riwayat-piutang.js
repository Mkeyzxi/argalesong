// riwayatPiutang
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("idcompany");
    const form = document.getElementById("filterForm");

    // Kirim form secara otomatis saat input berubah
    input.addEventListener("change", function () {
        form.submit();
    });
});
// End riwayatPiutang