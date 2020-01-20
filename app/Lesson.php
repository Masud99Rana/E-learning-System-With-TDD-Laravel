<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Series;

class Lesson extends Model
{
    protected $guarded = [];

    /**
     * A lesson belongs to a series
     *
     * @return void
     */
    public function series() {
        return $this->belongsTo(Series::class);
    }
}
