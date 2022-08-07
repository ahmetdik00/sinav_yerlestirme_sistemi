<?php

namespace App\Http\Controllers;

use App\Models\Sinif;
use App\Models\StudentInfo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $class = Sinif::count('id');
        $capacity = Sinif::sum('kapasite');
        $student = StudentInfo::count('aday_no');
        $documents = DB::table('sinav_giris_belge')->count('aday_no');
        $datetime = Carbon::now('EUROPE/ISTANBUL');
        $mytime = $datetime->locale('tr')->isoFormat('LLLL');
        return view('admin.index', compact('capacity', 'student', 'documents', 'class', 'mytime'));
    }
}
