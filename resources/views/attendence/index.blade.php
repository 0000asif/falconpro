@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="box-title">Attendence History</h5>
                @can('view attendance')
                    <a href="{{ route('print.attendance') }}" class="btn btn-success btn-sm">Print</a>
                @endcan
            </div>
            <div class="card-body">
                <br>
                @include('components/alert')
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="dt-responsive">

                        <thead class="thead-light">
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Check-In</th>
                                <th>Check-In-Ip</th>
                                <th>Check-Out</th>
                                <th>Check-Out-Ip</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($attendences as $key => $value)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ date('m-d-Y', strtotime($value->created_at)) }}</td>
                                    <td>{{ $value->employee->name ?? 'N/A' }}</td>
                                    <td>{{ date('m-d-Y H:i:s', strtotime($value->check_in)) }} </td>
                                    <td>{{ $value->check_in_ip }} </td>
                                    <td>
                                        @if ($value->check_out == null)
                                        @else
                                            {{ date('m-d-Y H:i:s', strtotime($value->check_out)) }}
                                        @endif
                                    </td>
                                    <td>{{ $value->check_out_ip }} </td>
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
