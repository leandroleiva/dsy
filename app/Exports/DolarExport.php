<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DolarExport implements FromCollection, WithHeadings
{
    use Exportable;
    public function __construct($items)
    {
        $this->items = $items;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect($this->items);
    }

    public function headings(): array
    {
        return ["Valor Dolar", "Fecha"];
    }
}
