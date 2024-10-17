<?php

namespace App\Models;

class VoiceflowAnalytics
{
    public $metric;
    public $value;

    public function __construct($metric, $value)
    {
        $this->metric = $metric;
        $this->value = $value;
    }
}
