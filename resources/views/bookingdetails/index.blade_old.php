@extends('layouts.private')
@php
    $globalTitle = 'Booking Details';
@endphp

@section('content')
    <!-- BEGIN PAGE CONTAINER-->
    <div class="container-fluid">
        <!-- BEGIN PAGE HEADER-->
        <div class="row-fluid">
            <div class="span12">
                <!-- BEGIN STYLE CUSTOMIZER -->
                @include('common.themesetting')
                <!-- END BEGIN STYLE CUSTOMIZER -->
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Manage {{ $globalTitle }}
                    {{-- <small>blank & starter page sample</small> --}}
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="{{ route('users.dashboard') }}">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Manage {{ $globalTitle }}</a>
                        {{-- <i class="icon-angle-right"></i> --}}
                    </li>
                    {{-- <li><a href="#">Blank Page</a></li> --}}
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <!-- END PAGE HEADER-->
        <!-- BEGIN PAGE CONTENT-->
        <div class="row-fluid">
            @include('common.msg')
            <div class="span12 responsive" data-tablet="span12 fix-offset">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <h4><i class="icon-cogs"></i>{{ $globalTitle }} Listing</h4>
                        <div class="actions">
                            @if (!(\Helper::isCustomerService() || \Helper::isDocument()))
                                <a href="{{ route('master.booking.add') }}" class="btn green"><i class="icon-plus"></i>
                                    Add</a>
                                <a href="#" class="btn yellow"><i class="icon-print"></i> Print</a>
                            @endif
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover nrgtables">
                            <thead>
                                <tr>
                                    <th style="width:8px;">ID</th>
                                    <th>Shipper</th>
                                    <th>Job Number</th>
                                    <th>Received From</th>
                                    <th>Final Delivery</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($booking_details) && is_object($booking_details) && $booking_details->count())
                                    @foreach ($booking_details as $detail)
                                        <tr class="odd gradeX">
                                            <td>{{ $detail->id }}</td>
                                            <td>{{ $detail->shipper_name }}</td>
                                            <td>{{ $detail->job_number }}</td>
                                            <td>{{ $detail->booking_received_from }}</td>
                                            <td>{{ $detail->final_place_of_delivery }}</td>
                                            <td>
                                                <a href="{{ route('master.booking.view', ['id' => $detail->id]) }}"
                                                    class="btn green mini"><i class="icon-eye-open"></i> View</a>
                                                @if (\Helper::isAdmin() || \Helper::isDocument())
                                                    @if(\Helper::isDocument())
                                                    <a href="{{ route('master.booking.documentedit', ['id' => $detail->id]) }}"
                                                        class="btn green mini"><i class="icon-pencil"></i> Edit</a>
                                                    @elseif(\Helper::isAdmin())
                                                    <a href="{{ route('master.booking.edit', ['id' => $detail->id]) }}"
                                                        class="btn green mini"><i class="icon-pencil"></i> Edit</a>        
                                                    @endif    
                                                    <a href="{{ route('master.booking.documentfilesedit', ['id' => $detail->id]) }}"
                                                        class="btn green mini"><i class="icon-file"></i> Files</a>
                                                        
                                                @else
                                                    <a href="{{ route('master.booking.edit', ['id' => $detail->id]) }}"
                                                        class="btn green mini"><i class="icon-pencil"></i> Edit</a>
                                                @endif

                                                @if (\Helper::isAdmin() || \Helper::isSales())
                                                    @if (\Helper::isAdmin())
                                                        <a href="javascript:void(0)"
                                                            onclick=deleteRow('{{ route('master.booking.delete', ['id' => $detail->id]) }}')
                                                            class="btn red mini"><i class="icon-trash"></i> Delete</a>
                                                    @elseif(isset($detail->status) && $detail->status == 1)
                                                        <a href="javascript:void(0)"
                                                            onclick=deleteRow('{{ route('master.booking.delete', ['id' => $detail->id]) }}')
                                                            class="btn red mini"><i class="icon-trash"></i> Delete</a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4">
                                            <center>No Record found</center>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE CONTENT-->
    </div>
    <!-- END PAGE CONTAINER-->
@endsection

<script>
    const deleteRow = (xURL) => {
        if (confirm('Are you sure want to remove this ?')) {
            window.location.href = xURL;
        }
    }
</script>
