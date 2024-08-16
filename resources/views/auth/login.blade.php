@extends('layouts.public')

@section('content')
    <!-- BEGIN LOGIN FORM -->
    
    <form class="" id="loginfrm" method="post" action="{{ route('auth.login') }}">@csrf
        <h3 class="form-title">Login to your account</h3>
        <div class="alert alert-error hide">
            <button class="close" data-dismiss="alert"></button>
            <span>Enter any username and passowrd.</span>
        </div>
        <div class="control-group">
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">Username</label>
            <div class="controls">
                <div class="input-icon left">
                    <i class="icon-user"></i>
                    <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" />
                </div>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label visible-ie8 visible-ie9">Password</label>
            <div class="controls">
                <div class="input-icon left">
                    <i class="icon-lock"></i>
                    <input class="m-wrap placeholder-no-fix" type="password" placeholder="Password" name="password" />
                </div>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn green pull-right">
                Login <i class="m-icon-swapright m-icon-white"></i>
            </button>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $('input').keyup(function(event) {
                if (event.which === 13) {
                    event.preventDefault();
                    $('#loginfrm').submit();
                }
            });
        })
    </script>
@endsection
