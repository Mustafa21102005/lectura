<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MaterialType extends Model
{
    /** @use HasFactory<\Database\Factories\MaterialTypeFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = ['name'];

    /**
     * Automatically generate a slug based on the name of the MaterialType when creating or updating.
     *
     * When creating a new MaterialType, the slug will be generated using the name.
     * When updating an existing MaterialType, the slug will only be updated if the name changed.
     */
    protected static function booted()
    {
        // When creating a new MaterialType
        static::creating(function ($materialType) {
            $materialType->slug = Str::slug($materialType->name);
        });

        // When updating an existing MaterialType
        static::updating(function ($materialType) {
            // Only update slug if the name changed
            if ($materialType->isDirty('name')) {
                $materialType->slug = Str::slug($materialType->name);
            }
        });
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * The study materials that belong to the MaterialType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studyMaterials()
    {
        return $this->hasMany(StudyMaterial::class, 'material_type_id');
    }
}
