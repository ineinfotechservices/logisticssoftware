<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<title>{{ Config::get('constants.company_name') }}</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/css/metro.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/css/style_responsive.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/css/style_default.css') }}" rel="stylesheet" id="style_color" />
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/gritter/css/jquery.gritter.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/uniform/css/uniform.default.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap-daterangepicker/daterangepicker.css') }}" />
	<link href="{{ asset('assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css') }}" rel="stylesheet" />
	<link href="{{ asset('assets/jqvmap/jqvmap/jqvmap.css') }}" media="screen" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{ asset('assets/data-tables/DT_bootstrap.css') }}" />
	<link rel="shortcut icon" href="favicon.ico" />
    <script src="{{ asset('assets/js/jquery-1.8.3.min.js') }}"></script>			
	<script src="{{ asset('assets/breakpoints/breakpoints.js') }}"></script>			
	<script src="{{ asset('assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js') }}"></script>	
	<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
</head>
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	@include('common.header')
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
   	<div class="container-fluid">
	
		@include('common.sidebar')
		<div class="row-fluid">
               <div class="span12">
			@yield('content')
		</div>
		</div>
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
		2013 &copy; Metronic by keenthemes.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>

	{{-- <script src="{{ asset('assets/breakpoints/breakpoints.js') }}"></script>		
	<script src="{{ asset('assets/jquery-ui/jquery-ui-1.10.1.custom.min.js') }}"></script>	
	<script src="{{ asset('assets/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('assets/fullcalendar/fullcalendar/fullcalendar.min.js') }}"></script>
	<script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.blockui.js') }}"></script>	
	<script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
	<script src="{{ asset('assets/jqvmap/jqvmap/jquery.vmap.js') }}" type="text/javascript"></script>	
	<script src="{{ asset('assets/jqvmap/jqvmap/maps/jquery.vmap.russia.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/jqvmap/jqvmap/maps/jquery.vmap.world.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/jqvmap/jqvmap/maps/jquery.vmap.europe.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/jqvmap/jqvmap/maps/jquery.vmap.germany.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/jqvmap/jqvmap/maps/jquery.vmap.usa.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/jqvmap/jqvmap/data/jquery.vmap.sampledata.js') }}" type="text/javascript"></script>	
	<script src="{{ asset('assets/flot/jquery.flot.js') }}"></script>
	<script src="{{ asset('assets/flot/jquery.flot.resize.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/gritter/js/jquery.gritter.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/uniform/jquery.uniform.min.js') }}"></script>	
	<script type="text/javascript" src="{{ asset('assets/js/jquery.pulsate.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/bootstrap-daterangepicker/date.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/bootstrap-daterangepicker/daterangepicker.js') }}"></script>	 --}}

	
	<script src="{{ asset('assets/js/jquery.blockui.js') }}"></script>
	<script src="{{ asset('assets/js/jquery.cookie.js') }}"></script>
	<script src="{{ asset('assets/fullcalendar/fullcalendar/fullcalendar.min.js') }}"></script>	
	<script type="text/javascript" src="{{ asset('assets/uniform/jquery.uniform.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/chosen-bootstrap/chosen/chosen.jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/data-tables/jquery.dataTables.js') }}"></script>
	<script type="text/javascript" src="{{ asset('assets/data-tables/DT_bootstrap.js') }}"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>	
	<script>
		jQuery(document).ready(function() {			
			App.init();
		});
	</script>
</body>
</html>
