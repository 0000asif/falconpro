@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">View Service</h5>
                        <a href="{{ route('service.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        <br>
                        @include('components/alert')
                        <div class="table-responsive">
                            <table class="table table-bordered w-100">
                                <tbody>
                                    <tr>
                                        <th>Created By</th>
                                        <td>{{ $task->user->name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Lead Name</th>
                                        <td>{{ $task->lead->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Employee Name</th>
                                        <td>{{ $task->staff->name ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Task Title</th>
                                        <td>{{ $task->title }}</td>
                                    </tr>
                                    <tr>
                                        <th>Task Charge</th>
                                        <td>{{ $task->charge }}</td>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <td>{{ date('d-m-Y', strtotime($task->start_date)) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Completion Day</th>
                                        <td>
                                            {{ $task->complete_date }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td>{{ $task->description }}</td>
                                    </tr>
                                    <tr>
                                        <th>Note</th>
                                        <td>{{ $task->note }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            @if ($task->status == '0')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif ($task->status == '1')
                                                <span class="badge badge-primary">In Progress</span>
                                            @elseif ($task->status == '2')
                                                <span class="badge badge-success">Completed</span>
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
    <!-- END: Page content-->
@endsection
