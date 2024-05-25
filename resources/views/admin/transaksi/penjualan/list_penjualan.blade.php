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
                    <th>order_id</th>
                    <th>Tanggal</th>
                    <th>Produk</th>
                    <th>kuantitas</th>
                    <th>Total Harga</th>
                    <th>status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data_penjualan as $item)
                <tr>
                    {{-- jika order_id == null maka tertulis cash --}}
                    <td>{{$item->order_id_midtrans}}</td>
                    <td>{{$item->tanggal}}</td>
                    <td>{{$item->produk->nama}}</td>
                    <td>{{$item->kuantitas}}</td>
                    <td>{{$item->total_harga}}</td>
                    <td>{{$item->status}}</td>
                    <td>
                        <a href="" class="btn btn-primary btn-sm">Detail</a>
                        @if ($item->status == 'pending' )
                            <button type="button" id="bayar_nanti" class="btn btn-success btn-sm bayar_nanti" data-order-id="{{ $item->order_id_midtrans }}">bayar</button>
                        @else
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('title_modal_tambah_penjualan', 'Tambah Penjualan')
@section('content_modal_tambah_penjualan')
<form id="form-penjualan" action="{{route('admin.transaksi.penjualan.save')}}" method="post">
    @csrf
    <div id="produk-container">
        <div class="produk-item mb-3">
            <label for="produk" class="form-label">Produk</label>
            <select class="form-select produk-select" id="produk" aria-label="Default select example" name="produk[]">
                <option selected value="">Pilih Produk</option>
                @foreach ($data_produk as $item)
                <option value="{{$item->id}}">{{$item->nama}}</option>
                @endforeach
            </select>
            <label for="harga_barang" class="form-label">Harga Barang</label>
            <input type="number" class="form-control harga-barang" name="harga_barang[]" readonly>
            <label for="kuantitas" class="form-label">Kuantitas</label>
            <input type="number" class="form-control kuantitas" name="kuantitas[]">
            <label for="total_harga" class="form-label">Total Harga</label>
            <input type="number" class="form-control total-harga" name="total_harga[]" readonly>
            <button type="button" class="btn btn-danger remove-produk" style="margin-top: 10px;">Remove</button>
        </div>
    </div>
    <button type="button" class="btn btn-primary" id="addMore">Add More</button>
    <div class="mt-5">
        <label for="total_harga" class="form-label ">Total seluruh Harga</label>
        <input type="number" class="form-control gross_amount " name="gross_amount" readonly>
    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Cash</button>
        <button type="button" id="non-cash" class="btn btn-primary">Non Cash</button>
    </div>
</form>

@endsection

@section('title_modal_print_penjualan', 'Tambah Print Penjualan')
@section('content_modal_print_penjualan')
<form id="dateForm" action="{{route('admin.transaksi.penjualan.export')}}" method="post">
    @csrf
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
        <button type="submit" class="btn btn-success" id="export-button">Export to Excel</button>
        <button type="button" class="btn btn-primary"  id="printButton">Print</button>
    </div>
</form>
@endsection

@section('title_modal_detail_penjualan', 'Detail Penjualan')
@section('content_modal_detail_penjualan')

@endsection

@section('scripts')
<script src="{{asset("js/custom/list_penjualan.js")}}"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
@endsection
