@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Create Company</h5>
                        <a href="{{ route('company.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <!-- City Dropdown -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="city_id">Enter City</label>
                                        <input type="text" name="city" id="city_id" class="form-control"
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

                                <!-- Employee Photo -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="image">Company logo<span style="color: red;">*</span></label>
                                        <input class="form-control" type="file" name="image" id="image" required>
                                    </div>
                                </div>
                                <!-- Name -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="name" id="name"
                                            placeholder="Enter Name" required>
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

@section('script')
    <script>
        $(document).ready(function() {
            // Add new row
            $(document).on('click', '.add-row', function() {
                let newRow = `
      <div class="payment-row">
        <select name="payment_method[]" class="form-control">
          <option value="">Select Payment Method</option>
          <option value="cash">Cash</option>
          <option value="credit">Credit</option>
        </select>
        <select name="account[]" class="form-control">
          <option value="">Select Account</option>
          <option value="cash_account">Cash Account</option>
          <option value="credit_account">Credit Account</option>
        </select>
        <input type="number" name="amount[]" class="form-control" placeholder="Amount" />
                    <button type="button" class="btn btn-danger delete-row"><i class="fa fa-trash"></i></button>
                    <button type="button" class="btn btn-success add-row"><i class="fa fa-plus"></i></button>
      </div>
    `;
                $('#payment-methods').append(newRow);
            });

            // Delete row
            $(document).on('click', '.delete-row', function() {
                $(this).closest('.payment-row').remove();
            });
        });
    </script>
@endsection
