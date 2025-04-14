@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">workOrder List</h5>

                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <form method="GET" action="{{ route('work-order.index') }}" class="form-inline align-items-center">
                            <label for="companyFilter" class="mr-3 text-muted">Filter by Company:</label>
                            <div class="input-group">
                                <select name="company_id" id="companyFilter" class="form-control">
                                    <option value="">Select One</option>
                                    @foreach ($companies as $company)
                                        <option value="{{ $company->id }}"
                                            {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                            {{ $company->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <button type="submit" class="btn btn-primary ml-3">Filter</button> --}}
                        </form>
                    </div>
                </div>

                @can('create work order')
                    <a href="{{ route('work-order.create') }}" class="btn btn-success btn-sm">Add New</a>
                @endcan

            </div>

            <div class="card-body">
                @include('components/alert')


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
                            @foreach ($workOrders as $workOrder)
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
                                    <td>{{ \Carbon\Carbon::parse($workOrder->due_date)->format('m-d-Y') }}</td>
                                    <td>{{ $workOrder->grand_total }}</td>
                                    <td>{{ $workOrder->total_qty }}</td>
                                    <td>
                                        <div class="btn-group">
                                            @can('view work order')
                                                <a href="{{ route('work-order.print', $workOrder->id) }}"
                                                    class="btn btn-sm btn-primary"><i class="fa fa-print"></i>
                                                </a>
                                            @endcan

                                            @can('view work order')
                                                <a href="{{ route('work-order.show', $workOrder->id) }}"
                                                    class="btn btn-sm btn-info"><i class="fa fa-eye"></i>
                                                </a>
                                            @endcan

                                            @can('edit work order')
                                                <a href="{{ route('work-order.edit', $workOrder->id) }}"
                                                    class="btn btn-sm btn-warning text-white"><i class="ti-pencil-alt"></i>
                                                </a>
                                            @endcan
                                            
                                            @can('delete work order')
                                                <form action="{{ route('work-order.destroy', $workOrder->id) }}" method="POST"
                                                    id="delete-form-{{ $workOrder->id }}" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete({{ $workOrder->id }})"><i
                                                            class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
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
    <!-- END: Page content-->
@endsection
@section('script')
    <script>
        document.getElementById('companyFilter').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
@endsection
