<?php

namespace App\Models;

class VoiceflowDocument
{
    public $id;
    public $name;
    public $status;
    public $created_at;

    public function __construct($id, $name, $status, $created_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->status = $status;
        $this->created_at = $created_at;
    }
}
