<?php

namespace App\Models;

use App\Enums\FileExtension;
use App\Enums\FileType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    use HasFactory;

    // Define the table associated with the model (optional, if follows convention)
    protected $table = 'files';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'url', // The URL of the image
        'type',
        'extension',
    ];


    protected $casts = [
        'type' => FileType::class,
        'extension' => FileExtension::class,
    ];

    public function plant()
    {
        return $this->hasOne(Plant::class);
    }
}
