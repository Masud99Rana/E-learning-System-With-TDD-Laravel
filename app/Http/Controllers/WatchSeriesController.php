<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Series;
use Illuminate\Http\Request;

class WatchSeriesController extends Controller
{
    /**
     * Watch a series
     *
     * @param App\Series $series
     * @return redirect
     */
    public function index(Series $series) {

        return redirect()->route('series.watch', [   
                'series' => $series->slug, 
                'lesson' => $series->lessons->first()->id 
        ]);
    }

    /**
     * Show a lesson page
     *
     * @param App\Series $series
     * @param App\Lesson $lesson
     * @return view
     */
    public function showLesson(Series $series, Lesson $lesson) {

        return view('watch', [
            'series' => $series,
            'lesson' => $lesson
        ]);
    }
}
