<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class GoogleCsvService
{
    public function fromSheet(User $user, string $sheetId): string
    {
        // 1️⃣ Get sheet name
        $meta = Http::withToken($user->google_token)
            ->get("https://sheets.googleapis.com/v4/spreadsheets/{$sheetId}");

        if ($meta->failed()) {
            throw new \Exception('Unable to fetch sheet metadata');
        }

        $sheetName = $meta->json('sheets.0.properties.title');

        // 2️⃣ Fetch values
        $response = Http::withToken($user->google_token)
            ->get("https://sheets.googleapis.com/v4/spreadsheets/{$sheetId}/values/" . urlencode($sheetName));

        if ($response->failed()) {
            throw new \Exception(
                'Google Sheets API error: ' . $response->json('error.message')
            );
        }

        $rows = $response->json('values');

        if (empty($rows)) {
            throw new \Exception('Google Sheet is empty');
        }

        // 3️⃣ Convert to CSV
        $csv = '';
        foreach ($rows as $row) {
            $csv .= implode(',', array_map(
                fn($v) => '"' . str_replace('"', '""', $v) . '"',
                $row
            )) . "\n";
        }

        // 4️⃣ Save
        $path = 'imports/products.csv';
        Storage::put($path, $csv);

        return Storage::path($path);
    }

    public function fromDrive(User $user, string $fileId): string
    {
        $metadata = Http::withToken($user->google_token)
            ->get("https://www.googleapis.com/drive/v3/files/{$fileId}")
            ->json();

        $isGoogleDoc = str_contains($metadata['mimeType'] ?? '', 'vnd.google-apps');

        if ($isGoogleDoc) {
            $url = "https://www.googleapis.com/drive/v3/files/{$fileId}/export?mimeType=text/csv";
        } else {
            $url = "https://www.googleapis.com/drive/v3/files/{$fileId}?alt=media";
        }

        $response = Http::withToken($user->google_token)->get($url);

        if ($response->failed()) {
            dd($response->json(), $response->status(), "URL used: $url");
        }

        $path = 'imports/products.csv';
        Storage::put($path, $response->body());

        return Storage::path($path);
    }
}
