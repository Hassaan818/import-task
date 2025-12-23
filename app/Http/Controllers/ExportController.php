<?php

namespace App\Http\Controllers;

use App\Exports\RecordExport;
use App\Jobs\ExportRecordsJob;
use App\Mail\ExportReadyMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        ExportRecordsJob::dispatch($request->email);

        return back()->with('success', 'A download link will be sent to your email once the export is ready.');
    }
}
