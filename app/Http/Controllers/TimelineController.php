<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Timeline;
use Carbon\Carbon;

class TimelineController extends Controller
{
    /**
     * 
     */
    public function getTimeline()
    {
        $timelines = Timeline::whereHas('friend', function($query){
            return $query->whereUserId(auth()->id());
        })->orderBy('id', 'desc')->limit(30)->get();

        $daysTimelines = $timelines->transform(function($item){
            $item->days = $item->created_at->diff(Carbon::now())->days;
            return $item;
        })->groupBy('days');

    	return view('timeline.main', [
            'daysTimelines' => $daysTimelines
        ]);
    }
}
