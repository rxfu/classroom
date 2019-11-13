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

        $today = Carbon::createFromDate(2017, 11, 13);
        $calendar = Calendar::where('rq', '<=', $today)->orderBy('rq', 'desc')->firstOrFail();
        $currentWeek = $today->diffInWeeks($calendar->rq) + 1;

        $campus = $request->has('campus') ? $request->input('campus') : null;
        $building = $request->has('building') ? $request->input('building') : null;
        $week = $request->has('week') ? $request->input('week') : $today->isoweekday();

        $usings = Using::with(['classroom', 'classroom.campus', 'classroom.building'])
            ->whereNd($calendar->nd)
            ->whereXq($calendar->xq)
            ->where('ksz', '<=', $currentWeek)
            ->where('jsz', '>=', $currentWeek);

        if ('all' === $campus) {
            $campusNumbers = $campuses->pluck('dm');
        } else {
            $campusNumbers[] = $campus;
        }

        if ('all' === $building) {
            $buildingNumbers = $buildings->pluck('dm');
        } else {
            $buildingNumbers[] = $building;
        }

        $usings = $usings->where(function ($query) use ($campusNumbers, $buildingNumbers) {
            foreach ($campusNumbers as $cnum) {
                foreach ($buildingNumbers as $bnum) {
                    $query = $query->orWhere('jsh', 'LIKE', $cnum . $bnum . '%');
                }
            }
        });

        if ('all' !== $week) {
            $usings = $usings->whereZc($week);
        }

        $usings = $usings->select('jsh', 'nd', 'xq', 'ksz', 'jsz', 'zc', 'md', DB::raw("string_agg(CAST(jc AS text), ',') AS jc"))
            ->groupBy('jsh', 'nd', 'xq', 'ksz', 'jsz', 'zc', 'md')
            ->orderBy('jsh')
            ->get();

        return view('search', compact('campuses', 'buildings', 'calendar', 'campus', 'building', 'week', 'usings'));
    }
}
