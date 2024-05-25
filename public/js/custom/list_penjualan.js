//data table
$(document).ready(function () {
    var table = $('#table_penjualan').DataTable({
        searching: true,
        lengthChange: false,
        info: true,
        paging: true,
        autoWidth: false,
    });
    let token = $('meta[name="csrf-token"]').attr('content');

    // Fungsi untuk menerapkan filter tanggal
    function filterByDate(startDate, endDate) {
        $.ajax({
            url: '/admin/transaksi/penjualan/filter_penjualan',
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': token
            },
            data: {
                start_date: startDate,
                // end_date + 1 day, karena filter menggunakan '<' dan '>'
                end_date: moment(endDate).add(1, 'days').format('YYYY-MM-DD')
            },
            dataType: 'json',
            success: function (response) {
                table.clear().draw();
                response.forEach(function (data) {
                    console.log(data);
                    table.row.add([
                        data.tanggal,
                        data.produk,
                        data.kuantitas,
                        data.total_harga,
                        `<button class="btn btn-primary" type="button"  data-bs-toggle="modal" data-bs-target="#detail-penjualan" data-id="${data.id}">Detail</button>`
                    ]).draw(false);
                });
            }
        });
    }

    $('#filter_btn').on('click', function () {
        var startDate = $('#tanggal_awal').val();
        var endDate = $('#tanggal_akhir').val();

        if (endDate < startDate) {
            alert('Tanggal awal tidak boleh lebih besar dari tanggal akhir!');
        }
        if (startDate !== '' && endDate !== '') {
            filterByDate(startDate, endDate);
        } else {
            alert('Silakan pilih tanggal awal dan akhir.');
        }
    });
});

const startDateInput = document.getElementById('startDate');
const endDateInput = document.getElementById('endDate');
const printButton = document.getElementById('printButton');
const exportButton = document.getElementById('export-button');
const printableContent = document.getElementById('printableContent');

printButton.addEventListener('click', function () {
    if (!startDateInput.value || !endDateInput.value) {
        // sweet alert
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Tanggal awal dan tanggal akhir harus diisi!",
        });
        return;
    }
    if (startDateInput.value > endDateInput.value) {
        // sweet alert
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Tanggal awal tidak boleh lebih besar dari tanggal akhir!",
        });
        return;

    }


    const startDate = startDateInput.value;
    const endDate = endDateInput.value;
    fetch(`/admin/transaksi/penjualan/print_penjualan/?startDate=${startDate}&endDate=${endDate}`)
        .then(response => response.json())
        .then(data => {
            const dataPenjualan = data.data.data_penjualan;
            const printWindow = window.open('', '_blank');
            printWindow.document.open();
            printWindow.document.write(`<html><head><title>Data Penjualan ${startDate} - ${endDate}</title></head><body>`);
            printWindow.document.write(`<h2>Data Penjualan ${startDate} - ${endDate}</h2>`);
            printWindow.document.write('<table border="1">');
            printWindow.document.write('<tr><th>Tanggal</th><th>Produk</th><th>Kuantitas</th><th>Total Harga</th></tr>');
            dataPenjualan.forEach(item => {
                printWindow.document.write(`<tr><td>${item.tanggal}</td><td>${item.produk}</td><td>${item.kuantitas}</td><td>${item.total_harga}</td></tr>`);
            });

            printWindow.document.write('</table>');
            printWindow.document.write('</body></html>');
            printWindow.document.close();
        });
});

exportButton.addEventListener('click', function () {
    if (!startDateInput.value || !endDateInput.value) {
        // sweet alert
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Tanggal awal dan tanggal akhir harus diisi!",
        });
        return;
    }

    if (startDateInput.value > endDateInput.value) {
        // sweet alert
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Tanggal awal tidak boleh lebih besar dari tanggal akhir!",
        });
        return;

    }
});


document.addEventListener("DOMContentLoaded", function () {
    var produkContainer = document.getElementById("produk-container");
    var addMoreButton = document.getElementById("addMore");
    var grossAmountInput = document.querySelector('.gross_amount');

    function updateGrossAmount() {
        let totalGross = 0;
        document.querySelectorAll('.total-harga').forEach(function (input) {
            totalGross += parseFloat(input.value) || 0;
        });
        grossAmountInput.value = Math.round(totalGross); // Convert to integer
    }

    addMoreButton.addEventListener("click", function () {
        var newProdukItem = document.querySelector(".produk-item").cloneNode(true);
        newProdukItem.querySelectorAll("input").forEach(input => input.value = ""); // Clear input values
        produkContainer.appendChild(newProdukItem);

        // Reassign event listeners for the new item
        assignEventListeners(newProdukItem);
        updateGrossAmount(); // Update gross amount after adding new item
    });

    produkContainer.addEventListener("click", function (e) {
        if (e.target && e.target.classList.contains("remove-produk")) {
            e.target.parentElement.remove();
            updateGrossAmount(); // Update gross amount after removing item
        }
    });

    function assignEventListeners(item) {
        item.querySelector(".produk-select").addEventListener("change", function () {
            var selectedProduct = this.value;
            var hargaBarangInput = item.querySelector(".harga-barang");

            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/admin/transaksi/penjualan/getProductPrice/" + selectedProduct, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    hargaBarangInput.value = response.harga_jual;
                }
            };
            xhr.send();
        });

        item.querySelector(".kuantitas").addEventListener("input", function () {
            var hargaBarang = parseFloat(item.querySelector(".harga-barang").value);
            var kuantitas = parseInt(this.value);
            var totalHarga = hargaBarang * kuantitas;
            item.querySelector(".total-harga").value = totalHarga;
            updateGrossAmount(); // Update gross amount on quantity change
        });
    }

    // Initial assignment of event listeners
    document.querySelectorAll(".produk-item").forEach(assignEventListeners);
    updateGrossAmount(); // Initial calculation of gross amount
});

document.getElementById('non-cash').onclick = function () {
    var form = document.getElementById('form-penjualan');
    var formData = new FormData(form);
    fetch('/admin/transaksi/penjualan/non-cash/', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.snap_token) {
            snap.pay(data.snap_token, {
                // Optional
                onSuccess: function(result) {
                    fetch('/admin/transaksi/penjualan/notification-non-cash', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify(result)
                    });
                },
                // Optional
                onPending: function(result) {
                    fetch('/admin/transaksi/penjualan/notification-non-cash', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify(result)
                    });
                    alert("status transaksi :" (result))
                },
                // Optional
                onError: function(result) {
                    fetch('/admin/transaksi/penjualan/notification-non-cash', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        },
                        body: JSON.stringify(result)
                    });
                }
            });
        } else {
            alert('Failed to get snap token');
        }
    });
};

document.querySelectorAll('.bayar_nanti').forEach(button => {
    button.addEventListener('click', function() {
        const orderId = this.getAttribute('data-order-id');

        fetch('/admin/transaksi/penjualan/bayar-nanti', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ order_id: orderId })
        })
        .then(response => {
            return response.json();
        })
        .then(data => {
            if (data.snap_token) {
                snap.pay(data.snap_token, {
                    // Optional
                    onSuccess: function(result) {
                        fetch('/admin/transaksi/penjualan/notification-non-cash', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: JSON.stringify(result)
                        });
                    },
                    // Optional
                    onPending: function(result) {
                        fetch('/admin/transaksi/penjualan/notification-non-cash', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: JSON.stringify(result)
                        });
                        alert("status transaksi :" (result))
                    },
                    // Optional
                    onError: function(result) {
                        fetch('/admin/transaksi/penjualan/notification-non-cash', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                            },
                            body: JSON.stringify(result)
                        });
                    }
                });
            } else {
                console.error('Snap token not found');
            }
        })
        .catch(error => console.error('Error fetching snap token:', error));
    });
});
