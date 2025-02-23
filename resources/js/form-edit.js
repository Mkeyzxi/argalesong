import  {formatRupiahWithRP, formatRupiah, unformatRupiah, unformatRupiahWithFloat, formatRupiahWithFleksibel} from './script.mjs';


// fungsi belum digunakan sama sekali, hanya untuk konfirmasi melakukan delete
function konfirmasiDelete(event, form) {
	event.preventDefault(); // Mencegah submit otomatis

	// Hapus modal sebelumnya jika ada
	const existingModal = document.getElementById("confirmModal");
	if (existingModal) {
		existingModal.remove();
	}
    

	const modalHTML = `
		<div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 px-6">
			<div class="bg-white p-6 rounded-md shadow-lg text-center">
				<p class="text-lg font-semibold text-gray-800">
					Apakah Anda yakin ingin menghapus pelanggan <strong>{{ $pelanggan->company->name }}</strong>?
				</p>
				<div class="mt-4 flex justify-center space-x-4">
					<button id="confirmYes" class="px-4 py-2 bg-red-600 text-white rounded">Ya</button>
					<button id="confirmNo" class="px-4 py-2 bg-gray-300 text-black rounded">Batal</button>
				</div>
			</div>
		</div>
	`;

	document.body.insertAdjacentHTML("beforeend", modalHTML);

	document.getElementById("confirmYes").addEventListener("click", function () {
		form.submit(); // Submit form jika user memilih "Ya"
	});

	document.getElementById("confirmNo").addEventListener("click", function () {
		document.getElementById("confirmModal").remove(); // Hapus modal jika "Batal"
	});

	return false; // Mencegah submit form langsung
}

// formEdit

function updateKodePelanggan() {
    var tipePelanggan = document.getElementById("tipePelanggan").value;
    var tipePiutang = document.getElementById("tipePiutang").value;
    var kodePelangganInput = document.getElementById("kode_pelanggan");
    function updateRowTotal(input) {
        const row = input.closest("tr");
        const piutangValue =
            parseInt(unformatRupiah(row.querySelector(".piutang-input").value)) ||
            0;
        const diskonValue =
            parseInt(unformatRupiah(row.querySelector(".diskon-input").value)) || 0;
        const dendaValue =
            parseInt(unformatRupiah(row.querySelector(".denda-input").value)) || 0;
    
        // Update hidden values
        row.querySelector(".diskon-value").value = diskonValue;
        row.querySelector(".denda-value").value = dendaValue;
    
        const newTotal = piutangValue - diskonValue + dendaValue;
    
        row.querySelector(".total-display").value = formatRupiah(newTotal);
        row.querySelector(".total-value").value = newTotal;
    
        updateTotalPiutang();
    }
    
    function updateTotalPiutang() {
        let total = 0;
        document.querySelectorAll(".total-value").forEach((input) => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById("total-piutang").value = formatRupiah(total);
        document.querySelector('input[name="total_piutang"]').value = total;
    }
    if (tipePelanggan && tipePiutang) {
        if (tipePelanggan === "perusahaan" && tipePiutang === "sewa-menyewa") {
            kodePelangganInput.value =
                "PRSH-" + Math.floor(Math.random() * 1000000);
        } else if (
            tipePelanggan === "individu" &&
            tipePiutang === "sewa-menyewa"
        ) {
            kodePelangganInput.value =
                "INDV-" + Math.floor(Math.random() * 1000000);
        } else {
            kodePelangganInput.value = "";
        }
    } else {
        kodePelangganInput.value = "";
    }
}
document.addEventListener("DOMContentLoaded", function () {
    const input = document.getElementById("idcompany");
    const form = document.getElementById("filterForm");

    // Kirim form secara otomatis saat input berubah
    input.addEventListener("change", function () {
        form.submit();
    });

    // jaga-jaga harusnya dipakai
    // document.getElementById("tipePelanggan").addEventListener("change", updateKodePelanggan);
// document.getElementById("tipePiutang").addEventListener("change", updateKodePelanggan);

    
    
});



// end formEdit