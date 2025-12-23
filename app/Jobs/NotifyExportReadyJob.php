<?php

namespace App\Jobs;

use App\Mail\ExportReadyMail;
use App\Models\Export;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class NotifyExportReadyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $email,
        public string $filePath
    ) {}

    public function handle()
    {
        if (!Storage::disk('public')->exists($this->filePath)) {
            throw new \Exception('Export file missing after queue');
        }

        $url = Storage::disk('public')->url($this->filePath);

        Mail::to($this->email)->send(new ExportReadyMail($url));

        Export::create([
            'export_name' => basename($this->filePath),
            'path' => $this->filePath,
            'status' => 'completed',
            'url' => $url,
        ]);
    }
}
