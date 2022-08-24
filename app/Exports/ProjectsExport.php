<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProjectsExport implements FromView
{
    public function view(): View{
        return view('projects-excel');
    }
}