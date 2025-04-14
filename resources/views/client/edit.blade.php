@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Edit Client</h5>
                        <a href="{{ route('client.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')
                        <form action="{{ route('client.update', $client->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                <!-- Name -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="name" id="name"
                                            value="{{ old('name', $client->name) }}" placeholder="Enter Name" required>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email<span style="color: red;">*</span></label>
                                        <input class="form-control" type="email" name="email" id="email"
                                            value="{{ old('email', $client->email) }}" placeholder="Enter Email" required>
                                    </div>
                                </div>

                                <!-- Contact Number -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="phone">Contact Number<span style="color: red;">*</span></label>
                                        <input class="form-control" type="number" name="phone" id="phone"
                                            value="{{ old('phone', $client->phone) }}" placeholder="Enter Contact Number"
                                            required>
                                    </div>
                                </div>

                                <!-- Company Dropdown -->
                                <div class="col-12 col-md-6">
                                    <label for="company_id">Select Company</label>
                                    <select class="form-control select2_demo" name="company_id" id="company_id">
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ old('company_id', $client->company_id) == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- City Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="city_id">Enter City</label>
                                        <input type="text" name="city_id" id="city_id" class="form-control"
                                            value="{{ $client->city_id }}" placeholder="Enter city">
                                    </div>
                                </div>

                                <!-- State Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="state_id">Enter State</label>
                                        <input required type="text" name="state_id" id="state_id" class="form-control"
                                            value="{{ $client->state_id }}" placeholder="Enter State name">
                                    </div>
                                </div>

                                <!-- Zip Code -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="zip_code">Zip Code<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="zip_code" id="zip_code"
                                            value="{{ old('zip_code', $client->zip_code) }}" placeholder="Enter Zip Code"
                                            required>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="address">Address<span style="color: red;">*</span></label>
                                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter Address" required>{{ old('address', $client->address) }}</textarea>
                                    </div>
                                </div>

                                <!-- Status Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="1"
                                                {{ old('status', $client->status) == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0"
                                                {{ old('status', $client->status) == 0 ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>

                            </div>


                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Page content-->
@endsection
