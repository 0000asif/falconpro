@extends('admin.masterAdmin')
@section('content')

    @can('view dashboard')
        <!-- BEGIN: Page heading-->
        <div class="page-heading">
            <div class="page-breadcrumb">
                <h1 class="page-title">Dashboard</h1><br>
            </div>
            <div class="row mb-4">
                <div class="col-12">
                    <form method="GET" action="{{ route('dashboard') }}" class="form-inline">
                        <label for="companyFilter" class="mr-2">Filter by Company:</label>
                        <select name="company_id" id="companyFilter" class="form-control mr-2">
                            <option value="">Select One</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        {{-- <button type="submit" class="btn btn-primary">Filter</button> --}}
                    </form>
                </div>
            </div>

        </div>
        <style>
            .font-weight-normal {
                color: white;
            }
        </style>
        <!-- BEGIN: Page content-->


        <div>
            @if (!$companyId)
                <div class="row">
                    {{-- <div class="col-12">

                    <h2 class="text-center mb-3">Total Info</h2>
                </div> --}}
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color: black;">
                            <div class="card-body">
                                <h6 class="mb-3 font-15  font-weight-normal text-white">Work Orders</h6>
                                <div class="h2 mb-0 font-weight-normal text-white">{{ $totalWorkOrder }}</div><i
                                    class="ft-dollar-sign data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color: blueviolet">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-white font-weight-normal">Total Work Order Amount</h6>
                                <div class="h2 mb-0 font-weight-normal">{{ $totalWOrkorderAmount }}</div><i
                                    class="ft-user data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color: brown">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-white font-weight-normal">Total Vendor</h6>
                                <div class="h2 mb-0 font-weight-normal">{{ $totalVendor }}</div><i
                                    class="ft-briefcase data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color:tomato">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-white font-weight-normal">Total Client</h6>
                                <div class="h2 mb-0 font-weight-normal">{{ $totalClient }}</div><i
                                    class="ft-users data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color:rgba(119, 84, 9, 0.658)">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-white font-weight-normal">Total Client Payment</h6>
                                <div class="h2 mb-0 font-weight-normal">
                                    {{ $totalClientPayment }}
                                </div><i class="ft-users data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color:rgba(11, 93, 107, 0.644)">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-white font-weight-normal">Total Vendor Payment</h6>
                                <div class="h2 mb-0 font-weight-normal">{{ $totalVendorPayment }}</div><i
                                    class="ft-users data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color:rgba(68, 5, 10, 0.603)">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-white font-weight-normal">Total Profit</h6>
                                <div class="h2 mb-0 font-weight-normal">{{ number_format($totalProfit, 2) }}</div><i
                                    class="ft-users data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>


                <div>
                    <div class="card">
                        <div class="card-header">
                            <h5 class="box-title">Complete Work Order List</h5>
                        </div>
                        <div class="card-body">
                            <br>
                            <div class="table-responsive">
                                <table class="table table-bordered w-100" id="dt-responsive">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>SL</th>
                                            <th>Invoice</th>
                                            <th>Work Order Number</th>
                                            <th>Client</th>
                                            <th>Vendor</th>
                                            <th>Company</th>
                                            <th>Status</th>
                                            <th>Due Date</th>
                                            <th>Grand Total</th>
                                            <th>Total Qty</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($completeorders as $workOrder)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $workOrder->invoice }}</td>
                                                <td>{{ $workOrder->work_order_number }}</td>
                                                <td>{{ $workOrder->client->name ?? 'N/A' }}</td>
                                                <td>{{ $workOrder->vendor->name ?? 'N/A' }}</td>
                                                <td>{{ $workOrder->company->name ?? 'N/A' }}</td>
                                                <td>
                                                    @if ($workOrder->status_id == 1)
                                                        <span class="badge badge-success">{{ $workOrder->status->name }}</span>
                                                    @elseif($workOrder->status_id == 10)
                                                        <span class="badge badge-danger">{{ $workOrder->status->name }}</span>
                                                    @else
                                                        <span class="badge badge-warning">{{ $workOrder->status->name }}</span>
                                                    @endif
                                                </td>
                                                <td>{{ date('m-d-Y', strtotime($workOrder->due_date)) }}</td>
                                                <td>{{ $workOrder->grand_total }}</td>
                                                <td>{{ $workOrder->total_qty }}</td>
                                                <td>
                                                    <div class="btn-group"><a
                                                            href="{{ route('work-order.show', $workOrder->id) }}"
                                                            class="btn btn-sm btn-info"><i class="fa fa-eye text-white"></i></a>
                                                        {{-- <a href="{{ route('work-order.edit', $workOrder->id) }}"
                                                    class="btn btn-sm btn-warning text-white"><i class="ti-pencil-alt text-white"></i>
                                                </a>
                                                <form action="{{ route('work-order.destroy', $workOrder->id) }}"
                                                    method="POST" id="delete-form-{{ $workOrder->id }}"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete({{ $workOrder->id }})"><i
                                                            class="fa fa-trash text-white"></i>
                                                    </button>
                                                </form> --}}
                                                    </div>

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

            <div class="row">
                @foreach ($companyStats as $stat)
                    <div class="col-12">
                        <h2 class="text-center mb-3">{{ $stat['company'] }}</h2>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color: black;">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 font-weight-normal text-white">Work Orders</h6>
                                <div class="h2 mb-0 font-weight-normal text-white">{{ $stat['total_work_orders'] }}
                                </div>
                                <i class="ft-dollar-sign data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color: blueviolet;">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-white font-weight-normal">Total Work Order Amount</h6>
                                <div class="h2 mb-0 font-weight-normal">
                                    {{ number_format($stat['total_work_order_amount'], 2) }}
                                </div>
                                <i class="ft-user data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color: brown;">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-white font-weight-normal">Total Vendors</h6>
                                <div class="h2 mb-0 font-weight-normal">{{ $stat['total_vendors'] }}</div>
                                <i class="ft-briefcase data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color: tomato;">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-white font-weight-normal">Total Clients</h6>
                                <div class="h2 mb-0 font-weight-normal">{{ $stat['total_clients'] }}</div>
                                <i class="ft-users data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color: rgba(119, 84, 9, 0.658);">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-white font-weight-normal">Total Client Payments</h6>
                                <div class="h2 mb-0 font-weight-normal">
                                    {{ number_format($stat['total_client_payments'], 2) }}
                                </div>
                                <i class="ft-users data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color: rgba(11, 93, 107, 0.644);">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-white font-weight-normal">Total Vendor Payments</h6>
                                <div class="h2 mb-0 font-weight-normal">
                                    {{ number_format($stat['total_vendor_payments'], 2) }}
                                </div>
                                <i class="ft-users data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>
                    @php
                        $totalProfit = $stat['total_client_payments'] - $stat['total_vendor_payments'];
                    @endphp
                    <div class="col-12 col-md-4 col-lg-4">
                        <div class="card" style="background-color: rgba(68, 5, 10, 0.603);">
                            <div class="card-body">
                                <h6 class="mb-3 font-15 text-white font-weight-normal">Total Profit</h6>
                                <div class="h2 mb-0 font-weight-normal">
                                    {{ number_format($totalProfit, 2) }}</div>
                                <i class="ft-users data-widget-icon text-white"></i>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if ($companyId)
                <div>
                    @forelse ($workOrdersByCompany as $companyName => $workOrders)
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4><a href="{{ route('company.view', $workOrders->first()->company->id) }}">
                                        {{ $companyName ?? 'Unspecified Company' }}
                                    </a>
                                </h4>

                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered w-100">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>SL</th>
                                                <th>Invoice</th>
                                                <th>Work Order Number</th>
                                                <th>Client</th>
                                                <th>Vendor</th>
                                                <th>Status</th>
                                                <th>Due Date</th>
                                                <th>Grand Total</th>
                                                <th>Total Qty</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($workOrders as $workOrder)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $workOrder->invoice }}</td>
                                                    <td>{{ $workOrder->work_order_number }}</td>
                                                    <td>{{ $workOrder->client->name ?? 'N/A' }}</td>
                                                    <td>{{ $workOrder->vendor->name ?? 'N/A' }}</td>
                                                    <td>
                                                        @if ($workOrder->status_id == 1)
                                                            <span
                                                                class="badge badge-success">{{ $workOrder->status->name }}</span>
                                                        @elseif($workOrder->status_id == 10)
                                                            <span
                                                                class="badge badge-danger">{{ $workOrder->status->name }}</span>
                                                        @else
                                                            <span
                                                                class="badge badge-warning">{{ $workOrder->status->name }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ date('m-d-Y', strtotime($workOrder->due_date)) }}</td>
                                                    <td>{{ $workOrder->grand_total }}</td>
                                                    <td>{{ $workOrder->total_qty }}</td>
                                                    <td>
                                                        <div class="btn-group">
                                                            <a href="{{ route('work-order.show', $workOrder->id) }}"
                                                                class="btn btn-sm btn-info">
                                                                <i class="fa fa-eye"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="alert text-center"
                            style="color: #842029; background-color: #f8d7da;  border-color: #f5c2c7;">
                            No work orders found
                            for this company.</div>
                    @endforelse
                </div>
            @endif



        </div><!-- END: Page content-->
    @endcan

@endsection
@section('script')
    <script>
        document.getElementById('companyFilter').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
@endsection
