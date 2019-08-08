@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-content">
            <div class="container-fluid">
                <div class="panel panel-headline">
                    <div class="panel-heading">
                        <h3 class="panel-title">{{ __('Update User') }}</h3>
                    </div>
                    <div class="panel-body">
                        <form method="POST" action="{{ route('user.update', $user->id) }}">
                            {{ method_field('PUT') }}
                            @csrf

                            <div class="form-group">
                                <div class="row">
                                    <label for="name" class="col-md-4">{{ __('Name') }}</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ isset($user) ? $user->name : old('name') }}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label for="email" class="col-md-4">{{ __('Email') }}</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ isset($user) ? $user->email : old('email') }}" {{isset($user) ? 'disabled' : ''}} required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label for="role" class="col-md-4">{{ __('Role') }}</label>
                                    <div class="col-md-6">
                                        <select name="role" id="role" class="form-control" required>
                                            <option value="0" {{isset($user) ? $user->role == 0 ? 'selected' : '' : ''}}>User</option>
                                            <option value="1" {{isset($user) ? $user->role == 1 ? 'selected' : '' : ''}}>Admin</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group clearfix">
                                <div class="col-md-4"></div>
                                <div class="col-md-6">
                                    <label class="fancy-checkbox element-left">
                                        <input type="checkbox" id="checkbox">
                                        <span>Change password?</span>
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label for="password" class="col-md-4">{{ __('Password') }}</label>
                                    <div class="col-md-6">
                                        <input disabled id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <label for="password-confirm" class="col-md-4">{{ __('Confirm Password') }}</label>
                                    <div class="col-md-6">
                                        <input disabled id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Update') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $("#checkbox").change(function() {
            if(this.checked) {
                $("#password").removeAttr("disabled")
                $("#password-confirm").removeAttr("disabled")
            } else {
                $("#password").attr("disabled", true)
                $("#password-confirm").attr("disabled", true)
            }
        });
    </script>
@endsection
