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
                <li class="active"><a href="#tab_1" data-toggle="tab">Booking Detail</a></li>
                @if (\Helper::isAdmin() || \Helper::isCustomerService())
                    <li><a class="advance_form_with_chosen_element" href="#tab_2" data-toggle="tab">Moment Detail</a>
                    </li>
                @else
                    <li><a class="advance_form_with_chosen_element" href="#" data-toggle="tab">Moment Detail</a>
                    </li>
                @endif
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <form action="{{ route('master.booking.update', ['id' => $id]) }}" method="post"
                        class="form-horizontal" enctype="multipart/form-data" id="frmedtbookingdetail"
                        onsubmit="return sendForm(this)">
                        @csrf
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
                                            <div class="row-fluid">
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label class="control-label">*Job Number</label>
                                                        <div class="controls">
                                                            {{ $booking_detail->job_number ?? '' }}
                                                        </div>
                                                    </div>



                                                    <div class="control-group">
                                                        <label class="control-label">*Shipper Name</label>
                                                        <div class="controls">
                                                            <input type="text" name="shipper_name"
                                                                value="{{ $booking_detail->shipper_name ?? '' }}"
                                                                placeholder="Please provide Shipper Name"
                                                                class="m-wrap medium" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">*Booking received from</label>
                                                        <div class="controls">
                                                            <input type="text" name="booking_received_from"
                                                                value="{{ $booking_detail->booking_received_from ?? '' }}"
                                                                placeholder="Booking received from" class="m-wrap medium" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">*Select Incoterm</label>
                                                        <div class="controls">
                                                            @if (isset($incoterm) && is_object($incoterm) && $incoterm->count())
                                                                <select name="ms_incoterm_id" id="ms_incoterm_id" class="form-control chosen_category">
                                                                    <option value="0">Select Incoterm</option>
                                                                    @foreach ($incoterm as $option)
                                                                        @if (isset($booking_detail->ms_incoterm_id) && $booking_detail->ms_incoterm_id == $option->id)
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
                                                    <div class="control-group">
                                                        <label class="control-label">*Selling Rate</label>
                                                        <div class="controls">
                                                            <input type="text" name="selling_rate"
                                                                value="{{ $booking_detail->selling_rate ?? 0 }}"
                                                                placeholder="Please provide Selling Rate"
                                                                class="m-wrap medium" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">*Select Currency</label>
                                                        <div class="controls">
                                                            @if (isset($curencies) && is_object($curencies) && $curencies->count())
                                                                <select name="ms_currencies_id" id="ms_currencies_id" class="form-control chosen_category">
                                                                    <option value="0">Select Currency</option>
                                                                    @foreach ($curencies as $option)
                                                                        @if (isset($booking_detail->ms_currencies_id) && $booking_detail->ms_currencies_id == $option->id)
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
                                                    <div class="control-group">
                                                        <label class="control-label">*Other Charges</label>
                                                        <div class="controls">
                                                            <textarea type="text" name="other_charges" placeholder="Please provide other charges" class="m-wrap medium">{{ $booking_detail->other_charges ?? '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="span4 ">
                                                    <div class="control-group">
                                                        <label class="control-label">By Shipping line rate</label>
                                                        <div class="controls">
                                                            <input type="text" name="shipping_line_rate"
                                                                value="{{ $booking_detail->shipping_line_rate ?? 0 }}"
                                                                placeholder="Please provide Shipping line rate"
                                                                class="m-wrap medium" />
                                                        </div>
                                                    </div>

                                                    <div class="control-group">
                                                        <label class="control-label">Select Equipment Type</label>
                                                        <div class="controls">
                                                            @if (isset($equipment_types) && is_object($equipment_types) && $equipment_types->count())
                                                                <select name="ms_equipment_type_id"
                                                                    id="ms_equipment_type_id" class="form-control chosen_category">
                                                                    <option value="0">Select Equipment Type</option>
                                                                    @foreach ($equipment_types as $option)
                                                                        @if (isset($booking_detail->ms_equipment_type_id) && $booking_detail->ms_equipment_type_id == $option->id)
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
                                                    <div class="control-group">
                                                        <label class="control-label">No Of Container</label>
                                                        <div class="controls">
                                                            @if (\Helper::isAdmin())
                                                                <input type="text" name="no_of_container"
                                                                    value="{{ $booking_detail->no_of_container ?? 0 }}"
                                                                    placeholder="Please provide No of container"
                                                                    class="m-wrap medium" />
                                                            @else
                                                                <input type="text" name="no_of_container" readonly
                                                                    value="{{ $booking_detail->no_of_container ?? 0 }}"
                                                                    placeholder="Please provide No of container"
                                                                    class="m-wrap medium" />
                                                            @endif
                                                        </div>
                                                    </div>


                                                    <div class="control-group">
                                                        <label class="control-label">Select port of loading</label>
                                                        <div class="controls">
                                                            @if (isset($port_of_loading) && is_object($port_of_loading) && $port_of_loading->count())
                                                                <select name="ms_port_of_loading_id"
                                                                    id="ms_port_of_loading_id" class="form-control chosen_category">
                                                                    <option value="0">Select Port of Loading</option>
                                                                    @foreach ($port_of_loading as $option)
                                                                        @if (isset($booking_detail->ms_port_of_loading_id) && $booking_detail->ms_port_of_loading_id == $option->id)
                                                                            <option selected
                                                                                value="{{ $option->id ?? 0 }}">
                                                                                {{ $option->title ?? '' }}, {{$option->country_name ?? '' }}</option>
                                                                        @else
                                                                            <option value="{{ $option->id ?? 0 }}">
                                                                                {{ $option->title ?? '' }}, {{$option->country_name ?? '' }}</option>
                                                                        @endif
                                                                    @endforeach
                                                                </select>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">*Pickup Location</label>
                                                        <div class="controls">
                                                            <input type="text" name="pickup_location"
                                                                value="{{ $booking_detail->pickup_location }}"
                                                                placeholder="Please provide Pickup Location"
                                                                class="m-wrap medium" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">*Port of Destination</label>
                                                        <div class="controls">
                                                            @if (isset($port_of_destination) && is_object($port_of_destination) && $port_of_loading->count())
                                                                <select name="ms_port_of_destination"
                                                                    id="ms_port_of_destination" class="form-control chosen_category">
                                                                    <option value="0">Select Port of Destination
                                                                    </option>
                                                                    @foreach ($port_of_destination as $option)
                                                                        @if (isset($booking_detail->ms_port_of_destination) && $booking_detail->ms_port_of_destination == $option->id)
                                                                            <option selected
                                                                                value="{{ $option->id ?? 0 }}">
                                                                                {{ $option->title ?? '' }}, {{$option->country_name ?? '' }}</option>
                                                                        @else
                                                                            <option value="{{ $option->id ?? 0 }}">
                                                                                {{ $option->title ?? '' }}, {{$option->country_name ?? '' }}</option>
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

                                                </div>

                                                @if (\Helper::isAdmin() || \Helper::isCustomerService())
                                                    <div class="span4 ">
                                                        <div class="control-group">
                                                            <label class="control-label">Select Shipper</label>
                                                            <div class="controls">
                                                                @if (isset($exporter) && is_object($exporter) && $exporter->count())
                                                                    <select name="ms_exporter_id" id="ms_exporter_id" class="form-control chosen_category">
                                                                        <option value="">Select Shipper</option>
                                                                        @foreach ($exporter as $exp)
                                                                            @if ($booking_detail->ms_exporter_id == $exp->id)
                                                                                <option selected
                                                                                    value="{{ $exp->id }}">
                                                                                    {{ $exp->name ?? '' }}</option>
                                                                            @else
                                                                                <option value="{{ $exp->id }}">
                                                                                    {{ $exp->name ?? '' }}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">Ramp Cut-Off Date/Time:</label>
                                                            <div class="controls">
                                                                <input type="text"
                                                                onkeyup="formatInputDateTime(this)" name="ramp_cut_off_datetime"
                                                                    value="{{ \Helper::converdb2datetime($booking_detail->ramp_cut_off_datetime ?? 0) }}"
                                                                    placeholder="Please provide Ram Cut-Off Date/Time"
                                                                    class="m-wrap medium" />
                                                            </div>
                                                        </div>

                                                        <div class="control-group">
                                                            <label class="control-label">Earliest Receiving
                                                                Date/Time:</label>
                                                            <div class="controls">
                                                                <input type="text" onkeyup="formatInputDateTime(this)" 
                                                                    name="earlist_receiving_datetime"
                                                                    value="{{ \Helper::converdb2datetime($booking_detail->earlist_receiving_datetime ?? 0) }}"
                                                                    placeholder="" class="m-wrap medium" />
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">VGM Cut-Off Date/Time: </label>
                                                            <div class="controls">
                                                                <input type="text" onkeyup="formatInputDateTime(this)"  name="vgm_cut_off_datetime"
                                                                    value="{{ \Helper::converdb2datetime($booking_detail->vgm_cut_off_datetime ?? 0) }}"
                                                                    placeholder="" class="m-wrap medium" />
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">Vessel/Voy:</label>
                                                            <div class="controls">
                                                                <input type="text" name="vessel_voy"
                                                                    value="{{ $booking_detail->vessel_voy ?? '' }}"
                                                                    placeholder="" class="m-wrap medium" />
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">Terminal Cut-Off
                                                                Date/Time:</label>
                                                            <div class="controls">
                                                                <input type="text" onkeyup="formatInputDateTime(this)"  name="terminal_datetime"
                                                                    value="{{ \Helper::converdb2datetime($booking_detail->terminal_datetime ?? 0) }}"
                                                                    placeholder="" class="m-wrap medium" />
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">ETA Date/Time:</label>
                                                            <div class="controls">
                                                                <input type="text" onkeyup="formatInputDateTime(this)"  name="eta_datetime"
                                                                    value="{{ \Helper::converdb2datetime($booking_detail->eta_datetime ?? 0)}}"
                                                                    placeholder="" class="m-wrap medium" />
                                                            </div>
                                                        </div>
                                                        <div class="control-group">
                                                            <label class="control-label">*ETD Date/Time:</label>
                                                            <div class="controls">
                                                                <input type="text" onkeyup="formatInputDateTime(this)"  name="etd_datetime"
                                                                    value="{{ \Helper::converdb2datetime($booking_detail->etd_datetime ?? 0)}}"
                                                                    placeholder="" class="m-wrap medium" />
                                                            </div>
                                                        </div>


                                                    </div>

                                                @endif
                                            </div>
                                            <!-- END FORM-->
                                        </div>

                                    </div>
                                </div>
                                @if (\Helper::isAdmin() || \Helper::isCustomerService())
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="portlet box blue">
                                                <div class="portlet-title">
                                                    <h4><i class="icon-reorder"></i>More Information</h4>
                                                </div>
                                                <div class="portlet-body">
                                                    <div class="row-fluid">
                                                        <div class="span4 ">
                                                            <div class="control-group">
                                                                <label class="control-label">*Booking Number</label>
                                                                <div class="controls">
                                                                    <input type="text" name="booking_number"
                                                                        value="{{ $booking_detail->booking_number ?? 0 }}"
                                                                        placeholder="Please provide Ram Cut-Off Date/Time"
                                                                        class="m-wrap medium" />
                                                                </div>
                                                            </div>


                                                            <div class="control-group">
                                                                <label class="control-label">SI Cut-Off Date/Time:</label>
                                                                <div class="controls">
                                                                    <input type="text" onkeyup="formatInputDateTime(this)" 
                                                                        name="si_cut_off_date_time"
                                                                        value="{{ \Helper::converdb2datetime($booking_detail->si_cut_off_date_time ?? 0) }}"
                                                                        placeholder="Please provide Ram Cut-Off Date/Time"
                                                                        class="m-wrap medium" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="span4">
                                                            <div class="control-group">
                                                                <label class="control-label">Document Cut-Off (S/Bill)
                                                                    Date/Time:</label>
                                                                <div class="controls">
                                                                    <input type="text" onkeyup="formatInputDateTime(this)" 
                                                                        name="document_cut_off_date_time"
                                                                        value="{{ \Helper::converdb2datetime($booking_detail->document_cut_off_date_time ?? 0) }}"
                                                                        placeholder="Please provide Ram Cut-Off Date/Time"
                                                                        class="m-wrap medium" />
                                                                </div>
                                                            </div>

                                                            <div class="control-group">
                                                                <label class="control-label">Booking Validity Date/Time:
                                                                </label>
                                                                <div class="controls">
                                                                    <input type="text" onkeyup="formatInputDateTime(this)" 
                                                                        name="eqp_available_datetime"
                                                                        value="{{ \Helper::converdb2datetime($booking_detail->eqp_available_datetime ?? 0) }}"
                                                                        placeholder="" class="m-wrap medium" />
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="span4">
                                                            <div class="control-group">
                                                                <label class="control-label">Stuffing: </label>
                                                                <div class="controls">
                                                                    <select name="stuffing" id="stuffing" class="form-control chosen_category">
                                                                        <option value="">Select Stuffing</option>
                                                                        @foreach (\Helper::get_stuffing() as $keystffing => $stuffing)
                                                                            @if ($booking_detail->stuffing == $keystffing)
                                                                                <option value="{{ $keystffing }}"
                                                                                    selected>
                                                                                    {{ $stuffing }}
                                                                                </option>
                                                                            @else
                                                                                <option value="{{ $keystffing }}">
                                                                                    {{ $stuffing }}
                                                                                </option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Booking File:</label>
                                                                <div class="controls">
                                                                    <input type="file" name="booking_file"
                                                                        value="{{ $booking_detail->booking_file_url ?? 0 }}"
                                                                        placeholder="Please provide fILE"
                                                                        class="m-wrap medium" />
                                                                    @if (isset($booking_detail->booking_file_url) && $booking_detail->booking_file_url != '')
                                                                        <a href="{{ $booking_detail->booking_file_url }}"
                                                                            target="_blank" class="btn mini purple"><i
                                                                                class="icon-open-eye"></i> Open File</a>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="control-group">
                                                                <label class="control-label">Remark</label>
                                                                <div class="controls">
                                                                    <textarea type="text" name="booking_detail_remark" placeholder="Please provide remark for booking detail"
                                                                        class="m-wrap medium" rows="4">{{ $booking_detail->booking_detail_remark ?? '' }}</textarea>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>




                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (isset($booking_transhipment_details) &&
                                        is_object($booking_transhipment_details) &&
                                        $booking_transhipment_details->count())
                                    <div class="row-fluid">
                                        <div class="span12">
                                            <div class="portlet box blue">
                                                <div class="portlet-title">
                                                    <h4><i class="icon-reorder"></i>Transhipment Details</h4>
                                                </div>
                                                <div class="portlet-body">
                                                    <div id="showerrortranshipmentlist"></div>
                                                    <table class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th width="5%">#</th>
                                                                <th width="15%">Port</th>
                                                                <th width="10%">ETA</th>
                                                                <th width="10%">ETD</th>
                                                                <th>Remark</th>
                                                                <th width="10%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($booking_transhipment_details as $btd)
                                                                <tr>
                                                                    <td>{{ $btd->id ?? 0 }}</td>
                                                                    <td>{{ $btd->transhipment_title ?? '' }}</td>
                                                                    <td>{{ \Helper::VessenHistoryShowDateTime($btd->transhipment_eta ?? '') }}
                                                                    </td>
                                                                    <td>{{ \Helper::VessenHistoryShowDateTime($btd->transhipment_etd ?? '') }}
                                                                    </td>
                                                                    <td>{{ $btd->transhipment_remark ?? '' }}</td>
                                                                    <td><a href="javascript:void(0)"
                                                                            onclick=showEditTranshipmentpopup(this,"{{ $btd->id ?? 0 }}")
                                                                            class="btn mini blue"><i
                                                                                class="icon-edit"></i> Edit</a>
                                                                        @if (\Helper::isAdmin())
                                                                            <a href="javascript:void(0)"
                                                                                class="btn mini red"
                                                                                onclick=deleteTranshipmentDetail("{{ $btd->id ?? 0 }}")><i
                                                                                    class="icon-trash"></i> Delete</a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-actions">

                                    <button type="submit" class="btn blue"><i class="icon-ok"></i>
                                        @if (\Helper::isAdmin() || \Helper::isCustomerService())
                                            Save & Next (Moment Detail)
                                        @else
                                            Save
                                        @endif
                                    </button>
                                    &nbsp;
                                    <a href="{{ route('master.booking.index') }}" class="btn red">Cancel</a>

                                    @if (\Helper::isAdmin() || \Helper::isCustomerService())
                                        &nbsp;
                                        <button type="button" onclick="showNewVesselConfimration(this)"
                                            class="btn blue"><i class="icon-plus"></i>
                                            Add New Vessel
                                        </button>
                                        @if (isset($booking_vessel_history_detail) &&
                                                is_object($booking_vessel_history_detail) &&
                                                $booking_vessel_history_detail->count() > 0)
                                            &nbsp;
                                            <button type="button" onclick="showVesselhistoryButton(this)"
                                                class="btn blue"><i class="icon-book"></i>
                                                Vessel History
                                            </button>
                                        @endif
                                        &nbsp;
                                        <button type="button" onclick="showAddNewTranshipmentPort(this)"
                                            class="btn blue"><i class="icon-plus"></i>
                                            Transhipment Port
                                        </button>
                                    @endif

                                </div>
                                <!-- END SAMPLE FORM PORTLET-->
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane" id="tab_2">
                    @if (\Helper::isAdmin() || \Helper::isCustomerService())
                        <form action="{{ route('master.momentdetails.update', ['id' => $id]) }}" method="post"
                            class="form-horizontal" enctype="multipart/form-data" id="frmmomentdetail"
                            onsubmit="return sendMomentForm(this)">
                            @csrf
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <h4><i class="icon-reorder"></i>Moment Detail</h4>
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
                                                <th>Container Number</th>
                                                <th>Custom Seal No.</th>
                                                <th>Line/Seal No.</th>
                                                <th>Vehicle No.</th>
                                                <th class="factory_selected">Factory In.</th>
                                                <th class="factory_selected">Factory Out.</th>
                                                <th class="cfs_selected">CFS Date.</th>
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
                                                            <input type="text" name="container_number[]"
                                                                value="{{ $moment_detail->container_number ?? '' }}" />
                                                        </td>
                                                        <td><input type="text" name="custom_seal_no[]"
                                                                value="{{ $moment_detail->custom_seal_no ?? '' }}" /></td>
                                                        <td><input type="text"
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
                                                        <td><input type="text" name="vehicle_no[]"
                                                                value="{{ $moment_detail->vehicle_no ?? '' }}" /></td>
                                                        <td class="factory_selected"><input type="text" onkeyup="formatInputDateTime(this)" 
                                                                name="factory_in[]"
                                                                value="{{ $moment_detail->factory_in ?? '' }}" /></td>
                                                        <td class="factory_selected"><input type="text" onkeyup="formatInputDateTime(this)" 
                                                                name="factory_out[]"
                                                                value="{{ $moment_detail->factory_out ?? '' }}" /></td>
                                                        <td class="cfs_selected"><input type="text" onkeyup="formatInputDateTime(this)" 
                                                                name="cfs_date[]"
                                                                value="{{ $moment_detail->cfs_date ?? '' }}" /></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                    <div class="form-actions">
                                        <button type="submit" class="btn blue"><i class="icon-ok"></i> Save</button>
                                        <a href="{{ route('master.booking.index') }}" class="btn red">Cancel</a>
                                        &nbsp;
                                        <button type="button" class="btn blue" onclick="BreakLineSeal(this)"><i
                                                class="icon-unlock"></i> Line/Seal</button>
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
            $("#tabIdx").find('a[href="#tab_2"]').click(function() {
                numberOfContainerFunction();
            });
        });
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

                    if (result.data == 'moment_detail') {

                        $("#tabIdx").find('ul li').each(function() {
                            if ($(this).find('a').attr('href') == '#tab_2') {
                                $(this).find('a').trigger('click');
                                return true;
                            }
                        });
                        numberOfContainerFunction();
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

        const unlockLineSeal = (idx) => {
            $.ajax({
                type: "POST",
                url: "{{ route('master.booking.unlockseal') }}",
                dataType: 'json',
                data: {
                    "_token": "{{ csrf_token() }}",
                    sealID: idx
                },
            }).done(function(result) {
                if (result.status) {
                    var errors = result.msg;
                    var idxNew = `moment_seal_${idx}`;
                    $("#" + idxNew).val('');
                    $("#" + idxNew).parent().find('button').hide();
                    var nerrorsHtml = '<div class="alert alert-success">' + errors + '</div>';
                    $('#form-errors').html(nerrorsHtml).show();
                    setTimeout(function() {
                        $('#form-errors').html('').hide();
                    }, 3000);
                } else {
                    var errors = result.msg;
                    var errorsHtml = '<div class="alert alert-success">' + errors + '</div>';
                    $('#form-errors').html(errorsHtml).show();
                    setTimeout(function() {
                        $('#form-errors').html('').hide();
                    }, 3000);
                }
            });
            return false;
        }

        const sendMomentForm = (obj) => {
            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                type: "POST",
                url: $('#frmmomentdetail').attr('action'),
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
                        window.location.href = "{{ route('master.booking.index') }}";
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


        const numberOfContainerFunction = () => {
            var numberOfContainer = 0;
            var previousNumberOfContainer = "{{ $booking_detail->no_of_container ?? 0 }}";
            var stuffingNumber = $("#stuffing").val();

            if (stuffingNumber == 0) {
                alert('Please selected Stuffing first');
            }
            numberOfContainer = $("input[name='no_of_container']").val();
            if (previousNumberOfContainer !== numberOfContainer && numberOfContainer > 0) {
                var tmpHTML = '';
                for (var x = 0; x < numberOfContainer; x++) {
                    tmpHTML += `
                                    <tr>
                                        <td><input type="text" name="container_number[]" /></td>
                                        <td><input type="text" name="custom_seal_no[]" /></td>
                                        <td><input type="text" name="a_seal_no[]" /></td>
                                        <td><input type="text" name="vehicle_no[]" /></td>
                                    
                                `;

                    if (stuffingNumber == 1) {
                        tmpHTML += `<td><input type="text" onkeyup="formatInputDateTime(this)"  name="factory_in[]" /></td>`;
                        tmpHTML += `<td><input type="text" onkeyup="formatInputDateTime(this)"  name="factory_out[]" /></td>`;
                    }
                    if (stuffingNumber == 2) {
                        tmpHTML += `<td><input type="text" onkeyup="formatInputDateTime(this)"  name="cfs_date[]" /></td>`;
                    }
                    tmpHTML += `</tr>`;

                }
                $("#numberOfContinerTable").find('tbody').html(tmpHTML);
            }

            switch (stuffingNumber) {
                case "1":
                    $("#numberOfContinerTable").find(".cfs_selected").hide();
                    $("#numberOfContinerTable").find(".factory_selected").show();
                    break;
                case "2":
                    $("#numberOfContinerTable").find(".cfs_selected").show();
                    $("#numberOfContinerTable").find(".factory_selected").hide();
                    break;
                default:
                    $("#numberOfContinerTable").find(".cfs_selected").hide();
                    $("#numberOfContinerTable").find(".factory_selected").hide();
            }
        }

        const showNewVesselConfimration = (obj) => {
            $("#addnewVesselmodal").modal('show');
        }

        const showAddNewTranshipmentPort = (obj) => {
            $("#addnewTranshipmentPort").modal('show');
        }

        const showVesselhistoryButton = (obj) => {
            $("#vesselHistoryModal").modal('show');
        }


        const addVesselHistory = (obj) => {

            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                type: "POST",
                url: "{{ route('master.booking.addvesselhistory', ['id' => $id]) }}",
                data: {
                    "_token": "{{ csrf_token() }}"
                },
            }).done(function(result) {
                if (result.status) {
                    var errors = result.msg;
                    var nerrorsHtml = '<div class="alert alert-success">' + errors + '</div>';
                    $('#form-errors').html(nerrorsHtml).show();
                    setTimeout(function() {
                        window.location.reload();
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
                $("#addnewVesselmodal").modal('close');
            });
            return false;
        }

        const BreakLineSeal = (obj) => {
            $("#breaksealconfirmation").modal('show');
        }

        const allowBreakSeal = (obj) => {
            $(".unlocksealbtn").show();
        }

        const saveTranshipmentDetail = (obj) => {
            var transhipment_port = $("#addnewTranshipmentPort").find('select[name="transhipment_port"]').val();
            var transhipment_eta = $("#addnewTranshipmentPort").find('input[name="transhipment_eta"]').val();
            var transhipment_etd = $("#addnewTranshipmentPort").find('input[name="transhipment_etd"]').val();
            var transhipment_remark = $("#addnewTranshipmentPort").find('textarea[name="transhipment_remark"]').val();

            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                type: "POST",
                url: "{{ route('master.booking.transhipment_save', ['id' => $id]) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    transhipment_port,
                    transhipment_eta,
                    transhipment_etd,
                    transhipment_remark
                },
            }).done(function(result) {
                if (result.status) {
                    var errors = result.msg;
                    var nerrorsHtml = '<div class="alert alert-success">' + errors + '</div>';
                    $('#showerrorstranshpment').html(nerrorsHtml).show();
                    setTimeout(function() {
                        window.location.reload();
                    }, 2000);
                } else {
                    var errors = result.msg;
                    var errorsHtml = '<div class="alert alert-danger"><ul>';

                    $.each(errors, function(key, value) {
                        errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                    });
                    errorsHtml += '</ul></div>';

                    $('#showerrorstranshpment').html(errorsHtml).show();
                    setTimeout(function() {
                        $('#showerrorstranshpment').html('').hide();
                    }, 3000);
                }

            });
            return false;
        }

        const showEditTranshipmentpopup = (obj, idx) => {
            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                type: "POST",
                url: "{{ route('master.booking.get_transportment_details', ['id' => $id]) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    idx
                },
            }).done(function(result) {

                if (result.status) {
                    var resultData = result.data;
                    $("#updateTranshipmentPort").modal('show');
                    setTimeout(function() {
                        $("#updateTranshipmentPort").find('input[name="transhipment_id"]').val(
                            resultData.id);
                        $("#updateTranshipmentPort").find('#transhipment_port').val(resultData
                            .transhipment_port);
                        $("#updateTranshipmentPort").find('input[name="transhipment_eta"]').val(
                            resultData.transhipment_eta);
                        $("#updateTranshipmentPort").find('input[name="transhipment_etd"]').val(
                            resultData.transhipment_etd);
                        $("#updateTranshipmentPort").find('textarea[name="transhipment_remark"]').val(
                            resultData.transhipment_remark);
                    }, 1000);

                } else {
                    var errors = result.msg;
                    var errorsHtml = '<div class="alert alert-danger">' + errors + '</div>';
                    $('#showerrortranshipmentlist').html(errorsHtml).show();
                    setTimeout(function() {
                        $('#showerrortranshipmentlist').html('').hide();
                    }, 3000);
                }

            });
            return false;
        }


        const deleteTranshipmentDetail = (idx) => {
            $("#removetranshipmentDetials").modal('show');

            setTimeout(function() {
                $("#removetranshipmentDetials").find('input[name="transhipment_detail_id"]').val(idx);
            }, 500);
        }

        const updateTranshipmentDetail = (obj) => {
            var transhipment_id = $("#updateTranshipmentPort").find('input[name="transhipment_id"]').val();
            var transhipment_port = $("#updateTranshipmentPort").find('#transhipment_port').val();
            var transhipment_eta = $("#updateTranshipmentPort").find('input[name="transhipment_eta"]').val();
            var transhipment_etd = $("#updateTranshipmentPort").find('input[name="transhipment_etd"]').val();
            var transhipment_remark = $("#updateTranshipmentPort").find('textarea[name="transhipment_remark"]').val();

            $.ajax({
                // Uncomment the following to send cross-domain cookies:
                //xhrFields: {withCredentials: true},
                type: "POST",
                url: "{{ route('master.booking.update_transportment', ['id' => $id]) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    transhipment_id,
                    transhipment_port,
                    transhipment_eta,
                    transhipment_etd,
                    transhipment_remark
                },
            }).done(function(result) {

                if (result.status) {
                    var errors = result.msg;
                    var errorsHtml = '<div class="alert alert-success">' + errors + '</div>';
                    $('#showupdateerrorstranshpment').html(errorsHtml).show();
                    setTimeout(function() {
                        window.location.reload(true);
                    }, 3000);

                } else {
                    var errors = result.msg;
                    var errorsHtml = '<div class="alert alert-danger">' + errors + '</div>';
                    $('#showupdateerrorstranshpment').html(errorsHtml).show();
                    setTimeout(function() {
                        $('#showupdateerrorstranshpment').html('').hide();
                    }, 3000);
                }

            });
            return false;
        }

        const removeTrannshipmentDetailFinal = (obj) => {
            var transhipment_detail_id = $("#removetranshipmentDetials").find('input[name="transhipment_detail_id"]')
                .val();
            $.ajax({
                type: "POST",
                url: "{{ route('master.booking.delete_transhpment', ['id' => $id]) }}",
                data: {
                    "_token": "{{ csrf_token() }}",
                    transhipment_detail_id,
                },
            }).done(function(result) {

                if (result.status) {
                    var errors = result.msg;
                    var errorsHtml = '<div class="alert alert-success">' + errors + '</div>';
                    $('#deleteshowupdateerrorstranshpment').html(errorsHtml).show();
                    setTimeout(function() {
                        window.location.reload(true);
                    }, 3000);

                } else {
                    var errors = result.msg;
                    var errorsHtml = '<div class="alert alert-danger">' + errors + '</div>';
                    $('#deleteshowupdateerrorstranshpment').html(errorsHtml).show();
                    setTimeout(function() {
                        $('#deleteshowupdateerrorstranshpment').html('').hide();
                    }, 3000);
                }

            });
            return false;
        }
    </script>

    <div id="addnewVesselmodal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3"
        aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3 id="myModalLabel3">New Vessel Confirmation</h3>
        </div>
        <div class="modal-body">
            <p>Once you confirm this, All Dates information will be removed and will be empty so are you sure want to
                proceed ?</p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button data-dismiss="modal" class="btn blue" onclick="addVesselHistory(this)">Confirm</button>
        </div>
    </div>

    <div id="removetranshipmentDetials" class="modal hide fade" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-header">
            <input type="hidden" name="transhipment_detail_id" value="" />
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3 id="myModalLabel3">Remove Transhipment Detail</h3>
        </div>
        <div class="modal-body">
            <div id="deleteshowupdateerrorstranshpment"></div>
            <p>Once you confirm this, It will remove this transhipment information, Do you want to continue?</p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button class="btn red" onclick="removeTrannshipmentDetailFinal(this)">Confirm</button>
        </div>
    </div>

    <div id="addnewTranshipmentPort" class="modal hide fade" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3 id="myModalLabel3">Add New</h3>
        </div>
        <div class="modal-body">
            <div id="showerrorstranshpment"></div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <h4><i class="icon-reorder"></i>Transhipment Port Information</h4>
                        </div>
                        <div class="portlet-body">

                            <div class="row-fluid">
                                <div class="span12 ">
                                    <div class="control-group">
                                        <label class="control-label">Select Port: </label>
                                        <div class="controls">
                                            @if (isset($port_of_destination) && is_object($port_of_destination) && $port_of_destination->count())
                                                <select name="transhipment_port" id="transhipment_port"
                                                    class="m-wrap span11 chosen_category">
                                                    <option value="">Select Port</option>
                                                    @foreach ($port_of_destination as $option)
                                                        <option value="{{ $option->id ?? 0 }}">
                                                            {{ $option->title ?? '' }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">ETA:</label>
                                        <div class="controls">
                                            <input type="text" onkeyup="formatInputDateTime(this)"  name="transhipment_eta" value="0"
                                                placeholder="Please provide Transhipment ETA" class="m-wrap medium">
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">ETD:</label>
                                        <div class="controls">
                                            <input type="text" onkeyup="formatInputDateTime(this)"  name="transhipment_etd" value="0"
                                                placeholder="Please provide Transhipment ETD" class="m-wrap medium">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12 ">
                                    <div class="control-group">
                                        <label class="control-label">Remark:</label>
                                        <div class="controls">
                                            <textarea class="span11 m-wrap" name="transhipment_remark" roww="50"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button class="btn blue" onclick="saveTranshipmentDetail(this)">Save</button>
        </div>
    </div>
    <div id="updateTranshipmentPort" class="modal hide fade" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3 id="myModalLabel3">Edit Detail</h3>
        </div>
        <div class="modal-body">
            <div id="showupdateerrorstranshpment"></div>
            <div class="row-fluid">
                <div class="span12">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <h4><i class="icon-reorder"></i>Transhipment Port Information</h4>
                        </div>
                        <div class="portlet-body">

                            <div class="row-fluid">
                                <div class="span12 ">
                                    <div class="control-group">
                                        <input type="hidden" name="transhipment_id" value="0" />
                                        <label class="control-label">Select Port: </label>
                                        <div class="controls">
                                            @if (isset($port_of_destination) && is_object($port_of_destination) && $port_of_destination->count())
                                                <select name="transhipment_port" id="transhipment_port"
                                                    class="m-wrap span11 chosen_category" >
                                                    <option value="">Select Port</option>
                                                    @foreach ($port_of_destination as $option)
                                                        <option value="{{ $option->id ?? 0 }}">
                                                            {{ $option->title ?? '' }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">ETA:</label>
                                        <div class="controls">
                                            <input type="text" onkeyup="formatInputDateTime(this)"  name="transhipment_eta" value="0"
                                                placeholder="Please provide Transhipment ETA" class="m-wrap medium">
                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">ETD:</label>
                                        <div class="controls">
                                            <input type="text" onkeyup="formatInputDateTime(this)"  name="transhipment_etd" value="0"
                                                placeholder="Please provide Transhipment ETD" class="m-wrap medium">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row-fluid">
                                <div class="span12 ">
                                    <div class="control-group">
                                        <label class="control-label">Remark:</label>
                                        <div class="controls">
                                            <textarea class="span11 m-wrap" name="transhipment_remark" roww="50"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button class="btn blue" onclick="updateTranshipmentDetail(this)">Update</button>
        </div>
    </div>


    <div id="breaksealconfirmation" class="modal hide fade" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3 id="myModalLabel3">Break Seal No Confirmation</h3>
        </div>
        <div class="modal-body">
            <p>Once you confirm this, It will enable option to break seal no and it will be removed current one and new
                number will applied, so are you sure want to proceed it?</p>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">No</button>
            <button data-dismiss="modal" class="btn blue" onclick="allowBreakSeal(this)">Confirm</button>
        </div>
    </div>
    <div id="vesselHistoryModal" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true"
        style="width:100%;left:15%">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
            <h3 id="myModalLabel3">Vessel History</h3>
        </div>
        <div class="modal-body">
            <div class="portlet box blue">
                <div class="portlet-title">
                    <h4><i class="icon-book"></i>Vessel History</h4>
                    {{-- <div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="#portlet-config" data-toggle="modal" class="config"></a>
									<a href="javascript:;" class="reload"></a>
									<a href="javascript:;" class="remove"></a>
								</div> --}}
                </div>
                <div class="portlet-body">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Booking Number</th>
                                <th>Shipper Name</th>
                                <th>Ramp Cut-Off Date/Time</th>
                                <th>Earliest Receiving Date/Time</th>
                                <th>VGM Cut-Off Date/Time</th>
                                <th>Terminal Cut-Off Date/Time</th>
                                <th>ETA Date/Time</th>
                                <th>ETD Date/Time</th>
                                <th>Document Cut-Off S/Bill Date/Time</th>
                                <th>Stuffing</th>
                                <th>SI Cut-Off Date/Time</th>
                                <th>Booking Validity</th>
                                <th>Booking File</th>
                                <th>Vessel/Voy</th>
                                <th>Remark</th>
                                <th>Created Datetime</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (isset($booking_vessel_history_detail) &&
                                    is_object($booking_vessel_history_detail) &&
                                    $booking_vessel_history_detail->count())
                                @foreach ($booking_vessel_history_detail as $detail)
                                    <tr>
                                        <td>{{ $detail->booking_number ?? '' }}</td>
                                        <td>{{ $detail->exporter_name ?? 0 }}</td>
                                        <td>{{ \Helper::VessenHistoryShowDateTime($detail->ramp_cut_off_datetime ?? '') }}
                                        </td>
                                        <td>{{ \Helper::VessenHistoryShowDateTime($detail->earlist_receiving_datetime ?? '') }}
                                        </td>
                                        <td>{{ \Helper::VessenHistoryShowDateTime($detail->vgm_cut_off_datetime ?? '') }}
                                        </td>
                                        <td>{{ \Helper::VessenHistoryShowDateTime($detail->terminal_datetime ?? '') }}
                                        </td>
                                        <td>{{ \Helper::VessenHistoryShowDateTime($detail->eta_datetime ?? '') }}</td>
                                        <td>{{ \Helper::VessenHistoryShowDateTime($detail->etd_datetime ?? '') }}</td>
                                        <td>{{ \Helper::VessenHistoryShowDateTime($detail->document_cut_off_date_time ?? '') }}
                                        </td>
                                        <td>
                                            @php
                                                $stuffing_obj = \Helper::get_stuffing();
                                                if (isset($stuffing_obj[$detail->stuffing])) {
                                                    echo $stuffing_obj[$detail->stuffing];
                                                }
                                            @endphp
                                        </td>
                                        <td>{{ \Helper::VessenHistoryShowDateTime($detail->si_cut_off_date_time ?? '') }}
                                        </td>
                                        <td>{{ \Helper::VessenHistoryShowDateTime($detail->eqp_available_datetime ?? '') }}
                                        </td>
                                        <td>
                                            @if (isset($detail->booking_file_url) && $detail->booking_file_url != '')
                                                <a href="{{ $detail->booking_file_url ?? '' }}" target="_blank"
                                                    class="btn mini blue"><i class="icon-open-eye"></i> Open File</a>
                                            @endif
                                        </td>
                                        <td>{{ $detail->vessel_voy ?? '' }}</td>
                                        <td>
                                            {{ $detail->booking_detail_remark ?? '' }}
                                        </td>
                                        <td>{{ \Helper::VessenHistoryShowDateTime($detail->created_at ?? '') }}</td>
                                        <td>{{ $detail->user_name ?? '' }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </div>
@endsection
