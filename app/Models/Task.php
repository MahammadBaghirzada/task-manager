<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Auth;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'is_done',
        'scheduled_at',
        'due_at',
    ];

    protected $casts = [
        'is_done' => 'boolean',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('member', function (Builder $builder) {
            $userId = Auth::id();
            $membershipIds = Auth::user()->memberships()->pluck('id')->toArray();

            $builder->where(function ($query) use ($userId, $membershipIds) {
                $query->where('creator_id', $userId)
                    ->orWhereIn('project_id', $membershipIds);
            });
        });
    }

    public function scopeScheduledBetween(Builder $query, string $fromDate, string $toDate)
    {
        $query->whereBetween('scheduled_at', [$fromDate, $toDate]);
    }

    public function scopeDueBetween(Builder $query, string $fromDate, string $toDate)
    {
        $query->whereBetween('due_at', [$fromDate, $toDate]);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
