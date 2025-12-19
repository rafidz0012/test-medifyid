<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MasterItemsExportExcel implements FromCollection, WithHeadings, WithMapping
{
    protected $no = 1;

    public function collection()
    {
        return MasterItem::with('categories')->get();
    }
    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Nama',
            'Jenis',
            'Harga Beli',
            'Laba',
            'Supplier',
        ];
    }
    public function map($masterItem): array
    {
        $hargaJual = $masterItem->harga_beli + ($masterItem->harga_beli * $masterItem->laba / 100);

        return [
            $this->no++,
            $masterItem->categories->pluck('nama')->join(', '),
            $masterItem->nama,
            $masterItem->supplier,
            $masterItem->harga_beli,
            $masterItem->laba,
            $hargaJual
        ];
    }
}
