<?php

namespace Helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AddressModel extends BaseModel
{
    use HasFactory;

    // Define the Table Fields That Can Be Mass-Assigned
    protected $fillable = [
        'name',          // Inherited from BaseModel
        'street',
        'city',
        'state',
        'postal_code',
        'country',
    ];

    // The slug is automatically handled by `BaseModel`.
    protected static function booted()
    {
        parent::booted();
    }

    // Belongs-To Relationship With the `ContactModel` for Contact
    public function contact(): BelongsTo
    {
        return $this->belongsTo(ContactModel::class, 'contact_id');
    }
}
