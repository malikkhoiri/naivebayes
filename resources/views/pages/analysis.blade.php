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
                            @php
                                $mc = Session::get('mc');
                            @endphp
                            <div class="row">
                                <div class="col-md-2">Mata Pelajaran</div>
                                <div class="col-md-2">: {{$mc['m']}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">Kelas</div>
                                <div class="col-md-2">: {{$mc['c']}}</div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class='table table-striped table-bordered'>
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
                                            $reliable = Session::get('reliable');

                                            $_output = array_count_values($output);
                                            $acc = $_output["diterima"];
                                            $rev = $_output["direvisi"];
                                            $dec = $_output["ditolak"];
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

                <div class="container-fluid">
                    <div class="panel panel-headline">
                        <div class="panel-heading">
                            <h3 class="panel-title">Analisis Reliabilitas</h3>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <table class='table table-striped table-bordered'>
                                        <tbody>
                                        <tr>
                                            <th>Jumlah siswa</th>
                                            <td>{{$reliable["n"]}}</td>
                                        </tr>
                                        <tr>
                                            <th>Jumlah soal</th>
                                            <td>{{$reliable["n_question"]}}</td>
                                        </tr>
                                        <tr>
                                            <th>Rata Skor</th>
                                            <td>{{$reliable["avg"]}}</td>
                                        </tr>
                                        <tr>
                                            <th>Variansi</th>
                                            <td>{{$reliable["variant"]}}</td>
                                        </tr>
                                        <tr>
                                            <th>Reliabilitas</th>
                                            <td>{{$reliable["r"]}}</td>
                                        </tr>
                                        <tr>
                                            <th>Keterangan</th>
                                            <td>
                                                @if($reliable["r"] > 0.800)
                                                    Sangat Tinggi
                                                @elseif($reliable["r"] > 0.600)
                                                    Tinggi
                                                @elseif($reliable["r"] > 0.400)
                                                    Cukup
                                                @elseif($reliable["r"] > 0.200)
                                                    Rendah
                                                @else
                                                    Sangat Rendah
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Soal Diterima</th>
                                            <td>{{$acc}} ({{($acc/array_sum($_output)*100)}}%)</td>
                                        </tr>
                                        <tr>
                                            <th>Soal Direvisi</th>
                                            <td>{{$rev}} ({{($rev/array_sum($_output)*100)}}%)</td>
                                        </tr>
                                        <tr>
                                            <th>Soal Ditolak</th>
                                            <td>{{$dec}} ({{($dec/array_sum($_output)*100)}}%)</td>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a href="{{route('exportPdf')}}" class="btn btn-primary" target="_blank">Export PDF</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
