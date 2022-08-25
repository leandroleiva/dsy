<?php

namespace App\Http\Controllers;

use App\Http\Requests\DateValidate;
use Illuminate\Http\Request;
use Carbon\Carbon;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dolarGet()
    {
        $date = Carbon::now();
        return view('home',compact('date'));
    }

    public function dolarPost(DateValidate $request)
    {
        try {
            $date = new Carbon($request->date);
            $items = collect(json_decode(file_get_contents('https://api.sbif.cl/api-sbifv3/recursos_api/dolar/'.$date->year.'/'.$date->month.'?apikey=d8093171162117c0c6e8da895b00978d4e2b6a0e&formato=json')));
        } catch (\Throwable $th) {
            return view('home',compact('date'))
                    ->withErrors(["Error"=>"No se pudo realizar la petición, intentelo más tarde"]);
        }
        return view('home',compact('date','items'));
    }
}