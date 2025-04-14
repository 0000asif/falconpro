@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Create Vendor</h5>
                        <a href="{{ route('vandors.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        <form action="{{ route('vandors.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <!-- Name -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="name" id="name"
                                            placeholder="Enter Name" value="{{old('name')}}" required>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Email<span style="color: red;">*</span></label>
                                        <input class="form-control" type="email" name="email" id="email"
                                            placeholder="Enter email" value="{{old('email')}}" required>
                                    </div>
                                </div>

                                <!-- phone -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Contract Number<span style="color: red;">*</span></label>
                                        <input class="form-control" type="number" name="phone" id="phone"
                                            placeholder="Enter Contract Number" value="{{old('phone')}}" step="any" required>
                                    </div>
                                </div>

                                <!-- Company Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="city_id">Select Company<span style="color: red;">*</span></label>
                                        <select class="form-control select2_demo" name="company_id" id="company_id"
                                            required>
                                            <option value="">Select Conpany</option>
                                            @foreach ($company as $value)
                                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- expertise Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="expertise">Expertise</label>
                                        <input type="text" value="{{old('expertise')}}" name="expertise" id="expertise" class="form-control"
                                            placeholder="Enter Expertise ">

                                    </div>
                                </div>

                                <!-- City Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="city_id">Enter City</label>
                                        <input type="text" value="{{old('city_id')}}" name="city_id" id="city_id" class="form-control"
                                            placeholder="Enter city">
                                    </div>
                                </div>

                                <!-- State Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="state_id">Enter State<span style="color: red;">*</span></label>
                                        <input required type="text" value="{{old('state_id')}}" name="state_id" id="state_id" class="form-control"
                                            placeholder="Enter State name">
                                    </div>
                                </div>

                                <!-- Zip Code -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="zip_code">Zip Code<span style="color: red;">*</span></label>
                                        <input class="form-control" value="{{old('zip_code')}}" type="text" name="zip_code" id="zip_code"
                                            placeholder="Enter Zip Code" required>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="address">Address<span style="color: red;">*</span></label>
                                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter Address" required></textarea>
                                    </div>
                                </div>


                                <!-- Status Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="1" selected>Active</option>
                                            <option value="0">Inactive</option>
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

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div><!-- END: Page content-->
@endsection
