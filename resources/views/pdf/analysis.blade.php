<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hasil Analisis</title>

    <style type="text/css">
        @page
        {
            /*The A4 paper size is 210 mm wide by 297 mm long*/
            size: 297mm 210mm;
            margin-left: 1.27cm;
            margin-right: 1.27cm;
            margin-top: 1.27cm;
            margin-bottom: 2.54cm;
        }

        div {
            word-wrap: normal !important;
        }

        table {
            table-layout: auto !important;
            width: 98%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid #CCC;
            text-align: left;
            padding: 8px;
        }

        .center {
            text-align: center;
        }

        .w-1 {
            width: 5% !important;;
        }

        .w-2 {
            width: 50% !important;;
        }

        tbody tr:nth-child(even){background-color: #f2f2f2}

        .table-container {
            width: 20% !important;
            display: table;
        }

        .table-container > div {
            display: table-row;
        }

        .table-container > div > div {
            display: table-cell;
            padding-top: 4px;
            padding-bottom: 4px;
        }

        .title {
            text-align: center;
        }
    </style>
</head>
<body>
@php
    $question = Session::get('question');
    $diff = Session::get('difficulty');
    $diffS = Session::get('diffStrength');
    $output = Session::get('output');
    $mc = Session::get('mc');
    $reliable = Session::get('reliable');

    $_output = array_count_values($output);
    $acc = $_output["diterima"];
    $rev = $_output["direvisi"];
    $dec = $_output["ditolak"];
@endphp

    <h2 class="title">Hasil Analisis Soal</h2>
    <div class="table-container">
        <div>
            <div>Soal</div>
            <div>: {{$mc['m']}}</div>
        </div>
        <div>
            <div>Kelas</div>
            <div>: {{$mc['c']}}</div>
        </div>
    </div>

    <br>

    <main>
        {!! $question !!}

        <div style="page-break-after: always"></div>

        <table>
            <thead>
            <tr>
                <th class="center w-1">Soal</th>
                <th class="center">Kesukaran</th>
                <th class="center">Daya Beda</th>
                <th class="center">Keputusan</th>
            </tr>
            </thead>
            <tbody>
            @for($i=0; $i<count($output); $i++)
                <tr>
                    <td class="center">{{$i+1}}</td>
                    <td>{{strtoupper($diff[$i][1])}}</td>
                    <td>{{strtoupper($diffS[$i][1])}}</td>
                    <td>{{strtoupper($output[$i])}}</td>
                </tr>
            @endfor
            </tbody>
        </table>

        <div style="page-break-after: always"></div>

        <table class="w-2">
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
    </main>
</body>
