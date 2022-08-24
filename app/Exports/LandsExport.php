<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LandsExport implements FromView
{
    public function __construct($ids,$id){
        $this->ids = $ids;
        $this->id = $id;
    }

    public function view(): View{
        return view('report-excel', [
            'ids' => $this->ids,
            'id' => $this->id
        ]);
    }
}