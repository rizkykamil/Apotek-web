@extends('admin.layouts.master')

@section('title', 'List Produk')
@section('header-icon', 'list')
@section('header-title', 'List Produk')
@section('header-sub-title')
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Tambah-produk">
    Tambah Produk
</button>
@endsection
@section('content')
<div class="col-md-12">
    <div class="row">
        @foreach ($list_produk as $item)
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="{{asset('img/image_obat/'.$item->gambar)}}" class="card-img-top" style="max-height:185px " loading="lazy" alt="...">
                <div class="card-body text-center">
                    <h4 class="card-title">{{$item->nama}}</h4>
                    <p class="card-text text-primary">
                        Rp. {{number_format($item->harga_jual, 0, ',', '.')}}
                    </p>
                    <div class="row">
                        <div class="d-grid gap-3 d-md-block">
                            <a href="{{route("admin.produk.view", $item->slug)}}" type="button" class="btn btn-primary">
                                Detail
                            </a>

                            <button type="button" class="btn btn-warning" id="button_edit_modal" data-id="{{$item->id}}" data-bs-toggle="modal" data-bs-target="#Edit-produk" >
                                Edit
                            </button>
                            <button type="button" class="btn btn-danger" id="button_delete_warning" data-id="{{$item->id}}">Delete</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

{{-- modal --}}
@section('title_modal_tambah_list', 'Tambah Produk')
@section('content_modal_tambah_list')
<form action="{{route('admin.produk.save')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-3">
        <label for="nama_produk" class="form-label">Nama Produk</label>
        <input type="text" class="form-control" id="nama_produk" aria-describedby="nama_produk" name="nama_produk">
    </div>
    <div class="mb-3">
        <label for="harga_beli_produk" class="form-label">Harga Beli Produk</label>
        <input type="number" class="form-control" id="harga_beli_produk_tambah" name="harga_beli_produk">
    </div>
    <div class="mb-3">
        <label for="stok_produk" class="form-label">Stok Produk</label>
        <input type="number" class="form-control" id="stok_produk" name="stok_produk">
    </div>
    <div class="mb-3">
        <label for="harga_jual_produk" class="form-label">Harga Jual Produk</label>
        <input type="number" class="form-control" id="harga_jual_produk_tambah" name="harga_jual_produk">
    </div>
    <div class="mb-3">
        <label for="kategori_produk" class="form-label">Kategori Produk</label>
        <select class="form-select" id="kategori_produk" aria-label="Default select example" name="kategori_produk">
            <option selected value="">Pilih Kategori Produk</option>
            @foreach ($kategori_produks as $kategori_produk)
            <option value="{{$kategori_produk->id}}">{{$kategori_produk->nama}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
        <textarea class="form-control" id="deskripsi_produk" rows="3" name="deskripsi_produk"></textarea>
    </div>
    
    <div class="mb-3">
        <label for="gambar_produk" class="form-label">Gambar Produk</label>
        <input class="form-control" type="file" id="gambar_produk" name="gambar_produk">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>
@endsection

@section('title_modal_edit_list', 'Edit Produk')
@section('content_modal_edit_list')
    <input type="hidden" name="id" id="id_produk_edit">
    <div class="mb-3">
        <label for="nama_produk" class="form-label">Nama Produk</label>
        <input type="text" class="form-control" id="nama_produk_edit" aria-describedby="nama_produk" name="nama_produk">
    </div>
    <div class="mb-3">
        <label for="harga_beli_produk" class="form-label">Harga Beli Produk</label>
        <input type="number" class="form-control" id="harga_beli_produk_edit" name="harga_beli_produk">
    </div>
    <div class="mb-3">
        <label for="stok_produk" class="form-label">Stok Produk</label>
        <input type="number" class="form-control" id="stok_produk_edit" name="stok_produk">
    </div>
    <div class="mb-3">
        <label for="harga_jual_produk" class="form-label">Harga Jual Produk</label>
        <input type="number" class="form-control" id="harga_jual_produk_edit" name="harga_jual_produk">
    </div>
    <div class="mb-3">
        <label for="kategori_produk" class="form-label">Kategori Produk</label>
        <select class="form-select" id="kategori_produk_edit" aria-label="Default select example" name="kategori_produk">
            <option selected value="">Pilih Kategori Produk</option>
            @foreach ($kategori_produks as $kategori_produk)
            <option value="{{$kategori_produk->id}}">{{$kategori_produk->nama}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
        <textarea class="form-control" id="deskripsi_produk_edit" rows="3" name="deskripsi_produk"></textarea>
    </div>
    
    <div class="mb-3">
        <label for="gambar_produk" class="form-label">Gambar Produk</label>
        <input class="form-control" type="file" id="gambar_produk_edit" name="gambar_produk">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="update_produk_button" class="btn btn-primary">Save changes</button>
    </div>
@endsection

@section('scripts')
    <script src="{{asset("js/custom/list_produk.js")}}"></script>
@endsection
