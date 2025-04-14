@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">Income List</h5>
                <a href="{{ route('income.create') }}" class="btn btn-success btn-sm">Create Income</a>
            </div>
            <div class="card-body">
                <br>
                @include('components/alert')
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="dt-responsive">

                        <thead class="thead-light">
                            <tr>
                                <th>SL</th>
                                <th>Created By</th>
                                <th>Category</th>
                                <th>Payment Method</th>
                                <th>Project</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>amount</th>
                                <th>note</th>
                                <th>reference</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($incomes as $key => $value)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $value->user->name }}</td>
                                    <td>{{ $value->category->name }}</td>
                                    <td>{{ $value->paymentmethod->name }}</td>
                                    <td>{{ $value->project->project_name ?? 'N/A' }}</td>
                                    <td>{{ $value->lead->name ?? 'N/A' }}</td>
                                    <td>{{ date('d-m-Y', strtotime($value->date)) }}</td>
                                    <td>{{ $value->income_amount }} </td>
                                    <td>{{ $value->note ?? 'N/A' }}</td>
                                    <td>{{ $value->reference ?? 'N/A' }}</td>

                                    <td>
                                        <form action="{{ route('income.destroy', $value->id) }}" method="POST"
                                            id="delete-form-{{ $value->id }}" >
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $value->id }})"><i class="fa fa-trash"></i>
                                            </button>
                                        </form>
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
