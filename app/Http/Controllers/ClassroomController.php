<?php

namespace App\Http\Controllers;

use App\Campus;
use App\Building;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function search(Request $request)
    {
        $campuses = Campus::where('dm', '<>', '')->get();
        $buildings = Building::where('dm', '<>', '')->get();

        return view('search', compact('campuses', 'buildings'));
    }
}
