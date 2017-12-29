<?php

namespace App\Models;

class WebhookEvent extends Model
{
    protected $table = 'webhook_events';

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

}
