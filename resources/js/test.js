// 

// nama komentar mengikuti nama file blade views








// afiliasi
// var customers = @json($customers);

// function updateCustomerDropdown() {
//     const perusahaan = document.getElementById("perusahaan").value; // Ambil perusahaan yang dipilih
//     const tipePelanggan = document.getElementById("tipePelanggan").value; // Tipe pelanggan yang dipilih
//     const datalist = document.getElementById("groupList"); // Referensi elemen datalist

//     // Kosongkan elemen datalist
//     datalist.innerHTML = "";

//     // Filter pelanggan berdasarkan perusahaan dan tipe pelanggan (jika ada)
//     const filteredCustomers = customers.filter((customer) => {
//         return (
//             (!perusahaan || customer.idcompany === perusahaan) &&
//             (!tipePelanggan || customer.idtypepelanggan === tipePelanggan)
//         );
//     });

//     // Tambahkan opsi ke datalist
//     filteredCustomers.forEach((customer) => {
//         const option = document.createElement("option");
//         option.value = customer.id_Pelanggan; // Value tetap id_Pelanggan
//         option.textContent = `${customer.name}`; // Nama pelanggan yang tampil
//         datalist.appendChild(option);
//     });

//     // Jika tidak ada pelanggan yang cocok, tambahkan opsi kosong
//     if (filteredCustomers.length === 0) {
//         const emptyOption = document.createElement("option");
//         emptyOption.value = "";
//         emptyOption.textContent = "-- Tidak Ada Pelanggan --";
//         datalist.appendChild(emptyOption);
//     }
// }

// // Event listener untuk memperbarui pelanggan saat perusahaan atau tipe pelanggan berubah
// document
//     .getElementById("perusahaan")
//     .addEventListener("change", updateCustomerDropdown);
// document
//     .getElementById("tipePelanggan")
//     .addEventListener("change", updateCustomerDropdown);

// // Panggil fungsi ini saat halaman dimuat untuk inisialisasi awal
// document.addEventListener("DOMContentLoaded", updateCustomerDropdown);

// function formatRupiah(value) {
//     return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
// }

// function formatDPP(input) {
//     let value = input.value.replace(/\./g, ""); // Remove existing dots for reformatting
//     if (!isNaN(value) && value !== "") {
//         input.value = formatRupiah(value); // Apply Rupiah format
//     } else {
//         input.value = ""; // Clear if not a valid number
//     }
//     calculatePiutang(); // Recalculate totals
// }

// function calculatePiutang() {
//     const dppInput =
//         parseFloat(document.getElementById("dpp").value.replace(/\./g, "")) ||
//         0;
//     const ppnRate = parseFloat(document.getElementById("ppn_type").value) || 0; // Get PPN rate percentage
//     const pphRate = parseFloat(document.getElementById("tarif").value) || 0; // Get PPh rate percentage

//     // Calculate PPN and PPh values
//     const ppnValue = (dppInput * ppnRate) / 100;
//     const pphValue = (dppInput * pphRate) / 100;

//     // Set formatted values for PPN and PPh
//     document.getElementById("ppn_value").value = formatRupiah(
//         ppnValue.toFixed(0)
//     );
//     document.getElementById("pph_value").value = formatRupiah(
//         pphValue.toFixed(0)
//     );

//     // Calculate total piutang
//     const totalPiutang = dppInput + ppnValue - pphValue;
//     document.getElementById("total_piutang").value = formatRupiah(
//         totalPiutang.toFixed(0)
//     );
// }

// // Event listeners to trigger calculation when PPN or PPh types change
// document
//     .getElementById("ppn_type")
//     .addEventListener("change", calculatePiutang);
// document.getElementById("tarif").addEventListener("change", calculatePiutang);
// // Show or hide 'jumlah_kali' input based on 'jenis_tagihan' selection
// document
//     .getElementById("jenis_tagihan")
//     .addEventListener("change", function () {
//         const jumlahKaliContainer = document.getElementById(
//             "jumlah_kali_container"
//         );
//         jumlahKaliContainer.style.display =
//             this.value === "berulang" ? "block" : "none";
//     });

// function syncCustomerId(input) {
//     const datalist = document.getElementById("groupList"); // Referensi elemen datalist
//     const hiddenInput = document.getElementById("id_Pelanggan"); // Input tersembunyi untuk id_Pelanggan
//     const selectedOption = Array.from(datalist.options).find(
//         (option) => option.textContent.trim() === input.value.trim()
//     );

//     // Jika nama pelanggan ditemukan di datalist, sinkronkan id_Pelanggan
//     if (selectedOption) {
//         hiddenInput.value = selectedOption.getAttribute("data-id"); // Ambil id_Pelanggan dari atribut data-id
//         input.value = selectedOption.textContent.trim(); // Set input value ke nama pelanggan
//     } else {
//         hiddenInput.value = ""; // Reset jika input tidak cocok
//     }
// }
// // End afiliasi