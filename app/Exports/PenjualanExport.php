<?php

namespace App\Exports;

use App\Models\Penjualan;
use App\Models\Produk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PenjualanExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $penjualans = Penjualan::query()
            ->join('produks', 'penjualans.produk_id', '=', 'produks.id')
            ->whereBetween('penjualans.created_at', [$this->startDate, $this->endDate])
            ->select('penjualans.created_at', 'produks.nama as produk', 'penjualans.kuantitas', 'penjualans.total_harga')
            ->get();

        $penjualans->map(function ($penjualan) {
            $penjualan->tanggal = $penjualan->created_at->format('d-m-Y');
            unset ($penjualan->created_at); // remove the original created_at column
        });

        return $penjualans->map(function ($penjualan) {
            return [
                'Tanggal' => $penjualan->tanggal,
                'Nama Produk' => $penjualan->produk,
                'Kuantitas' => $penjualan->kuantitas,
                'Total Harga' => $penjualan->total_harga,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Nama Produk',
            'Kuantitas',
            'Total Harga',
        ];
    }
}