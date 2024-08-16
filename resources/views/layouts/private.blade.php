<!DOCTYPE html>
<head>
	<meta charset="utf-8" />
	<title>{{ Config::get('constants.company_name') }}</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link href="{{ url('public/assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
	<link href="{{ url('public/assets/css/metro.css') }}" rel="stylesheet" />
	<link href="{{ url('public/assets/bootstrap/css/bootstrap-responsive.min.css') }}" rel="stylesheet" />
	<link href="{{ url('public/assets/font-awesome/css/font-awesome.css') }}" rel="stylesheet" />
	<link href="{{ url('public/assets/css/style.css') }}" rel="stylesheet" />
	<link href="{{ url('public/assets/css/style_responsive.css') }}" rel="stylesheet" />
	<link href="{{ url('public/assets/css/style_default.css') }}" rel="stylesheet" id="style_color" />
	<link rel="stylesheet" type="text/css" href="{{ url('public/assets/gritter/css/jquery.gritter.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ url('public/assets/chosen-bootstrap/chosen/chosen.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ url('public/assets/uniform/css/uniform.default.css') }}" />
	<link rel="stylesheet" type="text/css" href="{{ url('public/assets/bootstrap-daterangepicker/daterangepicker.css') }}" />
	<link href="{{ url('public/assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css') }}" rel="stylesheet" />
	<link href="{{ url('public/assets/jqvmap/jqvmap/jqvmap.css') }}" media="screen" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" href="{{ url('public/assets/data-tables/DT_bootstrap.css') }}" />
	<link rel="shortcut icon" href="favicon.ico" />
    <script src="{{ url('public/assets/js/jquery-1.8.3.min.js') }}"></script>			
	<script src="{{ url('public/assets/breakpoints/breakpoints.js') }}"></script>			
	<script src="{{ url('public/assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js') }}"></script>	
	<script src="{{ url('public/assets/bootstrap/js/bootstrap.min.js') }}"></script>
</head>
<body class="fixed-top">
	<!-- BEGIN HEADER -->
	@include('common.header')
	<!-- END HEADER -->
	<!-- BEGIN CONTAINER -->
	<div class="page-container row-fluid">
		@include('common.sidebar')
		<div class="page-content">
			@yield('content')
		</div>
	</div>
	<!-- END CONTAINER -->
	<!-- BEGIN FOOTER -->
	<div class="footer">
		Powerd and Developed by NRG
		
	</div>

	<script src="{{ url('public/assets/js/jquery.blockui.js') }}"></script>
	<script src="{{ url('public/assets/js/jquery.cookie.js') }}"></script>
	<script src="{{ url('public/assets/fullcalendar/fullcalendar/fullcalendar.min.js') }}"></script>	
	<script type="text/javascript" src="{{ url('public/assets/uniform/jquery.uniform.min.js') }}"></script>
	<script type="text/javascript" src="{{ url('public/assets/chosen-bootstrap/chosen/chosen.jquery.min.js') }}"></script>
	<script type="text/javascript" src="{{ url('public/assets/data-tables/jquery.dataTables.js') }}"></script>
	<script type="text/javascript" src="{{ url('public/assets/data-tables/DT_bootstrap.js') }}"></script>
	<script src="{{ url('public/assets/js/app.js') }}"></script>	
	<script>
		jQuery(document).ready(function() {		
			App.setPage("table_managed");
			App.init();			
			App.initChosenSelect('.chosen_category');
		});

		const goBack = (xURL) => {
			window.location.href = xURL;
		}

		const getState = (obj,state_id) => {

			let frmdata = new FormData();
			frmdata.append('_token', "{{ csrf_token() }}");
			frmdata.append('country_id', $(obj).val());
			$("#"+state_id).find('option').remove();
			$("#"+state_id).append('<option>Select State</option>');
			$.ajax({
                type: "POST",
                url: "{{ route('master.states.ajax') }}",
                dataType: 'json',
                data:frmdata,
                processData: false,
                contentType: false,
            }).done(function(result) {
                if (result.status) {
                    var stateData = result.data;
					console.log('stateData',stateData);
					stateData.map((item)=>{
						$("#"+state_id).append(`<option value="${item.id}">${item.title}</option>`)
					})
					
                  
                } 
            });
		}

		const getEditState = (obj,state_id, selected_state_id) => {

			let frmdata = new FormData();
			frmdata.append('_token', "{{ csrf_token() }}");
			frmdata.append('country_id', $(obj).val());
			$("#"+state_id).find('option').remove();
			$("#"+state_id).append('<option>Select State</option>');
			$.ajax({
                type: "POST",
                url: "{{ route('master.states.ajax') }}",
                dataType: 'json',
                data:frmdata,
                processData: false,
                contentType: false,
            }).done(function(result) {
                if (result.status) {
                    var stateData = result.data;
					console.log('stateData',stateData);
					stateData.map((item)=>{
						$("#"+state_id).append(`<option value="${item.id}">${item.title}</option>`);
					});
					$("#"+state_id).find('option[value='+selected_state_id+']').prop('selected','selected');
					
                  
                } 
            });
		}

		const getCity = (obj,city_id) => {

			let frmdata = new FormData();
			frmdata.append('_token', "{{ csrf_token() }}");
			frmdata.append('state_id', $(obj).val());
			$("#"+city_id).find('option').remove();
			$("#"+city_id).append('<option>Select City</option>');
			$.ajax({
                type: "POST",
                url: "{{ route('master.cities.ajax') }}",
                dataType: 'json',
                data:frmdata,
                processData: false,
                contentType: false,
            }).done(function(result) {
                if (result.status) {
                    var stateData = result.data;
					console.log('stateData',stateData);
					stateData.map((item)=>{
						$("#"+city_id).append(`<option value="${item.id}">${item.title}</option>`)
					})
					
                  
                } 
            });
		}

		const getEditCity = (obj,city_id, selected_city_id) => {

			let frmdata = new FormData();
			frmdata.append('_token', "{{ csrf_token() }}");
			frmdata.append('state_id', $(obj).val());
			$("#"+city_id).find('option').remove();
			$("#"+city_id).append('<option>Select City</option>');
			$.ajax({
                type: "POST",
                url: "{{ route('master.cities.ajax') }}",
                dataType: 'json',
                data:frmdata,
                processData: false,
                contentType: false,
            }).done(function(result) {
                if (result.status) {
                    var stateData = result.data;
					console.log('stateData',stateData);
					stateData.map((item)=>{
						$("#"+city_id).append(`<option value="${item.id}">${item.title}</option>`)
					})
                  	$("#"+city_id).find('option[value='+selected_city_id+']').prop('selected','selected');
                } 
            });
		}


		function formatInputDateTime(obj) {
            var inputDateTime = obj.value;

            // Remove any non-digit and non-colon characters
            var cleanedDateTime = inputDateTime.replace(/[^\d:]/g, '');

            // Format the date and time with slashes and a space
            var formattedDateTime = cleanedDateTime;

            if (formattedDateTime.length > 2 && formattedDateTime.charAt(2) !== '/') {
				formattedDateTime = formattedDateTime.slice(0, 2) + '/' + formattedDateTime.slice(2);
				var day = formattedDateTime.slice(0, 2);
				if(day > 31) {
					formattedDateTime = '';
				}
            }
            if (formattedDateTime.length > 5 && formattedDateTime.charAt(5) !== '/') {
                formattedDateTime = formattedDateTime.slice(0, 5) + '/' + formattedDateTime.slice(5);
				var month = formattedDateTime.slice(3, 5);
				console.log('month',month);
				if(month > 12) {
					formattedDateTime = '';
				}
            }
            if (formattedDateTime.length > 10 && formattedDateTime.charAt(10) !== ' ') {
                formattedDateTime = formattedDateTime.slice(0, 10) + ' ' + formattedDateTime.slice(10);
            }
            if (formattedDateTime.length > 13 && formattedDateTime.charAt(13) !== ':') {
                formattedDateTime = formattedDateTime.slice(0, 13) + ':' + formattedDateTime.slice(13);
            }

            // Validate the hour and minute ranges
            var hour = formattedDateTime.slice(11, 13);
            var minute = formattedDateTime.slice(14, 16);

            if (hour < 0 || hour > 23 || minute < 0 || minute > 59) {
                formattedDateTime = '';
            }

            // Update the input value with the formatted date and time
            obj.value = formattedDateTime;
        }

		
	</script>
</body>
</html>
