<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SummaryExport implements FromView
{
    public function view(): View{
        return view('summary-excel');
    }
}