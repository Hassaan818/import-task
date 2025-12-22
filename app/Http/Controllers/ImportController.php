<?php

namespace App\Http\Controllers;

use App\Imports\ProductCsvImport;
use App\Models\Import;
use App\Services\GoogleCsvService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function import(Request $request, GoogleCsvService $googleCsv)
    {
        $request->validate([
            'source' => 'required|in:sheet,drive',
            'sheet_id' => 'required_if:source,sheet',
            'file_id' => 'required_if:source,drive',
        ]);

        $import = Import::create([
            'user_id' => auth()->id(),
            'source' => $request->source,
            'sheet_id' => $request->sheet_id ?? null,
            'file_id' => $request->file_id ?? null,
            'status' => 'started',
        ]);

        try {
            if ($request->source === 'sheet') {
                $path = $googleCsv->fromSheet(auth()->user(), $request->sheet_id);
            } else {
                $path = $googleCsv->fromDrive(auth()->user(), $request->file_id);
            }

            $import->update([
                'status' => 'queued',
            ]);

            Excel::queueImport(new ProductCsvImport($import->id), $path);
        } catch (\Exception $e) {
            $import->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);

            return back()->with('error', 'Import failed: ' . $e->getMessage());
        }
        if (!file_exists($path)) {
            return back()->withErrors(['error' => "File not found at: {$path}"]);
        }


        return back()->with('success', 'CSV Added successfully');
    }

    public function getImports()
    {
        $data = Import::orderBy('created_at', 'desc')->paginate(10);
        return view('imports.index', [
            'data' => $data
        ]);
    }
}
