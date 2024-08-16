@extends('layouts.private')
@php
    $globalTitle = 'Jobs';
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
                            <form action="{{ route('master.exporter.save') }}" method="post" class="form-horizontal"
                                enctype="multipart/form-data" id="frmaddexporter" onsubmit="return sendForm(this)">@csrf

                                <div class="row-fluid">
                                    <div class="span4 ">
                                        <div class="control-group">
                                            <label class="control-label">*Job Number</label>
                                            <div class="controls">
                                                <input type="text" name="name" value="{{ old('name') }}"
                                                    placeholder="Please provide Name" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select Exporter</label>
                                            <div class="controls">
                                                <input type="text" name="email" value="{{ old('email') }}"
                                                    placeholder="Please provide Email" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Start Date</label>
                                            <div class="controls">
                                                <input type="text" name="phone" value="{{ old('phone') }}"
                                                    placeholder="Please provide Phone" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select Incoterm</label>
                                            <div class="controls">
                                                <input type="text" name="phone" value="{{ old('phone') }}"
                                                    placeholder="Please provide Phone" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select State</label>
                                            <div class="controls">
                                                @if (isset($states) && is_object($states) && $states->count())
                                                    <select name="state_id">
                                                        <option value="">Select State</option>
                                                        @foreach ($states as $state)
                                                            <option value="{{ $state->id ?? 0 }}">
                                                                {{ $state->title ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select City</label>
                                            <div class="controls">
                                                @if (isset($cities) && is_object($cities) && $cities->count())
                                                    <select name="city_id">
                                                        <option value="">Select City</option>
                                                        @foreach ($cities as $city)
                                                            <option value="{{ $city->id ?? 0 }}">
                                                                {{ $city->title ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Enter Pincode</label>
                                            <div class="controls">
                                                <input type="text" name="pincode" value="{{ old('pincode') }}"
                                                    placeholder="Please provide Pincode" class="m-wrap medium" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4 ">
                                        <div class="control-group">
                                            <label class="control-label">Select Shipping line</label>
                                            <div class="controls">
                                                <input type="text" name="electricity_bill_number"
                                                    value="{{ old('electricity_bill_number') }}"
                                                    placeholder="Please provide Electricity Bill Number"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Select Shipping Rate</label>
                                            <div class="controls">
                                               <input type="text" name="electricity_bill_number"
                                                    value="{{ old('electricity_bill_number') }}"
                                                    placeholder="Please provide Electricity Bill Number"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Equipment Type</label>
                                            <div class="controls">
                                                <input type="text" name="telephone_number"
                                                    value="{{ old('telephone_number') }}"
                                                    placeholder="Please provide Telephone Number" class="m-wrap medium" />
                                            </div>
                                        </div>


                                        <div class="control-group">
                                            <label class="control-label">Number of container</label>
                                            <div class="controls">
                                                <input type="text" name="telephone_file"
                                                    value="{{ old('telephone_file') }}" placeholder="Please provide File"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Port of Loading</label>
                                            <div class="controls">
                                                <input type="text" name="gst_number" value="{{ old('gst_number') }}"
                                                    placeholder="Please provide GST" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Cargo weight</label>
                                            <div class="controls">
                                                <input type="text" name="gst_file" value="{{ old('gst_file') }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Port of Destination</label>
                                            <div class="controls">
                                                <input type="text" name="gst_file" value="{{ old('gst_file') }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>


                                <div class="form-actions">
                                    <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                    <a href="{{ route('master.exporter.index') }}" class="btn red">Cancel</a>
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
                type:"POST",
                url: $('#frmaddexporter').attr('action'),
                dataType: 'json',
                data: new FormData(obj),
                processData: false,
                contentType: false,
            }).done(function(result) {
                if(result.status) {
                    var errors = result.msg;
                var nerrorsHtml = '<div class="alert alert-success">'+errors+'</div>';
                 $( '#form-errors' ).html( nerrorsHtml ).show();
                 setTimeout(function(){
                    window.location.href = "{{ route('master.exporter.index') }}";
                 },2000);
                }else{
                    var errors = result.msg;
                var errorsHtml = '<div class="alert alert-danger"><ul>';

                 $.each( errors, function( key, value ) {
                      errorsHtml += '<li>'+ value[0] + '</li>'; //showing only the first error.
                 });
                 errorsHtml += '</ul></div>';

                 $( '#form-errors' ).html( errorsHtml ).show();
                 setTimeout(function(){
                    $( '#form-errors' ).html('').hide();
                 },3000);
                }
            });
            return false;
        }
    </script>
@endsection
