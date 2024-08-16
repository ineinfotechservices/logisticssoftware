@extends('layouts.private')
@php
    $globalTitle = 'Delivery Agent';
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
                        <a href="{{ route('master.deliveryagent.index') }}">Manage {{ $globalTitle }}</a>
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
                            <form action="{{ route('master.deliveryagent.save') }}" method="post" class="form-horizontal"
                                id="frmadddeliveryagent" onsubmit="return sendForm(this)">@csrf
                                <div class="control-group">
                                    <label class="control-label">*Full Name</label>
                                    <div class="controls">
                                        <input type="text" name="title" value="{{ old('title') }}"
                                            placeholder="Please provide Name" class="m-wrap medium" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">*Email Address</label>
                                    <div class="controls">
                                        <input type="text" name="email" value="{{ old('email') }}"
                                            placeholder="Please provide Email" class="m-wrap medium" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Contact</label>
                                    <div class="controls">
                                        <input type="text" name="mobile" value="{{ old('mobile') }}"
                                            placeholder="Please provide Mobile" class="m-wrap medium" />
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Address 1</label>
                                    <div class="controls">
                                        <input type="text" name="address" value="{{ old('address') }}"
                                            placeholder="Please provide Address" class="m-wrap medium" />
                                        <a href="javascript:void(0)" class="btn mini blue" onclick="addmoreAddress(this)"><i
                                                class="icon-plus"></i> Add More</a>
                                    </div>
                                </div>
                                <div class="control-group" id="address_2" style="display:none">
                                    <label class="control-label">Address 2</label>
                                    <div class="controls">
                                        <input type="text" name="address2" value="{{ old('address') }}"
                                            placeholder="Please provide Address" class="m-wrap medium" />
                                        <a href="javascript:void(0)" class="btn mini black"
                                            onclick="deletemoreAddress(2)"><i class="icon-trash"></i> Delete</a>
                                    </div>
                                </div>
                                <div class="control-group" id="address_3" style="display:none">
                                    <label class="control-label">Address 3</label>
                                    <div class="controls">
                                        <input type="text" name="address3" value="{{ old('address') }}"
                                            placeholder="Please provide Address" class="m-wrap medium" />
                                        <a href="javascript:void(0)" class="btn mini black"
                                            onclick="deletemoreAddress(3)"><i class="icon-trash"></i> Delete</a>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">*Country</label>
                                    <div class="controls">
                                        @if (isset($countries) && is_object($countries) && $countries->count())
                                            <select name="country" onchange="getState(this,'state_id')">
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id ?? 0 }}">
                                                        {{ $country->title ?? '' }}</option>
                                                @endforeach
                                            </select>
                                        @endif

                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">State</label>
                                    <div class="controls">
                                        <select name="state_id" id="state_id" onchange="getCity(this,'city_id')">
                                            <option value="">Select State</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">City</label>
                                    <div class="controls">
                                        <select name="city_id" id="city_id">
                                            <option value="">Select City</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">*Pin/Zip</label>
                                    <div class="controls">
                                        <input type="text" name="pincode" value="{{ old('pincode') }}"
                                            placeholder="Please provide pincode" class="m-wrap medium" />
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                    <a href="{{ route('master.deliveryagent.index') }}" class="btn red">Cancel</a>
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
        const addmoreAddress = (obx) => {
            if (!$("#address_2").is(":visible")) {
                $("#address_2").show();
                return false;
            }

            if (!$("#address_3").is(":visible")) {
                $("#address_3").show();
                return false;
            }

            alert('Maximum 3 address allowed')
        }

        const deletemoreAddress = (idx) => {
            var addressName = 'address_' + idx;
            $("#" + addressName).find('input').val('');
            $("#" + addressName).hide();
        }

        const sendForm = (obj) => {
            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                type: "POST",
                url: $('#frmadddeliveryagent').attr('action'),
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
                        window.location.href = "{{ route('master.deliveryagent.index') }}";
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
