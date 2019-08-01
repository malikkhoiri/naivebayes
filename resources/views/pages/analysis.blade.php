@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Analisis Soal</h3>
                    </div>
                    <form method="get" action="{{route('analysis')}}">
                        @csrf
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="mapel">Mata Pelajaran</label>
                                        <select name="mapel" id="mapel" class="form-control" required>
                                            <option value="">-- Pilih --</option>
                                            @foreach($mapel as $m)
                                                <option value="{{$m->id}}">{{$m->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="class">Kelas</label>
                                        <select name="class" id="class" class="form-control" required>
                                            <option value="">-- Pilih --</option>
                                            @foreach($class as $c)
                                                <option value="{{$c->id}}">{{$c->class}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Analisa</button>
                        </div>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="container-fluid">
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Hasil Analisis</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class='table table-striped'>
                                        <thead>
                                        <tr>
                                            <th style="width: 100px;" class="text-center">Soal</th>
                                            <th class="text-center">Kesukaran</th>
                                            <th class="text-center">Daya Beda</th>
                                            <th class="text-center">Keputusan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $diff = Session::get('difficulty');
                                            $diffS = Session::get('diffStrength');
                                            $output = Session::get('output');
                                        @endphp
                                        @for($i=0; $i<count($output); $i++)
                                            <tr>
                                                <td style="width: 100px;" class="text-center">{{$i+1}}</td>
                                                <td class="text-center">({{$diff[$i][0]}}) | {{strtoupper($diff[$i][1])}}</td>
                                                <td class="text-center">({{$diffS[$i][0]}}) | {{strtoupper($diffS[$i][1])}}</td>
                                                <td class="text-center">{{strtoupper($output[$i])}}</td>
                                            </tr>
                                        @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

{{--<div class="row">--}}
{{--    <div class="col-md-12">--}}
{{--        <table class='table table-striped'>--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th style="width: 100px;" class="text-center">No</th>--}}
{{--                <th>Daftar Soal</th>--}}
{{--                <th style="width: 200px;" class="text-center">Action</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}
{{--            @php $i=1 @endphp--}}
{{--            </tbody>--}}
{{--        </table>--}}
{{--    </div>--}}
{{--</div>--}}
