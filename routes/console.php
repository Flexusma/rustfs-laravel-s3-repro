<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


Artisan::command('testfs', function () {
    $path = 'abc/test-' . Str::random(8) . '.pdf';

    // 1. Check before
    $existsBefore = Storage::exists($path);
    Log::debug('Exists before upload', [
        'path' => $path,
        'exists' => $existsBefore,
    ]);

    // 2. Create a minimal random PDF
    $pdfContent = "%PDF-1.4\n"
        . "1 0 obj\n<< /Type /Catalog /Pages 2 0 R >>\nendobj\n"
        . "2 0 obj\n<< /Type /Pages /Kids [3 0 R] /Count 1 >>\nendobj\n"
        . "3 0 obj\n<< /Type /Page /Parent 2 0 R /MediaBox [0 0 200 200] "
        . "/Contents 4 0 R /Resources << >> >>\nendobj\n"
        . "4 0 obj\n<< /Length 44 >>\nstream\n"
        . "BT /F1 12 Tf 10 100 Td (RustFS Test " . Str::random(6) . ") Tj ET\n"
        . "endstream\nendobj\n"
        . "xref\n0 5\n0000000000 65535 f \n"
        . "trailer\n<< /Root 1 0 R /Size 5 >>\n"
        . "startxref\n"
        . "%%EOF\n";

    // 3. Upload
    $putResult = Storage::put($path, $pdfContent);
    Log::debug('Put result', [
        'path' => $path,
        'success' => $putResult,
    ]);

    // 4. Check after
    $existsAfter = Storage::exists($path);
    Log::debug('Exists after upload', [
        'path' => $path,
        'exists' => $existsAfter,
    ]);

    $this->info('RustFS test completed. Check logs for details.');
})->purpose('Test rustfs exists');
