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

                        {!! Form::open(['route' => 'service.store', 'method' => 'post', 'files' => true]) !!}
                        <div class="row">
                            <!-- Lead ID -->
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Customer</label>
                                    <select class="form-control select2_demo" id="lead_id" name="lead_id">
                                        <option value="">Select an customer</option>
                                        @foreach ($leads as $lead)
                                            <option value="{{ $lead->id }}">{{ $lead->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Employee -->
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Employee</label>
                                    <select class="form-control select2_demo" id="employee_id" name="employee_id">
                                        <option value="">Select an Employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Title -->
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Title<span style="color: red;">*</span></label>
                                    <input class="form-control" type="text" name="title" value=""
                                        placeholder="Title" required>
                                </div>
                            </div>

                            <!-- Charge -->
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Charge<span style="color: red;">*</span></label>
                                    <input class="form-control" type="number" name="charge" value=""
                                        placeholder="Charge" required>
                                </div>
                            </div>

                            <!-- Start Date -->
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Start Date<span style="color: red;">*</span></label>
                                    <input class="form-control datetimepicker_5" type="text" name="start_date"
                                        value="" placeholder="Start Date" required>
                                </div>
                            </div>

                            <!-- Complete Date -->
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Complete Days <span style="color: red;">*</span></label>
                                    <input class="form-control" type="number" name="complete_date" value=""
                                        placeholder="Complete Date">
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control" placeholder="Description">{{ old('description') }}</textarea>
                                </div>
                            </div>

                            <!-- Note -->
                            <div class="col-12">
                                <div class="form-group mb-4">
                                    <label>Note</label>
                                    <textarea name="note" class="form-control" placeholder="Note">{{ old('note') }}</textarea>
                                </div>
                            </div>

                            <!-- Status -->
                            {{-- <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Status<span style="color: red;">*</span></label>
                                    <select class="form-control select2_demo" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>
                            </div> --}}

                        </div>
                        <!-- Submit Button -->
                        <div class="form-group">
                            <button class="btn btn-primary mr-2" type="submit" id="collection_button">Submit</button>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </div><!-- END: Page content-->
@endsection
