@extends('layouts.private')
@php
    $globalTitle = 'User Detail';
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
                    Edit {{ $globalTitle }}
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="{{ route('users.dashboard') }}">Home</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li>
                        <a href="{{ route('master.users.index') }}">Manage {{ $globalTitle }}</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li><a href="#">Edit {{ $globalTitle }}</a></li>
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
                            <span class="hidden-480">Edit {{ $globalTitle }}</span>
                            &nbsp;
                        </h4>
                    </div>
                    <div class="portlet-body form">
                        <div class="tab-content">
                            @include('common.msg')
                            <div id="form-errors"></div>
                            <form action="{{ route('master.users.update', ['id' => $id]) }}" method="post"
                                class="form-horizontal" enctype="multipart/form-data" id="frmedtbookingdetail"
                                onsubmit="return sendForm(this)">
                                @csrf
                                <div class="row-fluid">
                                    <div class="span4 ">
                                        <div class="control-group">
                                            <label class="control-label">*Name</label>
                                            <div class="controls">
                                                <input type="text" name="name" value="{{ $info->name ?? '' }}"
                                                    placeholder="Please provide Name" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Email</label>
                                            <div class="controls">
                                                <input type="text" name="email" value="{{ $info->email ?? '' }}"
                                                    placeholder="Please provide Email" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Password</label>
                                            <div class="controls">
                                                <input type="password" name="password" value=""
                                                    placeholder="Please provide Password" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Confirm Password</label>
                                            <div class="controls">
                                                <input type="password" name="confirm_password" value=""
                                                    placeholder="Please provide Confirm Password" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select Role</label>
                                            <div class="controls">
                                                @if (isset($roles) && is_object($roles) && $roles->count())
                                                    <select name="roles_id" id="roles_id">
                                                        <option value="">Select Role</option>
                                                        @foreach ($roles as $option)
                                                            @if (isset($info->roles_id) && $info->roles_id == $option->id)
                                                                <option selected value="{{ $option->id ?? 0 }}">
                                                                    {{ $option->role_name ?? '' }}</option>
                                                            @else
                                                                <option value="{{ $option->id ?? 0 }}">
                                                                    {{ $option->role_name ?? '' }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                @endif

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                    <a href="{{ route('master.users.index') }}" class="btn red">Cancel</a>
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
                        window.location.href = "{{ route('master.users.index') }}";
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
