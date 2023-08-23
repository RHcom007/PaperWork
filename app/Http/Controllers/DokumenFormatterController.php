<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DocumentFormatter;

class DokumenFormatterController extends Controller
{
    public function Index () {
        $data = DocumentFormatter::latest();
        return view('document_formatter',[
            "data" => $data
        ]);
    }

    public function Create(){
        return view('format.document_format_create');
    }
}
