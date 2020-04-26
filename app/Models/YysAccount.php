<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YysAccount extends Model
{
    protected $guarded = [];

    protected $casts = [
        'yuhun' => 'array',
    ];

    public function scopeWhereNeedUpdate($builder)
    {
        return $builder->whereNull('hp');
    }

    public function getServerIdAttribute()
    {
        return explode('-', $this->sn)[1];
    }
}
