// formBaru
function formatNPWP(input) {
    // Hapus semua karakter yang bukan angka
    let value = input.value.replace(/\D/g, "");

    // Format string NPWP: XX.XXX.XXX.X-XXX.XXX
    let formattedValue = "";

    if (value.length > 0) {
        formattedValue += value.substring(0, 2); // XX
    }
    if (value.length > 2) {
        formattedValue += "." + value.substring(2, 5); // .XXX
    }
    if (value.length > 5) {
        formattedValue += "." + value.substring(5, 8); // .XXX
    }
    if (value.length > 8) {
        formattedValue += "." + value.substring(8, 9); // .X
    }
    if (value.length > 9) {
        formattedValue += "-" + value.substring(9, 12); // -XXX
    }
    if (value.length > 12) {
        formattedValue += "." + value.substring(12, 15); // .XXX
    }

    // Tetapkan nilai input dengan format yang baru
    input.value = formattedValue;
}





function toggleInput(dropdownId, inputDivId) {
    var dropdown = document.getElementById(dropdownId);
    var inputDiv = document.getElementById(inputDivId);

    if (dropdown.value === "ada") {
        inputDiv.style.display = "block";
    } else {
        inputDiv.style.display = "none";
    }
}

// On page load, check initial value of dropdowns
document.addEventListener("DOMContentLoaded", function () {
    toggleInput("npwp_option", "npwp_input");
});

// function validateForm() {
//     let messages = [];
//     const fields = {
//         'Tipe Pelanggan': document.getElementById('tipePelanggan'),
//         'Nama Pelanggan': document.getElementById('namaPelanggan'),
//         'KTP': document.getElementById('ktp'),
//         'NPWP': document.getElementById('npwp'),
//         'Alamat': document.getElementById('alamat'),
//         'E-mail': document.getElementById('email'),
//         'Whatsapp': document.getElementById('whatsapp'),
//         'Kota': document.getElementById('kota'),
//         'Kode Pos': document.getElementById('kodePos')
//     };

//     for (const [key, field] of Object.entries(fields)) {
//         if (field.value.trim() === '') {
//             messages.push(key + ' wajib diisi.');
//             field.classList.add('border-red-500');
//         } else {
//             field.classList.remove('border-red-500');
//         }
//     }

//     if (messages.length > 0) {
//         alert(messages.join('\n'));
//     } else {
//         // alert('Form sudah lengkap, data siap disimpan!');
//         // Tambahkan logika untuk submit form di sini
//     }
// }

// end formBaru
