<?php

namespace App\Http\Controllers;

use App\Using;
use App\Campus;
use App\Building;
use App\Calendar;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function search(Request $request)
    {
        $campuses = Campus::where('dm', '<>', '')->get();
        $buildings = Building::where('dm', '<>', '')->get();

        $today = Carbon::today();
        $calendar = Calendar::where('rq', '<', $today)->orderBy('rq', 'desc')->firstOrFail();

        $campus = $building = $week = null;
        if ($request->input('search') === 'search') {
            $campus = $request->input('campus');
            $building = $request->input('building');
            $week = $request->input('week');

            $usings = Using::whereNd($calendar->nd)->whereXq($calendar->xq)->get();
        }

        return view('search', compact('campuses', 'buildings', 'calendar', 'campus', 'building', 'week', 'usings'));
    }
}
