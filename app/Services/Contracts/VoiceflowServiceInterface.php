<?php

namespace App\Services\Contracts;

interface VoiceflowServiceInterface
{
    public function getAnalyticsData($projectID, $token, $startTime, $endTime, $name);

    public function getDocuments($params);

    public function uploadDocument($token, $filePath);
}
