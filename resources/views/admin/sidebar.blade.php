<style>
    .metismenu li a {
        color: white !important;
    }

    .metismenu li a i {
        color: white !important;
    }

    #sidebar {
        background-color: green;
    }

    .sidebar-menu li.mm-active {
        background-color: #1a8d1a !important;
    }

    .sidebar-menu a:focus,
    .sidebar-menu a:hover {
        background-color: #5bb05b !important;
    }
</style>

<!-- BEGIN: Sidebar-->
<div class="page-sidebar custom-scroll" id="sidebar">
    <div class="sidebar-header"><a class="sidebar-brand" href="{{ URL::to('dashboard') }}">Facility Maintenance Wizard </a><a
            class="sidebar-brand-mini" href="index.html">FMW</a><span class="sidebar-points"><span
                class="badge badge-success badge-point mr-2"></span><span
                class="badge badge-danger badge-point mr-2"></span><span
                class="badge badge-warning badge-point"></span></span></div>
    <ul class="sidebar-menu metismenu">
        {{-- <li class="heading"><span>DASHBOARDS</span></li> --}}
        @php
            $user = Auth::user();
        @endphp
        @can('view dashboard')
            <li class="mm-active"><a href="{{ URL::to('/dashboard') }}">
                <i class="sidebar-item-icon ft-home"></i><span class="nav-label">Dashboards</span></a>
            </li>
        @endcan

        @can('create attendance')
            <li><a href="{{ Route('attendence.create') }}">
                <i class="sidebar-item-icon fa fa-pencil-square-o"></i><span class="nav-label">Attendence</span></a>
            </li>
        @endcan

        @can('view attendance')
            {{-- Attendence Histor for admin --}}
            <li><a href="{{ Route('attendence.index') }}">
                    <i class="sidebar-item-icon fa fa-pencil-square-o"></i>
                    <span class="nav-label">Attendence History</span></a>
            </li>
        @endcan


        @if ($user->hasAnyPermission(['view type', 'create type']))
        <li><a href="javascript:;"><i class="sidebar-item-icon fa fa-caret-square-o-right"></i><span
                    class="nav-label">Type</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                @can('create type')
                    <li><a href="{{ Route('type.create') }}">Add a Type</a></li>
                @endcan
                @can('view type')
                    <li><a href="{{ Route('type.index') }}">All Type</a></li>
                @endcan
            </ul>
        </li>
        @endif


        {{-- <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">City</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ Route('city.create') }}">Add City</a></li>
                <li><a href="{{ Route('city.index') }}">All City</a></li>
            </ul>
        </li>


        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">State</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ Route('state.create') }}">Add State</a></li>
                <li><a href="{{ Route('state.index') }}">All State</a></li>
            </ul>
        </li> --}}
        @if ($user->hasAnyPermission(['view company', 'create company']))
            <li><a href="javascript:;"><i class="sidebar-item-icon fa fa-building-o"></i><span
                        class="nav-label">Company</span><i class="arrow la la-angle-right"></i></a>
                <ul class="nav-2-level">
                    @can('create company')
                        <li><a href="{{ Route('company.create') }}">Add Company</a></li>
                    @endcan
                    @can('view company')
                        <li><a href="{{ Route('company.index') }}">Manage Company</a></li>
                    @endcan
                </ul>
            </li>
        @endcan
        @if ($user->hasAnyPermission(['view client', 'create client']))
        <li><a href="javascript:;"><i class="sidebar-item-icon fa fa-user-o"></i><span class="nav-label">Client</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ Route('client.create') }}">Add Client</a></li>
                <li><a href="{{ Route('client.index') }}">Manage Client</a></li>
            </ul>
        </li>
        @endif

        @if ($user->hasAnyPermission(['view vendor', 'create vendor']))
        <li><a href="javascript:;"><i class="sidebar-item-icon fa fa-briefcase"></i><span
                    class="nav-label">Vendor</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li class="d-none"><a href="{{ Route('expertise.index') }}">Expertise</a></li>
                @can('create vendor')
                    <li><a href="{{ Route('vandors.create') }}">Add Vendor</a></li>
                @endcan
                @can('view vendor')
                    <li><a href="{{ Route('vandors.index') }}">Manage Vendor</a></li>
                @endcan
            </ul>
        </li>
        @endcan

        @if ($user->hasAnyPermission(['view payment method', 'create payment method']))
        <li><a href="javascript:;"><i class="sidebar-item-icon fa fa-usd"></i><span class="nav-label">Payment
                    Method</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                @can('create payment method')
                    <li><a href="{{ Route('payment_method.create') }}">Add New</a></li>
                @endcan
                @can('view payment method')
                    <li><a href="{{ Route('payment_method.index') }}">Payment Methods</a></li>
                @endcan
            </ul>
        </li>
        @endif

        @if ($user->hasAnyPermission(['view designation', 'create designation', 'view employee', 'create employee', 'create salary payment', 'view salary payment']))
        <li><a href="javascript:;"><i class="sidebar-item-icon fa fa-user-circle-o"></i><span
                    class="nav-label">HRM</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                @if ($user->hasAnyPermission(['view designation', 'create designation']))
                    <li><a href="{{ Route('designation.index') }}">Designation</a></li>
                @endif
                @if ($user->hasAnyPermission(['view employee', 'create employee']))
                    <li><a href="{{ Route('employee.index') }}">Employee</a></li>
                @endif
                @if ($user->hasAnyPermission(['create salary payment']))
                    <li><a href="{{ Route('salary.create') }}">Salary Payment</a></li>
                @endif
                @if ($user->hasAnyPermission(['view salary payment']))
                    <li><a href="{{ Route('salary.index') }}">Salary Record</a></li>
                @endif
            </ul>
        </li>
        @endif

        @if ($user->hasAnyPermission(['create work order', 'view work order', 'view bids', 'create bids', 'create client invoice', 'view client invoice', 'create vendor invoice', 'view vendor invoice', 'create comment', 'view comment']))
        <li><a href="javascript:;"><i class="sidebar-item-icon fa fa-first-order"></i><span class="nav-label">Work
                    Order</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                @can('create work order')
                    <li><a href="{{ Route('work-order.create') }}">Add New</a></li>
                @endcan
                @can('view work order')
                    <li><a href="{{ Route('work-order.index') }}">Manage Order</a></li>
                @endcan
            </ul>
        </li>
        @endif
        @php
            use App\Models\Note;
            $pendingNote = Note::where('status', '0')->count();
        @endphp

        <li class="d-none"><a href="javascript:;"><i class="sidebar-item-icon fa fa-comment-o"></i><span class="nav-label">Comments
                </span> <span class="badge badge-info"
                    style="border-radius:30%;font-size:14px;color:white; margin-left:20px">{{ $pendingNote }}</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ Route('note.index') }}">Manage Comments</a></li>
            </ul>
        </li>

        @if ($user->hasAnyPermission(['view user role', 'create user role']))
            <li>
                <a href="javascript:;"><i class="sidebar-item-icon fa fa-user-o"></i><span class="nav-label">Role
                    </span><i
                        class="arrow la la-angle-right"></i></a>
                <ul class="nav-2-level">
                    <li><a href="{{ route('user_role_list') }}">User Role</a></li>
                </ul>
            </li>
        @endcan



        {{-- <li><a href="javascript:;"><i class="sidebar-item-icon fa fa-user-circle-o"></i><span
                    class="nav-label">Bids</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ Route('bids.create') }}">Add New</a></li>
                <li><a href="{{ Route('bids.index') }}">Manage Bids</a></li>
            </ul>
        </li> --}}

        @if ($user->hasAnyPermission(['view salary report', 'create work order report', 'view work order item', 'view client payment', 'view vendor payment']))
            <li><a href="javascript:;"><i class="sidebar-item-icon fa fa-flag-o"></i><span
                        class="nav-label">Reports</span><i class="arrow la la-angle-right"></i></a>
                <ul class="nav-2-level">
                    {{-- <li><a href="{{ Route('income.report') }}">Income</a></li>
                    <li><a href="{{ Route('expense.report') }}">Expence</a></li> --}}
                    @can('view salary report')
                        <li><a href="{{ Route('salary.report') }}">Salary </a></li>
                    @endcan
                    {{-- <li><a href="{{ Route('workorder') }}">Work Order </a></li> --}}
                    @can('create work order report')
                        <li><a href="{{ Route('dailypayment') }}">Work Order </a></li>
                    @endcan
                    @can('view work order item')
                        <li><a href="{{ Route('workorderitem') }}">Work Order Item</a></li>
                    @endcan
                    @can('view client payment')
                        <li><a href="{{ Route('clientpayment') }}">Client Payment</a></li>
                    @endcan
                    @can('view vendor payment')
                        <li><a href="{{ Route('vendorpayment') }}">Vednor Payment</a></li>
                    @endcan
                </ul>
            </li>
        @endif

    </ul>
</div>
<!-- END: Sidebar-->
