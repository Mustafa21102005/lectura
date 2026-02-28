<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class StudyMaterial extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\StudyMaterialFactory> */
    use HasFactory, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'subject_id',
        'teacher_id',
        'material_type_id'
    ];

    /**
     * Automatically generate a slug for the study material when it is created or updated.
     *
     * This should generate a slug based on the title of the material. This slug
     * can then be used to fetch the material in the frontend.
     */
    protected static function booted()
    {
        static::creating(function ($material) {
            $material->slug = Str::slug($material->title);
        });

        static::updating(function ($material) {
            if ($material->isDirty('title')) {
                $material->slug = Str::slug($material->title);
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
     * Study materials belong to a teacher.
     *
     * @return BelongsTo<\App\Models\User>
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Study materials belong to a material type.
     *
     * @return BelongsTo<\App\Models\MaterialType>
     */
    public function type()
    {
        return $this->belongsTo(MaterialType::class, 'material_type_id');
    }

    /**
     * Study materials belong to a subject.
     *
     * @return BelongsTo<\App\Models\Subject>
     */
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
