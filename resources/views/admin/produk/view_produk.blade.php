@extends('admin.layouts.master')

@section('title')
    Detail Produk | {{$list_produk->slug}}
@endsection
@section('header-icon', 'droplet')
@section('header-title', 'Detail Produk')
@section('header-sub-title' , '')
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <img src="{{asset('img/image_obat/'.$list_produk->gambar)}}" class="img-fluid" loading="lazy" alt="Foto Produk">
                </div>
                <div class="col-md-9">
                    <h3>{{$list_produk->nama}}</h3>
                    <p>{{$list_produk->deskripsi}}</p>
                    <p>Harga Beli : Rp. {{number_format($list_produk->harga_beli)}}</p>
                    <p>Harga Jual : Rp. {{number_format($list_produk->harga_jual)}}</p>
                    <p>Stok : {{$list_produk->stok->jumlah}}</p>
                    <p>Kategori : {{$list_produk->jenisProduk->nama}}</p>
                    <p>Dibuat pada : {{date('d F Y', strtotime($list_produk->created_at))}}</p>
                    <p>Diupdate pada : {{date('d F Y', strtotime($list_produk->updated_at))}}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                    <a href="{{route('admin.produk.list')}}" class="btn btn-primary ">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
