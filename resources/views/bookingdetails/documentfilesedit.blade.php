@extends('layouts.private')
@php
    $globalTitle = 'Booking Files';
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
                        <a href="{{ route('master.booking.index') }}">Manage {{ $globalTitle }}</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li><a href="#">Edit {{ $globalTitle }}</a></li>
                </ul>
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        @include('common.msg')
        <div id="form-errors"></div>

        <div class="tabbable tabbable-custom boxless" id="tabIdx">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab">Files</a></li>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <form action="{{ route('master.booking.documentfileupdate', ['id' => $id]) }}" method="post"
                        class="form-horizontal" enctype="multipart/form-data" id="frmedtbookingfileupdate"
                        onsubmit="return sendForm(this)">
                        @csrf
                        <div class="row-fluid">
                            <div class="span12">
                                <!-- BEGIN SAMPLE FORM PORTLET-->
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <h4>
                                            <i class="icon-reorder"></i>
                                            <span class="hidden-480">Files Detail</span>
                                            &nbsp;
                                        </h4>
                                    </div>
                                    <div class="portlet-body form">
                                        <div class="tab-content">
                                            <div class="row-fluid">
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label class="control-label">Shipping Bill File</label>
                                                        <div class="controls">
                                                            <input type="file" name="shipping_bill[]" multiple />
                                                            <br />
                                                            @php
                                                                $shipping_file_list = \Helper::getBookingOtherFiles($id, 'shipping_bill');
                                                            @endphp
                                                            @if (isset($shipping_file_list) && is_object($shipping_file_list) && $shipping_file_list->count() > 0)
                                                                @foreach ($shipping_file_list as $shippinglist)
                                                                    <span id="fileother_{{ $shippinglist->id ?? 0 }}">
                                                                    <a class="btn green mini" href="{{ $shippinglist->other_file_url ?? '' }}"
                                                                        target="_blank"><i class="icon-eye-open"></i>View File</a> <a class="btn red mini"
                                                                        href="javascript:void(0)"
                                                                        onclick=deleteOtherfile('{{ route('master.booking.deleteotherdocumenfile', ['id' => $id]) }}','{{ $shippinglist->id ?? 0 }}')><i class="icon-trash"></i> Delete
                                                                    </a></span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Gate Pass File</label>
                                                        <div class="controls">
                                                            <input type="file" name="gate_pass[]" multiple />
                                                            <br />
                                                            @php
                                                                $other_file_list = \Helper::getBookingOtherFiles($id, 'gate_pass');
                                                            @endphp
                                                            @if (isset($other_file_list) && is_object($other_file_list) && $other_file_list->count() > 0)
                                                                @foreach ($other_file_list as $other_file)
                                                                    <span id="fileother_{{ $other_file->id ?? 0 }}">
                                                                    <a class="btn green mini" href="{{ $other_file->other_file_url ?? '' }}"
                                                                        target="_blank"><i class="icon-eye-open"></i>View File</a> <a class="btn red mini"
                                                                        href="javascript:void(0)"
                                                                        onclick=deleteOtherfile('{{ route('master.booking.deleteotherdocumenfile', ['id' => $id]) }}','{{ $other_file->id ?? 0 }}')><i class="icon-trash"></i> Delete
                                                                    </a></span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Invoice Copy File</label>
                                                        <div class="controls">
                                                            <input type="file" name="invoice_copy[]" multiple />
                                                            @php
                                                                $invoice_other_file_list = \Helper::getBookingOtherFiles($id, 'invoice_copy');
                                                            @endphp
                                                            @if (isset($invoice_other_file_list) && is_object($invoice_other_file_list) && $invoice_other_file_list->count() > 0)
                                                                @foreach ($invoice_other_file_list as $other_file)
                                                                    <span id="fileother_{{ $other_file->id ?? 0 }}">
                                                                    <a class="btn green mini" href="{{ $other_file->other_file_url ?? '' }}"
                                                                        target="_blank"><i class="icon-eye-open"></i>View File</a> <a class="btn red mini"
                                                                        href="javascript:void(0)"
                                                                        onclick=deleteOtherfile('{{ route('master.booking.deleteotherdocumenfile', ['id' => $id]) }}','{{ $other_file->id ?? 0 }}')><i class="icon-trash"></i> Delete
                                                                    </a></span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label class="control-label">Packing List File</label>
                                                        <div class="controls">
                                                            <input type="file" name="packing_list[]" multiple />
                                                            <br />
                                                            @php
                                                                $packing_list_other_file_list = \Helper::getBookingOtherFiles($id, 'packing_list');
                                                            @endphp
                                                            @if (isset($packing_list_other_file_list) && is_object($packing_list_other_file_list) && $packing_list_other_file_list->count() > 0)
                                                                @foreach ($packing_list_other_file_list as $other_file)
                                                                    <span id="fileother_{{ $other_file->id ?? 0 }}">
                                                                    <a class="btn green mini" href="{{ $other_file->other_file_url ?? '' }}"
                                                                        target="_blank"><i class="icon-eye-open"></i>View File</a> <a class="btn red mini"
                                                                        href="javascript:void(0)"
                                                                        onclick=deleteOtherfile('{{ route('master.booking.deleteotherdocumenfile', ['id' => $id]) }}','{{ $other_file->id ?? 0 }}')><i class="icon-trash"></i> Delete
                                                                    </a></span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">VGM Copy File</label>
                                                        <div class="controls">
                                                            <input type="file" name="vgm_copy[]" multiple />
                                                            <br />
                                                            @php
                                                                $vgm_copy_other_file_list = \Helper::getBookingOtherFiles($id, 'vgm_copy');
                                                            @endphp
                                                            @if (isset($vgm_copy_other_file_list) && is_object($vgm_copy_other_file_list) && $vgm_copy_other_file_list->count() > 0)
                                                                @foreach ($vgm_copy_other_file_list as $other_file)
                                                                    <span id="fileother_{{ $other_file->id ?? 0 }}">
                                                                    <a class="btn green mini" href="{{ $other_file->other_file_url ?? '' }}"
                                                                        target="_blank"><i class="icon-eye-open"></i>View File</a> <a class="btn red mini"
                                                                        href="javascript:void(0)"
                                                                        onclick=deleteOtherfile('{{ route('master.booking.deleteotherdocumenfile', ['id' => $id]) }}','{{ $other_file->id ?? 0 }}')><i class="icon-trash"></i> Delete
                                                                    </a></span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">

                                                    <div class="control-group">
                                                        <label class="control-label">Booking Copy File</label>
                                                        <div class="controls">
                                                            <input type="file" name="booking_copy[]" multiple />
                                                            <br />
                                                            @php
                                                                $booking_copy_other_file_list = \Helper::getBookingOtherFiles($id, 'booking_copy');
                                                            @endphp
                                                            @if (isset($booking_copy_other_file_list) && is_object($booking_copy_other_file_list) && $booking_copy_other_file_list->count() > 0)
                                                                @foreach ($booking_copy_other_file_list as $other_file)
                                                                    <span id="fileother_{{ $other_file->id ?? 0 }}">
                                                                    <a class="btn green mini" href="{{ $other_file->other_file_url ?? '' }}"
                                                                        target="_blank"><i class="icon-eye-open"></i>View File</a> <a class="btn red mini"
                                                                        href="javascript:void(0)"
                                                                        onclick=deleteOtherfile('{{ route('master.booking.deleteotherdocumenfile', ['id' => $id]) }}','{{ $other_file->id ?? 0 }}')><i class="icon-trash"></i> Delete
                                                                    </a></span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Other File</label>
                                                        <div class="controls">
                                                            <input type="file" name="other_file[]" multiple />
                                                            <br />
                                                            @php
                                                                $other_file_other_file_list = \Helper::getBookingOtherFiles($id, 'other_file');
                                                            @endphp
                                                            @if (isset($other_file_other_file_list) && is_object($other_file_other_file_list) && $other_file_other_file_list->count() > 0)
                                                                @foreach ($other_file_other_file_list as $other_file)
                                                                    <span id="fileother_{{ $other_file->id ?? 0 }}">
                                                                    <a class="btn green mini" href="{{ $other_file->other_file_url ?? '' }}"
                                                                        target="_blank"><i class="icon-eye-open"></i>View File</a> <a class="btn red mini"
                                                                        href="javascript:void(0)"
                                                                        onclick=deleteOtherfile('{{ route('master.booking.deleteotherdocumenfile', ['id' => $id]) }}','{{ $other_file->id ?? 0 }}')><i class="icon-trash"></i> Delete
                                                                    </a></span>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END FORM-->
                                        </div>

                                    </div>
                                </div>
                                <div class="form-actions">
                                    @if (\Helper::isAdmin() || \Helper::isDocument())
                                        <button type="submit" class="btn blue"><i class="icon-ok"></i>
                                            Save Files
                                        </button>
                                    @endif
                                    &nbsp;
                                    <a href="{{ route('master.booking.index') }}" class="btn red">Cancel</a>

                                </div>
                                <!-- END SAMPLE FORM PORTLET-->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->

    <script>
        $(document).ready(function() {
            $('a[href="#tab_4"]').click(function() {
                getContainerDetails();
            });
        });
        const sendForm = (obj) => {
            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                type: "POST",
                url: $('#frmedtbookingfileupdate').attr('action'),
                dataType: 'json',
                data: new FormData(obj),
                processData: false,
                contentType: false,
            }).done(function(result) {
                if (result.status) {
                    var errors = result.msg;
                    var nerrorsHtml = '<div class="alert alert-success">' + errors + '</div>';
                    $('#form-errors').html(nerrorsHtml).show();

                    if (result.data == 'moment_detail') {

                        $("#tabIdx").find('ul li').each(function() {
                            if ($(this).find('a').attr('href') == '#tab_2') {
                                $(this).find('a').trigger('click');
                                return true;
                            }
                        });

                        $("html, body").animate({
                            scrollTop: 0
                        }, "slow");
                        setTimeout(function() {
                            $("#form-errors").html('');
                            window.location.reload(true);
                        }, 5000);
                    } else {
                        setTimeout(function() {
                            window.location.href = "{{ route('master.booking.index') }}";
                        }, 2000);
                    }



                } else {
                    var errors = result.msg;
                    var errorsHtml = '<div class="alert alert-danger"><ul>';

                    $.each(errors, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                    });
                    errorsHtml += '</ul></div>';

                    $('#form-errors').html(errorsHtml).show();
                    $("html, body").animate({
                        scrollTop: 0
                    }, "slow");
                    setTimeout(function() {
                        $('#form-errors').html('').hide();
                    }, 5000);
                }
            });
            return false;
        }


        const deleteOtherfile = (xURL, mainid) => {
            if (confirm('Are you sure want to remove this ?')) {
                $.ajax({
                    // Uncomment the following to send cross-domain cookies:
                    //xhrFields: {withCredentials: true},
                    type: "POST",
                    url: xURL,
                    dataType: 'json',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'mainid': mainid
                    },
                }).done(function(result) {
                    console.log(result);
                    // fileother_
                    if (result.status) {
                        var errors = result.msg;
                        var nerrorsHtml = '<div class="alert alert-success">' + errors + '</div>';
                        $('#form-errors').html(nerrorsHtml).show();
                        setTimeout(function() {
                            $("#form-errors").html('');
                        }, 5000);
                        $("#fileother_"+mainid).remove();
                    } else {
                        var errors = result.msg;
                        var errorsHtml = '<div class="alert alert-danger">'+errors+'<div>';
                        $('#form-errors').html(errorsHtml).show();
                        $("html, body").animate({
                            scrollTop: 0
                        }, "slow");
                        setTimeout(function() {
                            $('#form-errors').html('').hide();
                        }, 5000);
                    }
                });
            }

            return false;
        }




        // const sendMomentForm = (obj) => {
        //     $.ajax({
        //         // Uncomment the following to send cross-domain cookies:
        //         //xhrFields: {withCredentials: true},
        //         type: "POST",
        //         url: $('#frmdocumentmomentdetail').attr('action'),
        //         dataType: 'json',
        //         data: new FormData(obj),
        //         processData: false,
        //         contentType: false,
        //     }).done(function(result) {
        //         if (result.status) {
        //             var errors = result.msg;
        //             var nerrorsHtml = '<div class="alert alert-success">' + errors + '</div>';
        //             $('#form-errors').html(nerrorsHtml).show();
        //             setTimeout(function() {
        //                 window.location.href = "{{ route('master.booking.documentinvoice', ['id' => $id]) }}";
        //             }, 2000);
        //         } else {
        //             var errors = result.msg;
        //             var errorsHtml = '<div class="alert alert-danger"><ul>';

        //             $.each(errors, function(key, value) {
        //                 errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
        //             });
        //             errorsHtml += '</ul></div>';

        //             $('#form-errors').html(errorsHtml).show();
        //             setTimeout(function() {
        //                 $('#form-errors').html('').hide();
        //             }, 3000);
        //         }
        //     });
        //     return false;
        // }

        // const sendVesselForm = (obj) => {
        //     $.ajax({
        //         // Uncomment the following to send cross-domain cookies:
        //         //xhrFields: {withCredentials: true},
        //         type: "POST",
        //         url: $('#frmdocumentvesseldetail').attr('action'),
        //         dataType: 'json',
        //         data: new FormData(obj),
        //         processData: false,
        //         contentType: false,
        //     }).done(function(result) {
        //         if (result.status) {
        //             var errors = result.msg;
        //             var nerrorsHtml = '<div class="alert alert-success">' + errors + '</div>';
        //             $('#form-errors').html(nerrorsHtml).show();
        //             setTimeout(function() {
        //                 $("a[href=#tab_3]").trigger('click');
        //             }, 2000);
        //         } else {
        //             var errors = result.msg;
        //             var errorsHtml = '<div class="alert alert-danger"><ul>';

        //             $.each(errors, function(key, value) {
        //                 errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
        //             });
        //             errorsHtml += '</ul></div>';

        //             $('#form-errors').html(errorsHtml).show();
        //             setTimeout(function() {
        //                 $('#form-errors').html('').hide();
        //             }, 3000);
        //         }
        //     });
        //     return false;
        // }

        // const sendCargoDetailForm = (obj) => {
        //     $.ajax({
        //         // Uncomment the following to send cross-domain cookies:
        //         //xhrFields: {withCredentials: true},
        //         type: "POST",
        //         url: $('#frmdocumentcargodetail').attr('action'),
        //         dataType: 'json',
        //         data: new FormData(obj),
        //         processData: false,
        //         contentType: false,
        //     }).done(function(result) {
        //         if (result.status) {
        //             var errors = result.msg;
        //             var nerrorsHtml = '<div class="alert alert-success">' + errors + '</div>';
        //             $('#form-errors').html(nerrorsHtml).show();
        //             setTimeout(function() {
        //                 $("a[href=#tab_4]").trigger('click');
        //                 getContainerDetails();
        //             }, 2000);
        //         } else {
        //             var errors = result.msg;
        //             var errorsHtml = '<div class="alert alert-danger"><ul>';

        //             $.each(errors, function(key, value) {
        //                 errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
        //             });
        //             errorsHtml += '</ul></div>';

        //             $('#form-errors').html(errorsHtml).show();
        //             setTimeout(function() {
        //                 $('#form-errors').html('').hide();
        //             }, 3000);
        //         }
        //     });
        //     return false;
        // }
        // const getShipperData = (obj) => {
        //     var shipperIdx = obj.value;
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('master.booking.getshipperinfo', ['id' => $id]) }}",
        //         dataType: 'json',
        //         data: {
        //             shipperIdx,
        //             "_token": "{{ csrf_token() }}"
        //         },
        //     }).done(function(result) {
        //         if (result.status) {
        //             $("#showshipperdata").find('div:first').html(result.data);
        //         } else {
        //             $("#showshipperdata").find('div:first').html('No Shipper found');
        //         }
        //     });
        //     return false;
        // }

        // const getConsigneeData = (obj) => {
        //     var consigneeIdx = obj.value;
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('master.booking.consignee_data', ['id' => $id]) }}",
        //         dataType: 'json',
        //         data: {
        //             consigneeIdx,
        //             "_token": "{{ csrf_token() }}"
        //         },
        //     }).done(function(result) {
        //         if (result.status) {
        //             $("#showconsigneedata").find('div:first').html(result.data);
        //         } else {
        //             $("#showconsigneedata").find('div:first').html('No Shipper found');
        //         }
        //     });
        //     return false;
        // }

        // const getNotify1Data = (obj) => {
        //     var consigneeIdx = obj.value;
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('master.booking.consignee_data', ['id' => $id]) }}",
        //         dataType: 'json',
        //         data: {
        //             consigneeIdx,
        //             "_token": "{{ csrf_token() }}"
        //         },
        //     }).done(function(result) {
        //         if (result.status) {
        //             $("#shownotify1data").find('div:first').html(result.data);
        //         } else {
        //             $("#shownotify1data").find('div:first').html('No Shipper found');
        //         }
        //     });
        //     return false;
        // }

        // const getNotify2Data = (obj) => {
        //     var consigneeIdx = obj.value;
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('master.booking.consignee_data', ['id' => $id]) }}",
        //         dataType: 'json',
        //         data: {
        //             consigneeIdx,
        //             "_token": "{{ csrf_token() }}"
        //         },
        //     }).done(function(result) {
        //         if (result.status) {
        //             $("#shownotify2data").find('div:first').html(result.data);
        //         } else {
        //             $("#shownotify2data").find('div:first').html('No Shipper found');
        //         }
        //     });
        //     return false;
        // }

        // const getNotify3Data = (obj) => {
        //     var consigneeIdx = obj.value;
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('master.booking.consignee_data', ['id' => $id]) }}",
        //         dataType: 'json',
        //         data: {
        //             consigneeIdx,
        //             "_token": "{{ csrf_token() }}"
        //         },
        //     }).done(function(result) {
        //         if (result.status) {
        //             $("#shownotify3data").find('div:first').html(result.data);
        //         } else {
        //             $("#shownotify3data").find('div:first').html('No Shipper found');
        //         }
        //     });
        //     return false;
        // }

        // const sameAsConsignee = (obj) => {
        //     if ($(obj).attr('checked') == 'checked') {
        //         const ms_consignee_id = $("#ms_consignee_id").val();
        //         $("select[name='notify_user1']").val(ms_consignee_id).trigger('change');
        //     }
        // }

        // const newrequiredOBL = (obj) => {
        //     $("input[name='express_bl']").prop('disabled',false);
        //         $("input[name='required_obl']").prop('disabled',false);
        //     if ($(obj).attr('checked') == 'checked') {
        //         $(obj).parent().parent().parent().find('input[type="text"]').show();
        //         $("input[name='express_bl']").prop('checked',false).trigger('click').prop('disabled',true);
        //     } else {
        //         $(obj).parent().parent().parent().find('input[type="text"]').hide();
        //         $("input[name='express_bl']").prop('disabled',false);
        //     }
        // }
        // const newExpressBL = (obj) => {
        //         $("input[name='express_bl']").prop('disabled',false);
        //         $("input[name='required_obl']").prop('disabled',false);
        //     if ($(obj).attr('checked') == 'checked') {
        //         $(obj).parent().parent().parent().find('input[type="text"]').show();
        //         $("input[name='required_obl']").prop('checked',false).trigger('click').prop('disabled',true);
        //     } else {
        //         $(obj).parent().parent().parent().find('input[type="text"]').hide();
        //     }
        // }

        // const getContainerDetails = () => {
        //     $( "input[id^='document_no_of_package_']" ).each(function(){
        //         var thisidx = $(this).attr('id');
        //         var tmpobj = thisidx.split('_');
        //         var mainidx = tmpobj[4] || 0;
        //         $(`#show_no_of_packages_${mainidx}`).val($(this).val());
        //     });

        //     $( "input[id^='document_kind_of_package_']" ).each(function(){
        //         var thisidx = $(this).attr('id');
        //         var tmpobj = thisidx.split('_');
        //         var mainidx = tmpobj[4] || 0;
        //         $(`#show_kind_of_packages_${mainidx}`).val($(this).val());
        //     });



        // }
    </script>
@endsection
