//data table
$(document).ready(function() {
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
            success: function(response) {
                table.clear().draw();
                response.forEach(function(data) {
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

    // Menangani klik tombol filter
    $('#filter_btn').on('click', function() {
        var startDate = $('#tanggal_awal').val();
        var endDate = $('#tanggal_akhir').val();

        if ( endDate < startDate){
            alert ('Tanggal awal tidak boleh lebih besar dari tanggal akhir!');
        }
        if (startDate !== '' && endDate !== '') {
            filterByDate(startDate, endDate);
        } else {
            alert('Silakan pilih tanggal awal dan akhir.');
        }
    });
});


document.addEventListener("DOMContentLoaded", function() {
    document.getElementById("produk").addEventListener("change", function() {
        var selectedProduct = this.value; 
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "/admin/transaksi/penjualan/getProductPrice/" + selectedProduct, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                document.getElementById("harga_barang").value = response.harga_jual;
            }
        };
        xhr.send();
    });

    document.getElementById("kuantitas").addEventListener("input", function() {
        var hargaBarang = parseFloat(document.getElementById("harga_barang").value);
        var kuantitas = parseInt(this.value);
        var totalHarga = hargaBarang * kuantitas;
        document.getElementById("total_harga").value = totalHarga;
    });
});