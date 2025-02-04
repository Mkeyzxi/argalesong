document.addEventListener('DOMContentLoaded', function() {

    // Format Rupiah
    function formatRupiah(angka) {
        if (angka === undefined || angka === null || isNaN(angka)) {
            return 'Rp. 0';
        }
        angka = Math.floor(angka);

        let number_string = angka.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return 'Rp. ' + rupiah;
    }

    // Function to fetch data based on selected month and year
    function fetchData(month, year) {
        fetch(`/get-monthly-report?month=${month}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                console.log(data);

                const tbody = document.getElementById('report-body');
                tbody.innerHTML = ''; // Clear current data

                if (data.length === 0) {
                    tbody.innerHTML =
                        `<tr><td colspan="8" class="text-center py-4 text-gray-500">Data tidak ada</td></tr>`;
                    return;
                }

                let totalPiutang = 0;
                let totalPembayaran = 0;
                let totalSaldoPiutang = 0;

                // Generate table rows using map()
                const rows = data.map((item, index) => {
                    let nominal = parseFloat(item.total_piutang) || 0;
                    let pembayaran = parseFloat(item.total_pembayaran) || 0;
                    let saldoPiutang = item.saldo_piutang < 10 ? 0 : item.saldo_piutang;

                    // Update totals
                    totalPiutang += nominal;
                    totalPembayaran += pembayaran;
                    totalSaldoPiutang += saldoPiutang;

                    return `
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">${index + 1}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${item.id_pelanggan}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${item.pelanggan}</td>
                            <td class="px-6 py-4 whitespace-nowrap">${item.jatuh_tempo}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">${formatRupiah(nominal)}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">${formatRupiah(pembayaran)}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">${formatRupiah(saldoPiutang)}</td>
                        </tr>
                    `;
                }).join(''); // Gabungkan semua row menjadi satu string HTML

                // Tambahkan total saldo piutang di akhir tabel
                const totalRow = `
                    <tr class="bg-gray-100 font-bold">
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-right">Total</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">${formatRupiah(totalSaldoPiutang)}</td>
                    </tr>
                `;

                tbody.innerHTML = rows + totalRow; // Masukkan semua row ke dalam tbody
            })
            .catch(error => {
                console.error('Terjadi Error Fecthing data:', error);
                document.getElementById('report-body').innerHTML =
                    `<tr><td colspan="8" class="text-center py-4 text-red-500">Terjadi kesalahan dalam mengambil data</td></tr>`;
            });
    }

    // Event listeners for month selection
    const today = new Date();
    const currentMonth = today.getMonth() + 1;
    const currentYear = today.getFullYear();

    // Set the current year in the dropdown
    document.getElementById('year').value = currentYear;

    function highlightCurrentMonth(month) {
        document.querySelectorAll('[id^="month-"]').forEach(el => el.classList.remove('border-b-4',
            'border-indigo-600', 'font-bold'));
        document.getElementById(`month-${month}`).classList.add('border-b-4', 'border-indigo-600',
            'font-bold');
    }

    // Fetch initial data
    fetchData(currentMonth, currentYear);
    highlightCurrentMonth(currentMonth);

    document.querySelectorAll('[id^="month-"]').forEach(element => {
        element.addEventListener('click', function() {
            const month = this.id.split('-')[1];
            const year = document.getElementById('year').value;
            fetchData(month, year);
            highlightCurrentMonth(month);
        });
    });

    // Print button functionality
    document.getElementById('print-btn').addEventListener('click', function() {
        window.print();
    });
});