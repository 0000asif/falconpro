@extends('admin.masterAdmin')
@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-header">
                <h4>Company: {{ $company->name }}</h4>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">Back to Dashboard</a>
            </div>
            <div class="card-body">
                <p>
                    <strong>Image: </strong> <img src="{{ asset('admin/company/' . $company->image) }}" alt="logo" width="200">
                </p>
                <p><strong>Name:</strong> {{ $company->name }}</p>
                <p><strong>City:</strong> {{ $company->city ?? 'N/A' }} </p>
                <p><strong>State:</strong> {{ $company->state_id }}</p>
                <p><strong>Zip Code:</strong> {{ $company->zip_code }}</p>
                <p><strong>Address:</strong> {{ $company->address }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Work Orders</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($company->workOrders as $workOrder)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $workOrder->invoice }}</td>
                                <td>{{ $workOrder->work_order_number }}</td>
                                <td>{{ $workOrder->client->name ?? 'N/A' }}</td>
                                <td>{{ $workOrder->vendor->name ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-success">Completed</span>
                                </td>
                                <td>{{ $workOrder->due_date }}</td>
                                <td>{{ $workOrder->grand_total }}</td>
                                <td>{{ $workOrder->total_qty }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
