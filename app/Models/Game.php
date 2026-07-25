<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Game extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'slug', 'image', 'guide_video', 'description', 'rate', 'has_custom_amount', 'is_featured', 'is_active', 'sort_order'];

    protected static function booted(): void
    {
        static::creating(function (Game $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
        static::updating(function (Game $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(GameCategory::class, 'category_id');
    }

    public function denominations()
    {
        return $this->hasMany(Denomination::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
