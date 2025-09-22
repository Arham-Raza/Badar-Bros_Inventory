<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AttachmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'attachments.*' => 'required|file|mimes:pdf,jpeg,png,svg|max:10240',
            'attachable_type' => 'required|string',
            'attachable_id' => 'required|integer',
        ]);
        try {
            $files = $request->file('attachments');
            $saved = [];
            foreach ($files as $file) {
                $path = $file->store('attachments');
                $attachment = Attachment::create([
                    'attachable_type' => $request->attachable_type,
                    'attachable_id' => $request->attachable_id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                    'mime_type' => $file->getClientMimeType(),
                ]);
                $saved[] = $attachment;
            }
            return response()->json(['success' => true, 'attachments' => $saved]);
        } catch (\Throwable $e) {
            Log::error('AttachmentController@store error: ' . $e->getMessage(), ['exception' => $e]);
            return response()->json(['success' => false, 'error' => 'Failed to upload attachments.'], 500);
        }
    }

    public function show($id)
    {
        $attachment = Attachment::findOrFail($id);
        return response()->file(storage_path('app/' . $attachment->file_path));
    }
}
