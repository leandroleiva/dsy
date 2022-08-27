@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><i class="fa-solid fa-magnifying-glass"></i>  Consulta dolar</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="post" action="/home">
                        {{ csrf_field() }}
                        <div class="row g-3 align-items-center justify-content-center">
                            <div class="col-auto">
                                <label for="date" class="col-form-label">Fecha</label>
                            </div>
                            <div class="col-auto">
                                <input type="month" id="date" name="date" class="form-control form-control-lg" value="{{$date->format('Y-m')}}" max="{{$today->format('Y-m')}}" >
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-success form-control-lg"><i class="fa-solid fa-magnifying-glass"></i> Consultar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    &nbsp;
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(isset($items))
        <div class="card">
            <canvas id="myChart" ></canvas>
        </div>
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-table-list"></i> Valores dolar {{$date_format}}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-compact">
                        <thead>
                            <tr>
                                <th class="text-center"><i class="fa-solid fa-money-bill-1-wave"></i> Valor</th>
                                <th class="text-center"><i class="fa-solid fa-calendar-days"></i> Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $dolar)
                                <tr>
                                    <td class="text-center">$ {{$dolar->Valor}}</td>
                                    <td class="text-center">{{$dolar->Fecha}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <form method="post" action="/download" class='text-center'>
                    {{ csrf_field() }}
                    <input type="hidden" name="date" value="{{$date}}">
                    <button type="submit" class="btn btn-success"><i class="fa-solid fa-download"></i> Descargar Excel</button>
                </form>
            </div>
        </div>
    @endif
</div>
<script>
    @if(isset($items))
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [
                @foreach ( $items as $item)
                    '{{date("d",strtotime($item->Fecha))}}',
                @endforeach
            ],
            datasets: [{
                label:  '{{$date_format}}',
                data: [
                    @foreach ( $items as $item)
                        '{{(float)$item->Valor}}',
                    @endforeach
                ],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        }
    });
    @endif
    </script>
    
@endsection