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
                        `<button class="btn btn-primary" data-toggle="modal" data-target="#modal-detail" data-id="${data.id}">Detail</button>`
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
const printableContent = document.getElementById('printableContent');

printButton.addEventListener('click', function () {
    if (!startDateInput.value || !endDateInput.value) {
        alert('Please select both start and end dates.');
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





document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("produk").addEventListener("change", function () {
        var selectedProduct = this.value;
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "/admin/transaksi/penjualan/getProductPrice/" + selectedProduct, true);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById("harga_barang").value = response.harga_jual;
            }
        };
        xhr.send();
    });

    document.getElementById("kuantitas").addEventListener("input", function () {
        var hargaBarang = parseFloat(document.getElementById("harga_barang").value);
        var kuantitas = parseInt(this.value);
        var totalHarga = hargaBarang * kuantitas;
        document.getElementById("total_harga").value = totalHarga;
    });
});
