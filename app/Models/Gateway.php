<?php

namespace App\Models;

class Gateway extends Model
{
    protected $table = 'gateways';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function webhookEvents()
    {
        return $this->hasMany(WebhookEvents::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
