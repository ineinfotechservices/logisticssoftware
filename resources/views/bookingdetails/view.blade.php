@extends('layouts.private')
@php
    $globalTitle = 'Booking Detail';
@endphp
@section('content')
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN STYLE CUSTOMIZER -->
                @include('common.themesetting')
                <!-- END BEGIN STYLE CUSTOMIZER -->
                <h3 class="page-title">
                    View {{ $globalTitle }}
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="{{ route('users.dashboard') }}">Home</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li>
                        <a href="{{ route('master.booking.index') }}">Manage {{ $globalTitle }}</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li><a href="#">View {{ $globalTitle }}</a></li>
                </ul>
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN SAMPLE FORM PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <h4>
                            <i class="icon-reorder"></i>
                            <span class="hidden-480">View {{ $globalTitle }}</span>
                            &nbsp;
                        </h4>
                    </div>
                    <div class="portlet-body form">
                        <div class="tab-content">
                            @include('common.msg')
                            <div id="form-errors"></div>
                            <form action="{{ route('master.booking.update', ['id' => $id]) }}" method="post"
                                class="form-horizontal" enctype="multipart/form-data" id="frmedtbookingdetail"
                                onsubmit="return sendForm(this)">
                                @csrf

                                <div class="row-fluid">
                                    <div class="span4 ">
                                        <div class="control-group">
                                            <label class="control-label">*Job Number</label>
                                            <div class="controls">
                                                {{ $booking_detail->job_number ?? '' }}
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select Shipper</label>
                                            <div class="controls">
                                                {{ $booking_detail->shipper_name ?? '' }}
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Booking received from</label>
                                            <div class="controls">
                                                {{ $booking_detail->booking_received_from ?? '' }}
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select Incoterm</label>
                                            <div class="controls">
                                                @if (isset($incoterm) && is_object($incoterm) && $incoterm->count())
                                                   
                                                        @foreach ($incoterm as $option)
                                                            @if (isset($booking_detail->ms_incoterm_id) && $booking_detail->ms_incoterm_id == $option->id)
                                                              {{ $option->title ?? '' }}
                                                          
                                                            @endif
                                                        @endforeach
                                                   
                                                @endif
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Selling Rate</label>
                                            <div class="controls">
                                                {{ $booking_detail->selling_rate ?? 0 }}
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select Currency</label>
                                            <div class="controls">
                                                @if (isset($curencies) && is_object($curencies) && $curencies->count())
                                                    
                                                        @foreach ($curencies as $option)
                                                            @if (isset($booking_detail->ms_currencies_id) && $booking_detail->ms_currencies_id == $option->id)
                                                               {{ $option->title ?? '' }}
                                                           
                                                            @endif
                                                        @endforeach
                                                   
                                                @endif
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Other Charges</label>
                                            <div class="controls">
                                                {{ $booking_detail->other_charges ?? '' }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4 ">
                                        <div class="control-group">
                                            <label class="control-label">By Shipping line rate</label>
                                            <div class="controls">
                                                {{ $booking_detail->shipping_line_rate ?? 0 }}
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Select Equipment Type</label>
                                            <div class="controls">
                                                @if (isset($equipment_types) && is_object($equipment_types) && $equipment_types->count())
                                                   
                                                        @foreach ($equipment_types as $option)
                                                            @if (isset($booking_detail->ms_equipment_type_id) && $booking_detail->ms_equipment_type_id == $option->id)
                                                               {{ $option->title ?? '' }}
                                                            @endif
                                                        @endforeach
                                                    
                                                @endif

                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">No Of Container</label>
                                            <div class="controls">
                                                {{ $booking_detail->no_of_container ?? 0 }}
                                            </div>
                                        </div>


                                        <div class="control-group">
                                            <label class="control-label">Select port of loading</label>
                                            <div class="controls">
                                                @if (isset($port_of_loading) && is_object($port_of_loading) && $port_of_loading->count())
                                                        @foreach ($port_of_loading as $option)
                                                            @if (isset($booking_detail->ms_port_of_loading_id) && $booking_detail->ms_port_of_loading_id == $option->id)
                                                                {{ $option->title ?? '' }}
                                                            
                                                            @endif
                                                        @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Pickup Location</label>
                                            <div class="controls">
                                                {{ $booking_detail->pickup_location }}
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Port of Destination</label>
                                            <div class="controls">
                                                @if (isset($port_of_destination) && is_object($port_of_destination) && $port_of_loading->count())
                                                        @foreach ($port_of_destination as $option)
                                                            @if (isset($booking_detail->ms_port_of_destination) && $booking_detail->ms_port_of_destination == $option->id)
                                                                {{ $option->title ?? '' }}
                                                            @endif
                                                        @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Final place of Delivery</label>
                                            <div class="controls">
                                                {{ $booking_detail->final_place_of_delivery ?? '' }}
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-actions">
                                    <a href="{{ route('master.booking.index') }}" class="btn">Go Back</a>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->

    <script>
        const sendForm = (obj) => {
            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                type: "POST",
                url: $('#frmedtbookingdetail').attr('action'),
                dataType: 'json',
                data: new FormData(obj),
                processData: false,
                contentType: false,
            }).done(function(result) {
                if (result.status) {
                    var errors = result.msg;
                    var nerrorsHtml = '<div class="alert alert-success">' + errors + '</div>';
                    $('#form-errors').html(nerrorsHtml).show();
                    setTimeout(function() {
                        window.location.href = "{{ route('master.booking.index') }}";
                    }, 2000);
                } else {
                    var errors = result.msg;
                    var errorsHtml = '<div class="alert alert-danger"><ul>';

                    $.each(errors, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                    });
                    errorsHtml += '</ul></div>';

                    $('#form-errors').html(errorsHtml).show();
                    setTimeout(function() {
                        $('#form-errors').html('').hide();
                    }, 3000);
                }
            });
            return false;
        }
    </script>
@endsection
