@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Create Client</h5>
                        <a href="{{ route('client.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        <form action="{{ route('client.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <!-- Name -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="name" id="name"
                                            placeholder="Enter Name" required>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Email<span style="color: red;">*</span></label>
                                        <input class="form-control" type="email" name="email" id="email"
                                            placeholder="Enter email" required>
                                    </div>
                                </div>

                                <!-- Name -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Contract Number<span style="color: red;">*</span></label>
                                        <input class="form-control" type="number" name="phone" id="phone"
                                            placeholder="Enter Contract Number" step="any" required>
                                    </div>
                                </div>

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

                                <!-- City Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="city_id">Enter City</label>
                                        <input type="text" name="city_id" id="city_id" class="form-control"
                                            placeholder="Enter city">
                                    </div>
                                </div>

                                <!-- State Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="state_id">Enter State<span style="color: red;">*</span></label>
                                        <input required type="text" name="state_id" id="state_id" class="form-control"
                                            placeholder="Enter State name">
                                    </div>
                                </div>

                                <!-- Zip Code -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="zip_code">Zip Code<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="zip_code" id="zip_code"
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
