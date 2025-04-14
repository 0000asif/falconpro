@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">Comments List</h5>
            </div>
            <div class="card-body">
                <br>
                @include('components/alert')
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="dt-responsive">

                        <thead class="thead-light">
                            <tr>
                                <th>SL</th>
                                <th>Work Order Number</th>
                                <th>Content</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($notes as $key => $note)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $note->workorder->work_order_number }}</td>
                                    <td>{{ $note->content }}</td>
                                    <td>
                                        @if ($note->status == 0)
                                            <span class="badge badge-danger">InActive</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                    <td>{{ $note->user->name }}</td>
                                    <td>{{ date('m-d-Y H:i:s', strtotime($note->created_at)) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('note.edit', $note->id) }}"
                                                class="btn btn-sm btn-warning text-white"><i class="ti-pencil-alt"></i></a>

                                            <form action="{{ route('note.destroy', $note->id) }}" method="POST"
                                                id="delete-form-{{ $note->id }}" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $note->id }})"><i class="fa fa-trash"></i>
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
