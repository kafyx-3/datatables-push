<?php

namespace Kafyx3\DataTablesExport\View\Components;

use Illuminate\View\Component;

class Table extends Component
{
    /**
     * ID unik elemen <table>. Wajib diisi.
     */
    public string $id;

    /**
     * Tombol export yang ditampilkan.
     * Contoh: ['copy', 'csv', 'excel', 'pdf', 'print']
     */
    public array $buttons;

    /**
     * Indeks kolom yang ikut diekspor (0-based).
     * null  = semua kolom ikut ekspor.
     * array = hanya kolom dengan indeks tersebut.
     *
     * Contoh: :exportColumns="[0,1,2]" akan ekspor kolom ke-1, 2, dan 3.
     */
    public ?array $exportColumns;

    public function __construct(
        string $id,
        array $buttons = [],
        ?array $exportColumns = null
    ) {
        $this->id            = $id;
        $this->buttons       = $buttons ?: config('datatables-export.default_buttons', ['copy', 'csv', 'excel', 'pdf', 'print']);
        $this->exportColumns = $exportColumns;
    }

    public function render()
    {
        return view('datatables-export::components.table');
    }
}
