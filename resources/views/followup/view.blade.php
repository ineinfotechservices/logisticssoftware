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
                            <form class="form-horizontal" >@csrf

                                <div class="row-fluid">
                                    <div class="span8 ">
                                        <div class="control-group">
                                            <label class="control-label">*Title</label>
                                            <div class="controls">
                                                {{ $row->title ?? '' }}
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Status</label>
                                            <div class="controls">
                                                {{ \Helper::getFollowupStatusbyID($row->status ?? 0) }}
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Assigned</label>
                                            <div class="controls">
                                                @php
                                                    $user = \Helper::getUserbyId($row->user_id ?? 0);
                                                    echo $user->name ?? '';
                                                @endphp

                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Started Date</label>
                                            <div class="controls">
                                                {{ \Helper::converdb2datetime($row->created_date ?? 0) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <!-- END FORM-->
                        </div>
                    </div>
                </div>

                @if (isset($trans_followup_details) && is_object($trans_followup_details) && $trans_followup_details->count() > 0)
                @foreach ($trans_followup_details as $followupdetails)
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <h4>
                            <i class="icon-reorder"></i>
                            <span class="hidden-480">Followup {{ $row->title ?? '' }}</span>
                            &nbsp;
                        </h4>
                    </div>
                    <div class="portlet-body form">
                        <div class="tab-content">
                            @include('common.msg')
                            <div id="form-errors"></div>
                            <form class="form-horizontal">

                                
                                        <div class="row-fluid">
                                            <div class="span8 ">
                                                <div class="control-group">
                                                    <label class="control-label">Description</label>
                                                    <div class="controls">
                                                        {{ $followupdetails->description ?? '' }}
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Status</label>
                                                    <div class="controls">
                                                        {{ \Helper::getFollowupStatusbyID($followupdetails->status ?? 0) }}
                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Assigned</label>
                                                    <div class="controls">
                                                        @php
                                                            $user = \Helper::getUserbyId($followupdetails->user_id ?? 0);
                                                            echo $user->name ?? '';
                                                        @endphp

                                                    </div>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label">Started Date</label>
                                                    <div class="controls">
                                                        {{ \Helper::converdb2datetime($followupdetails->created ?? 0) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                   
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>

                @endforeach
                @endif

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
