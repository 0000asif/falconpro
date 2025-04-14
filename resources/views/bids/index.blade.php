@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="box-title">Bids List</h5>
                <a href="{{ route('bids.create') }}" class="btn btn-success btn-sm">Add New</a>
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
                                <th>Total Qty</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($bids as $key => $value)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $value->user->name }}</td>
                                    <td>
                                        @if ($value->image)
                                            <img src="{{ asset('admin/bids/' . $value->image) }}" width="100px"
                                                alt="img">
                                        @else
                                            N/A
                                        @endif

                                    </td>
                                    <td>{{ $value->total_qty }} </td>
                                    <td>{{ $value->total_amount }} </td>
                                    <td>
                                        @if ($value->status == '1')
                                            <div class="badge badge-success">Active</div>
                                        @else
                                            <div class="badge badge-danger">Inactive</div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('bids.show', $value->id) }}"
                                                class="btn btn-sm btn-primary text-white"><i class="ti-eye"></i></a>

                                            <a href="{{ route('bids.edit', $value->id) }}"
                                                class="btn btn-sm btn-warning text-white"><i class="ti-pencil-alt"></i></a>

                                            <form action="{{ route('bids.destroy', $value->id) }}" method="POST"
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
