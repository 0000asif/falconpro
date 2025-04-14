@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5>Financial Report</h5>

            </div>

            <div class="card-body">
                <br>
                @include('components/alert')
                <div class="mb-4">
                    <form method="GET" action="{{ route('reports.index') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Start Date</label>
                                <input type="text" name="start_date" placeholder="start date"
                                    value="{{ request('start_date') }}" class="form-control datetimepicker_5">
                            </div>
                            <div class="col-md-4">
                                <label>End Date</label>
                                <input type="text" name="end_date" placeholder="End date"
                                    value="{{ request('end_date') }}" class="form-control datetimepicker_5">
                            </div>
                            <div class="col-md-4 mt-4">
                                <button type="submit" class="btn btn-primary">Report</button>
                            </div>
                        </div>
                    </form>
                </div>


                <div class="table-responsive">
                    <table class="table table-bordered w-100">
                        <thead class="thead-light">
                            <tr>
                                <th>Category</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Total Income</td>
                                <td>{{ $incomes }}</td>
                            </tr>
                            <tr>
                                <td>Total Expenses</td>
                                <td>{{ $expenses }}</td>
                            </tr>
                            <tr>
                                <td>Total Salaries</td>
                                <td>{{ $salaries }}</td>
                            </tr>
                            <tr>
                                <th>Net Balance</th>
                                <th>{{ $total }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <!-- END: Page content-->
@endsection
