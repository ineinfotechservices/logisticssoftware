<!DOCTYPE html>
<head>
	  <meta charset="utf-8" />
    <title>{{ Config::get('constants.company_name') }}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="{{ url('public/assets/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" />
    <link href="{{ url('public/assets/css/metro.css') }}" rel="stylesheet" />
    <link href="{{ url('public/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
    <link href="{{ url('public/assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ url('public/assets/css/style_responsive.css') }}" rel="stylesheet" />
    <link href="{{ url('public/assets/css/style_default.css') }}" rel="stylesheet" id="style_color" />
    <link rel="stylesheet" type="text/css" href="{{ url('public/assets/uniform/css/uniform.default.css') }}" />
    <link rel="shortcut icon" href="favicon.ico" />
    <script src="{{ url('public/assets/js/jquery-1.8.3.min.js') }}"></script>			
	<script src="{{ url('public/assets/breakpoints/breakpoints.js') }}"></script>			
	<script src="{{ url('public/assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js') }}"></script>	
	<script src="{{ url('public/assets/bootstrap/js/bootstrap.min.js') }}"></script>
</head>
<body class="login">
  <!-- BEGIN LOGO -->
  <div class="logo">
    <img src="assets/img/logo-big.png" alt="" /> 
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
  @include('common.msg')
  @yield('content')
    
  </div>
  <!-- END LOGIN -->
  <!-- BEGIN COPYRIGHT -->
  <div class="copyright">
    Powerd and Developed by NRG
  </div>
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  <!-- END JAVASCRIPTS -->
</body>
</html>
