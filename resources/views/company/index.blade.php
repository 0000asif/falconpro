@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">Company List</h5>
                @can('create company')
                    <a href="{{ route('company.create') }}" class="btn btn-success btn-sm">Add New</a>
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
                                <th>Image</th>
                                <th>Name</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Zip Code </th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($companies as $key => $value)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $value->user->name ?? ''}}</td>
                                    <td>
                                        <img src="{{ asset('admin/company/' . $value->image) }}" alt="logo"
                                            style="width: 50px;">
                                    </td>
                                    <td>{{ $value->name }} </td>
                                    <td>{{ $value->city ?? 'N/A' }} </td>
                                    <td>{{ $value->state_id }} </td>
                                    <td>{{ $value->zip_code }} </td>
                                    <td>{{ $value->address }}</td>
                                    <td>
                                        @can('edit company')
                                            @if ($value->status == 0)
                                                <span class="badge badge-danger">InActive</span>
                                            @else
                                                <span class="badge badge-success">Active</span>
                                            @endif
                                        @endcan
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            @can('edit company')
                                                <a href="{{ route('company.edit', $value->id) }}"
                                                class="btn btn-sm btn-warning text-white"><i class="ti-pencil-alt"></i></a>
                                            @endcan

                                            @can('delete company')
                                                <form action="{{ route('company.destroy', $value->id) }}" method="POST"
                                                    id="delete-form-{{ $value->id }}" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete({{ $value->id }})"><i
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
