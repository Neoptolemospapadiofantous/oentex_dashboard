<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VoiceflowService;
use Illuminate\Support\Facades\Log;

class VoiceflowAnalyticsController extends Controller
{
    protected $voiceflowService;

    public function __construct(VoiceflowService $voiceflowService)
    {
        $this->voiceflowService = $voiceflowService;
    }

    public function getAnalyticsData(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'startTime' => 'required|date',
            'endTime' => 'required|date',
            'projectID' => 'required|string',
            'apiKey' => 'required|string',
        ]);

        try {
            $data = $this->voiceflowService->getAnalyticsData(
                $request->input('projectID'),
                $request->input('apiKey'),
                $request->input('startTime'),
                $request->input('endTime'),
                $request->input('name')
            );
            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error fetching analytics data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve data'], 500);
        }
    }
}
