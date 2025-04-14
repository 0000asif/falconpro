@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">All payment methods</h5>
                @can('create payment method')
                    <a href="{{ route('payment_method.create') }}" class="btn btn-success btn-sm">Create method</a>
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
                                <th>Created By</th>
                                <th>Name</th>
                                <th>Branch name</th>
                                <th>Account Number</th>
                                <th>Blance</th>
                                <th>Opening date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($methods as $key => $value)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $value->user->name }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->branch_name ?? 'N/A' }}</td>
                                    <td>{{ $value->account_number }}</td>
                                    <td>{{ $value->balance }}</td>
                                    <td>{{ date('m-d-Y', strtotime($value->opening_date)) }}</td>
                                    <th>
                                        @can('delete payment method')
                                            <form action="{{ route('payment_method.destroy', $value->id) }}" method="POST"
                                                id="delete-form-{{ $value->id }}" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $value->id }})"><i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
                                    </th>
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
