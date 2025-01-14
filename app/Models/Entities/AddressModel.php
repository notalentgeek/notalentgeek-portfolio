<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddressModel extends BaseModel
{
    use HasFactory;

    // Define the Table Fields That Can Be Mass-Assigned
    protected $fillable = [
        'name',
        'street',
        'street_number',
        'floor',
        'room_number',
        'subdistrict',
        'district',
        'city',
        'state',
        'postal_code',
        'country',
        'full_address',
        'additional_notes',
        'link',
        'latitude',
        'longitude',
    ];

    // The slug is automatically handled by BaseModel.
    protected static function booted()
    {
        parent::booted();

        // Automatically Build the Full Address When Saving
        static::saving(function ($model) {
            $model->full_address = $model->buildFullAddress();
        });
    }

    // Build Full Address Based on the Available Fields
    protected function buildFullAddress()
    {
        // Gather All Address Parts and Remove Empty Ones
        $addressParts = array_filter([
            $this->street,
            $this->street_number,
            $this->floor ? 'Floor ' . $this->floor : null,
            $this->room_number ? 'Room ' . $this->room_number : null,
            $this->subdistrict,
            $this->district,
            $this->city,
            $this->state,
            $this->postal_code,
            $this->country,
        ]);

        // Join the Valid Parts With Commas and Return the Cleaned Full Address
        return implode(', ', $addressParts);
    }

    // Relationship With the `ContactModel` for Contacts
    public function contacts(): BelongsToMany
    {
        return $this->belongsToMany(
            ContactModel::class,
            DatabaseConstant::PIVOT_TABLE_ADDRESS_CONTACT,
            'address_id',
            'contact_id',
        )->withPivot(
            'active',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at'
        );
    }

    // Relationship With the `AchievementModel` for Achievements
    public function achievements(): BelongsToMany
    {
        return $this->belongsToMany(
            Achievement::class,
            DatabaseConstant::PIVOT_TABLE_ACHIEVEMENT_ADDRESS,
            'address_id',
            'achievement_id'
        )->withPivot(
            'active',
            'created_by',
            'updated_by',
            'created_at',
            'updated_at'
        );
    }
}
