<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VoiceflowService;
use Illuminate\Support\Facades\Log;

class VoiceflowDocumentController extends Controller
{
    protected $voiceflowService;

    public function __construct(VoiceflowService $voiceflowService)
    {
        $this->voiceflowService = $voiceflowService;
    }

    // Method to get documents
    public function getDocuments(Request $request)
    {
        try {
            $documents = $this->voiceflowService->getDocuments($request->all());
            return response()->json($documents);
        } catch (\Exception $e) {
            Log::error('Error fetching documents: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve documents'], 500);
        }
    }

   // Method to upload a document
   public function uploadDocument(Request $request)
   {
       $request->validate([
           'file' => 'required|file|max:2048|mimes:txt,pdf,docx', // Validate file type and size
       ]);
       
       try {
           $file = $request->file('file'); // Get the uploaded file
           // Pass the file directly without modifying the path
           $uploadResponse = $this->voiceflowService->uploadDocument($file); // Call the service method with the file
   
           return response()->json($uploadResponse);
       } catch (\Exception $e) {
           Log::error('Error uploading document: ' . $e->getMessage());
           return response()->json(['error' => 'Failed to upload document'], 500);
       }
   }
}
