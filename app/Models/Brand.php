<?php

namespace App\Models;

use App\Enums\BrandStatus;
use App\Traits\HasActiveScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, HasActiveScope, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => BrandStatus::class,
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
