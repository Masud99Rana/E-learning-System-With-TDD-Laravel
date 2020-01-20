<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class SeriesRequest extends FormRequest
{
    /**
     * Upload the series image passed in the request
     * 
     * @return App\Http\Requests\CreateSeriesRequest
     */
    public function uploadSeriesImage() 
    {
        $uploadedImage = $this->image;

        $this->fileName = Str::slug($this->title) . '.' . $uploadedImage->getClientOriginalExtension();

        $uploadedImage->storePubliclyAs(
            'public/series',  $this->fileName
        );

        return $this;
    }
}
