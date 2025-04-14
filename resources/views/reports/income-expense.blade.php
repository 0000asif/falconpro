@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">Income Expence Report</h5>
            </div>
            <div class="card-body">
                <br>
                @include('components/alert')

                <form action="{{ route('income.report') }}" method="GET" class="mb-4">
                    <div class="row">

                        <!-- Date From Filter -->
                        <div class="col-md-3">
                            <label for="date_from">Date From</label>
                            <input type="text" class="form-control datetimepicker_5" name="date_from" id="date_from"
                                placeholder="Start date" value="{{ request('date_from') }}">
                        </div>

                        <!-- Date To Filter -->
                        <div class="col-md-3">
                            <label for="date_to">Date To</label>
                            <input type="text" class="form-control datetimepicker_5" name="date_to" id="date_to"
                                placeholder="End date" value="{{ request('date_to') }}">
                        </div>

                        <!-- Type Filter -->
                        <div class="col-md-3">
                            <label for="type">Type</label>
                            <select class="form-control" name="type" id="type">
                                <option value="">All</option>
                                <option value="1" {{ request('type') == '1' ? 'selected' : '' }}>Income</option>
                                <option value="2" {{ request('type') == '2' ? 'selected' : '' }}>Expense</option>
                            </select>
                        </div>

                        <!-- Category Filter -->
                        <div class="col-md-3">
                            <label for="category">Category</label>
                            <select class="form-control" name="income_expence_category_id" id="category">
                                <option value="">All Categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('income_expence_category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Project Filter -->
                        <div class="col-md-3">
                            <label for="project">Project</label>
                            <select class="form-control" name="project_id" id="project">
                                <option value="">All Projects</option>
                                @foreach ($projects as $project)
                                    <option value="{{ $project->id }}"
                                        {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                        {{ $project->project_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lead Filter -->
                        <div class="col-md-3">
                            <label for="lead">Customer</label>
                            <select class="form-control" name="lead_id" id="lead">
                                <option value="">All Customer</option>
                                @foreach ($leads as $lead)
                                    <option value="{{ $lead->id }}"
                                        {{ request('lead_id') == $lead->id ? 'selected' : '' }}>
                                        {{ $lead->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <div class="col-md-3 mt-2">
                            <button type="submit" class="btn btn-primary mt-4">Report</button>
                            <a href="{{ route('income.report') }}" class="btn btn-secondary mt-4">Reset</a>
                        </div>
                    </div>
                </form>




                <div class="table-responsive">

                    <table class="table table-bordered w-100">
                        <thead class="thead-light">
                            <tr>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Type</th>
                                <th>Project</th>
                                <th>Customer</th>
                                <th>Income Amount</th>
                                <th>Expense Amount</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                                <tr>
                                    <td>{{ $item->date }}</td>
                                    <td>{{ $item->category->name ?? 'N/A' }}</td>
                                    <td>{{ $item->type == 1 ? 'Income' : 'Expense' }}</td>
                                    <td>{{ $item->project->name ?? 'N/A' }}</td>
                                    <td>{{ $item->lead->name ?? 'N/A' }}</td>
                                    <td>{{ $item->income_amount ?? '-' }}</td>
                                    <td>{{ $item->expence_amount ?? '-' }}</td>
                                    <td>{{ $item->note }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <!-- END: Page content-->
@endsection
