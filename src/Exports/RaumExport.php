<?php

namespace Hwkdo\IntranetAppRaumverwaltung\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class RaumExport implements FromView
{
    private $raume;

    public function __construct($raume)
    {
        $this->raume = $raume;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() : View
    {        
        return view('intranet-app-raumverwaltung::raume_xls', [
            'raume' => $this->raume
        ]);        
    }
}
