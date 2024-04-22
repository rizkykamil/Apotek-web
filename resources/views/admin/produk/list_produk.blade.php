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
        <div class="col-md-3 mb-3">
            <div class="card">
                <img src="{{asset("img/image_obat/voltaren.jpeg")}}" class="card-img-top " loading="lazy" alt="">
                <div class="card-body text-center">
                    <h5 class="card-title">Nama Produk</h5>
                    <p class="card-text">Rp. 17.000</p>
                    <a href="#" class="btn btn-primary">View Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">Example Card</div>
                <div class="card-body">This is a blank page. You can use this page as a boilerplate for creating new
                    pages! This page uses the compact page header format, which allows you to create pages with a very
                    minimal and slim page header so you can get right to showcasing your content.</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">Example Card</div>
                <div class="card-body">This is a blank page. You can use this page as a boilerplate for creating new
                    pages! This page uses the compact page header format, which allows you to create pages with a very
                    minimal and slim page header so you can get right to showcasing your content.</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">Example Card</div>
                <div class="card-body">This is a blank page. You can use this page as a boilerplate for creating new
                    pages! This page uses the compact page header format, which allows you to create pages with a very
                    minimal and slim page header so you can get right to showcasing your content.</div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-header">Example Card</div>
                <div class="card-body">This is a blank page. You can use this page as a boilerplate for creating new
                    pages! This page uses the compact page header format, which allows you to create pages with a very
                    minimal and slim page header so you can get right to showcasing your content.</div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- modal --}}
@section('id_modal', 'Tambah-produk')
@section('title_modal', 'Tambah Produk')
{{-- @section('ukuran_modal', 'modal-lg') --}}
@section('content_modal')
<form action="{{route('admin.produk.save')}}" method="post">
    @csrf
    <div class="mb-3">
        <label for="nama_produk" class="form-label">Nama Produk</label>
        <input type="text" class="form-control" id="nama_produk" aria-describedby="nama_produk" name="nama_produk">
    </div>
    <div class="mb-3">
        <label for="harga_beli_produk" class="form-label">Harga Beli Produk</label>
        <input type="number" class="form-control" id="harga_beli_produk" name="harga_beli_produk">
    </div>
    <div class="mb-3">
        <label for="stok_produk" class="form-label">Stok Produk</label>
        <input type="number" class="form-control" id="stok_produk" name="stok_produk">
    </div>
    <div class="mb-3">
        <label for="harga_jual_produk" class="form-label">Harga Jual Produk</label>
        <input type="number" class="form-control" id="harga_jual_produk" name="harga_jual_produk">
    </div>
    <div class="mb-3">
        <label for="kategori_produk" class="form-label">Kategori Produk</label>
        <select class="form-select" id="kategori_produk" aria-label="Default select example" name="kategori_produk">
            <option selected>Pilih Kategori Produk</option>
            @foreach ($kategori_produks as $kategori_produk)
            <option value="{{$kategori_produk->id}}">{{$kategori_produk->nama_kategori}}</option>
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
