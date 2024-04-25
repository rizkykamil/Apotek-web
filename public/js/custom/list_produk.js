$(document).ready(function () {
    $('#harga_beli_produk').mask('000.000.000', {
        reverse: true
    });
    $('#harga_jual_produk').mask('000.000.000', {
        reverse: true
    });
});

// edit modal produk
$('body').on('click', '#button_edit_modal', function () {
    let id_button_edit = $(this).data('id');
    $.ajax({
        url: "/admin/produk/edit_produk/" + id_button_edit,
        type: "GET",
        dataType: "JSON",
        success: function (data) {
            const {
                id,
                nama_produk,
                harga_beli_produk,
                harga_jual_produk,
                stok_produk,
                deskripsi_produk,
                kategori_produk_id
            } = data.data_produk;
            $('#id_produk_edit').val(id);
            $('#nama_produk_edit').val(nama_produk);
            $('#harga_beli_produk_edit').val(harga_beli_produk);
            $('#harga_jual_produk_edit').val(harga_jual_produk);
            $('#stok_produk_edit').val(stok_produk);
            $('#deskripsi_produk_edit').val(deskripsi_produk);
            $('#kategori_produk_edit').val(kategori_produk_id);
            $('#modal_edit').modal('show');
        }
    });
});

// update button edit produk
$('#update_produk_button').on('click', function () {
    let id_produk = $('#id_produk_edit').val();
    let nama_produk = $('#nama_produk_edit').val();
    let harga_beli_produk = $('#harga_beli_produk_edit').val();
    let harga_jual_produk = $('#harga_jual_produk_edit').val();
    let stok_produk = $('#stok_produk_edit').val();
    let deskripsi_produk = $('#deskripsi_produk_edit').val();
    let kategori_produk = $('#kategori_produk_edit').val();
    let gambar_produk = $('#gambar_produk_edit')[0].files[0];

    let formData = new FormData();
    formData.append('id', id_produk);
    formData.append('nama_produk', nama_produk);
    formData.append('harga_beli_produk', harga_beli_produk);
    formData.append('harga_jual_produk', harga_jual_produk);
    formData.append('stok_produk', stok_produk);
    formData.append('deskripsi_produk', deskripsi_produk);
    formData.append('kategori_produk', kategori_produk);
    if (gambar_produk !== undefined) {
        formData.append('gambar_produk', gambar_produk);
    }

    let token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "/admin/produk/update_produk/" + id_produk,
        type: "POST",
        headers: {
            'X-CSRF-TOKEN': token
        },
        processData: false,
        contentType: false,
        data: formData,
        success: function (data) {
            $('#Edit-produk').modal('hide');
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Your work has been saved",
                showConfirmButton: false,
                timer: 1000
            });
            setTimeout(function () {
                location.reload();
            }, 1000);

        },
        error: function (errors) {
            let message = JSON.parse(errors.responseText).message;
            Swal.fire({
                position: "center",
                icon: "error",
                title: message,
                showConfirmButton: false,
                timer: 1500
            });
        }
    });
});

// warning button delete produk
$('body').on('click', '#button_delete_warning', function () {
    Swal.fire({
        title: "Apakah anda yakin untuk menghapus produk ini?",
        showCancelButton: true,
        confirmButtonText: "Hapus",
        confirmButtonColor: "#d33",
    }).then((result) => {
        if (result.isConfirmed) {
            let id_button_delete = $(this).data('id');
            $.ajax({
                url: "/admin/produk/delete_produk/" + id_button_delete,
                type: "GET",
                success: function (data) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "Produk berhasil dihapus",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                }
            });
        }
    });
});
