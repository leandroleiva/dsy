<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dolarGet()
    {
        $date = date('Y-m-d');
        return view('home',compact('date'));
    }

    public function dolarPost(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date'
        ]);
        $date = date('Y-m-d',strtotime($request->date));
        $m = date('m',strtotime($date));
        $y = date('Y',strtotime($date));
        $items = collect(json_decode(file_get_contents('https://api.sbif.cl/api-sbifv3/recursos_api/dolar/'.$y.'/'.$m.'?apikey=d8093171162117c0c6e8da895b00978d4e2b6a0e&formato=json')));
        return view('home',compact('date','items'));
    }
}
