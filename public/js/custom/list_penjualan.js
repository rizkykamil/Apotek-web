//data table
$(document).ready(function() {
    $('#table_penjualan').DataTable({
        searching: true,
        lengthChange: false,
        info: true,    
        paging: true,
        autoWidth: false,
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