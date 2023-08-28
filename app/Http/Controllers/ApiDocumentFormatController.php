<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DataDocument;
use Illuminate\Http\Request;
use App\Models\DocumentFormatter;
use Illuminate\Support\Facades\Log;

class ApiDocumentFormatController extends Controller
{
    public function createDocument($id, Request $request)
    {
        $format = DocumentFormatter::findOrFail($id);
        $data = $request->json()->all();
        $datadokumen = [];
        foreach ($data as $name => $value) {
            if ($name != '_token' and $name != 'judul' and $name != 'user') {
                $datadokumen[] = [$name => $value];
            }
        }
        $jsondokumen = json_encode($datadokumen);
        $datadok = DataDocument::create([
            'user_id' => $request['user']->id,
            'format_id' => $id,
            'name' => $request->judul,
            'data_dokumen' => $jsondokumen
        ]);
        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(config('app.url') . $format->url_file);
        foreach (json_decode($datadok->data_dokumen) as $item) {
            foreach ($item as $key => $value) {
                if ($key != 'judul') {
                    $templateProcessor->setValue($key, $value);
                    // Log::info($key.'|'.$value);
                }
            }
        }
        $randint = random_int(100000,999999);
        $filePath = storage_path('app/public/' . $datadok->format_id . '/' . $datadok->name . '-' . $randint . '.docx');
        $directory = dirname($filePath);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        $templateProcessor->saveAs($filePath);
        $url_file = config('app.url').'/storage/' . $datadok->format_id . '/' . $datadok->name . '-' . $randint . '.docx';
        $jsonarray = [
            'url_file'=> $url_file,
            'dokument_id' => $datadok->id,
            'format_id'=>$datadok->format_id,
            'status' => 200
        ];
        return response()->json($jsonarray);
    }
}
