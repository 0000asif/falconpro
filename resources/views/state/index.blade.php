@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">State List</h5>
                <a href="{{ route('state.create') }}" class="btn btn-success btn-sm">Add New</a>
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
                                <th>City</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($states as $key => $value)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $value->user->name }}</td>
                                    <td>{{ $value->city->name }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>
                                        <form action="{{ route('state.destroy', $value->id) }}" method="POST"
                                            id="delete-form-{{ $value->id }}" style="display:inline-block;">
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
