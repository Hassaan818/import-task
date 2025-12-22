<?php

namespace App\Http\Controllers;

use App\Models\Record;
use Illuminate\Http\Request;

class RecordController extends Controller
{
    public function index()
    {
        $records = Record::latest()->paginate(1000); // 15 per page
        return view('records.index', compact('records'));
    }
}
