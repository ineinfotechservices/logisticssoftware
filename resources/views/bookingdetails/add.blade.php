@extends('layouts.private')
@php
    $globalTitle = 'Booking Details';
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
                    Add {{ $globalTitle }}
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="{{ route('users.dashboard') }}">Home</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li>
                        <a href="{{ route('master.jobs.index') }}">Manage {{ $globalTitle }}</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li><a href="#">Add {{ $globalTitle }}</a></li>
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
                            <span class="hidden-480">Add {{ $globalTitle }}</span>
                            &nbsp;
                        </h4>
                    </div>
                    <div class="portlet-body form">
                        <div class="tab-content">
                            @include('common.msg')
                            <div id="form-errors"></div>
                            <form action="{{ route('master.booking.save') }}" method="post" class="form-horizontal"
                                enctype="multipart/form-data" id="frmaddbookingdetail" onsubmit="return sendForm(this)">@csrf

                                <div class="row-fluid">
                                    <div class="span4 ">
                                        <div class="control-group">
                                            <label class="control-label">*Job Number</label>
                                            <div class="controls">
                                                {{ $generate_booking_detail_job_number  ?? '' }}
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Shipper Name</label>
                                            <div class="controls">
                                                <input type="text" name="shipper_name"
                                                    value="{{ old('shipper_name') }}"
                                                    placeholder="Please provide Shipper Name" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Booking received from</label>
                                            <div class="controls">
                                                <input type="text" name="booking_received_from"
                                                    value="{{ old('booking_received_from') }}"
                                                    placeholder="Booking received from" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select Incoterm</label>
                                            <div class="controls">
                                                @if (isset($incoterm) && is_object($incoterm) && $incoterm->count())
                                                    <select name="ms_incoterm_id" id="ms_incoterm_id" class="form-control chosen_category">
                                                        <option value="0">Select Incoterm</option>
                                                        @foreach ($incoterm as $option)
                                                            <option value="{{ $option->id ?? 0 }}">
                                                                {{ $option->title ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Selling Rate</label>
                                            <div class="controls">
                                                <input type="text" name="selling_rate"
                                                    value="{{ old('selling_rate') }}"
                                                    placeholder="Please provide Selling Rate" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select Currency</label>
                                            <div class="controls">
                                                @if (isset($curencies) && is_object($curencies) && $curencies->count())
                                                    <select name="ms_currencies_id" id="ms_currencies_id" class="form-control chosen_category">
                                                        <option value="0">Select Currency</option>
                                                        @foreach ($curencies as $option)
                                                            <option value="{{ $option->id ?? 0 }}">
                                                                {{ $option->title ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Other Charges</label>
                                            <div class="controls">
                                                <textarea type="text" name="other_charges" value="{{ old('other_charges') }}"
                                                    placeholder="Please provide other charges" class="m-wrap medium"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4 ">
                                        <div class="control-group">
                                            <label class="control-label">By Shipping line rate</label>
                                            <div class="controls">
                                                <input type="text" name="shipping_line_rate"
                                                    value="{{ old('shipping_line_rate') }}"
                                                    placeholder="Please provide Shipping line rate" class="m-wrap medium" />
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Select Equipment Type</label>
                                            <div class="controls">
                                                @if (isset($equipment_types) && is_object($equipment_types) && $equipment_types->count())
                                                    <select name="ms_equipment_type_id" id="ms_equipment_type_id" class="form-control chosen_category">
                                                        <option value="0">Select Equipment Type</option>
                                                        @foreach ($equipment_types as $option)
                                                            <option value="{{ $option->id ?? 0 }}">
                                                                {{ $option->title ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">No Of Container</label>
                                            <div class="controls">
                                                <input type="text" name="no_of_container"
                                                    value="{{ old('no_of_container') }}"
                                                    placeholder="Please provide No of container" class="m-wrap medium" />
                                            </div>
                                        </div>


                                        <div class="control-group">
                                            <label class="control-label">Select port of loading</label>
                                            <div class="controls">
                                                @if (isset($port_of_loading) && is_object($port_of_loading) && $port_of_loading->count())
                                                    <select name="ms_port_of_loading_id" id="ms_port_of_loading_id" class="form-control chosen_category">
                                                        <option value="0">Select Port of Loading</option>
                                                        @foreach ($port_of_loading as $option)
                                                            <option value="{{ $option->id ?? 0 }}">
                                                                {{ $option->title ?? '' }}, {{$option->country_name ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Pickup Location</label>
                                            <div class="controls">
                                                <input type="text" name="pickup_location"
                                                    value="{{ old('pickup_location') }}"
                                                    placeholder="Please provide Pickup Location" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Port of Destination</label>
                                            <div class="controls">
                                                @if (isset($port_of_destination) && is_object($port_of_destination) && $port_of_loading->count())
                                                    <select name="ms_port_of_destination" id="ms_port_of_destination" class="form-control chosen_category"> 
                                                        <option value="0">Select Port of Destination</option>
                                                        @foreach ($port_of_destination as $option)
                                                            <option value="{{ $option->id ?? 0 }}">
                                                                {{ $option->title ?? '' }}, {{$option->country_name ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Final place of Delivery</label>
                                            <div class="controls">
                                                <textarea type="text" name="final_place_of_delivery" value="{{ old('final_place_of_delivery') }}"
                                                    placeholder="Please provide File" class="m-wrap medium"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="form-actions">
                                    <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                    <a href="{{ route('master.booking.index') }}" class="btn">Cancel</a>
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
                url: $('#frmaddbookingdetail').attr('action'),
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
