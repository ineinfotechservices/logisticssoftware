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
                        <a href="{{ route('master.exporter.index') }}">Manage {{ $globalTitle }}</a>
                        <span class="icon-angle-right"></span>
                    </li>
                    <li><a href="#">Add {{ $globalTitle }}</a></li>
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
                            <span class="hidden-480">Add {{ $globalTitle }}</span>
                            &nbsp;
                        </h4>
                    </div>
                    <div class="portlet-body form">
                        <div class="tab-content">
                            @include('common.msg')
                            <div id="form-errors"></div>
                            <form action="{{ route('master.exporter.save') }}" method="post" class="form-horizontal"
                                id="frmaddexporter" onsubmit="return sendForm(this)">@csrf

                                <div class="row-fluid">
                                    <div class="span6 ">
                                        <div class="control-group">
                                            <label class="control-label">*Enter Name</label>
                                            <div class="controls">
                                                <input type="text" name="name" value="{{ old('name') }}"
                                                    placeholder="Please provide Name" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Enter Email</label>
                                            <div class="controls">
                                                <input type="text" name="email" value="{{ old('email') }}"
                                                    placeholder="Please provide Email" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Enter Phone</label>
                                            <div class="controls">
                                                <input type="text" name="phone" value="{{ old('phone') }}"
                                                    placeholder="Please provide Phone" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Enter Address</label>
                                            <div class="controls">
                                                <input type="text" name="address" placeholder="Please provide Address"
                                                    class="m-wrap medium" value="{{ old('address') }}" />
                                                <a href="javascript:void(0)" class="btn mini blue" onclick="addmoreAddress(this)"> <i class="icon-plus"></i>Add More</a>
                                            </div>
                                        </div>
                                        <div class="control-group" id="address_2" style="display:none">
                                            <label class="control-label">Address 2</label>
                                            <div class="controls">
                                                <input type="text" name="address2" value="{{ old('address2') }}"
                                                    placeholder="Please provide Address" class="m-wrap medium" />
                                                <a href="javascript:void(0)" class="btn mini black" onclick="deletemoreAddress(2)"><i class="icon-trash"></i> Delete</a>
                                            </div>
                                        </div>
                                        <div class="control-group" id="address_3" style="display:none">
                                            <label class="control-label">Address 3</label>
                                            <div class="controls">
                                                <input type="text" name="address3" value="{{ old('address3') }}"
                                                    placeholder="Please provide Address" class="m-wrap medium" />
                                                <a href="javascript:void(0)" class="btn mini black" onclick="deletemoreAddress(3)"><i class="icon-trash"></i> Delete</a>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Country</label>
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
                                            <label class="control-label">Select State</label>
                                            <div class="controls">
                                                @if (isset($states) && is_object($states) && $states->count())
                                                    <select name="state_id" id="state_id"
                                                        onchange="getCity(this,'city_id')">
                                                        <option value="">Select State</option>
                                                    </select>
                                                @endif
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
                                                <input type="text" name="pincode" value="{{ old('pincode') }}"
                                                    placeholder="Please provide Pincode" class="m-wrap medium" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4 ">
                                        {{-- <div class="control-group">
                                            <label class="control-label">Enter Electricity Number</label>
                                            <div class="controls">
                                                <input type="text" name="electricity_bill_number"
                                                    value="{{ old('electricity_bill_number') }}"
                                                    placeholder="Please provide Electricity Bill Number"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div> --}}

                                        {{-- <div class="control-group">
                                            <label class="control-label">Select Electricity File</label>
                                            <div class="controls">
                                                <input type="file" name="electricity_bill_file"
                                                    value="{{ old('electricity_bill_file') }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div> --}}
                                        <div class="control-group">
                                            <label class="control-label">Telephone Number</label>
                                            <div class="controls">
                                                <input type="text" name="telephone_number"
                                                    value="{{ old('telephone_number') }}"
                                                    placeholder="Please provide Telephone Number" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        {{-- <div class="control-group">
                                            <label class="control-label">Select Telephone File</label>
                                            <div class="controls">
                                                <input type="file" name="telephone_file"
                                                    value="{{ old('telephone_file') }}" placeholder="Please provide File"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div> --}}
                                        <div class="control-group">
                                            <label class="control-label">*Enter GST Number</label>
                                            <div class="controls">
                                                <input type="text" name="gst_number" value="{{ old('gst_number') }}"
                                                    placeholder="Please provide GST" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        {{-- <div class="control-group">
                                            <label class="control-label">*Select GST File</label>
                                            <div class="controls">
                                                <input type="file" name="gst_file" value="{{ old('gst_file') }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div> --}}
                                        <div class="control-group">
                                            <label class="control-label">Enter GST Address</label>
                                            <div class="controls">
                                                <textarea type="text" name="gst_address" placeholder="Please provide Name" class="m-wrap medium">{{ old('gst_address') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Enter Pan Number</label>
                                            <div class="controls">
                                                <input type="text" name="pan_number" value="{{ old('pan_number') }}"
                                                    placeholder="Please provide PAN" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        {{-- <div class="control-group">
                                            <label class="control-label">*Enter Aadhar Number</label>
                                            <div class="controls">
                                                <input type="text" name="aadhar_number"
                                                    value="{{ old('aadhar_number') }}"
                                                    placeholder="Please provide Aadhar" class="m-wrap medium" />
                                            </div>
                                        </div> --}}
                                        <div class="control-group">
                                            <label class="control-label">Enter IEC Number</label>
                                            <div class="controls">
                                                <input type="text" name="iec_number" value="{{ old('iec_number') }}"
                                                    placeholder="Please provide IEC" class="m-wrap medium" />
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="span4 "> --}}

                                    {{-- <div class="control-group">
                                            <label class="control-label">*Select Pan File</label>
                                            <div class="controls">
                                                <input type="file" name="pan_file" value="{{ old('pan_file') }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div> --}}

                                    {{-- <div class="control-group">
                                            <label class="control-label">*Select Aadhar File</label>
                                            <div class="controls">
                                                <input type="file" name="aadhar_file"
                                                    value="{{ old('aadhar_file') }}" placeholder="Please provide File"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div> --}}

                                    {{-- <div class="control-group">
                                            <label class="control-label">*Select IEC File</label>
                                            <div class="controls">
                                                <input type="file" name="iec_file" value="{{ old('iec_file') }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div> --}}


                                    {{-- </div> --}}
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
            <div class="span4 ">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>Document Uploads</h4>
                    </div>
                    <div class="portlet-body">
                        <div id="form-file-errors"></div>
                        <form action="{{ route('master.exporter.docssave') }}" method="post" class="form-horizontal"
                            enctype="multipart/form-data" id="frmdocssave" onsubmit="return frmDocumentSave(this)">@csrf
                            <div class="btn-group">
                                @php
                                    $getFileTypes = \Helper::getFileTypeAction();
                                @endphp
                                <select class="form-control" name="filetypeselection">

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
                                    {{-- <tr>
                                                            <td>1</td>
                                                            <td>Mark</td>
                                                            <td>Otto</td>
                                                            <td><span class="label label-success">Approved</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td>2</td>
                                                            <td>Jacob</td>
                                                            <td>Nilson</td>
                                                            <td><span class="label label-info">Pending</span></td>
                                                        </tr> --}}
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

        const FileUploadType = (obj) => {
            if (obj.value == '') {
                document.getElementById('showFileUploader').style.display = 'none';
            }
            document.getElementById('showFileUploader').style.display = 'block';
        }

        const frmDocumentSave = (obj) => {
            $.ajax({
                type: "POST",
                url: $('#frmdocssave').attr('action'),
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

        const deletetmpFile = (filex) => {
            if (confirm('Are you sure want to remove it ?')) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('master.exporter.deletetmp') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        filetype: filex
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
@endsection
