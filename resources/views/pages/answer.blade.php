@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">Unggah Jawaban</h3>
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
                                <button type="button" class="btn btn-primary mr-5" data-toggle="modal" data-target="#uploadQuest">
                                    Unggah Jawaban
                                </button>

                                {{--Modals #importCSV--}}
                                <div class="modal fade" id="uploadQuest" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <form method="post" action="{{route('uploadAnswer')}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Unggah Jawaban</h4>
                                                </div>
                                                <div class="modal-body">
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
                                                    <div class="form-group">
                                                        <label for="member">Member</label>
                                                        <select name="member" id="member" class="form-control" required>
                                                            <option value="">-- Pilih --</option>
                                                            @foreach($member as $mem)
                                                                <option value="{{$mem->id}}">{{$mem->member}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="answer">File Input</label>
                                                        <input type="file" id="answer" name="answer" required class="form-control">
                                                        <p class="help-block">File Extension (.doc .docx)</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Unggah</button>
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
                                        <th style="width: 100px;" class="text-center">No</th>
                                        <th>Daftar Jawaban</th>
                                        <th style="width: 200px;" class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=1 @endphp
                                    @foreach($answer as $ans)
                                        <tr>
                                            <td style="width: 100px;" class="text-center">{{$i++}}</td>
                                            <th>{{$ans->filename}}</th>
                                            <td style="width: 100px;" class="text-center">
                                                <a href="#"><i class="fa fa-pencil"></i></a>&ensp;
                                                <a href="{{route('deleteAnswer', $ans->id)}}"><i class="fa fa-trash"></i></a>&ensp;
                                                <a href="{{route('downloadAnswer', $ans->id)}}"><i class="fa fa-download"></i></a>&ensp;
                                            </td>
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
