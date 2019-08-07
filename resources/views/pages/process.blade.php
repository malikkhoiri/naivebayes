@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">Testing</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <form class="form-inline" action="{{url('/process/testing')}}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="sr-only" for="kesukaran">Email address</label>
                                        <input type="text" class="form-control" id="kesukaran" name="kesukaran" value="{{ old('kesukaran') }}" placeholder="Kesukaran" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="pembeda">Password</label>
                                        <input type="text" class="form-control" id="pembeda" name="pembeda" value="{{ old('pembeda') }}" placeholder="Pembeda" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Test</button>
                                </form>
                            </div>
                        </div>
                        @if(session('output'))
                            <pre>Input: <br>@foreach(session('input') as $key => $val){{$key}} => {{$val}}<br>@endforeach<br>Output: {{session('output')}}<br></pre>
                            {{Session::remove('output')}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
