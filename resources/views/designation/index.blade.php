@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">All Designation</h5>
                @can('create designation')
                    <a href="{{ route('designation.create') }}" class="btn btn-success btn-sm">Create Designation</a>
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
                                @can('delete designation')
                                    <th>Action</th>
                                @endcan
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($designations as $key => $value)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $value->user->name }}</td>
                                    <td>{{ $value->name }}</td>
                                    <th>
                                        @can('delete designation')
                                            <form action="{{ route('designation.destroy', $value->id) }}" method="POST"
                                                id="delete-form-{{ $value->id }}" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $value->id }})"><i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
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
