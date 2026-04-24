<?php

namespace App\Exports;

use App\Models\Asset;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AssetsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Asset::select(
            'name',
            'category',
            'serial_number',
            'status',
            'assigned_to',
            'location'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Name',
            'Category',
            'Serial Number',
            'Status',
            'Assigned To',
            'Location',
        ];
    }
}