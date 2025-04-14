@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">Salary Record</h5>
                @can('create salary payment')
                    <a href="{{ route('salary.create') }}" class="btn btn-success btn-sm">Make a Salary</a>
                @endcan
            </div>
            <div class="card-body">
                <br>
                @include('components/alert')
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="dt-responsive">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Payment Method</th>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Amount</th>
                                <th>Bonous</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($salaries as $key => $staff)
                                <tr>
                                    <th>{{ $key + 1 }} </th>
                                    <td>{{ $staff->staff->name }}</td>
                                    <td>{{ $staff->PaymentMethod->name }}</td>
                                    @php
                                        $monthNumber = $staff->payment_month; // Example month number
                                        $monthName = \Carbon\Carbon::create()->month($monthNumber)->format('F');
                                    @endphp
                                    <td>{{ $monthName }}</td>
                                    <td>{{ $staff->payment_year }}</td>
                                    <td>{{ $staff->salary_amount }}</td>
                                    <td>{{ $staff->bonous ?? 'N/A' }}</td>
                                    <td>{{ date('m-d-Y', strtotime($staff->payment_date)) }}</td>
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
