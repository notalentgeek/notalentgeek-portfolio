<?php

namespace App\Models\Entities;

use App\Constants\DatabaseConstant;
use App\Models\Traits\HasAccessorsMutatorsTraits;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AchievementModel extends BaseModel
{
    use HasAccessorsMutatorsTraits, HasFactory;

    // Relationship With the `AddressModel` for Address
    public function addresses(): BelongsToMany
    {
        return $this->belongsToMany(
            Address::class,
            DatabaseConstant::PIVOT_TABLE_ACHIEVEMENT_ADDRESS,
            'achievement_id',
            'address_id',
        );
    }

    // Relationship With the `ContactModel` for Institutions
    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(
            Contact::class,
            DatabaseConstant::PIVOT_TABLE_ACHIEVEMENT_CONTACT_INSTITUTIONS,
            'achievement_id',
            'contact_id',
        );
    }

    // Relationship With the `ContactModel` for Related Parties
    public function relatedParties(): BelongsToMany
    {
        return $this->belongsToMany(
            Contact::class,
            DatabaseConstant::PIVOT_TABLE_ACHIEVEMENT_CONTACT_RELATED_PARTIES,
            'achievement_id',
            'contact_id',
        );
    }

    // Accessors and Mutators
    protected function date(): Attribute
    {
        return $this->dateAccessorMutator();
    }

    protected function addressIds(): Attribute
    {
        return $this->relationshipAccessor('addresses');
    }

    protected function institutionContactIds(): Attribute
    {
        return $this->relationshipAccessor('institutions');
    }

    protected function relatedPartyContactIds(): Attribute
    {
        return $this->relationshipAccessor('relatedParties');
    }

    // Getters and Setters
    // Define the Table Fields That Can Be Mass-Assigned
    public function getFillable()
    {
        return array_merge(parent::getFillable(), [
            'rank',
            'date',
            'address_ids',
            'institution_contact_ids',
            'related_party_contact_ids',
            'description',
        ]);
    }

    // Define the JSON Typecast
    public function getCasts()
    {
        return array_merge(parent::getCasts(), [
            'rank' => 'integer',
            'date' => 'datetime',
            'address_ids' => 'array',
            'institution_contact_ids' => 'array',
            'related_party_contact_ids' => 'array',
        ]);
    }
}
