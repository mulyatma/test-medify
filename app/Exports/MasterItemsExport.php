<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class MasterItemsExport implements FromCollection, WithHeadings, WithMapping, WithTitle
{
    public function collection()
    {
        return MasterItem::with('category')
            ->orderBy('id')
            ->get();
    }

    public function map($item): array
    {
        $namaKategori = $item->category
            ->pluck('nama')
            ->implode(', ');

        $hargaJual = $item->harga_beli + ($item->harga_beli * $item->laba / 100);

        return [
            $item->id,
            $namaKategori,
            $item->nama,
            $item->supplier,
            $item->harga_beli,
            $item->laba,
            round($hargaJual),
        ];
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama kategori',
            'Nama items',
            'Nama supplier',
            'Harga',
            'Laba',
            'Hargajual',
        ];
    }

    public function title(): string
    {
        return 'Master Items';
    }
}
