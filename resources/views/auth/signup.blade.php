@extends('templates.default')


@section('content')

<div class="row" style="margin-top: 100px">
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div class="row" style="background: white;border-radius: 10px">
            <div class="col-lg-12" style="padding: 20px 30px">
                <form class="form-vertical" id="signup" role="form" method="post" action="{{ route('auth.signup') }}">
                    <h2 class="auth_title">Sign up</h2>
                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email" class="control-label">Email</label>
                        <input type="text" name="email" class="form-control" id="email" value="{{ Request::old('email') ?: '' }}" placeholder="Email">
                        @if ($errors->has('email'))
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group  {{ $errors->has('username') ? ' has-error' : '' }}">
                        <label for="username" class="control-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username" value="{{ Request::old('username') ?: '' }}" placeholder="Username">
                        @if ($errors->has('username'))
                            <span class="help-block">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="form-group  {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="control-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="form-group" id="c_label">
                        <label for="password" class="control-label">Confirm-Password</label>
                        <input type="password" name="re_password" class="form-control" id="re_password" placeholder="Confirm-Password">

                        <span class="help-block" id="e_span" style="display: none">please input the confirm password correctly</span>

                    </div>
                    <div class="form-group">
                        <button type="button" class="btn btn-default auth_btn">Sign up</button>
                    </div>
                    <input type="hidden" name="_token" value="{{ Session::token() }}">
                </form>
            </div>
        </div>
    </div>

</div>

@stop

@section('script')
    <script>
        $('.auth_btn').on('click', function () {
            var pass = $('#password').val();
            var re_pass = $('#re_password').val();

            if (pass == re_pass){
                $('#signup').submit();
            }else {
                $('#c_label').addClass('has-error');
                $('#e_span').css({'display':'inline'});
            }
        })
    </script>
@stop