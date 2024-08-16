<header>
    <div class="col2-set">
        <div class="col-1 customer-info">
            <div class="shipper">
                <h4 class="smallHeading12">Shipper</h4>
                <b>{{ $shipper_data->name ?? '' }}</b><br>
                @if (isset($shipper_data->address) && $shipper_data->address != '')
                    {{ $shipper_data->address ?? '' }}
                @endif
                @if (isset($shipper_data->address2) && $shipper_data->address2 != '')
                    <br />{{ $shipper_data->address2 ?? '' }}
                @endif
                @if (isset($shipper_data->address3) && $shipper_data->address3 != '')
                    <br />{{ $shipper_data->address3 ?? '' }}
                @endif

                @php
                    $shipper_state = \Helper::getStatesbyID($shipper_data->state_id ?? 0);
                    $shipper_country = \Helper::getCountrybyID($shipper_data->country ?? 0);
                @endphp
                @if (isset($shipper_state->title) && $shipper_state->title != '')
                    <br />{{ $shipper_state->title }}
                @endif
                @if (isset($shipper_country->title) && $shipper_country->title != '')
                    ,{{ $shipper_country->title }}
                @endif

            </div>
            <div>
                <h4 class="smallHeading12">Consignee(If 'To Order' as indicate)</h4>
                <b>{{ $consignee_data->full_name ?? '' }}</b><br>
                @if (isset($consignee_data->address) && $consignee_data->address != '')
                    {{ $consignee_data->address ?? '' }}
                @endif
                @if (isset($consignee_data->address2) && $consignee_data->address2 != '')
                    <br />{{ $consignee_data->address2 ?? '' }}
                @endif
                @if (isset($consignee_data->address3) && $consignee_data->address3 != '')
                    <br />{{ $consignee_data->address3 ?? '' }}
                @endif
                @php
                    $consignee_state = \Helper::getStatesbyID($consignee_data->state_id ?? 0);
                    $consignee_country = \Helper::getCountrybyID($consignee_data->country ?? 0);
                @endphp
                @if (isset($consignee_state->title) && $consignee_state->title != '')
                    <br />{{ $consignee_state->title }}
                @endif
                @if (isset($consignee_country->title) && $consignee_country->title != '')
                    ,{{ $consignee_country->title }}
                @endif
            </div>
            <div>
                <h4 class="smallHeading12">Notify Party(No claim shall attach for failure to notify)</h4>
                <b>{{ $notify_user_data->full_name ?? '' }}</b><br>
                @if (isset($notify_user_data->address) && $notify_user_data->address != '')
                    {{ $notify_user_data->address ?? '' }}
                @endif
                @if (isset($notify_user_data->address2) && $notify_user_data->address2 != '')
                    <br />{{ $notify_user_data->address2 ?? '' }}
                @endif
                @if (isset($notify_user_data->address3) && $notify_user_data->address3 != '')
                    <br />{{ $notify_user_data->address3 ?? '' }}
                @endif
                @php
                    $notify_user_state = \Helper::getStatesbyID($notify_user_data->state_id ?? 0);
                    $notify_user_country = \Helper::getCountrybyID($notify_user_data->country ?? 0);
                @endphp
                @if (isset($notify_user_state->title) && $notify_user_state->title != '')
                    <br />{{ $notify_user_state->title }}
                @endif
                @if (isset($notify_user_country->title) && $notify_user_country->title != '')
                    ,{{ $notify_user_country->title }}
                @endif
            </div>
        </div>
        <div class="col-2 vendor-info">
            <div>
                Multimodal Transport Document No.
                <h4><b>INE-AMD/22-23/254</b></h4>
            </div>
            <div>
                <p>Shipper's Reference</p>
            </div>
            <div class="vendor-info-data">

                <div>
                    <p>Multimodal Transport Document Registration No. MTO/DGS/2530/DEC/2024</p>
                    <img src="{{ public_path('invoice/logo.jpg') }}" alt="" title=""
                        style="max-width:250px;" />
                    <p>504, SPG Empressa, Near Passport Office, Mithalkali Six Road,<br />Navrangpura, Ahmedabad
                        - 380009</p>
                </div>
            </div>

            <div class="contact-number">
                <p><img src="{{ public_path('invoice/telephone.png') }}" alt="" title=""
                        style="width:16px;height:16px;" /> +91 79 48916312</p>
            </div>
            <div class="col2-set">
                <div class="col-1">
                    <p><img src="{{ public_path('invoice/email.png') }}" alt="" title=""
                            style="width:16px;height:16px;" /> info@inelogistics.in</p>
                </div>
                <div class="col-2">
                    <p><img src="{{ public_path('invoice/web.png') }}" alt="" title=""
                            style="width:16px;height:16px;" /> www.inelogistics.in</p>
                </div>
            </div>
        </div>
    </div>
    <div class="additional-delivery-table table-1">
        <div class="adt-row">
            <div>
                <span class="smallHeading12">Place of Receipt</span><br>
                {{ strtoupper($pickup_location ?? '')}}
                
            </div>
            <div>
                <span class="smallHeading12">Place of Loading</span><br>
                {{ strtoupper($port_of_loading_data->title ?? '') }}
            </div>
            <div>
                <span class="smallHeading12">Freight Payable at:</span><br>
                {{ strtoupper($freight_payble_data->title ?? '') }}
            </div>
        </div>
    </div>
    <div class="additional-delivery-table table-2">
        <div class="adt-row">
            <div>
                <span class="smallHeading12">Vessel/Voy</span><br>
                {{ strtoupper($vessel_voy ?? '') }}
            </div>
            <div>
                <span class="smallHeading12">Port of Discharge</span><br>
                {{ strtoupper($ms_port_of_discharge_data->title ?? '')}}
            </div>
            <div>
                <span class="smallHeading12">Final Place of Delivery</span><br>
                {{ strtoupper($final_place_of_delivery ?? '')}}
            </div>
            <div>
                <span class="smallHeading12">No. of Original Bills of Lading</span><br>
                @if($required_obl==1) 
                THREE(03)/THREE(03)
                @elseif($express_bl==1)
                ZERO(0)/ONE(01)
                @endif


            </div>
        </div>
    </div>
</header>
