<?php

namespace App\Models\Traits;

use App\Constants\Format;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAccessorsMutatorsTraits
{
    protected function dateAccessorMutator(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format(FormatConstant::DATE_FORMAT) : null,
            set: fn ($value) => $value ? Carbon::parse($value)->toDateString() : null
        );
    }

    protected function dateTimeAccessorMutator(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? Carbon::parse($value)->format(FormatConstant::DATE_TIME_FORMAT) : null,
            set: fn ($value) => $value ? Carbon::parse($value)->toDateTimeString() : null
        );
    }

    protected function relationshipAccessorMutator(string $relation): Attribute
    {
        return Attribute::make(
            get: fn () => $this->$relation()->pluck('id')->toArray(),
            set: fn (array $value) => $this->$relation()->sync($value),
        )->shouldCache();
    }
}
