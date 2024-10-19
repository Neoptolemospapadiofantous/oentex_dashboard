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
            return response()->json([
                'data' => $documents['data'] ?? [], // Use null coalescing to prevent errors
                'total' => $documents['total'] ?? 0
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching documents: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve documents'], 500);
        }
    }

    // Method to upload a document
    public function uploadDocument(Request $request)
    {
        $request->validate([
            'file' => 'required|file|max:2048|mimes:txt,pdf,docx',
        ]);
        
        try {
            $file = $request->file('file');
            $uploadResponse = $this->voiceflowService->uploadDocument($file);

            if (isset($uploadResponse['error'])) {
                Log::error('Upload error: ' . $uploadResponse['error']);
                return response()->json(['error' => 'Failed to upload document: ' . $uploadResponse['error']], 500);
            }

            return response()->json($uploadResponse);
        } catch (\Exception $e) {
            Log::error('Error uploading document: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to upload document'], 500);
        }
    }

    // Method to upload a document from URL
    public function uploadDocumentFromUrl(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        try {
            $uploadResponse = $this->voiceflowService->uploadDocumentFromUrl($request->input('url'));

            if (isset($uploadResponse['error'])) {
                Log::error('Upload from URL error: ' . $uploadResponse['error']);
                return response()->json(['error' => 'Failed to upload document from URL: ' . $uploadResponse['error']], 500);
            }

            return response()->json($uploadResponse);
        } catch (\Exception $e) {
            Log::error('Error uploading document from URL: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to upload document from URL'], 500);
        }
    }

    // Method to upload table data
    public function uploadTableData(Request $request)
    {
        $request->validate([
            'tableData' => 'required|array',
            'overwrite' => 'boolean',
        ]);

        try {
            $uploadResponse = $this->voiceflowService->uploadTableData($request->input('tableData'), $request->input('overwrite', false));

            if (isset($uploadResponse['error'])) {
                Log::error('Upload table data error: ' . $uploadResponse['error']);
                return response()->json(['error' => 'Failed to upload table data: ' . $uploadResponse['error']], 500);
            }

            return response()->json($uploadResponse);
        } catch (\Exception $e) {
            Log::error('Error uploading table data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to upload table data'], 500);
        }
    }

    // Method to delete a document
    public function deleteDocument($documentID)
    {
        try {
            $deleteResponse = $this->voiceflowService->deleteDocument($documentID);

            if (isset($deleteResponse['error'])) {
                Log::error('Delete document error: ' . $deleteResponse['error']);
                return response()->json(['error' => 'Failed to delete document: ' . $deleteResponse['error']], 500);
            }

            return response()->json($deleteResponse);
        } catch (\Exception $e) {
            Log::error('Error deleting document: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete document'], 500);
        }
    }

    // Method to replace a document
    public function replaceDocument(Request $request, $documentID)
    {
        $request->validate([
            'file' => 'required|file|max:2048|mimes:txt,pdf,docx',
        ]);

        try {
            $file = $request->file('file');
            $replaceResponse = $this->voiceflowService->replaceDocument($documentID, $file);

            if (isset($replaceResponse['error'])) {
                Log::error('Replace document error: ' . $replaceResponse['error']);
                return response()->json(['error' => 'Failed to replace document: ' . $replaceResponse['error']], 500);
            }

            return response()->json($replaceResponse);
        } catch (\Exception $e) {
            Log::error('Error replacing document: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to replace document'], 500);
        }
    }

    // Method to replace a document with a URL
    public function replaceDocumentWithUrl(Request $request, $documentID)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        try {
            $replaceResponse = $this->voiceflowService->replaceDocumentWithUrl($documentID, $request->input('url'));

            if (isset($replaceResponse['error'])) {
                Log::error('Replace document with URL error: ' . $replaceResponse['error']);
                return response()->json(['error' => 'Failed to replace document with URL: ' . $replaceResponse['error']], 500);
            }

            return response()->json($replaceResponse);
        } catch (\Exception $e) {
            Log::error('Error replacing document with URL: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to replace document with URL'], 500);
        }
    }

    // Method to get a document chunk
    public function getDocumentChunk($documentID)
    {
        try {
            // Call to Voiceflow API to get document details, including chunks
            $response = $this->voiceflowService->getDocumentChunk($documentID);
            
            // Return the response as JSON
            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('Error retrieving document chunk: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve document chunk'], 500);
        }
    }
}
