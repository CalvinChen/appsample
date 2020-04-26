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

    public function getStatusDescAttribute()
    {
        $status = [
            0 => '已取回',
            2 => '上架中',
            6 => '买家取走',
        ];
        return $status[$this->status] ?? '未知';
    }
}
