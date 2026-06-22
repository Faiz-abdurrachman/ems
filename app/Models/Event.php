<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    protected $fillable = [
        'title',
        'description',
        'event_date',
        'location',
        'quota',
        'status',
        'image',
        'category_id',
    ];

    protected $casts = [
        'event_date' => 'datetime',
        'quota' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function participants()
    {
        return $this->belongsToMany(Participant::class, 'registrations')
            ->withPivot('registration_date')
            ->withTimestamps();
    }
}
