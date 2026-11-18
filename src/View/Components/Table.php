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
     * Class CSS pada elemen <table>.
     * Default 'display' (class bawaan DataTables).
     */
    public string $class;

    public function __construct(
        string $id,
        string $class = 'display'
    ) {
        $this->id    = $id;
        $this->class = $class;
    }

    public function render()
    {
        return view('datatables-export::components.table');
    }
}
