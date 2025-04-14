@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Create Service</h5>
                        <a href="{{ route('service.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        <form action="{{ route('service.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Lead Selection -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-4">
                                        <label>Lead Name <span style="color: red;">*</span></label>
                                        <select name="lead_id" class="form-control select2_demo">
                                            <option value="">Select Lead</option>
                                            @foreach ($leads as $lead)
                                                <option value="{{ $lead->id }}"
                                                    {{ $task->lead_id == $lead->id ? 'selected' : '' }}>
                                                    {{ $lead->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Employee Selection -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-4">
                                        <label>Employee Name <span style="color: red;">*</span></label>
                                        <select name="employee_id" class="form-control select2_demo">
                                            <option value="">Select Employee</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"
                                                    {{ $task->employee_id == $employee->id ? 'selected' : '' }}>
                                                    {{ $employee->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Task Title -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-4">
                                        <label>Task Title <span style="color: red;">*</span></label>
                                        <input type="text" name="title" class="form-control"
                                            value="{{ $task->title }}" placeholder="Task Title" required>
                                    </div>
                                </div>

                                <!-- Charge -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-4">
                                        <label>Task Charge <span style="color: red;">*</span></label>
                                        <input type="number" name="charge" class="form-control"
                                            value="{{ $task->charge }}" placeholder="Task Charge" required>
                                    </div>
                                </div>

                                <!-- Start Date -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-4">
                                        <label>Start Date <span style="color: red;">*</span></label>
                                        <input type="text " name="start_date" class="form-control datetimepicker_5"
                                            value="{{ date('d-m-Y', strtotime($task->start_date)) }}" required>
                                    </div>
                                </div>

                                <!-- Completion Date -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-4">
                                        <label>Completion Date</label>
                                        <input type="number" name="complete_date" class="form-control"
                                            value="{{ $task->complete_date }}">
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label>Description</label>
                                        <textarea name="description" class="form-control" placeholder="Task Description">{{ $task->description }}</textarea>
                                    </div>
                                </div>

                                <!-- Note -->
                                <div class="col-12">
                                    <div class="form-group mb-4">
                                        <label>Note</label>
                                        <textarea name="note" class="form-control" placeholder="Additional Notes">{{ $task->note }}</textarea>
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-4">
                                        <label>Status <span style="color: red;">*</span></label>
                                        <select name="status" class="form-control" required>
                                            <option value="0" {{ $task->status == '0' ? 'selected' : '' }}>
                                                Pending</option>
                                            <option value="1" {{ $task->status == '1' ? 'selected' : '' }}>In Progress
                                            </option>
                                            <option value="2" {{ $task->status == '2' ? 'selected' : '' }}>
                                                Completed</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </form>



                    </div>
                </div>
            </div>
        </div>
    </div><!-- END: Page content-->
@endsection
