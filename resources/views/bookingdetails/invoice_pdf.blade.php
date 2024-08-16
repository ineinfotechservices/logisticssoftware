<!doctype html>
<html>

<head>
    <title>Invoice</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    {{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;1,400;1,500;1,700&display=swap" rel="stylesheet"> --}}
    <style type="text/css" media="all">
        .info-container,
        .delivery-info,
        .item-details {
            border-bottom: 1px solid #231F20;
        }

        /* New CSS*/
        *,
        *::after,
        *::before {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', Arial, sans-serif;
            font-size: 11px;
            page-break-after: always;
            line-height: 17px;
            letter-spacing: 0.3px;
        }

        .small-heading {
            font-size: 8px;
        }

        .invoice-table {
            padding: 20px;
        }

        .invoice-table .table-wrapper {
            border: 1px solid #231F20;
            vertical-align: top;
            /*max-width: 1240px;*/
            margin: 0 auto;
        }

        .col2-set {
            display: table;
            /*flex-flow: row;*/
            width: 100%;
        }

        .wrapper {
            height: 1050px;
        }

        .col2-set>div {
            width: 50%;
            border-right: 1px solid #231F20;
            border-bottom: 1px solid #231F20;
            display: table-cell;
        }

        .col2-set>div:last-child {
            border-right: 0;
        }

        .header-top {
            text-transform: uppercase;
        }

        .header-top.col2-set .col-2 {
            text-align: right;
            color: #f00;
        }

        .header-top.col2-set>div {
            border: 0;
            padding: 10px;
        }

        .customer-info>div {
            padding: 5px 10px;
            border-bottom: 1px solid #231F20;
            min-height: 100px;
        }

        .customer-info>div:last-child {
            border-bottom: 0;
        }

        .vendor-info>div {
            padding: 5px 10px;
            border-bottom: 1px solid #231F20;

        }

        .vendor-info-data {
            text-align: center;
        }

        .vendor-info>div:last-child {
            border-bottom: 0;
        }

        .vendor-info .col2-set>div {
            border-bottom: 0;
            border-right: 0;
            text-align: center;
        }

        .vendor-info>div.contact-number {
            border-bottom: 0;
            text-align: center;
        }

        .additional-delivery-table {
            display: table;
            justify-content: space-around;
            width: 100%;
        }

        .additional-delivery-table .adt-row {
            display: table-row;
        }

        .additional-delivery-table .adt-row>div {
            border-right: 1px solid #231F20;
            border-bottom: 1px solid #231F20;
            display: table-cell;
            padding: 5px 10px;
        }

        .additional-delivery-table .adt-row>div:last-child {
            border-right: 0;
        }

        .additional-delivery-table .adt-row>div {
            width: 25%;
        }

        .additional-delivery-table.table-1 .adt-row>div:nth-child(3) {
            width: 50%;
        }

        .additional-delivery-table.table-2 .adt-row>div:nth-last-child(2) {
            border-right: 0;
        }

        .item-details .table-head {
            width: 100%;
            display: table;
        }

        .item-details .table-head>div {
            border-right: 1px solid #231F20;
            border-bottom: 1px solid #231F20;
            display: table-cell;
            padding: 5px 10px;
        }

        .item-details .table-head>div:last-child {
            border-right: 0;
        }

        .item-details .table-head>div:first-child {
            width: 25%;
        }

        .item-details .table-head>div:nth-child(2) {
            width: 50%;
        }

        .item-details .table-head>div:nth-child(3) {
            width: calc(25%/2);
        }

        17px .item-details .table-head>div:last-child {
            width: calc(25%/2);
        }

        .item-details .table-head>div:nth-last-child(2) {
            border-right: 0;
        }

        .item-details {
            background: url("{{ public_path('invoice/logo-watermark.jpg') }}") center 60px no-repeat;
            background-size: 60%;
        }

        .item-details .table-data {
            width: 100%;
            display: table;
        }

        .item-details .table-data>div {
            border-right: 1px solid #231F20;
            /*border-bottom: 1px solid #231F20;*/
            display: table-cell;
            padding: 5px 10px;
        }

        .item-details .table-data>div:nth-last-child(2) {
            border-right: 0;
        }

        .item-details .table-data>div:last-child {
            border-right: 0;
        }

        .item-details .table-data>div:first-child {
            width: 25%;
        }

        .item-details .table-data>div:nth-child(2) {
            width: 50%;
        }

        .item-details .table-data>div:nth-child(3) {
            width: calc(25%/2);
        }

        .item-details .table-data>div:last-child {
            width: calc(25%/2);
        }

        .invoice-notes .col {
            padding: 5px 10px;
        }

        .invoice-notes.col2-set>div.col-1 {
            width: 70%;
        }

        .invoice-notes.col2-set>div.col-2 {
            width: 30%;
        }

        @page {
            margin: 20mm;
        }

        .smallHeading12 {
            font-size: 11px;
            font-weight: 500;
        }

        .smallHeading11 {
            font-size: 11px;
        }

        .smallHeading09 {
            font-size: 09px;
            line-height: 14px;
        }
    </style>
    @php
        $tmp_data = [1, 2];
        
        $pickup_location = isset($bookingdata->pickup_location) ? $bookingdata->pickup_location : '';
        $vessel_voy = isset($bookingdata->vessel_voy) ? $bookingdata->vessel_voy : '';
        
        $document_marks = isset($bookingdata->document_marks) ? $bookingdata->document_marks : '';
        $document_description = isset($bookingdata->document_description) ? $bookingdata->document_description : '';
        $document_gross_weight = isset($bookingdata->document_gross_weight) ? $bookingdata->document_gross_weight : '';
        $document_measurement = isset($bookingdata->document_measurement) ? $bookingdata->document_measurement : '';
        $final_place_of_delivery = isset($bookingdata->final_place_of_delivery) ? $bookingdata->final_place_of_delivery : '';

        
        $document_marks_br = sizeof(explode('<br />', nl2br($document_marks)));
        $document_description_br = sizeof(explode('<br />', nl2br($document_description)));
        $document_gross_weight_br = sizeof(explode('<br />', nl2br($document_gross_weight)));
        $document_measurement_br = sizeof(explode('<br />', nl2br($document_measurement)));
        $heightest_height_array = [$document_marks_br, $document_description_br, $document_gross_weight_br, $document_measurement_br];
        $heightest_height_count = max($heightest_height_array);
        $loopCount = (int) ceil($heightest_height_count / 10);
        $forLoop = range(1, $loopCount);
        
        $exporter_id = isset($bookingdata->ms_exporter_id) ? $bookingdata->ms_exporter_id : 0;
        $invoice_get_shipper_by_id = \Helper::invoice_get_shipper_by_id($exporter_id);
        
        $ms_consignee_id = isset($bookingdata->ms_consignee_id) ? $bookingdata->ms_consignee_id : 0;
        $invoice_get_consignee_by_id = \Helper::invoice_get_consignee_by_id($ms_consignee_id);
        
        $notify_user1 = isset($bookingdata->notify_user1) ? $bookingdata->notify_user1 : 0;
        $notify_user_data = \Helper::invoice_get_consignee_by_id($notify_user1);
        
        $ms_port_of_loading_id = isset($bookingdata->ms_port_of_loading_id) ? $bookingdata->ms_port_of_loading_id : 0;
        $port_of_loading_data = \Helper::invoice_get_port_of_loading_by_id($ms_port_of_loading_id);
        
        $freight_payble_at = isset($bookingdata->freight_payble_at) ? $bookingdata->freight_payble_at : 0;
        $freight_payble_data = \Helper::invoice_get_port_of_destination_by_id($freight_payble_at);
        
        $ms_port_of_destination = isset($bookingdata->ms_port_of_destination) ? $bookingdata->ms_port_of_destination : 0;
        $ms_port_of_discharge_data = \Helper::invoice_get_port_of_destination_by_id($ms_port_of_destination);

         
        $required_obl = isset($bookingdata->required_obl) ? $bookingdata->required_obl : 0;
        $express_bl = isset($bookingdata->express_bl) ? $bookingdata->express_bl : 0;
        
    @endphp
</head>

<body>
    @foreach ($forLoop as $number)
        <div class="wrapper invoice-table">
            <div class="col2-set header-top">
                <div class="col-1">
                    <p><strong>Bill of Lading</strong></p>
                </div>
                <div class="col-2">
                    <p><strong>Non negotiable copy</strong>
                    <p>
                </div>
            </div>
            <div class="table-wrapper">


                @include('bookingdetails.invoice_header', [
                    'shipper_data' => $invoice_get_shipper_by_id,
                    'consignee_data' => $invoice_get_consignee_by_id,
                    'notify_user_data' => $notify_user_data,
                    'port_of_loading_data' => $port_of_loading_data,
                    'freight_payble_data' => $freight_payble_data,
                    'ms_port_of_discharge_data' => $ms_port_of_discharge_data,
                    'pickup_location' => $pickup_location,
                    'vessel_voy' => $vessel_voy,
                    'final_place_of_delivery'=>$final_place_of_delivery,
                    'required_obl'=>$required_obl,
                    'express_bl'=>$express_bl
                ])
                <div class="item-details" style="height:370px">
                    <div class="table-head small-heading">
                        <div>Marks and Numbers</div>
                        <div>Number and kind of packages/Description of goods</div>
                        <div>Gross Weight</div>
                        <div>Measurement</div>
                    </div>
                    <div class="table-data" >
                        <div>
                            {!! \Helper::getLimitValueByNumber($document_marks, $number) !!}
                        </div>
                        <div>
                            {!! \Helper::getLimitValueByNumber($document_description, $number) !!}
                        </div>
                        <div>
                            {!! \Helper::getLimitValueByNumber($document_gross_weight, $number) !!}
                        </div>
                        <div>
                            {!! \Helper::getLimitValueByNumber($document_measurement, $number) !!}
                        </div>
                    </div>
                    @if ($loopCount == $number)
                    
                    @if($booking_detail_moment_detail->count() == 1)
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
                                                {{ $moment_detail->id ?? 0 }}
                                            </td>
                                            <td>{{ $moment_detail->custom_seal_no ?? '' }}</td>
                                            <td>{{ $moment_detail->a_seal_no ?? '' }}
                                            </td>
                                            <td>
                                            {{ $moment_detail->document_gross_weight ?? '' }}
                                            <td>
                                            {{ $moment_detail->document_no_of_package ?? '' }}
                                            </td>
                                            <td>{{ $moment_detail->document_kind_of_package ?? '' }}
                                            </td>
                                            <td>{{ $moment_detail->document_vgm_weight ?? '' }}</td>
                                            <td>{{ $moment_detail->document_net_weight ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                       @endif
                    

                    
                        <div class="table-data">
                            <div>&nbsp;</div>
                            <div style="text-align: center;">
                                <b>SHIPPED ON BOARD DATE: 30.11.2022</b>
                                <p class="smallHeading11">
                                    SAID TO CONTAIN, SHIPPER'S LOAD, STOW, COUNT & SEAL DEAMURRAGE/DETENTION CHARGES AT
                                    PORT OF
                                    DESITNATION PAYBLE BY CONSIGNEE </p>
                                <p class="smallHeading11">AS PER TARIFF IF SHIPMENT NOT CLEARED AT DESTINATION ALL
                                    DESTINATION CHARGES TO BE BRONE BY
                                    SHIPPER </p>
                                <p class="smallHeading11">FCL/FCL -CY/CY continue to 2nd page</p>
                            </div>
                            <div>&nbsp;</div>
                            <div>&nbsp;</div>
                        </div>
                    @endif
                    <!--<div style="text-align:center; padding: 0px 5px;">
                        <b>"FREIGHT COLLECT"</b><br>
                        <b>SHIPPED ON BOARD DATE: 30.11.2022</b>
                        <p class="smallHeading11">
                            SAID TO CONTAIN, SHIPPER'S LOAD, STOW, COUNT & SEAL DEAMURRAGE/DETENTION CHARGES AT PORT OF
                            DESITNATION PAYBLE BY CONSIGNEE </p>
                        <p class="smallHeading11">AS PER TARIFF IF SHIPMENT NOT CLEARED AT DESTINATION ALL DESTINATION CHARGES TO BE BRONE BY
                            SHIPPER </p>
                        <p class="smallHeading11">FCL/FCL -CY/CY continue to 2nd page</p>
                    </div>-->
                </div>


                @include('bookingdetails.invoice_footer')

            </div>

        </div>
    @endforeach
    @if($booking_detail_moment_detail->count() > 1)
    
    <div class="anotherPagetable">
    <center style="margin-top:10px;">Continue from page - 1</center>
    <table class="table table-bordered table-striped" id="numberOfContinerTable">
            
            <tbody>
                
                        <tr>
                            <td><b>BL Number</b></td>
                            <td><b>Vessel Name</b></td>
                            <td><b>Voyage</b>
                        </td>
                           
                        </tr>
                        <tr>
                            <td>
                            -
                            </td>
                            <td>-</td>
                            <td>{{ $vessel_voy ?? '-'}}
                            </td>
                           
                        </tr>
            </tbody>
        </table>

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
                </tr>
            </thead>
            <tbody>
                @if (isset($booking_detail_moment_detail) &&
                        is_object($booking_detail_moment_detail) &&
                        $booking_detail_moment_detail->count())
                    @foreach ($booking_detail_moment_detail as $moment_detail)
                        <tr>
                            <td>
                                {{ $moment_detail->id ?? 0 }}
                            </td>
                            <td>{{ $moment_detail->custom_seal_no ?? '' }}</td>
                            <td>{{ $moment_detail->a_seal_no ?? '' }}
                            </td>
                            <td>
                            {{ $moment_detail->document_gross_weight ?? '' }}
                            <td>
                            {{ $moment_detail->document_no_of_package ?? '' }}
                            </td>
                            <td>{{ $moment_detail->document_kind_of_package ?? '' }}
                            </td>
                            <td>{{ $moment_detail->document_vgm_weight ?? '' }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
    @endif
</body>

</html>


<style>
.anotherPagetable{
    width: 100%;
    margin-top: 10px;
    text-align: center;
}
.anotherPagetable table{
    width: 98%;
    margin-top:10px;
    margin-left: 5px;
}
.anotherPagetable table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    padding: 4px;
}
/* .anotherPagetable table tr {
    border: 1px solid #000;
    padding: 3px; */
/* } */
.anotherPagetable{
    
}
.anotherPagetable{
    
}

</style>
