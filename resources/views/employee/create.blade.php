@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Create Employee</h5>
                        <a href="{{ route('employee.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        {!! Form::open(['route' => 'employee.store', 'method' => 'post', 'files' => true]) !!}
                        <div class="row">

                            <!-- Company Dropdown -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="company_id">Select Company</label>
                                    <select class="form-control select2_demo" name="company_id" id="company_id">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Employee Name<span style="color: red;">*</span> </label>
                                    <input class="form-control" type="text" name="name" value="{{ old('name') }}"
                                        placeholder="Employee Name" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Employee Email<span style="color: red;">*</span> </label>
                                    <input class="form-control" type="email" name="email" value="{{ old('email') }}"
                                        placeholder="Employee Email" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Join Date <span style="color: red;">*</span> </label>
                                    <input class="form-control datetimepicker_5" type="text" name="join_date"
                                        value="{{ date('m-d-Y') }}" placeholder="Date" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Phone Number<span style="color: red;">*</span> </label>
                                    <input class="form-control" type="number" name="phone" value="{{ old('phone') }}"
                                        placeholder="Phone Number" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Salary<span style="color: red;">*</span> </label>
                                    <input class="form-control" type="number" name="salary" value="{{ old('salary') }}"
                                        placeholder="Salary" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Employee Photo </label>
                                    <input class="form-control" type="file" name="image" value="{{ old('image') }}"
                                        placeholder="Employee Name">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Designation<span style="color: red;">*</span></label>
                                    <select class="form-control select2_demo" id="designation_id" name="designation_id"
                                        required>
                                        <option value="">Select an Option</option>
                                        @foreach ($positions as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role <span class="text-danger">*</span></label>
                                    <select name="user_role" class="form-control" required>
                                        <option>Select One</option>
                                        @foreach ($role_permissions as $role)
                                            <option value="{{$role->name}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                        </div>


                        <div class="form-group"><button class="btn btn-primary mr-2" type="submit"
                                id="collection_button">Submit</button></div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END: Page content-->
@endsection