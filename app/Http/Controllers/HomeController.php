<?php

namespace App\Http\Controllers;

use App\Http\Requests\DateValidate;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Exports\DolarExport;
use Maatwebsite\Excel\Facades\Excel;
class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dolarGet()
    {
        $date = $today = Carbon::now();
        return view('home',compact('date','today'));
    }

    public function dolarPost(DateValidate $request)
    {
        $today = Carbon::now();
        $date = new Carbon($request->date);
        try {
            $items = collect(json_decode(file_get_contents('https://api.sbif.cl/api-sbifv3/recursos_api/dolar/'.$date->year.'/'.$date->month.'?apikey=d8093171162117c0c6e8da895b00978d4e2b6a0e&formato=json')))['Dolares'];
        } catch (\Throwable $th) {
            return view('home',compact('date','today'))
                    ->withErrors(["Error"=>"No se pudo realizar la petición, intentelo más tarde"]);
        }
        return view('home',compact('date','today','items'));
    }

    public function download(Request $request) {
        $date = new Carbon($request->date);
        try {
            $items = collect(json_decode(file_get_contents('https://api.sbif.cl/api-sbifv3/recursos_api/dolar/'.$date->year.'/'.$date->month.'?apikey=d8093171162117c0c6e8da895b00978d4e2b6a0e&formato=json')))['Dolares'];
            return Excel::download(new DolarExport($items), 'dolares.xlsx');
        } catch (\Throwable $th) {
            return view('home',compact('date','today'))
                    ->withErrors(["Error"=>"No se pudo realizar la petición, intentelo más tarde"]);
        }
    }
}