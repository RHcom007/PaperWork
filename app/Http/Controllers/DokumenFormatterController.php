<?php

namespace App\Http\Controllers;

use App\Models\DataDocument;
use Illuminate\Http\Request;
use App\Models\DocumentFormatter;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class DokumenFormatterController extends Controller
{
    public function Index()
    {
        $data = DocumentFormatter::latest()->get();
        return view('document_formatter', [
            "data" => $data
        ]);
    }

    public function Create()
    {
        return view('format.document_format_create');
    }

    public function Insert(Request $request)
    {
        $validate = $request->validate([
            "dokumen_upload" => "file|required",
            "judul" => "required|string",
            "keterangan" => "required|string",
            "name_form" => "required|array",
            "pattern" => "required|array"
        ]);

        $data = [];

        // Assuming both arrays have the same length
        for ($i = 0; $i < count($request->name_form); $i++) {
            $data[] = [
                'name_form' => $request->name_form[$i],
                'pattern' => $request->pattern[$i]
            ];
        }
        $jsonData = json_encode($data);
        $path = $request->file('dokumen_upload')->store('format', 'public');
        DocumentFormatter::create([
            'user_id' => auth()->user()->id,
            'judul' => $validate['judul'],
            'keterangan' => $validate['keterangan'],
            "name_form" => $jsonData,
            "url_file" => "/storage/" . $path
        ]);
        return redirect('/document')->with('success', 'Berhasil menambahkan data');
    }

    public function CreateDokumenFormat($id)
    {
        $data = DocumentFormatter::findOrFail($id);
        return view('format.document_maker', [
            'data' => $data
        ]);
    }

    public function CreateDokumen($id)
    {
        $data = DataDocument::where('format_id', $id)->get();
        return view('format.document_generate', [
            'data' => $data
        ]);
    }

    public function InsertDokumen(Request $request, $id)
    {
        $format = DocumentFormatter::findOrFail($id);
        $datadokumen = [];
        foreach ($request->all() as $name => $value) {
            if ($name != '_token') {
                $datadokumen[] = [$name => $value];
            }
        }
        $jsondokumen = json_encode($datadokumen);
        DataDocument::create([
            'user_id' => auth()->user()->id,
            'format_id' => $id,
            'name' => $request->judul,
            'data_dokumen' => $jsondokumen
        ]);
    }

    public function CreateDokumenGenerate($projectid, $id)
    {
        $format = DocumentFormatter::findOrFail($projectid);
        $data = DataDocument::findOrFail($id);
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(config('app.url') . $format->url_file);
        // Log::info($templateProcessor);
        // dd(json_decode($data->data_dokumen));
        foreach (json_decode($data->data_dokumen) as $item) {
            foreach ($item as $key => $value) {
                if ($key != '_token') {
                    // Log::info($key . '|' . $value);
                    $templateProcessor->setValue($key, $value);
                }
            }
        }
        $filePath = storage_path('app/public/' . $data->format_id . '/' . $data->id . '-' . random_int(100000,999999) . '.docx');
        $directory = dirname($filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        $templateProcessor->saveAs($filePath);
        return Redirect::away('/storage/' . $data->format_id . '/' . $data->id . '-' . random_int(100000,999999) . '.docx');
    }
}
