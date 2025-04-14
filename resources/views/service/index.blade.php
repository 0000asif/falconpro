@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">Employee List</h5>
                <a href="{{ route('service.create') }}" class="btn btn-success btn-sm">Add New</a>
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
                                <th>Title</th>
                                <th>charge</th>
                                <th>Description</th>
                                <th>note</th>
                                <th>Start date</th>
                                <th>Complete day</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($services as $key => $value)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $value->user->name }}</td>
                                    <td>{{ $value->title }} </td>
                                    <td>{{ $value->charge }} </td>
                                    <td>{{ $value->description }} </td>
                                    <td>{{ $value->note }}</td>
                                    <td>{{ date('d-m-Y', strtotime($value->start_date)) }}</td>
                                    <td>{{ $value->complete_date }} </td>
                                    <td>
                                        @if ($value->status == 0)
                                            <span class="badge badge-danger">Pending</span>
                                        @elseif ($value->status == 1)
                                            <span class="badge badge-primary">In Progress</span>
                                        @else
                                            <span class="badge badge-success">Complete</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">

                                            <a href="{{ route('service.show', $value->id) }}"
                                                class="btn btn-sm btn-info text-white">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a href="{{ route('service.edit', $value->id) }}"
                                                class="btn btn-sm btn-warning text-white">
                                                <i class="ti-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('service.destroy', $value->id) }}" method="POST"
                                                id="delete-form-{{ $value->id }}" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $value->id }})"><i
                                                        class="fa fa-trash"></i>
                                                </button>
                                            </form>
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
