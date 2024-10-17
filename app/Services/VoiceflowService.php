<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class VoiceflowService
{
    protected $client;
    protected $token;

    public function __construct()
    {
        // Initialize the Guzzle HTTP client with the Voiceflow API base URI for documents
        $this->client = new Client([
            'base_uri' => 'https://api.voiceflow.com/v1/',
        ]);
        
        // Set the authorization token from the environment variable
        $this->token = env('VOICEFLOW_API_TOKEN');

        // Ensure the token is set
        if (empty($this->token)) {
            Log::error('Authorization token is missing');
            throw new \Exception('Authorization token is missing');
        }
    }

    /**
     * Fetch analytics data from Voiceflow API.
     *
     * @param string $projectID
     * @param string $startTime
     * @param string $endTime
     * @param string $name
     * @return array
     */
    public function getAnalyticsData($projectID, $startTime, $endTime, $name)
    {
        try {
            // Prepare the query for analytics data
            $query = [
                'query' => [
                    [
                        'name' => $name,
                        'filter' => [
                            'projectID' => $projectID,
                            'startTime' => $startTime,
                            'endTime' => $endTime,
                        ],
                    ],
                ],
            ];

            // Send a POST request to the analytics endpoint
            $response = $this->client->post('https://analytics-api.voiceflow.com/v1/query/usage', [
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ],
                'json' => $query,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Log specific error message if the response is available
            if ($e->hasResponse()) {
                $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
                Log::error('Error fetching analytics data: ' . $errorResponse['message'] ?? $e->getMessage());
                return ['error' => $errorResponse['message'] ?? 'Failed to retrieve data'];
            }
            // General error logging for other exceptions
            Log::error('Error fetching analytics data: ' . $e->getMessage());
            return ['error' => 'Failed to retrieve data'];
        }
    }

    /**
     * Get documents from the Voiceflow knowledge base.
     *
     * @param array $params
     * @return array
     */
    public function getDocuments($params)
    {
        try {
            // Send a GET request to retrieve documents
            $response = $this->client->get('knowledge-base/docs', [
                'query' => [
                    'page' => $params['page'] ?? 1,
                    'limit' => $params['limit'] ?? 10,
                    'documentType' => $params['documentType'] ?? null,
                    'includeTags' => $params['includeTags'] ?? [],
                    'excludeTags' => $params['excludeTags'] ?? [],
                    'includeAllNonTagged' => $params['includeAllNonTagged'] ?? false,
                    'includeAllTagged' => $params['includeAllTagged'] ?? false,
                ],
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json'
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Log specific error message if the response is available
            if ($e->hasResponse()) {
                $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
                Log::error('Error fetching documents: ' . $errorResponse['message'] ?? $e->getMessage());
                return ['error' => $errorResponse['message'] ?? 'Failed to retrieve documents'];
            }
            // General error logging for other exceptions
            Log::error('Error fetching documents: ' . $e->getMessage());
            return ['error' => 'Failed to retrieve documents'];
        }
    }

    /**
     * Upload a document to Voiceflow.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param bool $overwrite
     * @param int $maxChunkSize
     * @return array
     */
    public function uploadDocument($file, $overwrite = false, $maxChunkSize = 1000)
    {
        try {
            // Ensure maxChunkSize is within the allowed range
            if ($maxChunkSize < 500 || $maxChunkSize > 1500) {
                Log::error('maxChunkSize must be between 500 and 1500, given: ' . $maxChunkSize);
                return ['error' => 'maxChunkSize must be between 500 and 1500'];
            }

            // Prepare the query parameters
            $query = [
                'maxChunkSize' => $maxChunkSize,
                'overwrite' => $overwrite ? 'True' : 'False',
            ];

            // Send a POST request to upload a document
            $response = $this->client->post('knowledge-base/docs/upload', [
                'query' => $query,
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ],
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($file->getRealPath(), 'r'), // Use getRealPath for file contents
                        'filename' => $file->getClientOriginalName(), // Provide original name
                    ],
                ],
            ]);

            // Decode and return the response
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Log specific error message if the response is available
            if ($e->hasResponse()) {
                $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
                Log::error('Error uploading document: ' . $errorResponse['message'] ?? $e->getMessage());
                return ['error' => $errorResponse['message'] ?? 'Failed to upload document'];
            }
            // General error logging for other exceptions
            Log::error('Error uploading document: ' . $e->getMessage());
            return ['error' => 'Failed to upload document'];
        }
    }
}