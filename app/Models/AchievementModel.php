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
        'institution_ids',
        'location_id',
        'description',
        'related_party_ids',
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
        return $this->belongsToMany(Contact::class, 'achievement_contact_institutions', 'achievement_id', 'contact_id');
    }

    // Relationship With the `ContactModel` for Related Parties
    public function relatedParties(): BelongsToMany
    {
        return $this->belongsToMany(Contact::class, 'achievement_contact_related_parties', 'achievement_id', 'contact_id');
    }
}
