<?php

namespace App\Http\Requests;

use App\Series;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CreateSeriesRequest extends FormRequest
{   
    public $fileName;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image'
        ];
    }

    public function uploadSeriesImage(){

        $uploadedImage = $this->image;
        $this->fileName = Str::slug($this->title).'.'. $uploadedImage->getClientOriginalExtension();
        $image = $this->image->storePubliclyAs(
            'public/series', $this->fileName
        );

        return $this;
    }

    public function storeSeries(){
        $series = Series::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title),
            'description' => $this->description,
            'image_url' => 'public/series/'. $this->fileName,
        ]);

        session()->flash('success', 'Series created successfully.');
        //redirect user to a page to see all series
        return redirect()->route('series.show',['series'=>$series->slug]);
    }
}
