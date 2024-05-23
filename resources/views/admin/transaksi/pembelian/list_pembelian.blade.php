@extends('admin.layouts.master')

@section('title', 'Pembelian')
@section('header-icon', 'refresh-ccw')
@section('header-title', 'Pembelian')
@section('header-sub-title' , '')
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex align-content-center mt-4">
                    Table History Pembelian
                </div>
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center justify-content-md-end">
                    <div class="me-3">
                        <label for="tanggal_awal" style="font-size:small;">Tanggal Awal</label>
                        <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal">
                    </div>
                    <div class="me-3">
                        <label for="tanggal_akhir" style="font-size:small;">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir">
                    </div>
                    <div class="me-3 mt-4">
                        <button id="filter_btn" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    <div class="card-body">
        <table id="table_pembelian" class="table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>Stok</th>
                    <th>kuantitas</th>
                    <th>Total Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_pembelian as $item)
                <tr>
                    <td>{{$item->tanggal}}</td>
                    <td>{{$item->nama}}</td>
                    <td>{{$item->stok}}</td>
                    <td>{{$item->kuantitas}}</td>
                    <td>{{$item->harga_beli}}</td>
                    <td><a href="" class="btn btn-primary btn-sm">Detail</a></td>
                    {{-- <a href="{{route('admin.transaksi.penjualan.detail', $item->id)}}" class="btn btn-primary btn-sm">Detail</a> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{asset("js/custom/list_pembelian.js")}}"></script>
@endsection