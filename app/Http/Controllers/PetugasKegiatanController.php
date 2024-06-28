<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\PetugasImport;
use Maatwebsite\Excel\Facades\Excel;

class PetugasKegiatanController extends Controller
{
    public function import(Request $request)
    {
        Excel::import(new PetugasImport, $request->file('excel_file'));

        return redirect()->back();
    }
}
