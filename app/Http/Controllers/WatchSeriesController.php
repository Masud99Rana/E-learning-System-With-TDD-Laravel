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
        $user = auth()->user();

        if($user->hasStartedSeries($series)) {
            return redirect()->route('series.watch', [   
                    'series' => $series->slug, 
                    'lesson' => $user->getNextLessonToWatch($series)
            ]);
        }
        
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

    /**
     * Complete a lesson via ajax
     *
     * @param App\Lesson $lesson
     * @return json response
     */
    public function completeLesson(Lesson $lesson) {
        auth()->user()->completeLesson($lesson);
        return response()->json([
            'status' => 'ok'
        ]);
    }
}
