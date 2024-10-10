<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Inertia\Inertia;

class VoiceflowAnalyticsController extends Controller
{
    // Fetch Interactions Data from Voiceflow API
    public function getInteractions()
    {
        $client = new Client();
        try {
            $response = $client->request('POST', 'https://analytics-api.voiceflow.com/v1/query/usage', [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'VF.DM.66f2a65d8d9312ecde1d7264.G7z7QOHV97maEKi1', // Replace with your Voiceflow token
                    'content-type' => 'application/json',
                ],
                'json' => [
                    'query' => [
                        [
                            'name' => 'interactions',
                            'filter' => [
                                'projectID' => '66e5a810791dba93cee4e8b7', // Replace with your projectID
                            ],
                        ],
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve interactions: ' . $e->getMessage()], 500);
        }
    }

    // Fetch Sessions Data from Voiceflow API
    public function getSessions()
    {
        $client = new Client();
        try {
            $response = $client->request('POST', 'https://analytics-api.voiceflow.com/v1/query/usage', [
                'headers' => [
                    'accept' => 'application/json',
                    'authorization' => 'VF.DM.66f2a65d8d9312ecde1d7264.G7z7QOHV97maEKi1', // Replace with your Voiceflow token
                    'content-type' => 'application/json',
                ],
                'json' => [
                    'query' => [
                        [
                            'name' => 'sessions',
                            'filter' => [
                                'projectID' => '66e5a810791dba93cee4e8b7', // Replace with your projectID
                            ],
                        ],
                    ],
                ],
            ]);

            $data = json_decode($response->getBody(), true);
            return response()->json($data);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve sessions: ' . $e->getMessage()], 500);
        }
    }
}
