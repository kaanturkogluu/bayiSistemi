<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ErrorReportMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ErrorReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string|min:10',
            'screenshot' => 'nullable|image|max:5120', // Max 5MB
        ]);

        $fullPath = null;
        if ($request->hasFile('screenshot')) {
            $path = $request->file('screenshot')->store('error_reports', 'local');
            $fullPath = Storage::disk('local')->path($path);
        }

        try {
            Mail::to('kaantrrkoglu@gmail.com')->send(new ErrorReportMail(
                $request->description,
                auth()->user(),
                $fullPath
            ));

            return response()->json([
                'success' => true,
                'message' => 'Hata bildiriminiz başarıyla iletildi. Teşekkür ederiz!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error reporting mail failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Hata bildirimi gönderilirken bir sorun oluştu. Lütfen daha sonra tekrar deneyin.'
            ], 500);
        } finally {
            // Cleanup the temporary file if needed, though Mailable handles it if not queued.
            // If queued, we should keep it until it's sent.
            // For now, let's leave it in storage/app/error_reports for a while.
        }
    }
}
