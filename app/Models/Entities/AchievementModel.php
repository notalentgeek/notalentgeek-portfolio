<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AchievementModel extends BaseModel
{
    use HasFactory;

    // Define the Table Fields That Can Be Mass-Assigned
    protected $fillable = [
        'rank',
        'date',
        'name',
        'address_ids',
        'institution_contact_ids',
        'related_party_contact_ids',
        'description',
    ];

    // Define the JSON Typecast
    protected $casts = [
        'rank' => 'integer',
        'date' => 'datetime',
        'address_ids' => 'array',
        'institution_contact_ids' => 'array',
        'related_party_contact_ids' => 'array',
        'created_by' => 'integer',
        'updated_by' => 'integer',
        'deleted_by' => 'integer',
    ];

    // The slug is automatically handled by `BaseModel` .
    protected static function booted()
    {
        parent::booted();
    }

    // Relationship With the `AddressModel` for Address
    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(
            Address::class,
            'achievement_address',
            'achievement_id',
            'address_id',
        );
    }

    // Relationship With the `ContactModel` for Institutions
    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(
            Contact::class,
            'achievement_contact_institutions',
            'achievement_id',
            'contact_id',
        );
    }

    // Relationship With the `ContactModel` for Related Parties
    public function relatedParties(): BelongsToMany
    {
        return $this->belongsToMany(
            Contact::class,
            'achievement_contact_related_parties',
            'achievement_id',
            'contact_id',
        );
    }

    // Accessors and Mutators
    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->date ? Carbon::parse($this->date)->format('Y-m-d') : null,
            set: fn (array $value) => $this->attributes['date'] = $value ? Carbon::parse($value) : null,
        )->shouldCache();
    }

    protected function addressIds(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->addresses()->pluck('id')->toArray(),
            set: fn (array $value) => $this->addresses()->sync(
                $this->addresses()->pluck('id')->diff($value)
            ),
        )->shouldCache();
    }

    protected function institutionContactIds(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->institutions()->pluck('id')->toArray(),
            set: fn (array $value) => $this->institutions()->sync(
                $this->institutions()->pluck('id')->diff($value)
            ),
        )->shouldCache();
    }

    protected function relatedPartyContactIds(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->relatedParties()->pluck('id')->toArray(),
            set: fn (array $value) => $this->relatedParties()->sync(
                $this->relatedParties()->pluck('id')->diff($value)
            ),
        )->shouldCache();
    }
}
