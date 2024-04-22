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
@section('content_modal')
<form>
    <div class="mb-3">
        <label for="nama_produk" class="form-label">Nama Produk</label>
        <input type="text" class="form-control" id="nama_produk" aria-describedby="nama_produk">
    </div>
    <div class="mb-3">
        <label for="harga_produk" class="form-label">Harga Produk</label>
        <input type="text" class="form-control" id="harga_produk">
    </div>
    <div class="mb-3">
        <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
        <textarea class="form-control" id="deskripsi_produk" rows="3"></textarea>
    </div>
    <div class="mb-3">
        <label for="gambar_produk" class="form-label">Gambar Produk</label>
        <input class="form-control" type="file" id="gambar_produk">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
    </div>
</form>
@endsection
