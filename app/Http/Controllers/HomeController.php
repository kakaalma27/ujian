<?php

namespace App\Http\Controllers;

use App\Models\jawaban;
use App\Models\kelas;
use Illuminate\Http\Request;
use App\Models\Pelajaran;
use App\Models\User;
use App\Models\users_jawaban;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userHome(Request $request)
    {
        // $hasUjian = DB::select(DB::raw('select * from users_ujians where user_id = ? AND is_done = ? LIMIT 1'), [Auth::id(), 0]);
        // if(sizeof($hasUjian) > 0){
        //     return view('siswa.ujian.index');
        // }
        return view('siswa.index',["msg"=>"Hello! I am user"]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function guruHome()
    {        
        return view('guru.home',["msg"=>"Hello! I am guru"]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()
    {
        $guruCount = User::where('role', 1)->count();
        $userCount = User::where('role', 0)->count();
        $kelasCount = Kelas::all()->count();
        $pelajaranCount = Pelajaran::all()->count();
        return view('admin.home', compact('guruCount', 'userCount', 'kelasCount', 'pelajaranCount'));
    }
}