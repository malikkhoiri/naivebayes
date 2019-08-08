@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">User</h3>
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
                                <a href="{{route('register')}}" class="btn btn-primary">Add User</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <table class='table table-striped'>
                                    <thead>
                                    <tr>
                                        <th style="width: 100px;" class="text-center">#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th style="width: 200px;" class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $i=1 @endphp
                                    @foreach($users as $user)
                                        <tr>
                                            <td style="width: 100px;" class="text-center">{{$i++}}</td>
                                            <td>{{$user->name}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->role}}</td>
                                            <td style="width: 100px;" class="text-center">
                                                <a href="{{route('user.edit', $user->id)}}"><i class="fa fa-pencil"></i></a>&ensp;
                                                <a onclick="event.preventDefault(); document.getElementById('delete-form').submit();"><i class="fa fa-trash"></i></a>&ensp;

                                                <form id="delete-form" action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: none;">
                                                    {{method_field('DELETE')}}
                                                    {{ csrf_field() }}
                                                </form>
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
