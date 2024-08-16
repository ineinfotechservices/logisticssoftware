@extends('layouts.private')
@php
    $globalTitle = 'Booking Detail';
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
                <li class="active"><a href="#tab_1" data-toggle="tab">Party</a></li>
                <li><a class="advance_form_with_chosen_element" href="#tab_2" data-toggle="tab">Vessel Detail</a>
                <li><a class="advance_form_with_chosen_element" href="#tab_3" data-toggle="tab">Cargo Detail</a>
                <li><a class="advance_form_with_chosen_element" href="#tab_4" data-toggle="tab">Container Detail</a>
                    {{-- <li><a class="advance_form_with_chosen_element" href="#tab_5" data-toggle="tab">Preview</a> --}}
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <form action="{{ route('master.booking.documentupdate', ['id' => $id]) }}" method="post"
                        class="form-horizontal" enctype="multipart/form-data" id="frmedtbookingdetailupdate"
                        onsubmit="return sendForm(this)">
                        @csrf
                        <div class="row-fluid">
                            <div class="span12">
                                <!-- BEGIN SAMPLE FORM PORTLET-->
                                <div class="portlet box blue">
                                    <div class="portlet-title">
                                        <h4>
                                            <i class="icon-reorder"></i>
                                            <span class="hidden-480">Party Detail</span>
                                            &nbsp;
                                        </h4>
                                    </div>
                                    <div class="portlet-body form">
                                        <div class="tab-content">
                                            <div class="row-fluid">
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label class="control-label">*Job Number</label>
                                                        <div class="controls">
                                                            {{ $booking_detail->job_number ?? '' }}
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">BL Number</label>
                                                        <div class="controls">
                                                            <input type="text" name="bl_number"
                                                                value="{{ $booking_detail->bl_number ?? '' }}"
                                                                class="m-wrap small" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Shipper</label>
                                                        <div class="controls">

                                                            @if (isset($exporter) && is_object($exporter) && $exporter->count())
                                                                    @foreach ($exporter as $exp)
                                                                        @if ($booking_detail->ms_exporter_id == $exp->id)
                                                                            
                                                                                {{ $exp->name ?? '' }}
                                                                        @else
                                                                            
                                                                        @endif
                                                                    @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group" id="showshipperdata">
                                                        <label class="control-label"></label>
                                                        <div class="controls">
                                                            {!! \Helper::getShipperDetailBL($booking_detail->ms_exporter_id ?? 0) !!}
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Consignee</label>
                                                        <div class="controls">

                                                            @if (isset($consignee_list) && is_object($consignee_list) && $consignee_list->count())
                                                                <select name="ms_consignee_id" id="ms_consignee_id"
                                                                    onchange="getConsigneeData(this)"
                                                                    class="form-control chosen_category">
                                                                    <option value="">Select Consignee</option>
                                                                    @foreach ($consignee_list as $exp)
                                                                        @if ($booking_detail->ms_consignee_id == $exp->id)
                                                                            <option selected value="{{ $exp->id }}">
                                                                                {{ $exp->full_name ?? '' }}</option>
                                                                        @else
                                                                            <option value="{{ $exp->id }}">
                                                                                {{ $exp->full_name ?? '' }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group" id="showconsigneedata">
                                                        <label class="control-label"></label>
                                                        <div class="controls" contenteditable="true">
                                                            {!! \Helper::getConsigneeDetailBL($booking_detail->ms_consignee_id ?? 0) !!}
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Notify Type</label>
                                                        <div class="controls">
                                                            @if ($booking_detail->same_as_consignee == 0)
                                                                <input onclick="sameAsConsignee(this)" type="checkbox"
                                                                    name="same_as_consignee" value="1" />
                                                            @else
                                                                <input onclick="sameAsConsignee(this)" type="checkbox"
                                                                    name="same_as_consignee" value="0" checked />
                                                            @endif
                                                            Same as Consignee ?
                                                        </div>
                                                    </div>
                                                    {{-- <div class="control-group">
                                                        <label class="control-label">Shipping Bill File</label>
                                                        <div class="controls">
                                                            <input type="file" name="shipping_bill" />
                                                            <br />
                                                            @if (isset($booking_detail->shipping_bill_url) && $booking_detail->shipping_bill_url != '')
                                                                <a href="{{ $booking_detail->shipping_bill_url ?? '' }}"
                                                                    target="_blank">View File</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Gate Pass File</label>
                                                        <div class="controls">
                                                            <input type="file" name="gate_pass" />
                                                            <br />
                                                            @if (isset($booking_detail->gate_pass_url) && $booking_detail->gate_pass_url != '')
                                                                <a href="{{ $booking_detail->gate_pass_url ?? '' }}"
                                                                    target="_blank">View File</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Invoice Copy File</label>
                                                        <div class="controls">
                                                            <input type="file" name="invoice_copy" />
                                                            <br />
                                                            @if (isset($booking_detail->invoice_copy_url) && $booking_detail->invoice_copy_url != '')
                                                                <a href="{{ $booking_detail->invoice_copy_url ?? '' }}"
                                                                    target="_blank">View File</a>
                                                            @endif
                                                        </div>
                                                    </div> --}}


                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label class="control-label">*Select Notify 1</label>
                                                        <div class="controls">
                                                            @if (isset($consignee_list) && is_object($consignee_list) && $consignee_list->count())
                                                                <select name="notify_user1"
                                                                    class="m-wrap span11 chosen_category"
                                                                    onchange="getNotify1Data(this)">
                                                                    <option value="">Select Notify User</option>
                                                                    @foreach ($consignee_list as $option)
                                                                        @if (isset($booking_detail->notify_user1) && $booking_detail->notify_user1 == $option->id)
                                                                            <option selected
                                                                                value="{{ $option->id ?? 0 }}">
                                                                                {{ $option->full_name ?? '' }}</option>
                                                                        @else
                                                                            <option value="{{ $option->id ?? 0 }}">
                                                                                {{ $option->full_name ?? '' }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group" id="shownotify1data">
                                                        <label class="control-label"></label>
                                                        <div class="controls" contenteditable="true">
                                                            {!! \Helper::getConsigneeDetailBL($booking_detail->notify_user1 ?? 0) !!}
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Select Notify 2</label>
                                                        <div class="controls">
                                                            @if (isset($consignee_list) && is_object($consignee_list) && $consignee_list->count())
                                                                <select name="notify_user2"
                                                                    class="m-wrap span11 chosen_category"
                                                                    onchange="getNotify2Data(this)">
                                                                    <option value="">Select Notify User</option>
                                                                    @foreach ($consignee_list as $option)
                                                                        @if (isset($booking_detail->notify_user2) && $booking_detail->notify_user2 == $option->id)
                                                                            <option selected
                                                                                value="{{ $option->id ?? 0 }}">
                                                                                {{ $option->full_name ?? '' }}</option>
                                                                        @else
                                                                            <option value="{{ $option->id ?? 0 }}">
                                                                                {{ $option->full_name ?? '' }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group" id="shownotify2data">
                                                        <label class="control-label"></label>
                                                        <div class="controls" contenteditable="true">
                                                            {!! \Helper::getConsigneeDetailBL($booking_detail->notify_user2 ?? 0) !!}
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Select Notify 3</label>
                                                        <div class="controls">
                                                            @if (isset($consignee_list) && is_object($consignee_list) && $consignee_list->count())
                                                                <select name="notify_user3"
                                                                    class="m-wrap span11 chosen_category"
                                                                    onchange="getNotify3Data(this)">
                                                                    <option value="">Select Notify User</option>
                                                                    @foreach ($consignee_list as $option)
                                                                        @if (isset($booking_detail->notify_user3) && $booking_detail->notify_user3 == $option->id)
                                                                            <option selected
                                                                                value="{{ $option->id ?? 0 }}">
                                                                                {{ $option->full_name ?? '' }}</option>
                                                                        @else
                                                                            <option value="{{ $option->id ?? 0 }}">
                                                                                {{ $option->full_name ?? '' }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group" id="shownotify3data">
                                                        <label class="control-label"></label>
                                                        <div class="controls" contenteditable="true">
                                                            {!! \Helper::getConsigneeDetailBL($booking_detail->notify_user3 ?? 0) !!}
                                                        </div>
                                                    </div>

                                                    {{-- <div class="control-group">
                                                        <label class="control-label">Packing List File</label>
                                                        <div class="controls">
                                                            <input type="file" name="packing_list" />
                                                            <br />
                                                            @if (isset($booking_detail->packing_list_url) && $booking_detail->packing_list_url != '')
                                                                <a href="{{ $booking_detail->packing_list_url ?? '' }}"
                                                                    target="_blank">View File</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">VGM Copy File</label>
                                                        <div class="controls">
                                                            <input type="file" name="vgm_copy" />
                                                            <br />
                                                            @if (isset($booking_detail->vgm_copy_url) && $booking_detail->vgm_copy_url != '')
                                                                <a href="{{ $booking_detail->vgm_copy_url ?? '' }}"
                                                                    target="_blank">View File</a>
                                                            @endif
                                                        </div>
                                                    </div> --}}
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label class="control-label">*Select Delivery Agent</label>
                                                        <div class="controls">
                                                            @if (isset($ms_get_delivery_agent) && is_object($ms_get_delivery_agent) && $ms_get_delivery_agent->count())
                                                                <select name="delivery_agent_id"
                                                                    class="m-wrap span11 chosen_category" onchange="getDeliveryAgentData(this)">
                                                                    <option value="">Select Delivery Agent</option>
                                                                    @foreach ($ms_get_delivery_agent as $option)
                                                                        @if (isset($booking_detail->delivery_agent_id) && $booking_detail->delivery_agent_id == $option->id)
                                                                            <option selected
                                                                                value="{{ $option->id ?? 0 }}">
                                                                                {{ $option->title ?? '' }}</option>
                                                                        @else
                                                                            <option value="{{ $option->id ?? 0 }}">
                                                                                {{ $option->title ?? '' }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group" id="showdeliveryDetails">
                                                        <label class="control-label"></label>
                                                        <div class="controls" contenteditable="true">
                                                            {!! \Helper::getDeliveryAgentDetailBL($booking_detail->delivery_agent_id ?? 0) !!}
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Remark</label>
                                                        <div class="controls">
                                                            <textarea rows="4" name="document_remark">{{ $booking_detail->document_remark ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="control-group">
                                                        <label class="control-label">Booking Copy File</label>
                                                        <div class="controls">
                                                            <input type="file" name="booking_copy" />
                                                            <br />
                                                            @if (isset($booking_detail->booking_copy_url) && $booking_detail->booking_copy_url != '')
                                                                <a href="{{ $booking_detail->booking_copy_url ?? '' }}"
                                                                    target="_blank">View File</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Other File</label>
                                                        <div class="controls">
                                                            <input type="file" name="other_file" />
                                                            <br />
                                                            @if (isset($booking_detail->other_file_url) && $booking_detail->other_file_url != '')
                                                                <a href="{{ $booking_detail->other_file_url ?? '' }}"
                                                                    target="_blank">View File</a>
                                                            @endif
                                                        </div>
                                                    </div> --}}
                                                </div>
                                            </div>
                                            <!-- END FORM-->
                                        </div>

                                    </div>
                                </div>
                                <div class="form-actions">
                                    @if (\Helper::isAdmin() || \Helper::isDocument())
                                        <button type="submit" class="btn blue"><i class="icon-ok"></i>
                                            Save & Next
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
                <div class="tab-pane" id="tab_2">
                    @if (\Helper::isAdmin() || \Helper::isCustomerService() || \Helper::isDocument())
                        <form action="{{ route('master.booking.documentvesseldetail', ['id' => $id]) }}" method="post"
                            class="form-horizontal" enctype="multipart/form-data" id="frmdocumentvesseldetail"
                            onsubmit="return sendVesselForm(this)">
                            @csrf
                            <div class="row-fluid">
                                <div class="span12">
                                    <!-- BEGIN SAMPLE FORM PORTLET-->
                                    <div class="portlet box blue">
                                        <div class="portlet-title">
                                            <h4>
                                                <i class="icon-reorder"></i>
                                                <span class="hidden-480">Vessel Detail</span>
                                                &nbsp;
                                            </h4>
                                        </div>
                                        <div class="portlet-body form">
                                            <div class="tab-content">
                                                <div class="row-fluid">
                                                    <div class="span4 ">
                                                        <div class="control-group">
                                                            <label class="control-label">Port of Loading</label>
                                                            <div class="controls">
                                                                
                                                                @if (isset($ms_port_of_loading) && is_object($ms_port_of_loading) && $ms_port_of_loading->count())
                                                                    <select name="ms_port_of_loading_id"
                                                                        id="ms_port_of_loading_id"
                                                                        class="form-control  chosen_category">
                                                                        <option value="">Select Port of Loading
                                                                        </option>
                                                                        @foreach ($ms_port_of_loading as $exp)
                                                                            @if ($booking_detail->ms_port_of_loading_id == $exp->id)
                                                                                <option selected
                                                                                    value="{{ $exp->id }}">
                                                                                    {{ $exp->title ?? '' }} - {{ $exp->country_name ?? '' }}</option>
                                                                            @else
                                                                                <option value="{{ $exp->id }}">
                                                                                    {{ $exp->title ?? '' }} - {{ $exp->country_name ?? '' }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                @endif
                                                            </div>
                                                        </div>
                                                       
                                                        <div class="control-group">
                                                            <label class="control-label">Port of Discharge</label>
                                                            <div class="controls">

                                                                @if (isset($ms_port_of_destination) && is_object($ms_port_of_destination) && $ms_port_of_destination->count())
                                                                    <select name="ms_port_of_destination"
                                                                        id="ms_port_of_destination"
                                                                        class="form-control chosen_category">
                                                                        <option value="">Select Port of Discharge
                                                                        </option>
                                                                        @foreach ($ms_port_of_destination as $exp)
                                                                            @if ($booking_detail->ms_port_of_destination == $exp->id)
                                                                                <option selected
                                                                                    value="{{ $exp->id }}">
                                                                                    {{ $exp->title ?? '' }}</option>
                                                                            @else
                                                                                <option value="{{ $exp->id }}">
                                                                                    {{ $exp->title ?? '' }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="span4 ">
                                                        <div class="control-group">
                                                            <label class="control-label">Freight Payble at:</label>
                                                            <div class="controls">

                                                                @if (isset($ms_port_of_destination) && is_object($ms_port_of_destination) && $ms_port_of_destination->count())
                                                                    <select name="freight_payble_at"
                                                                        id="freight_payble_at"
                                                                        class="form-control chosen_category">
                                                                        <option value="">Select </option>
                                                                        @foreach ($ms_port_of_destination as $exp)
                                                                            @if ($booking_detail->freight_payble_at == $exp->id)
                                                                                <option selected
                                                                                    value="{{ $exp->id }}">
                                                                                    {{ $exp->title ?? '' }}</option>
                                                                            @else
                                                                                <option value="{{ $exp->id }}">
                                                                                    {{ $exp->title ?? '' }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">*Final place of Delivery</label>
                                                            <div class="controls">
                                                                <textarea type="text" name="final_place_of_delivery" placeholder="Please provide File" class="m-wrap medium">{{ $booking_detail->final_place_of_delivery ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">Required OBL</label>
                                                            <div class="controls">
                                                                @if ($booking_detail->required_obl == 1)
                                                                    <input onclick=newrequiredOBL(this) type="checkbox"
                                                                        name="required_obl" value="1" checked />
                                                                @else
                                                                    <input onclick=newrequiredOBL(this) type="checkbox"
                                                                        name="required_obl" value="1"  />
                                                                @endif
                                                                <input
                                                                    @if ($booking_detail->required_obl == 0) style="display:none" @endif
                                                                    type="text" name="no_of_original_bills_of_loading"
                                                                    placeholder="Please provide No. of Original Bills of Loading"
                                                                    class="m-wrap small" value="3" readonly />
                                                                <input
                                                                    @if ($booking_detail->required_obl == 0) style="display:none" @endif
                                                                    type="text" name="no_of_negotiable_copy"
                                                                    placeholder="Please provide No. Of negotiable copy"
                                                                    class="m-wrap small" value="3" readonly />

                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">Express BL</label>
                                                            <div class="controls">
                                                                @if ($booking_detail->express_bl == 1)
                                                                    <input onclick="newExpressBL(this)" type="checkbox"
                                                                        name="express_bl" value="1" checked />
                                                                @else
                                                                    <input onclick="newExpressBL(this)" type="checkbox"
                                                                        name="express_bl" value="1"  />
                                                                @endif
                                                                <input
                                                                    @if ($booking_detail->express_bl == 0) style="display:none" @endif
                                                                    type="text" name="no_of_express_obj"
                                                                    placeholder="Please provide No. of Original Bills of Loading"
                                                                    class="m-wrap small" value="0" readonly />
                                                                <input
                                                                    @if ($booking_detail->express_bl == 0) style="display:none" @endif
                                                                    type="text" name="no_of_express_negotiable_copy"
                                                                    placeholder="Please provide No. Of negotiable copy"
                                                                    class="m-wrap small" value="1" readonly />

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
                                                Save & Next
                                            </button>
                                        @endif
                                        &nbsp;
                                        <a href="{{ route('master.booking.index') }}" class="btn red">Cancel</a>

                                    </div>
                                    <!-- END SAMPLE FORM PORTLET-->
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
                <div class="tab-pane" id="tab_3">
                    @if (\Helper::isAdmin() || \Helper::isCustomerService() || \Helper::isDocument())
                        <form action="{{ route('master.booking.cargo_details', ['id' => $id]) }}" method="post"
                            class="form-horizontal" enctype="multipart/form-data" id="frmdocumentcargodetail"
                            onsubmit="return sendCargoDetailForm(this)">
                            @csrf
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <h4><i class="icon-reorder"></i>Cargo Detail</h4>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                        <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                        <a href="javascript:;" class="reload"></a>
                                        <a href="javascript:;" class="remove"></a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <div class="row-fluid">
                                        {{-- <div class="span4 ">
                                            <div class="control-group">
                                                <label class="control-label">No of Package</label>
                                                <div class="controls">
                                                    <input type="text" class="m-wrap medium"
                                                        name="document_no_of_package" value="{{ $booking_detail->document_no_of_package ?? 0 }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="span4">
                                            <div class="control-group">
                                                <label class="control-label">Kind of Package</label>
                                                <div class="controls">
                                                    <input type="text" class="m-wrap medium"
                                                        name="document_kind_of_package" value="{{ $booking_detail->document_kind_of_package ?? '' }}" />
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="span4 ">
                                            <div class="control-group">
                                                <label class="control-label">*HSC Code</label>
                                                <div class="controls">
                                                    <input type="text" class="m-wrap medium" name="document_hsc_code"
                                                        value="{{ $booking_detail->document_hsc_code ?? '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php /* <table class="table table-bordered table-striped" id="numberOfContinerTable">
                                        <thead>
                                            <tr>
                                                <th width="10%">Container Number</th>
                                                <th width="5%">No of Package</th>
                                                <th width="5%">Kind of Package</th>
                                                <th width="10%">Gross Weight</th>
                                                <th width="10%">Measurement</th>
                                                {{-- <th width="10%">Custom Seal No.</th> --}}
                                                {{-- <th width="10%">Line/Seal No.</th> --}}
                                                <th>Marks</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($booking_detail_moment_detail) &&
                                                    is_object($booking_detail_moment_detail) &&
                                                    $booking_detail_moment_detail->count())
                                                @foreach ($booking_detail_moment_detail as $moment_detail)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="def_id[]"
                                                                value="{{ $moment_detail->id ?? 0 }}" />
                                                            <input class="m-wrap small" type="text"
                                                                name="container_number[]" disabled
                                                                value="{{ $moment_detail->container_number ?? '' }}" />
                                                        </td>
                                                        <td>
                                                            <input class="m-wrap small" id="document_no_of_package_{{ $moment_detail->id ?? 0}}" type="text"
                                                                name="document_no_of_package[]" 
                                                                value="{{ $moment_detail->document_no_of_package ?? '' }}" />
                                                        </td>
                                                        <td>
                                                            <input class="m-wrap small" id="document_kind_of_package_{{ $moment_detail->id ?? 0}}" type="text"
                                                                name="document_kind_of_package[]" 
                                                                value="{{ $moment_detail->document_kind_of_package ?? '' }}" />
                                                        </td>
                                                        <td>
                                                            <input class="m-wrap small" type="text"
                                                                name="document_gross_weight[]" 
                                                                value="{{ $moment_detail->document_gross_weight ?? '' }}" />
                                                        </td>
                                                        <td>
                                                            <input class="m-wrap small" type="text"
                                                                name="document_measurement[]" 
                                                                value="{{ $moment_detail->document_measurement ?? '' }}" />
                                                        </td>
                                                        <td>
                                                            <textarea type="text" class="span12" name="document_marks[]">{{ $moment_detail->document_marks ?? '' }}</textarea>
                                                        <td>
                                                            <textarea class="span12" name="document_description[]">{{ $moment_detail->document_description ?? '' }}</textarea>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table> */
                                    ?>
                                    <table class="table table-bordered" id="numberOfContinerTable">
                                        <thead>
                                            <tr>
                                                <th>Marks</th>
                                                <th>*Description</th>
                                                <th>Gross Weight</th>
                                                <th>Measurement</th>
                                                <th>Net Weight</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <textarea rows="5" cols="50" name="document_marks">{{ $booking_detail->document_marks ?? '' }}</textarea>
                                                </td>
                                                <td>
                                                    <textarea rows="5" cols="50" name="document_description">{{ $booking_detail->document_description ?? '' }}</textarea>
                                                </td>
                                                <td>
                                                    <textarea rows="5" cols="50" name="document_gross_weight" class="form-control">{{ $booking_detail->document_gross_weight ?? '' }}</textarea>
                                                </td>
                                                <td>
                                                    <textarea rows="5" cols="50" name="document_measurement" class="form-control">{{ $booking_detail->document_measurement ?? '' }}</textarea>
                                                </td>
                                                <td>
                                                    <textarea rows="5" cols="50" name="document_netweight" class="form-control">{{ $booking_detail->document_netweight ?? '' }}</textarea>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="form-actions">
                                        <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                        <a href="{{ route('master.booking.index') }}" class="btn red">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
                <div class="tab-pane" id="tab_4">
                    @if (\Helper::isAdmin() || \Helper::isCustomerService() || \Helper::isDocument())
                        <form action="{{ route('master.booking.documentmoemntupdate', ['id' => $id]) }}" method="post"
                            class="form-horizontal" enctype="multipart/form-data" id="frmdocumentmomentdetail"
                            onsubmit="return sendMomentForm(this)">
                            @csrf
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <h4><i class="icon-reorder"></i>Container Detail</h4>
                                    <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                        <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                        <a href="javascript:;" class="reload"></a>
                                        <a href="javascript:;" class="remove"></a>
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <table class="table table-bordered table-striped" id="numberOfContinerTable">
                                        <thead>
                                            <tr>
                                                <th width="10%">Container Number</th>
                                                <th width="10%">Custom Seal No.</th>
                                                <th width="10%">Line/Seal No.</th>
                                                <th>Gross weight</th>
                                                <th>No of Package</th>
                                                <th>Kind of Package</th>
                                                <th>VGM Weight</th>
                                                <th>Net Weight</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($booking_detail_moment_detail) &&
                                                    is_object($booking_detail_moment_detail) &&
                                                    $booking_detail_moment_detail->count())
                                                @foreach ($booking_detail_moment_detail as $moment_detail)
                                                    <tr>
                                                        <td>
                                                            <input type="hidden" name="def_id[]"
                                                                value="{{ $moment_detail->id ?? 0 }}" />
                                                            <input class="m-wrap small" type="text"
                                                                name="container_number[]" disabled
                                                                value="{{ $moment_detail->container_number ?? '' }}" />
                                                        </td>
                                                        <td><input class="m-wrap small" type="text"
                                                                name="custom_seal_no[]" disabled
                                                                value="{{ $moment_detail->custom_seal_no ?? '' }}" /></td>
                                                        <td><input class="m-wrap small" type="text" disabled
                                                                id="moment_seal_{{ $moment_detail->id ?? 0 }}"
                                                                name="a_seal_no[]"
                                                                value="{{ $moment_detail->a_seal_no ?? '' }}" />
                                                            @if (isset($moment_detail->a_seal_no) && $moment_detail->a_seal_no > 0)
                                                                <button type="button" style="display:none"
                                                                    class="btn red unlocksealbtn"
                                                                    onclick=unlockLineSeal("{{ $moment_detail->id }}")><i
                                                                        class="icon-unlock"></i></button>
                                                            @endif
                                                        </td>

                                                        <td>
                                                            <input class="m-wrap medium" type="text"
                                                                id="gross_weight_{{ $moment_detail->id ?? 0 }}"
                                                                name="document_gross_weight[]" 
                                                                value="{{ $moment_detail->document_gross_weight ?? '' }}" />
                                                        <td>
                                                            <input class="m-wrap small"
                                                                id="show_no_of_packages_{{ $moment_detail->id ?? 0 }}"
                                                                type="text"  name="show_no_of_packages[]"
                                                                value="{{ $moment_detail->document_no_of_package ?? '' }}" />
                                                        </td>
                                                        <td><input class="m-wrap small" type="text"
                                                                id="show_kind_of_packages_{{ $moment_detail->id ?? 0 }}"
                                                                name="show_kind_of_packages[]"
                                                                value="{{ $moment_detail->document_kind_of_package ?? '' }}" />
                                                        </td>
                                                        <td><input class="m-wrap medium" type="text"
                                                                id="vgm_weight{{ $moment_detail->id ?? 0 }}"
                                                                name="document_vgm_weight[]"
                                                                value="{{ $moment_detail->document_vgm_weight ?? '' }}" />
                                                        </td>
                                                        <td><input class="m-wrap medium" type="text"
                                                                id="vgm_weight{{ $moment_detail->id ?? 0 }}"
                                                                name="document_net_weight[]"
                                                                value="{{ $moment_detail->document_net_weight ?? '' }}" />
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="form-actions">
                                        <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                        <a href="{{ route('master.booking.index') }}" class="btn red">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
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
                url: $('#frmedtbookingdetailupdate').attr('action'),
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

        const sendMomentForm = (obj) => {
            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                type: "POST",
                url: $('#frmdocumentmomentdetail').attr('action'),
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
                        window.location.href =
                            "{{ route('master.booking.documentinvoice', ['id' => $id]) }}";
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

        const sendVesselForm = (obj) => {
            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                type: "POST",
                url: $('#frmdocumentvesseldetail').attr('action'),
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
                        $("a[href=#tab_3]").trigger('click');
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

        const sendCargoDetailForm = (obj) => {
            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                type: "POST",
                url: $('#frmdocumentcargodetail').attr('action'),
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
                        $("a[href=#tab_4]").trigger('click');
                        getContainerDetails();
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
        const getShipperData = (obj) => {
            var shipperIdx = obj.value;
            $.ajax({
                type: "POST",
                url: "{{ route('master.booking.getshipperinfo', ['id' => $id]) }}",
                dataType: 'json',
                data: {
                    shipperIdx,
                    "_token": "{{ csrf_token() }}"
                },
            }).done(function(result) {
                if (result.status) {
                    $("#showshipperdata").find('div:first').html(result.data);
                } else {
                    $("#showshipperdata").find('div:first').html('No Shipper found');
                }
            });
            return false;
        }

        const getConsigneeData = (obj) => {
            var consigneeIdx = obj.value;
            $.ajax({
                type: "POST",
                url: "{{ route('master.booking.consignee_data', ['id' => $id]) }}",
                dataType: 'json',
                data: {
                    consigneeIdx,
                    "_token": "{{ csrf_token() }}"
                },
            }).done(function(result) {
                if (result.status) {
                    $("#showconsigneedata").find('div:first').html(result.data);
                } else {
                    $("#showconsigneedata").find('div:first').html('No Shipper found');
                }
            });
            return false;
        }

        const getNotify1Data = (obj) => {
            var consigneeIdx = obj.value;
            $.ajax({
                type: "POST",
                url: "{{ route('master.booking.consignee_data', ['id' => $id]) }}",
                dataType: 'json',
                data: {
                    consigneeIdx,
                    "_token": "{{ csrf_token() }}"
                },
            }).done(function(result) {
                if (result.status) {
                    $("#shownotify1data").find('div:first').html(result.data);
                } else {
                    $("#shownotify1data").find('div:first').html('No Shipper found');
                }
            });
            return false;
        }

        const getDeliveryAgentData = (obj) => {
            var consigneeIdx = obj.value;
            $.ajax({
                type: "POST",
                url: "{{ route('master.deliveryagent.data', ['id' => $id]) }}",
                dataType: 'json',
                data: {
                    consigneeIdx,
                    "_token": "{{ csrf_token() }}"
                },
            }).done(function(result) {
                if (result.status) {
                    $("#showdeliveryDetails").find('div:first').html(result.data);
                } else {
                    $("#showdeliveryDetails").find('div:first').html('No Shipper found');
                }
            });
            return false;
        }

        const getNotify2Data = (obj) => {
            var consigneeIdx = obj.value;
            $.ajax({
                type: "POST",
                url: "{{ route('master.booking.consignee_data', ['id' => $id]) }}",
                dataType: 'json',
                data: {
                    consigneeIdx,
                    "_token": "{{ csrf_token() }}"
                },
            }).done(function(result) {
                if (result.status) {
                    $("#shownotify2data").find('div:first').html(result.data);
                } else {
                    $("#shownotify2data").find('div:first').html('No Shipper found');
                }
            });
            return false;
        }

        const getNotify3Data = (obj) => {
            var consigneeIdx = obj.value;
            $.ajax({
                type: "POST",
                url: "{{ route('master.booking.consignee_data', ['id' => $id]) }}",
                dataType: 'json',
                data: {
                    consigneeIdx,
                    "_token": "{{ csrf_token() }}"
                },
            }).done(function(result) {
                if (result.status) {
                    $("#shownotify3data").find('div:first').html(result.data);
                } else {
                    $("#shownotify3data").find('div:first').html('No Shipper found');
                }
            });
            return false;
        }

        const sameAsConsignee = (obj) => {
            if ($(obj).attr('checked') == 'checked') {
                const ms_consignee_id = $("#ms_consignee_id").val();
                $("select[name='notify_user1']").val(ms_consignee_id).trigger('change');
            }
        }

        const newrequiredOBL = (obj) => {
            $("input[name='express_bl']").prop('disabled', false);
            $("input[name='required_obl']").prop('disabled', false);
            if ($(obj).attr('checked') == 'checked') {
                $(obj).parent().parent().parent().find('input[type="text"]').show();
                $("input[name='express_bl']").prop('checked', false).trigger('click').prop('disabled', true);
            } else {
                $(obj).parent().parent().parent().find('input[type="text"]').hide();
                $("input[name='express_bl']").prop('disabled', false);
            }
        }
        const newExpressBL = (obj) => {
            $("input[name='express_bl']").prop('disabled', false);
            $("input[name='required_obl']").prop('disabled', false);
            if ($(obj).attr('checked') == 'checked') {
                $(obj).parent().parent().parent().find('input[type="text"]').show();
                $("input[name='required_obl']").prop('checked', false).trigger('click').prop('disabled', true);
            } else {
                $(obj).parent().parent().parent().find('input[type="text"]').hide();
            }
        }

        const getContainerDetails = () => {
            $("input[id^='document_no_of_package_']").each(function() {
                var thisidx = $(this).attr('id');
                var tmpobj = thisidx.split('_');
                var mainidx = tmpobj[4] || 0;
                $(`#show_no_of_packages_${mainidx}`).val($(this).val());
            });

            $("input[id^='document_kind_of_package_']").each(function() {
                var thisidx = $(this).attr('id');
                var tmpobj = thisidx.split('_');
                var mainidx = tmpobj[4] || 0;
                $(`#show_kind_of_packages_${mainidx}`).val($(this).val());
            });



        }
    </script>
@endsection
