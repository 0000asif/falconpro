@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Edit Employee</h5>
                        <a href="{{ route('employee.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        {!! Form::open(['route' => ['employee.update', $member->id], 'method' => 'put', 'files' => true]) !!}
                        <div class="row">

                            <!-- Company Dropdown -->
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="company_id">Select Company</label>
                                    <select class="form-control select2_demo" name="company_id" id="company_id">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ $member->company_id == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Employee Name<span style="color: red;">*</span> </label>
                                    <input class="form-control" type="text" name="name"
                                        value="{{ old('name', $member->name) }}" placeholder="Employee Name" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Employee Email<span style="color: red;">*</span> </label>
                                    <input class="form-control" type="email" name="email"
                                        value="{{ old('email', $member->email) }}" placeholder="Employee Email" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Phone Number<span style="color: red;">*</span> </label>
                                    <input class="form-control" type="number" name="phone"
                                        value="{{ old('phone', $member->phone) }}" placeholder="Phone Number" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Join Date <span style="color: red;">*</span> </label>
                                    <input class="form-control datetimepicker_5" type="text"
                                        value="{{ date('m-d-Y', strtotime($member->join_date)) }}" readonly disabled
                                        placeholder="Date">
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Salary<span style="color: red;">*</span> </label>
                                    <input class="form-control" type="number" name="salary" value="{{ $member->salary }}"
                                        placeholder="Salary">
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Designation<span style="color: red;">*</span></label>
                                    <select class="form-control select2_demo" id="designation_id" name="designation_id"
                                        required>
                                        <option value="">Select an Option</option>
                                        @foreach ($positions as $value)
                                            <option value="{{ $value->id }}"
                                                {{ $member->designation_id == $value->id ? 'selected' : '' }}>
                                                {{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Role </label>
                                    <select name="user_role" class="form-control" required>
                                        <option>Select One</option>
                                        @foreach ($role_permissions as $role)
                                            <option value="{{$role->name}}">{{$role->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Employee Photo </label>
                                    <input class="form-control" type="file" name="image" value=""
                                        placeholder="Employee Name">

                                    <div class="mt-4">
                                        @if ($member->image)
                                            <img src="{{ asset('/admin/employee/' . $member->image) }}"
                                                alt="{{ __('image') }}" width="150px">
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Description</label>
                                    <textarea name="description" class="form-control">{{ old('description', $member->description) }}</textarea>
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
    </div>
    <!-- END: Page content-->
@endsection
