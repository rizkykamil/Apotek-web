<div class="modal fade" id="Tambah-produk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog @yield('ukuran_modal')">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-primary"  id="exampleModalLabel">@yield('title_modal_tambah_list')</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @yield('content_modal_tambah_list')
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="Edit-produk" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog @yield('ukuran_modal')">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-primary"  id="exampleModalLabel">@yield('title_modal_edit_list')</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                @yield('content_modal_edit_list')
            </div>
        </div>
    </div>
</div>