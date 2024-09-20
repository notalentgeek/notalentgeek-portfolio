<?php

namespace App\Models;

use App\helpers\SlugHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

abstract class BaseModel extends Model
{
    use SoftDeletes;

    // Default Fields to Be Added
    protected $fillable = ['name'];

    public static function booted()
    {
        parent::booted();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
            $model->slug = SlugHelper::generateUniqueSlug($model->name, self::class);
            $model->created_by = Auth::id();
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

    // Relationships: `created_by` , `updated_by` , `deleted_by` (Assuming You Use A User Model)
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
