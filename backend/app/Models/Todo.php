<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
        'completed_at',
        'status'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'completed_at' => 'datetime'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';

    public static function getStatuses(): array
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_IN_PROGRESS,
            self::STATUS_COMPLETED
        ];
    }

    public function markAsCompleted(): void
    {
        $this->completed_at = now();
        $this->status = self::STATUS_COMPLETED;
        $this->save();
    }

    public function markAsInProgress(): void
    {
        $this->status = self::STATUS_IN_PROGRESS;
        $this->save();
    }

    public function markAsPending(): void
    {
        $this->status = self::STATUS_PENDING;
        $this->save();
    }
}