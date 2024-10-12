<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class VoiceflowAnalyticsController extends Controller
{
    public function getAnalyticsData(Request $request)
    {
        $client = new Client();
        
        // Capture the request data
        $name = $request->input('name');  // The metric name (e.g., 'interactions', 'sessions', etc.)
        $startTime = $request->input('startTime');  // Start time
        $endTime = $request->input('endTime');      // End time
        $projectID = $request->input('projectID');  // Project ID
        $token = $request->input('apiKey');         // API key

        // Validate projectID and token
        if (!$projectID || !$token) {
            return response()->json(['error' => 'Project ID or API token missing.'], 400);
        }

        if (!$startTime || !$endTime) {
            return response()->json(['error' => 'Invalid startTime or endTime.'], 400);
        }

        try {
            // Prepare the query for Voiceflow API
            $query = [
                'name' => $name,
                'filter' => [
                    'projectID' => $projectID,
                    'startTime' => $startTime,
                    'endTime' => $endTime,
                ],
            ];

            // Send the POST request to Voiceflow API
            $response = $client->post('https://analytics-api.voiceflow.com/v1/query/usage', [
                'headers' => [
                    'Authorization' => $token,
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'query' => [$query],
                ],
            ]);

            // Decode the response from Voiceflow
            $data = json_decode($response->getBody(), true);
            return response()->json($data);

        } catch (\Exception $e) {
            Log::error('Error fetching analytics data: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to retrieve data: ' . $e->getMessage()], 500);
        }
    }
}
