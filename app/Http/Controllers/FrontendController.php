<?php

namespace App\Http\Controllers;

use App\Series;
use Illuminate\Http\Request;

use Artesaos\SEOTools\Traits\SEOTools as SEOToolsTrait;

class FrontendController extends Controller
{
    /**
     * Show the welcome / landing page
     *
     * @return view 
     */
    use SEOToolsTrait;

    public function welcome() {

        $this->seo()->setTitle('Home');
        $this->seo()->setDescription('This is my page description');

        return view('welcome')->withSeries(Series::all());
    }

    /**
     * Show the series page
     *
     * @param Series $series
     * @return view
     */
    public function series(Series $series) {

        return view('series')->withSeries($series);
    }

    /**
     * Show all the series
     *
     * @return view
     */
    public function showAllSeries() {
        return view('all-series')->withSeries(Series::all());
    }
}
