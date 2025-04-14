@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">Income/Expence Category List</h5>
                <a href="{{ route('IEcategory.create') }}" class="btn btn-success btn-sm">Create Category</a>
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
                                <th>Category Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($data as $key => $value)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $value->user->name }}</td>
                                    <td>{{ $value->name }}</td>
                                    <td>
                                        @if ($value->status == 0)
                                            <span class="badge badge-danger">InActive</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                    <th>
                                        <a href="{{ route('IEcategory.edit', $value->id) }}"
                                            class="btn btn-sm btn-warning text-white"><i class="ti-pencil-alt"></i></a>

                                        <form action="{{ route('IEcategory.destroy', $value->id) }}" method="POST"
                                            id="delete-form-{{ $value->id }}" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm"
                                                onclick="confirmDelete({{ $value->id }})"><i class="fa fa-trash"></i>
                                            </button>
                                        </form>

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
