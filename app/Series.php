<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lesson;

class Series extends Model
{
    protected $guarded = [];

    /**
     * Eager load relationships
     *
     * @var array
     */
    protected $with = ['lessons'];

    /**
     * A series has many lessons
     *
     * @return void
     */
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
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
     * Return the public path for series image
     *
     * @return string
     */
    public function getImagePathAttribute() {
        return asset('storage/' . $this->image_url);
    }
}
