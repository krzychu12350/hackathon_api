<?php

namespace App\Models;

use App\Enums\PlantWaterAmount;
use App\Strategies\PhotoStorageStrategy\PhotoStorageStrategy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'plant_type',
        'description',
        'preferred_water_amount',
        'location',
        'last_watering',
        'plant_category_id',
        'expected_humidity',
        'current_humidity',
        'file_id',
    ];

    protected $casts = [
        'preferred_water_amount' => PlantWaterAmount::class,
    ];

//    public function category(): BelongsTo
//    {
//        return $this->belongsTo(PlantCategory::class, 'plant_category_id');
//    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photo(): BelongsTo
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
