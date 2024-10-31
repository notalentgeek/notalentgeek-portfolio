<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AchievementModel extends BaseModel
{
    use HasFactory;

    // Define the Table Fields That Can Be Mass-Assigned
    protected $fillable = [
        'rank',
        'date',
        'name',
        'location_id',
        'description',
    ];

    // The slug is automatically handled by `BaseModel` .
    protected static function booted()
    {
        parent::booted();
    }

    // Relationship With the `LocationModel` for Location
    public function location(): BelongsTo
    {
        return $this->belongsTo(LocationModel::class, 'location_id');
    }

    // Relationship With the `ContactModel` for Institutions
    public function institutions(): BelongsToMany
    {
        return $this->hasMany(
            Contact::class,
            'achievement_id',
        );
    }

    // Relationship With the `ContactModel` for Related Parties
    public function relatedParties(): BelongsToMany
    {
        return $this->hasMany(
            Contact::class,
            'achievement_id',
        );
    }
}
