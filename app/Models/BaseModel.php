<?php

namespace App\Models;

use App\Models\Traits\HasAccessorsMutatorsTraits;
use Carbon\Carbon;
use Helpers\SlugHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

abstract class BaseModel extends Model
{
    use HasAccessorsMutatorsTraits, SoftDeletes;

    public static function booted()
    {
        parent::booted();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->created_by = Auth::id();

            // Check if `name` Is Non-empty (Not Empty String or Spaces)
            if (trim($model->name)) {
                $model->slug = SlugHelper::generateUniqueSlug($model->name, self::class);
            } else {
                // Set `slug` To Empty if `name` Is Empty or Just Spaces
                $model->slug = '';
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name')) {
                $model->slug = SlugHelper::generateUniqueSlug($model->name, self::class);
            }
            $model->updated_by = Auth::id();
        });

        static::deleting(function ($model) {
            $model->deleted_by = Auth::id();
        });

        static::deleted(function ($model) {
            $model->save();
        });
    }

    // Relationships: `created_by`, `updated_by`, and `deleted_by`
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(User::class, 'deleted_by');
    }

    // Timestamps (Handled Automatically By Laravel)

    // Getters and Setters
    // Define the Table Fields That Can Be Mass-Assigned
    public function getFillable()
    {
        return array_merge(parent::getFillable(), [
            'uuid',
            'name',
        ]);
    }

    // Define the JSON Typecast
    public function getCasts()
    {
        return array_merge(parent::getCasts(), [
            'uuid' => 'string',
            'created_by' => 'integer',
            'updated_by' => 'integer',
            'deleted_by' => 'integer',
        ]);
    }
}
