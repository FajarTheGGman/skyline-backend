<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

use App\Models\PlacesModels;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PlaceExports implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $data = PlacesModels::all();
        return view('excel.places', ['data' => $data]);
    }
}
