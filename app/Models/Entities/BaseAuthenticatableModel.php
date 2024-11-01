<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

abstract class BaseAuthenticatableModel extends Authenticatable
{
    use SoftDeletes;

    // Automatically Handle the `created_by` , `updated_by` , and `deleted_by` Fields
    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });

        static::deleting(function ($model) {
            $model->deleted_by = Auth::id();
            $model->save();
        });
    }

    // Default Fields to Be Added
    protected $fillable = ['name', 'slug'];

    // Automatically Manage UUIDs
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            if (empty($model->slug) && !empty($model->name)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    // Relationships: `created_by`, `updated_by`, `deleted_by` (Assuming You Use A User Model)
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
}
