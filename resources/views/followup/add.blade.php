@extends('layouts.private')
@php
    $globalTitle = 'Followup';
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
                        <a href="{{ route('master.followup.index') }}">Manage {{ $globalTitle }}</a>
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
                            <form action="{{ route('master.followup.add_save') }}" method="post" class="form-horizontal"
                                enctype="multipart/form-data" id="frmadduser" onsubmit="return sendForm(this)">@csrf

                                <div class="row-fluid">
                                    <div class="span4 ">
                                        <div class="control-group">
                                            <label class="control-label">*Title</label>
                                            <div class="controls">
                                                <input type="text" name="title"
                                                    value="{{ old('title') }}"
                                                    placeholder="Please provide Followup Title" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Description</label>
                                            <div class="controls">
                                                <textarea type="text" name="description"
                                                    value="{{ old('description') }}"
                                                    placeholder="Please provide Description" class="m-wrap medium" ></textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Next Followup Date/Time</label>
                                            <div class="controls">
                                                <input type="text" name="next_followup"
                                                    value="{{ old('next_followup') }}" onkeyup="formatInputDateTime(this)"
                                                    placeholder="Please provide Next Followup Date/time" class="m-wrap medium" />
                                                
                                                
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Follow Up Assign</label>
                                            <div class="controls">
                                                @if (isset($role_users) && is_object($role_users) && $role_users->count())
                                                    <select name="assign_user_id" id="assign_user_id">
                                                        <option value="">Select User</option>
                                                        @foreach ($role_users as $option)
                                                            <option value="{{ $option->id ?? 0 }}">
                                                                {{ $option->name ?? '' }} - ({{ $option->email ?? '' }})</option>
                                                        @endforeach
                                                    </select>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-actions">
                                    <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                    <a href="{{ route('master.followup.index') }}" class="btn red">Cancel</a>
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
                url: $('#frmadduser').attr('action'),
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
                        window.location.href = "{{ route('master.followup.index') }}";
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
