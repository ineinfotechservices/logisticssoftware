<div class="page-sidebar nav-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <ul>
        <li>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <div class="sidebar-toggler hidden-phone"></div>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        </li>
        <li>
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <form class="sidebar-search">
                <div class="input-box">
                    <a href="javascript:;" class="remove"></a>
                    <input type="text" placeholder="Search..." />
                    <input type="button" class="submit" value=" " />
                </div>
            </form>
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
        </li>
        @if (in_array($pageURL, $array_dashboard))
            <li class="start active">
            @else
            <li class="start">
        @endif
        <a href="{{ route('users.dashboard') }}">
            <i class="icon-home"></i>
            <span class="title">Dashboard</span>
            <span class="selected"></span>
        </a>
        </li>
        @if (\Helper::isCustomerService())

            @if (in_array($pageURL, $array_master))
                <li class="has-sub active">
                @else
                <li class="has-sub">
            @endif
            <a href="javascript:;">
                <i class="icon-bookmark-empty"></i>
                <span class="title">Masters</span>
                <span class="arrow "></span>
            </a>

            <ul class="sub">
                <li><a href="{{ route('master.exporter.index') }}">Manage Shipper</a></li>
            </ul>
            </li>
        @endif

        @if(\Helper::isDocument())
            @if (in_array($pageURL, $array_master))
                <li class="has-sub active">
                @else
                <li class="has-sub">
            @endif
            <a href="javascript:;">
                <i class="icon-bookmark-empty"></i>
                <span class="title">Masters</span>
                <span class="arrow "></span>
            </a>
            <ul class="sub">
                <li><a href="{{ route('master.consignee.index') }}">Manage Consignee</a></li>
            </ul>
            </li>

        @endif


        @if (in_array($pageURL, $array_booking_details))
            <li class="has-sub active">
            @else
            <li class="has-sub ">
        @endif

        <a href="{{ route('master.booking.index') }}">
            <i class="icon-bookmark-empty"></i>
            <span class="title">Booking Details</span>
        </a>
        {{-- <a href="{{ route('master.jobs.index') }}">
                <i class="icon-bookmark-empty"></i>
                <span class="title">Job Management</span>
            </a> --}}

        </li>
</div>