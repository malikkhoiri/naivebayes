@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">Training Data</h3>
                        {{--<p class="panel-subtitle">Period: Oct 14, 2016 - Oct 21, 2016</p>--}}
                    </div>
                    <div class="panel-body">
                        {{--<div class="row">

                            @if ($errors->has('file'))
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-times-circle"></i><strong> Gagal!</strong> {{ $errors->first('file') }}
                                </div>
                            @endif

                            @if ($sukses = Session::get('sukses'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <i class="fa fa-check-circle"></i><strong> Sukses!</strong> {{ $sukses }}
                                </div>
                            @endif
                        </div> --}}
                        <div class="row">
                            <div class="col-md-12 margin-bottom-30">
                                <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#importCSV">
                                    IMPORT CSV
                                </button>

                                {{--Modals #importCSV--}}
                                <div class="modal fade" id="importCSV" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <form method="post" action="{{route('importCSV')}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Unggah Data Training</h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="csvFile">File Input</label>
                                                        <input type="file" id="csvFile" name="csvFile" required="required">
                                                        <p class="help-block">File Extension (.csv)</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Import</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class='table table-striped'>
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kesukaran</th>
                                        <th>Pembeda</th>
                                        <th>Keputusan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=1 @endphp
                                    @foreach($data as $d)
                                        <tr>
                                            <td>{{$i++}}</td>
                                            <td>{{$d->kesukaran}}</td>
                                            <td>{{$d->pembeda}}</td>
                                            <td>{{$d->keputusan}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
