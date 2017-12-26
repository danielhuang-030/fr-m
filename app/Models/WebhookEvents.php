<?php

namespace App\Models;

class WebhookEvents extends Model
{
    protected $table = 'webhook_events';
    protected $guarded = ['id'];

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

}
