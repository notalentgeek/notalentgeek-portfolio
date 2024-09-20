<?php

namespace Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactModel extends BaseModel
{
    use HasFactory;

    // Define the Table Fields That Can Be Mass-Assigned
    protected $fillable = [
        'name',
        'alias',
    ];

    // The slug is automatically handled by `BaseModel` .
    protected static function booted()
    {
        parent::booted();
    }

    // One-to-Many Relationship With the `AddressModel` for Addresses
    public function addresses(): HasMany
    {
        return $this->hasMany(AddressModel::class, 'contact_id');
    }

    // One-to-Many Relationship With the `PhoneNumberModel` for Phone Numbers
    public function phoneNumbers(): HasMany
    {
        return $this->hasMany(PhoneNumberModel::class, 'contact_id');
    }

    // One-to-Many Relationship With the `EmailModel` for Emails
    public function emails(): HasMany
    {
        return $this->hasMany(EmailModel::class, 'contact_id');
    }

    // One-to-Many Relationship With the `LinkModel` for Links
    public function links(): HasMany
    {
        return $this->hasMany(LinkModel::class, 'contact_id');
    }
}
