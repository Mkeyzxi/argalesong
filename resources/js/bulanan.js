
// Bulanan belum digunakan
// document.addEventListener("DOMContentLoaded", function () {
//     // Format Rupiah
//     function formatRupiah(angka) {
//         if (angka === undefined || angka === null || isNaN(angka)) {
//             return "Rp. 0"; // Atau nilai default lainnya jika angka null atau undefined
//         }

//         // Pastikan angka adalah integer, hilangkan desimal jika ada
//         angka = Math.floor(angka);

//         let number_string = angka.toString(),
//             sisa = number_string.length % 3,
//             rupiah = number_string.substr(0, sisa),
//             ribuan = number_string.substr(sisa).match(/\d{3}/g);

//         if (ribuan) {
//             let separator = sisa ? "." : "";
//             rupiah += separator + ribuan.join(".");
//         }

//         return "Rp. " + rupiah;
//     }

//     // Function to fetch data based on selected month and year
//     function fetchData(month, year) {
//         fetch(`/get-monthly-report?month=${month}&year=${year}`)
//             .then((response) => response.json())
//             .then((data) => {
//                 console.log(data);

//                 const tbody = document.getElementById("report-body");
//                 tbody.innerHTML = ""; // Clear current data

//                 let totalPiutang = 0; // Variable to calculate total receivables
//                 let totalPembayaran = 0; // Variable to calculate total payments
//                 let totalSaldoPiutang = 0; // Variable to calculate total outstanding balance

//                 if (data.length === 0) {
//                     tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-gray-500">Data tidak ditemukan</td></tr>`;
//                 } else {
//                     // Process all data without grouping by customer
//                     data.forEach((item, index) => {
//                         let nominal = parseFloat(item.total_piutang) || 0;
//                         let pembayaran = parseFloat(item.total_pembayaran) || 0;

//                         // Calculate saldo piutang (outstanding balance)

//                         totalPiutang += nominal;
//                         totalPembayaran += pembayaran;
//                         totalSaldoPiutang += item.saldo_piutang;

//                         tbody.innerHTML += `
// <tr>
// 	<td class="px-6 py-4 whitespace-nowrap">${index + 1}</td>
// 	<td class="px-6 py-4 whitespace-nowrap">${item.id_pelanggan}</td>
// 	<td class="px-6 py-4 whitespace-nowrap">${item.pelanggan}</td>
// 	<td class="px-6 py-4 whitespace-nowrap">${item.jatuh_tempo}</td>
// 	<td class="px-6 py-4 whitespace-nowrap text-right">${formatRupiah(
//         item.total_piutang
//     )}</td>
// 	<td class="px-6 py-4 whitespace-nowrap text-right">${formatRupiah(
//         pembayaran
//     )}</td>
//   <td class="px-6 py-4 whitespace-nowrap text-right">${formatRupiah(
//       item.saldo_piutang < 10 ? 0 : item.saldo_piutang
//   )}</td>

// </tr>
// `;
//                     });

//                     // Add the last row for total balance
//                     tbody.innerHTML += `
// 			<tr>
// 				<td colspan="6" class="px-6 py-4 whitespace-nowrap text-right font-bold">Total</td>
// 				<td class="px-6 py-4 whitespace-nowrap text-right font-bold">${formatRupiah(
//                     totalSaldoPiutang
//                 )}</td>
// 			</tr>
// 		`;
//                 }
//             })
//             .catch((error) => {
//                 console.error("Error fetching data:", error);
//                 const tbody = document.getElementById("report-body");
//                 tbody.innerHTML = `<tr><td colspan="8" class="text-center py-4 text-red-500">Terjadi kesalahan dalam mengambil data</td></tr>`;
//             });
//     }

//     // Event listeners for month selection
//     const today = new Date();
//     const currentMonth = today.getMonth() + 1; // JavaScript month is 0-indexed, so add 1
//     const currentYear = today.getFullYear();

//     // Set the current year in the dropdown
//     document.getElementById("year").value = currentYear;

//     // Function to highlight the selected month
//     function highlightCurrentMonth(month) {
//         document
//             .querySelectorAll('[id^="month-"]')
//             .forEach((el) =>
//                 el.classList.remove(
//                     "border-b-4",
//                     "border-indigo-600",
//                     "font-bold"
//                 )
//             );
//         document
//             .getElementById(`month-${month}`)
//             .classList.add("border-b-4", "border-indigo-600", "font-bold");
//     }

//     // Fetch data based on current month and year
//     fetchData(currentMonth, currentYear);
//     highlightCurrentMonth(currentMonth);

//     // Event listeners for month selection
//     document.querySelectorAll('[id^="month-"]').forEach((element) => {
//         element.addEventListener("click", function () {
//             const month = this.id.split("-")[1];
//             const year = document.getElementById("year").value;

//             // Fetch and display data
//             fetchData(month, year);

//             // Highlight the selected month
//             highlightCurrentMonth(month);
//         });
//     });

//     // Print button functionality
//     document.getElementById("print-btn").addEventListener("click", function () {
//         window.print();
//     });
// });
// End Bulanan