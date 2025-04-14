@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">Type List</h5>
                @can('create type')
                    <a href="{{ route('type.create') }}" class="btn btn-success btn-sm">Add New</a>
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
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($types as $key => $value)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $value->user->name }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>
                                        @if ($value->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('edit type')
                                            <a href="{{ route('type.edit', $value->id) }}"
                                                class="btn btn-sm btn-warning text-white"><i class="ti-pencil-alt"></i>
                                            </a>
                                        @endcan

                                        @can('delete type')
                                            <form action="{{ route('type.destroy', $value->id) }}" method="POST"
                                                id="delete-form-{{ $value->id }}" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $value->id }})"><i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endcan
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
