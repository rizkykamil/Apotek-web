@extends('admin.layouts.master')

@section('title', 'Penjualan')
@section('header-icon', 'dollar-sign')
@section('header-title', 'Penjualan')
@section('header-sub-title')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center justify-content-md-end">
            <div class="me-3">
                <button class="btn btn-primary btn-sm">Print</button>
            </div>
            <div class="me-3">
                <button class="btn btn-primary btn-sm">Tambah Penjualan</button>
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
                <form action="" method="post">
                    <div class="d-flex align-items-center justify-content-md-end">
                        @csrf
                        <div class="me-3">
                            <label for="tanggal_awal" style="font-size:small; font-color:#0000 !important" >Tanggal Awal</label>
                            <input type="date" class="form-control" name="tanggal_awal" id="tanggal_awal">
                        </div>
                        <div class="me-3">
                            <label for="tanggal_akhir" style="font-size:small; font-color:#0000">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir">
                        </div>
                        <div class="me-3 mt-4">
                            <button class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <div class="card-body">
        <table id="myTable" class="table">
            <thead>
                <tr>
                    <th>
                        Tanngal
                    </th>
                    <th>
                        Produk
                    </th>
                    <th>
                        qty
                    </th>
                    <th>
                        Total Harga
                    </th>
                    <th>
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        2021-10-10
                    </td>
                    <td>
                        Obat Batuk
                    </td>
                    <td>
                        10
                    </td>
                    <td>
                        100000
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm">Detail</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        2021-10-10
                    </td>
                    <td>
                        Obat Batuk
                    </td>
                    <td>
                        10
                    </td>
                    <td>
                        100000
                    </td>
                    <td>
                        <button class="btn btn-primary btn-sm">Detail</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{asset("js/custom/list_penjualan.js")}}"></script>
@endsection
