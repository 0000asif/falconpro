@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Edit Company</h5>
                        <a href="{{ route('company.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        <form action="{{ route('company.update', $entry->id) }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">

                                <!-- City Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="city_id">Enter City</label>
                                        <input type="text" name="city" id="city_id" class="form-control"
                                            value="{{ $entry->city }}" placeholder="Enter city">
                                    </div>
                                </div>

                                <!-- State Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="state_id">Enter State<span style="color: red;">*</span></label>
                                        <input required type="text" name="state_id" id="state_id" class="form-control"
                                            value="{{ $entry->state_id }}" placeholder="Enter State name">
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-4">
                                        <label>Company Logo<span style="color: red;">*</span> </label>
                                        <input class="form-control" type="file" name="image" value=""
                                            placeholder="Company Logo">

                                        <div class="mt-4">
                                            <img src="{{ asset('/admin/company/' . $entry->image) }}"
                                                alt="{{ __('logo') }}" width="150px" alt="file not found">
                                        </div>

                                    </div>
                                </div>
                                <!-- Name -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="name" id="name"
                                            placeholder="Enter Name" value="{{ $entry->name }}" required>
                                    </div>
                                </div>

                                <!-- Zip Code -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="zip_code">Zip Code<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="zip_code" id="zip_code"
                                            placeholder="Enter Zip Code" value="{{ $entry->zip_code }}" required>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="address">Address<span style="color: red;">*</span></label>
                                        <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter Address" required>{{ $entry->address }}</textarea>
                                    </div>
                                </div>

                                <!-- Status Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="1" {{ $entry->status == '1' ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $entry->status == '0' ? 'selected' : '' }}>Inactive
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
