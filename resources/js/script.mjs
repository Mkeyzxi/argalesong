// function yang digunakan terus menerus

function formatRupiah(number) {
    const roundedNumber = Math.floor(number);
    return `Rp ${roundedNumber
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
}

function formatRupiahWithRP(number) {
    const roundedNumber = Math.floor(number);
    return `Rp ${roundedNumber
        .toString()
        .replace(/\B(?=(\d{3})+(?!\d))/g, ".")}`;
}

function formatRupiahWithFleksibel(angka) {
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
    return parseInt(rupiahString.replace(/[^0-9]/g, ""), 10) || 0;
}

function unformatRupiahWithFloat(rupiahString) {
    return parseFloat(rupiahString.replace(/[^\d,]/g, '').replace(/\./g, '').replace(',', '.')) || 0;
}
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

// jika terjadi perubahan, lakukan submit
// export const submitChange = (event) => {
//     // closest mencari form terdekat
//     const form = event.target.closest("form"); 
//     if (form) {
//         form.submit(); 
//     }
// };

// export {formatRupiahWithRP, formatRupiah, unformatRupiah, unformatRupiahWithFloat, formatRupiahWithFleksibel, submitForm,submitChange};
export {formatRupiahWithRP, formatRupiah, unformatRupiah, unformatRupiahWithFloat, formatRupiahWithFleksibel, submitForm};