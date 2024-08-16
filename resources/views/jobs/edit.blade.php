@extends('layouts.private')
@php 
    $globalTitle = "Exporter";
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
                            <form action="{{ route('master.exporter.update',['id'=>$exporter->id]) }}" method="post" class="form-horizontal"
                                enctype="multipart/form-data" id="frmaddexporter" onsubmit="return sendForm(this)">@csrf

                                <div class="row-fluid">
                                    <div class="span4 ">
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
                                            <label class="control-label">*Enter Phone</label>
                                            <div class="controls">
                                                <input type="text" name="phone" value="{{ $exporter->phone }}"
                                                    placeholder="Please provide Phone" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Enter Address</label>
                                            <div class="controls">
                                                <textarea type="text" name="address" placeholder="Please provide Address" class="m-wrap medium">{{ $exporter->address }}</textarea>
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select State</label>
                                            <div class="controls">
                                                @if (isset($states) && is_object($states) && $states->count())
                                                    <select name="state_id">
                                                        <option value="">Select State</option>
                                                        @foreach ($states as $state)
                                                            @if(isset($exporter->state_id) && $exporter->state_id==$state->id)
                                                            <option selected value="{{ $state->id ?? 0 }}">
                                                                {{ $state->title ?? '' }}</option>
                                                            @else 
                                                            <option value="{{ $state->id ?? 0 }}">
                                                                {{ $state->title ?? '' }}</option>
                                                            @endif     
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
                                                        @if(isset($exporter->state_id) && $exporter->city_id==$city->id)
                                                            <option selected value="{{ $city->id ?? 0 }}">
                                                                {{ $city->title ?? '' }}</option>
                                                         @else 
                                                            <option value="{{ $city->id ?? 0 }}">
                                                                {{ $city->title ?? '' }}</option>
                                                         @endif       
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Enter Pincode</label>
                                            <div class="controls">
                                                <input type="text" name="pincode" value="{{ $exporter->pincode }}"
                                                    placeholder="Please provide Pincode" class="m-wrap medium" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4 ">
                                        <div class="control-group">
                                            <label class="control-label">Enter Electricity Number</label>
                                            <div class="controls">
                                                <input type="text" name="electricity_bill_number"
                                                    value="{{ $exporter->electricity_bill_number }}"
                                                    placeholder="Please provide Electricity Bill Number"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div>

                                        <div class="control-group">
                                            <label class="control-label">Select Electricity File</label>
                                            <div class="controls">
                                                <input type="file" name="electricity_bill_file"
                                                    value="{{ $exporter->electricity_bill_file }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Telephone Number</label>
                                            <div class="controls">
                                                <input type="text" name="telephone_number"
                                                    value="{{ $exporter->telephone_number }}"
                                                    placeholder="Please provide Telephone Number" class="m-wrap medium" />
                                            </div>
                                        </div>


                                        <div class="control-group">
                                            <label class="control-label">Select Telephone File</label>
                                            <div class="controls">
                                                <input type="file" name="telephone_file"
                                                    value="{{ $exporter->telephone_file }}" placeholder="Please provide File"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Enter GST Number</label>
                                            <div class="controls">
                                                <input type="text" name="gst_number" value="{{ $exporter->gst_number }}"
                                                    placeholder="Please provide GST" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select GST File</label>
                                            <div class="controls">
                                                <input type="file" name="gst_file" value="{{ $exporter->gst_file }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Enter GST Address</label>
                                            <div class="controls">
                                                <textarea type="text" name="gst_address" placeholder="Please provide Name" class="m-wrap medium">{{ $exporter->gst_address }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span4 ">
                                        <div class="control-group">
                                            <label class="control-label">*Enter Pan Number</label>
                                            <div class="controls">
                                                <input type="text" name="pan_number" value="{{ $exporter->pan_number }}"
                                                    placeholder="Please provide PAN" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select Pan File</label>
                                            <div class="controls">
                                                <input type="file" name="pan_file" value="{{ old('pan_file') }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Enter Aadhar Number</label>
                                            <div class="controls">
                                                <input type="text" name="aadhar_number"
                                                    value="{{ $exporter->aadhar_number }}"
                                                    placeholder="Please provide Aadhar" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select Aadhar File</label>
                                            <div class="controls">
                                                <input type="file" name="aadhar_file"
                                                    value="{{ old('aadhar_file') }}" placeholder="Please provide File"
                                                    class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Enter IEC Number</label>
                                            <div class="controls">
                                                <input type="text" name="iec_number" value="{{ $exporter->iec_number }}"
                                                    placeholder="Please provide IEC" class="m-wrap medium" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">*Select IEC File</label>
                                            <div class="controls">
                                                <input type="file" name="iec_file" value="{{ old('iec_file') }}"
                                                    placeholder="Please provide File" class="m-wrap medium" />
                                            </div>
                                        </div>

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