@php
    $pageURL = Request::segment(1);
    $array_master = ['shippingline', 'consignee', 'equipmenttypes', 'portofloading', 'portofdestination', 'exporter', 'country', 'state', 'city', 'users','notify','deliveryagent','placeofreceipt'];
    $array_booking_details = ['bookingdetails', 'jobookingdetailsbs'];
    $array_followups = ['followup'];
    $array_dashboard = ['dashboard'];

    $roles_sales = array_merge($array_booking_details,$array_dashboard);
    
    $roles_customer_service = array_merge($array_booking_details,$array_dashboard,['exporter']);
    
@endphp
@switch(\Helper::getUserRoleId())

@case(1)
    @include('common.sidebar.admin')
@break 

@case(2)
    @include('common.sidebar.sales')
@break 

@case(3)
    @include('common.sidebar.customerservice')
@break 

@case(4)
    @include('common.sidebar.documentation')
@break 

@endswitch

