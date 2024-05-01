@extends('admin.layouts.master')

@section('title', 'Penjualan')
@section('header-icon', 'dollar-sign')
@section('header-title', 'Penjualan')
@section('header-sub-title')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-md-end">
            <div class="me-3">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Print-penjualan">
                    Print
                </button>
            </div>
            <div class="me-3">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#Tambah-penjualan">
                    Tambah Penjualan
                </button>
            </div>
        </div>  
    </div>
</div>
@endsection
@section('content')
<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <div class="d-flex align-content-center mt-4">
                    Table History Penjualan
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
        <table id="table_penjualan" class="table">
            <thead>
                <tr>
                    <th>Tanngal</th>
                    <th>Produk</th>
                    <th>kuantitas</th>
                    <th>Total Harga</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_penjualan as $item)
                <tr>
                    <td>{{$item->tanggal}}</td>
                    <td>{{$item->produk->nama}}</td>
                    <td>{{$item->kuantitas}}</td>
                    <td>{{$item->total_harga}}</td>
                    <td><a href="" class="btn btn-primary btn-sm">Detail</a></td>
                    {{-- <a href="{{route('admin.transaksi.penjualan.detail', $item->id)}}" class="btn btn-primary btn-sm">Detail</a> --}}
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('title_modal_tambah_penjualan', 'Tambah Penjualan')
@section('content_modal_tambah_penjualan')
<form action="{{route('admin.transaksi.penjualan.save')}}" method="post">
    @csrf
    <div class="mb-3">
        <label for="produk" class="form-label">Produk</label>
        <select class="form-select" id="produk" aria-label="Default select example" name="produk">
            <option selected value="">Pilih Produk</option>
            @foreach ($data_produk as $item)
            <option value="{{$item->id}}">{{$item->nama}}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label for="harga_barang" class="form-label">Harga Barang</label>
        <input type="number" class="form-control disabled" id="harga_barang" name="harga_barang" readonly>
    </div>
    <div class="mb-3">
        <label for="kuantitas" class="form-label">Kuantitas</label>
        <input type="number" class="form-control" id="kuantitas" name="kuantitas">
    </div>
    <div class="mb-3">
        <label for="total_harga" class="form-label">Total Harga</label>
        <input type="number"  class="form-control disabled" id="total_harga" name="total_harga" readonly>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
@endsection

@section('title_modal_print_penjualan', 'Tambah Print Penjualan')
@section('content_modal_print_penjualan')
<form id="dateForm">
    <div class="mb-3">
        <label for="startDate" class="form-label">Tanggal Awal:</label>
        <input type="date" class="form-control" id="startDate" name="startDate">
    </div>
    <div class="mb-3">
        <label for="endDate" class="form-label" >Tanggal Akhir:</label>
        <input type="date" class="form-control" id="endDate" name="endDate">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary"  id="printButton">Print</button>
    </div>
</form>
@endsection

@section('scripts')
<script src="{{asset("js/custom/list_penjualan.js")}}"></script>
@endsection
