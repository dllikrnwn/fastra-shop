<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class GameCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon', 'sort_order', 'is_active'];

    protected static function booted(): void
    {
        static::creating(function (GameCategory $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
        static::updating(function (GameCategory $model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->name);
            }
        });
    }

    public function games()
    {
        return $this->hasMany(Game::class, 'category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
