<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;

class VoiceflowService
{
    protected $client;
    protected $token;
    protected $projectID;
    
    public function __construct()
    {
        // Initialize the Guzzle HTTP client with the Voiceflow API base URI for documents
        $this->client = new Client([
            'base_uri' => 'https://api.voiceflow.com/v1/',
        ]);
        
        // Set the authorization token from the environment variable
        $this->token = env('VOICEFLOW_API_TOKEN');
        $this->projectID = env('VOICEFLOW_PROJECT_ID');

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
    public function getAnalyticsData($startTime, $endTime, $name)
    {
        try {
            // Prepare the query for analytics data
            $query = [
                'query' => [
                    [
                        'name' => $name,
                        'filter' => [
                            'projectID' => $this->projectID,
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
            $this->handleRequestException($e, 'fetching analytics data');
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
            $this->handleRequestException($e, 'fetching documents');
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
            $this->handleRequestException($e, 'uploading document');
            return ['error' => 'Failed to upload document'];
        }
    }

    /**
     * Upload a document from a URL to Voiceflow.
     */
    public function uploadDocumentFromUrl($url, $overwrite = false)
    {
        try {
            $response = $this->client->post('knowledge-base/docs/upload-url', [
                'json' => [
                    'url' => $url,
                    'overwrite' => $overwrite ? 'True' : 'False',
                ],
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleRequestException($e, 'uploading document from URL');
            return ['error' => 'Failed to upload document from URL'];
        }
    }

    /**
     * Upload table data to Voiceflow.
     */
    public function uploadTableData($tableData, $overwrite = false)
    {
        try {
            $response = $this->client->post('knowledge-base/docs/upload-table', [
                'json' => [
                    'tableData' => $tableData,
                    'overwrite' => $overwrite ? 'True' : 'False',
                ],
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleRequestException($e, 'uploading table data');
            return ['error' => 'Failed to upload table data'];
        }
    }

    /**
     * Delete a document from Voiceflow.
     */
    public function deleteDocument($documentID)
    {
        try {
            $response = $this->client->delete("knowledge-base/docs/{$documentID}", [
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleRequestException($e, 'deleting document');
            return ['error' => 'Failed to delete document'];
        }
    }

    /**
     * Retrieve document chunk.
     */
    public function getDocumentChunk($documentID)
    {
        try {
            // Make the GET request to the Voiceflow API
            $response = $this->client->get("https://api.voiceflow.com/v1/knowledge-base/docs/{$documentID}", [
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ]
            ]);
    
            // Decode and return the response
            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Handle any request exceptions here
            Log::error('Request error: ' . $e->getMessage());
            throw $e; // Rethrow to handle in controller
        }
    }
    /**
     * Replace a document (non-URL).
     */
    public function replaceDocument($documentID, $file)
    {
        try {
            // dd($file,$documentID);
            $response = $this->client->put("knowledge-base/docs/{$documentID}/upload", [
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ],
                'multipart' => [
                    [
                        'name' => 'file',
                        'contents' => fopen($file->getRealPath(), 'r'),
                        'filename' => $file->getClientOriginalName(),
                    ],
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleRequestException($e, 'replacing document');
            return ['error' => 'Failed to replace document'];
        }
    }

    /**
     * Replace a document (URL).
     */
    public function replaceDocumentWithUrl($documentID, $url)
    {
        try {
            $response = $this->client->put("knowledge-base/docs/{$documentID}", [
                'json' => ['url' => $url],
                'headers' => [
                    'Authorization' => $this->token,
                    'Accept' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            $this->handleRequestException($e, 'replacing document with URL');
            return ['error' => 'Failed to replace document with URL'];
        }
    }

    /**
     * Handle request exceptions and log errors.
     */
    protected function handleRequestException(RequestException $e, $action)
    {
        if ($e->hasResponse()) {
            $errorResponse = json_decode($e->getResponse()->getBody()->getContents(), true);
            Log::error("Error {$action}: " . ($errorResponse['message'] ?? $e->getMessage()));
        } else {
            Log::error("Error {$action}: " . $e->getMessage());
        }
    }
}
