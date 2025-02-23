import {formatRupiah, unformatRupiah, submitForm} from './script.mjs';

// Pembayaran
function loadCustomersByCompany(companyId) {
    // Cari elemen dropdown pelanggan berdasarkan ID
    const customerDropdown = document.getElementById("customer");

    // Reset dropdown pelanggan
    customerDropdown.innerHTML =
        '<option value="">-- Pilih Pelanggan --</option>';

    if (!companyId) return;

    // Fetch customers by company ID
    fetch(`/api/customers-by-company/${companyId}`)
        .then((response) => response.json())
        .then((data) => {
            data.customers.forEach((customer) => {
                const option = document.createElement("option");
                option.value = customer.idpelanggan;
                option.textContent = `${customer.customer_name}`;
                customerDropdown.appendChild(option);
            });
        })
        .catch((error) => {
            console.error("Error loading customers:", error);
        });
}

function loadInvoicesByCustomer(customerId) {
    const invoiceContainer = document.getElementById("invoice-container");
    invoiceContainer.innerHTML = "";

    if (!customerId) return;

    fetch(`/api/invoices-by-customer/${customerId}`)
        .then((response) => response.json())
        .then((data) => {
            let totalPiutang = 0;

            data.invoices.forEach((invoice, index) => {
                totalPiutang += parseFloat(invoice.total);

                const row = `
<tr class="invoice-row" data-total="${invoice.total}">
<td class="px-3 py-2">
<input type="text" name="invoices[${index}][nomor_invoice]"
	class="invoice-input border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
	value="${invoice.no_invoice}" readonly>
</td>
<td class="px-3 py-2">
<input type="date" name="invoices[${index}][jatuh_tempo]"
	class="invoice-input border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
	value="${invoice.tgl_jatuh_tempo}" readonly>
</td>
<td class="px-3 py-2">
<input type="text"
	class="piutang-input border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
	value="${formatRupiah(parseFloat(invoice.tagihan))}" readonly>
<input type="hidden" name="invoices[${index}][piutang_belum_dibayar]" class="piutang-value" value="${parseFloat(
                    invoice.tagihan
                )}">
</td>
<td class="px-3 py-2">
<input type="text"
class="diskon-input border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
value="${formatRupiah(parseFloat(invoice.diskon))}"
onchange="updateRowTotal(this)"
onfocus="removeFormatting(this)"
onblur="applyFormatting(this)">
<input type="hidden" name="invoices[${index}][diskon]" class="diskon-value" value="${parseFloat(
                    invoice.diskon
                )}">
</td>
<td class="px-3 py-2">
<input type="text"
class="denda-input border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
value="${formatRupiah(parseFloat(invoice.denda))}"
onchange="updateRowTotal(this)"
onfocus="removeFormatting(this)"
onblur="applyFormatting(this)">
<input type="hidden" name="invoices[${index}][denda]" class="denda-value" value="${parseFloat(
                    invoice.denda
                )}">
</td>
<td class="px-3 py-2">
<input type="text"
	class="total-display border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm w-full"
	value="${formatRupiah(parseFloat(invoice.total))}" readonly>
<input type="hidden" name="invoices[${index}][total]" class="total-value" value="${parseFloat(
                    invoice.total
                )}">
</td>
<td class="px-3 py-2">
<button type="button" class="delete-btn" data-total="${parseFloat(
                    invoice.total
                )}">
	<svg class="h-5 w-5 fill-red-600" xmlns="http://www.w3.org/2000/svg"
		viewBox="0 0 20 20" fill="currentColor">
		<path fill-rule="evenodd"
			d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
			clip-rule="evenodd" />
	</svg>
</button>
</td>
</tr>`;

                invoiceContainer.insertAdjacentHTML("beforeend", row);
                const deleteButton =
                    invoiceContainer.lastElementChild.querySelector(
                        ".delete-btn"
                    );
                deleteButton.addEventListener("click", function () {
                    const row = this.closest("tr");
                    row.remove();
                    reindexInvoiceInputs();
                    updateTotalPiutang();
                });
                updateTotalPiutang();
            });
        });
}

function removeFormatting(input) {
    input.value = unformatRupiah(input.value);
}

function applyFormatting(input) {
    const value = parseInt(input.value) || 0;
    input.value = formatRupiah(value);
    const row = input.closest("tr");
    row.querySelector(".piutang-value").value = value;
    updatePenaltyAndDiscount(input, input.closest("tr").rowIndex);
}


// Fungsi-fungsi inisialisasi





function reindexInvoiceInputs() {
    const rows = document.querySelectorAll(".invoice-row");
    rows.forEach((row, index) => {
        const inputs = row.querySelectorAll('input[name^="invoices["]');
        inputs.forEach((input) => {
            const oldName = input.name;
            const fieldName = oldName.match(/\[([^\]]+)\]$/)[1];
            input.name = `invoices[${index}][${fieldName}]`;
        });
    });
}

function submitForm(action) {
    const form = document.getElementById("paymentForm");
    if (action === "proses") {
        form.action = form.dataset.prosesUrl;
    } else {
        form.action = form.dataset.storeUrl;
    }
    form.submit();
}
// End Pembayaran


// Fungsi untuk menangani pengiriman formulir
// function submitForm(action) {
//     const form = document.getElementById('paymentForm');
    
//     const procesUrl = form.getAttribute('data-proses-url');
//     const storeUrl = form.getAttribute('data-store-url');

//     if (action === 'proses') {
//         form.action = procesUrl;
//         form.method = 'GET';
//     } else {
//         form.action = storeUrl;
//         form.method = 'POST';
//     }
//     form.submit();
// }