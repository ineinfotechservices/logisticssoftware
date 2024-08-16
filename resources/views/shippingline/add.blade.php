@extends('layouts.private')

@section('content')
    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
         <div id="portlet-config" class="modal hide">
            <div class="modal-header">
               <button data-dismiss="modal" class="close" type="button"></button>
               <h3>portlet Settings</h3>
            </div>
            <div class="modal-body">
               <p>Here will be a configuration form</p>
            </div>
         </div>
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
                     Add Shipping Line                     
                  </h3>
                  <ul class="breadcrumb">
                     <li>
                        <i class="icon-home"></i>
                        <a href="{{ route('users.dashboard') }}">Home</a> 
                        <span class="icon-angle-right"></span>
                     </li>
                     <li>
                        <a href="{{ route('master.shippingline.index') }}">Manage Shipping Line</a>
                        <span class="icon-angle-right"></span>
                     </li>
                     <li><a href="#">Add Shipping Line</a></li>
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
                           <span class="hidden-480">Add Shipping Line</span>
                           &nbsp;
                        </h4>
                     </div>
                     <div class="portlet-body form">
                           <div class="tab-content">
                                 @include('common.msg')
                                 <form action="{{ route('master.shippingline.save') }}" method="post" class="form-horizontal">@csrf
                                    <div class="control-group">
                                       <label class="control-label">Full Name</label>
                                       <div class="controls">
                                          <input type="text" name="full_name" value="{{ old('full_name') }}" placeholder="Please provide Name" class="m-wrap medium" />
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Address</label>
                                       <div class="controls">
                                          <textarea type="text" name="address" value="{{ old('address') }}" class="m-wrap medium" ></textarea>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                       <a href="{{ route('master.shippingline.index') }}" class="btn red">Cancel</a>
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
@endsection
