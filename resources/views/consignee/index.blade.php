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
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Manage Consignee
                    {{-- <small>blank & starter page sample</small> --}}
                </h3>
                <ul class="breadcrumb">
                    <li>
                        <i class="icon-home"></i>
                        <a href="{{ route('users.dashboard') }}">Home</a>
                        <i class="icon-angle-right"></i>
                    </li>
                    <li>
                        <a href="#">Manage Consignee</a>
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
            <div class="span12 responsive" data-tablet="span12 fix-offset">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                @include('common.msg')
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <h4><i class="icon-cogs"></i>Consignee Listing</h4>
                        <div class="actions">
                            <a href="{{ route('master.consignee.add') }}" class="btn green"><i class="icon-plus"></i>
                                Add</a>
                            <a href="#" class="btn yellow"><i class="icon-print"></i> Print</a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-bordered table-hover" id="sample_3">
                            <thead>
                                <tr>
                                    <th style="width:8px;">ID</th>
                                    <th>Full Name</th>
                                    <th class="hidden-480">Email</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($consignee) && is_object($consignee) && $consignee->count())
                                    @foreach ($consignee as $consig)
                                        <tr class="odd gradeX">
                                            <td>{{ $consig->id }}</td>
                                            <td>{{ $consig->full_name }}</td>
                                            <td class="hidden-480"><a href="mailto:{{ $consig->email_address }}">{{ $consig->email_address }}</a>
                                            </td>
                                            <td>
											<a href="{{ route('master.consignee.edit',['id'=>$consig->id]) }}" class="btn green mini"><i class="icon-pencil"></i> Edit</a>
											<a href="javascript:void(0)" onclick=deleteRow('{{ route('master.consignee.delete',['id'=>$consig->id]) }}') class="btn red mini"><i class="icon-trash"></i> Delete</a>
											</td>
                                        </tr>
                                    @endforeach
                                @else 
                                <tr>
                                    <td colspan="4"><center>No Record found</center></td>
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
        if(confirm('Are you sure want to remove this ?')) {
            window.location.href = xURL;
        }
    }
</script>