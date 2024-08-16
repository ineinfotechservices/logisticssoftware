@extends('layouts.private')
@php
    $globalTitle = 'Shipper';
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
                        <a href="{{ route('master.city.index') }}">Manage {{ $globalTitle }}</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li><a href="#">Edit {{ $globalTitle }}</a></li>
                </ul>
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            <div class="span8">
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
                            <form action="{{ route('master.exporter.update', ['id' => $exporter->id]) }}" method="post"
                                class="form-horizontal" enctype="multipart/form-data" id="frmaddexporter"
                                onsubmit="return sendForm(this)">@csrf

                                <div class="row-fluid">
                                    <div class="span6 ">
                                        <div class="control-group">
                                            <label class="control-label">*Enter Name</label>
                                            <div class="controls">
                                                <input type="text" name="name" value="{{ $exporter->name }}"
                                                    placeholder="Please provide Name" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Enter Email</label>
                                            <div class="controls">
                                                <input type="text" name="email" value="{{ $exporter->email }}"
                                                    placeholder="Please provide Email" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Enter Phone</label>
                                            <div class="controls">
                                                <input type="text" name="phone" value="{{ $exporter->phone }}"
                                                    placeholder="Please provide Phone" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Enter Address</label>
                                            <div class="controls">
                                                <input type="text" name="address" placeholder="Please provide Address"
                                                    class="m-wrap medium" value="{{ $exporter->address }}" />
                                                <a href="javascript:void(0)" class="btn mini blue"  onclick="addmoreAddress(this)"><i class="icon-plus"></i> Add More</a>
                                            </div>
                                        </div>
                                        <div class="control-group" id="address_2" style="display:none">
                                            <label class="control-label">Address 2</label>
                                            <div class="controls">
                                                <input type="text" name="address2"
                                                    value="{{ $exporter->address2 ?? '' }}"
                                                    placeholder="Please provide Address" class="m-wrap medium" />
                                                <a href="javascript:void(0)" class="btn mini black"  onclick="deletemoreAddress(2)"><i class="icon-trash"></i> Delete</a>
                                            </div>
                                        </div>
                                        <div class="control-group" id="address_3" style="display:none">
                                            <label class="control-label">Address 3</label>
                                            <div class="controls">
                                                <input type="text" name="address3"
                                                    value="{{ $exporter->address3 ?? '' }}"
                                                    placeholder="Please provide Address" class="m-wrap medium" />
                                                <a href="javascript:void(0)" class="btn mini black"  onclick="deletemoreAddress(3)"><i class="icon-trash"></i> Delete</a>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Country</label>
                                            <div class="controls">
                                                @if (isset($countries) && is_object($countries) && $countries->count())
                                                    <select name="country"
                                                        onchange="getEditState(this,'state_id','{{ $exporter->state_id ?? 0 }}')" class="form-control">
                                                        <option value="">Select Country</option>
                                                        @foreach ($countries as $country)
                                                            @if ($country->id == $exporter->country)
                                                                <option selected value="{{ $country->id ?? 0 }}">
                                                                @else
                                                                <option value="{{ $country->id ?? 0 }}">
                                                            @endif
                                                            {{ $country->title ?? '' }}</option>
                                                        @endforeach
                                                    </select>
                                                @endif

                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">State</label>
                                            <div class="controls">
                                                <select name="state_id" id="state_id"
                                                    onchange="getEditCity(this,'city_id','{{ $exporter->city_id ?? 0 }}')">
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
                                            <label class="control-label">Enter Pincode</label>
                                            <div class="controls">
                                                <input type="text" name="pincode" value="{{ $exporter->pincode }}"
                                                    placeholder="Please provide Pincode" class="m-wrap medium" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6 ">
                                        {{-- <div class="control-group">
                                            <label class="control-label">Enter Electricity Number</label>
                                            <div class="controls">
                                                <input type="text" name="electricity_bill_number"
                                                    value="{{ $exporter->electricity_bill_number }}"
                                                    placeholder="Please provide Electricity Bill Number"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div> --}}
                                        <div class="control-group">
                                            <label class="control-label">Telephone Number</label>
                                            <div class="controls">
                                                <input type="text" name="telephone_number"
                                                    value="{{ $exporter->telephone_number }}"
                                                    placeholder="Please provide Telephone Number" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Enter GST Number</label>
                                            <div class="controls">
                                                <input type="text" name="gst_number"
                                                    value="{{ $exporter->gst_number }}" placeholder="Please provide GST"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Enter GST Address</label>
                                            <div class="controls">
                                                <textarea type="text" name="gst_address" placeholder="Please provide Name" class="m-wrap medium">{{ $exporter->gst_address }}</textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Enter Pan Number</label>
                                            <div class="controls">
                                                <input type="text" name="pan_number"
                                                    value="{{ $exporter->pan_number }}" placeholder="Please provide PAN"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div>
                                        {{-- <div class="control-group">
                                            <label class="control-label">Enter Aadhar Number</label>
                                            <div class="controls">
                                                <input type="text" name="aadhar_number"
                                                    value="{{ $exporter->aadhar_number }}"
                                                    placeholder="Please provide Aadhar" class="m-wrap medium" />
                                            </div>
                                        </div> --}}
                                        <div class="control-group">
                                            <label class="control-label">Enter IEC Number</label>
                                            <div class="controls">
                                                <input type="text" name="iec_number"
                                                    value="{{ $exporter->iec_number }}" placeholder="Please provide IEC"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div>
                                        {{-- <div class="control-group">
                                            <label class="control-label">Select Electricity File</label>
                                            <div class="controls">
                                                <input type="file" name="electricity_bill_file"
                                                    value="{{ $exporter->electricity_bill_file }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div> --}}



                                        {{-- <div class="control-group">
                                            <label class="control-label">Select Telephone File</label>
                                            <div class="controls">
                                                <input type="file" name="telephone_file"
                                                    value="{{ $exporter->telephone_file }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div> --}}

                                        {{-- <div class="control-group">
                                            <label class="control-label">Select GST File</label>
                                            <div class="controls">
                                                <input type="file" name="gst_file" value="{{ $exporter->gst_file }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div> --}}

                                    </div>
                                </div>


                                <div class="form-actions">
                                    <button type="submit" class="btn blue"><i class="icon-ok"></i> Update</button>
                                    <a href="{{ route('master.exporter.index') }}" class="btn red">Cancel</a>
                                </div>
                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
                <!-- END SAMPLE FORM PORTLET-->
            </div>
            <div class="span4 ">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Document Uploads</h4>
                    </div>
                    <div class="portlet-body">
                        <div id="form-file-errors"></div>
                        <form action="{{ route('master.exporter.saveedit') }}" method="post" class="form-horizontal"
                            enctype="multipart/form-data" id="frmdocsupdate" onsubmit="return frmDocumentUpdate(this)">@csrf
                            <input type="hidden" name="fileid" value="{{ $exporter->id ?? 0 }}" />
                            <div class="btn-group">
                                @php
                                    $getFileTypes = \Helper::getFileTypeAction();
                                @endphp
                                <select class="form-control" name="filetypeselection" class="form-control chosen_category">

                                    @if (isset($getFileTypes) && is_array($getFileTypes) && sizeof($getFileTypes))
                                        @foreach ($getFileTypes as $key => $typeValue)
                                            <option value={{ $key }}>{{ $typeValue }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div id="showFileUploader">
                                <input class="form-control" type="file" name="file_upload" />
                                <button type="submit" class="btn blue"><i class="icon-ok"></i>
                                    Upload file</button>
                                <button type="button" class="btn">Cancel</button>
                            </div>
                            <br />

                            <table class="table table-hover" id="showExporter">
                                <thead>
                                    <tr>
                                        <th>File Document Name</th>
                                        <th>File URL</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {!! \Helper::generateDocumentUploadHTMLforUpdate($exporter) !!}
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->

    <script>
        setTimeout(function() {
            $("select[name='country']").trigger('change');
        }, 1000);
        setTimeout(function() {
            $("select[name='state_id']").trigger('change');
        }, 1500);
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
                url: $('#frmaddexporter').attr('action'),
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
                        window.location.href = "{{ route('master.exporter.index') }}";
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

        const frmDocumentUpdate = (obj) => {
            $.ajax({
                type: "POST",
                url: $('#frmdocsupdate').attr('action'),
                dataType: 'json',
                data: new FormData(obj),
                processData: false,
                contentType: false,
            }).done(function(result) {
                if (result.status) {
                    var errors = result.msg;
                    $("#showExporter").find('tbody').html(result.data);
                    var nerrorsHtml = '<div class="alert alert-success">' + errors + '</div>';
                    $('#form-file-errors').html(nerrorsHtml).show();
                    setTimeout(function() {
                        $('#form-file-errors').html('').hide();
                    }, 2000);
                } else {
                    var errors = result.msg;
                    var errorsHtml = '<div class="alert alert-danger"><ul>';

                    $.each(errors, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                    });
                    errorsHtml += '</ul></div>';

                    $('#form-file-errors').html(errorsHtml).show();
                    setTimeout(function() {
                        $('#form-file-errors').html('').hide();
                    }, 3000);
                }
            });
            return false;
        }
        const deleteRealEditDoc = (filex, idx) => {
            if (confirm('Are you sure want to remove it ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('master.exporter.deleteedit') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        filetype: filex,
                        fileid: idx
                    },
                }).done(function(result) {
                    if (result.status) {
                        var errors = result.msg;
                        $("#showExporter").find('tbody').html(result.data);
                    } else {
                        var errors = result.msg;
                        var errorsHtml = '<div class="alert alert-danger"><ul>';

                        $.each(errors, function(key, value) {
                            errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                        });
                        errorsHtml += '</ul></div>';

                        $('#form-file-errors').html(errorsHtml).show();
                        setTimeout(function() {
                            $('#form-file-errors').html('').hide();
                        }, 3000);
                    }
                });
            }

            return false;
        }
    </script>
    @if (isset($exporter->address2) && $exporter->address2 != '')
        <script>
            setTimeout(function() {
                $("#address_2").show();
            }, 1000);
        </script>
    @endif
    @if (isset($exporter->address3) && $exporter->address3 != '')
        <script>
            setTimeout(function() {
                $("#address_3").show();
            }, 1000);
        </script>
    @endif
@endsection
