@extends('layouts.private')
@php 
    $globalTitle = "City";
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
                                 <form action="{{ route('master.city.update',['id'=>$shippingline->id]) }}" method="post" class="form-horizontal">@csrf
                                    <div class="control-group">
                                       <label class="control-label">Full Name</label>
                                       <div class="controls">
                                          <input type="text" name="title" value="{{ $shippingline->title ?? '' }}" placeholder="Please provide Title" class="m-wrap medium" />
                                       </div>
                                    </div>
                                    <div class="control-group">
                                       <label class="control-label">Select Country</label>
                                       <div class="controls">
                                          @if(isset($states) && is_object($states) && $states->count())
                                          <select name="state_id">
                                             <option value="">Select State</option>
                                             @foreach($states as $state)
                                                   @if(isset($shippingline->state_id) && $shippingline->state_id==$state->id)
                                                      <option value="{{ $state->id ?? 0 }}" selected>{{ $state->title ?? '' }}</option>
                                                   @else 
                                                      <option value="{{ $state->id ?? 0 }}">{{ $state->title ?? '' }}</option>
                                                   @endif
                                             @endforeach   
                                             </select>
                                          @endif
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue">Update</button>
                                       <a href="{{ route('master.city.index') }}" class="btn red">Cancel</a>
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