<?php

namespace App\Http\Controllers;

use DB;
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

            $usings = Using::whereNd($calendar->nd)->whereXq($calendar->xq);

            if ('all' === $campus) {
                $campusNumbers = $campuses->pluck('dm');
            } else {
                $campusNumbers[] = $campus;
            }

            if ('all' === $building) {
                $buildingNumbers = $buildings->pluck('jsh');
            } else {
                $buildingNumbers[] = $building;
            }

            foreach ($campusNumbers as $cnum) {
                foreach ($buildingNumbers as $bnum) {
                    $usings = $usings->where('jsh', 'LIKE', $cnum . $bnum . '%');
                }
            }

            if ('all' !== $week) {
                $usings = $usings->whereZc($week);
            }

            $usings = $usings->select('jsh', 'nd', 'xq', 'ksz', 'jsz', 'zc', 'md', DB::raw("string_agg(CAST(jc AS text), ',') AS jc"))
                ->groupBy('jsh', 'nd', 'xq', 'ksz', 'jsz', 'zc', 'md')
                ->orderBy('jsh')
                ->get();
        }

        return view('search', compact('campuses', 'buildings', 'calendar', 'campus', 'building', 'week', 'usings'));
    }
}
