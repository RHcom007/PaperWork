<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Kwitansi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DocumentController extends Controller
{
    public function CreateInvoices()
    {
        return view('document.create-invoices');
    }
    public function InsertInvoices(Request $req)
    {
        $validated = $req->validate([
            'project_id' => 'nullable|string',
            'invoice_id' => 'nullable|string',
            'nama_client' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'alamat_detail' => 'required|string',
            'invoices' => 'required|array',
            'invoice_description' => 'required|array',
            'invoice_category' => 'required|array',
            'invoice_fee' => 'required|array',
            'additional_informations' => 'required|array'
        ]);
        $invoicesData = [];

        for ($i = 0; $i < count($validated['invoices']); $i++) {
            $invoice = [
                'name' => $validated['invoices'][$i],
                'description' => $validated['invoice_description'],
                'category' => $validated['invoice_category'],
                'fee' => $validated['invoice_fee']
            ];
        
            $invoicesData[] = $invoice;
        }
        
        $invoicesJson = json_encode($invoicesData);
        Invoice::create([
            'project_id'=> $validated['project_id'],
            'invoice_id'=> $validated['project_id'],
            'user_id'=> auth()->user()->id,
            'nama_client' => $validated['nama_client'],
            'alamat_detail' => $validated['alamat_detail'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'invoices' => $invoicesData,
            'additional_informations' => json_encode($validated['additional_informations'])
        ]);
        return redirect('/dashboard');
    }
    public function CreateInvoicesDocument($id)
    {
        $data = Invoice::find($id)->get()->first();
        $data['created'] = Carbon::parse($data['created_at'])->format('d-m-Y');
        $data['enddate'] = Carbon::parse($data['created_at'])->format('d-m-Y');
        return view('document.invoice', ['data'=>$data]);
    }
    public function CreateInvoicePDF(Request $req){
        $url = config('app.url').'/make/kwitansi';
        $response = Http::post($url, $req);

        if ($response->failed()) {
            return abort(500, 'Failed to fetch HTML content from the remote server.');
        }

        $html = $response->body();
        // echo $html;
        // exit;

        if ($html === false) {
            return abort(500, 'Failed to fetch HTML content from the remote server.');
        }

        $response = Http::post("https://yakpdf.p.rapidapi.com/pdf", [
            'source' => ['html' => $html],
            'pdf' => ['format' => 'A4', 'scale' => 1, 'printBackground' => true],
            'wait' => ['for' => 'navigation', 'waitUntil' => 'load', 'timeout' => 2500]
        ], [
            "X-RapidAPI-Host" => "yakpdf.p.rapidapi.com",
            "X-RapidAPI-Key" => "f545e655femshac30171bd2e44d4p164cecjsnf04f7ae32e18",
            "content-type" => "application/json"
        ]);

        if ($response->failed()) {
            return abort(500, 'Failed to fetch HTML content from the remote server.');
        }

        $pdfData = $response->body();
        $filename = "invoice " . $_POST['nama_client'] . " " . date("d-m-Y") . ".pdf";

        // Simpan file PDF ke storage/invoices
        $filePath = 'invoices/' . $filename;
        Storage::put($filePath, $pdfData);

        // Set headers to force download the PDF
        return response($pdfData)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
    public function getInvoices()
    {
        $invoices = Invoice::latest();
    
        return DataTables::of($invoices)
            ->addColumn('action', function ($invoice) {
                return '<a href="/dokumen/invoice/'.$invoice.' class="btn btn-xs btn-primary">Lihat</a>';
            })
            ->make(true);
    }

    public function CreateKwitansi()
    {
        return view('document.create-kwitansi');
    }
    public function InsertKwitansi(Request $req)
    {
        $validated = $req->validate([
            'project_id' => 'nullable|string',
            'invoice_id' => 'nullable|string',
            'nama_pemberi' => 'required|string',
            'pembayaran' => 'required|string',
            'nominal' => 'required|string',
            'catatan' => 'required|array'
        ]);
        $invoice = new Invoice;
        $invoice = $invoice->where('invoice_id', '=', $validated['invoice_id'])->first();
        if($invoice){
            $invoice_id = $invoice->id;
        } else {
            $invoice_id = 'NOT SET';
        }
        $validated['nominal'] = (int) $validated['nominal'];
        Kwitansi::create([
            'project_id'=> $validated['project_id'],
            'kwitansi_id'=> 'NOT SET',
            'invoice_id'=> $invoice_id,
            'user_id'=> auth()->user()->id,
            'nama_pemberi' => $validated['nama_pemberi'],
            'nominal' => $validated['nominal'],
            'pembayaran' => $validated['pembayaran'],
            'catatan' => json_encode($validated['catatan'])
        ]);
        return redirect('/dashboard');
    }
    public function CreateKwitasiDocument($id){
        $data = Kwitansi::find($id);
        return view('document.kwitansi',[
            "data" => $data,
            "tanggal" => Carbon::parse($data['created_at'])->format('d-m-Y'),
        ]);
    }
    public function CreateKwitansiPDF(Request $req)
    {
        $url = config('app.url').'/make/invoice';
        $response = Http::post($url, $req);

        if ($response->failed()) {
            return abort(500, 'Failed to fetch HTML content from the remote server.');
        }

        $html = $response->body();
        // echo $html;

        if ($html === false) {
            return abort(500, 'Failed to fetch HTML content from the remote server.');
        }

        $response = Http::post("https://yakpdf.p.rapidapi.com/pdf", [
            'source' => ['html' => $html],
            'pdf' => ['format' => 'A4', 'scale' => 1, 'printBackground' => true],
            'wait' => ['for' => 'navigation', 'waitUntil' => 'load', 'timeout' => 2500]
        ], [
            "X-RapidAPI-Host" => "yakpdf.p.rapidapi.com",
            "X-RapidAPI-Key" => "f545e655femshac30171bd2e44d4p164cecjsnf04f7ae32e18",
            "content-type" => "application/json"
        ]);

        if ($response->failed()) {
            return abort(500, 'Failed to fetch HTML content from the remote server.');
        }

        $pdfData = $response->body();
        $filename = "invoice " . $_POST['nama_client'] . " " . date("d-m-Y") . ".pdf";

        // Simpan file PDF ke storage/invoices
        $filePath = 'invoices/' . $filename;
        Storage::put($filePath, $pdfData);

        // Set headers to force download the PDF
        return response($pdfData)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
    public function getKwitansi()
    {
        $invoices = Kwitansi::latest();
    
        return DataTables::of($invoices)
            ->addColumn('action', function ($invoice) {
                return '<a href="/dokumen/invoice/'.$invoice.' class="btn btn-xs btn-primary">Lihat</a>';
            })
            ->make(true);
    }
}
