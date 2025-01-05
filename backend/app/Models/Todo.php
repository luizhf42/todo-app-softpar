<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Todo extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'status'
    ];

    protected $dates = [
        'created_at',
        'completed_at'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in progress';
    const STATUS_COMPLETED = 'completed';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = Carbon::now('America/Sao_Paulo');
        });
    }

    public function getCreatedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->setTimezone('America/Sao_Paulo') : null;
    }

    public function getCompletedAtAttribute($value)
    {
        return $value ? Carbon::parse($value)->setTimezone('America/Sao_Paulo') : null;
    }

    public function markAsCompleted()
    {
        $this->completed_at = Carbon::now('America/Sao_Paulo');
        $this->status = self::STATUS_COMPLETED;
        $this->save();
    }

    public function markAsInProgress()
    {
        $this->status = self::STATUS_IN_PROGRESS;
        $this->completed_at = null;
        $this->save();
    }
}