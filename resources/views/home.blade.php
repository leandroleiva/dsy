@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Consulta Dolar</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="post" action="/home">
                        {{ csrf_field() }}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="date">Fecha</label>
                                <input type="month" id="date" name="date" class="form-control" value="{{$date->format('Y-m')}}" max="{{$today->format('Y-m')}}" >
                            </div>
                            <button type="submit" class="btn btn-success">Consultar</button>
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
            <div class="card-header">Valor Dolar {{$date->format('Y-m')}}</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-compact">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items['Dolares'] as $dolar)
                                <tr>
                                    <td>{{$dolar->Fecha}}</td>
                                    <td>{{$dolar->Valor}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <form method="" action="#">
                    {{ csrf_field() }}
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Exportar a Excel</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection