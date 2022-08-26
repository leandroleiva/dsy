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
        $date_format = $this->dateFormat($date);
        try {
            $items = collect(json_decode(file_get_contents('https://api.sbif.cl/api-sbifv3/recursos_api/dolar/'.$date->year.'/'.$date->month.'?apikey=d8093171162117c0c6e8da895b00978d4e2b6a0e&formato=json')))['Dolares'];
            $items = collect($items)->map(function ($item) {
                $item->Fecha = date('d-m-Y',strtotime($item->Fecha));
                return $item;
            });
        } catch (\Throwable $th) {
            dd($th);
            return view('home',compact('date','today'))
                    ->withErrors(["Error"=>"No se pudo realizar la petición, intentelo más tarde"]);
        }
        return view('home',compact('date','today','items','date_format'));
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

    private function dateFormat($date) {
        $months = [
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre'
        ];
        return $months[$date->month] .' de '. $date->year;
    }
}