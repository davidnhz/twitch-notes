<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Streamer extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('id', 'desc');
        });
    }

    public function notes()
    {
        return $this->hasMany(StreamerNote::class);
    }

    public function addNote($attributes)
    {
        return $this->notes()->create($attributes);
    }
}
