@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">All Field</h5>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        {!! Form::open(['id' => 'collection','method' => 'post','files' => true]) !!}
                            <div class="row">

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-4">
                                        <label>Select Bank<span style="color: red;">*</span></label>
                                        <select class="form-control select2_demo" id="bank_id" name="bank_id" required>
                                            <option value="">Select an option</option>
                                            
                                            <option value="1">Option 1</option>
                                            <option value="1">Option 1</option>
                                            <option value="1">Option 1</option>
                                            <option value="1">Option 1</option>
        
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-4">
                                        <label>Bank Balance<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="bank_balance" value="" readonly>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-4">
                                        <label>Deposit Amount <span style="color: red;">*</span></label>
                                        <input class="form-control" type="number" step="any" name="deposit_amount" required>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-4">
                                        <label>Confirm Deposit Amount <span style="color: red;">*</span></label>
                                        <input class="form-control" type="number" step="any" name="confirm_deposit_amount" required>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-4">
                                        <label>Transaction Note </label>
                                        <textarea name="tranaction_note" class="form-control">{{ old('tranaction_note') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-4">
                                        <label>Remarks </label>
                                        <textarea name="remarks" class="form-control">{{ old('remarks') }}</textarea>
                                    </div>
                                </div>

                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-4">
                                        <label>Transaction Date <span style="color: red;">*</span></label>
                                        <input class="form-control datetimepicker_5" type="text" name="transaction_date" value="{{ date("d-m-Y") }}" required>
                                    </div>
                                </div>


                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-4">
                                        <label>Transaction Date & Time <span style="color: red;">*</span></label>
                                        <input class="form-control" id="datetimepicker_1" type="text" name="transaction_date"  required>
                                    </div>
                                </div>

                            </div>


                            <div class="form-group"><button class="btn btn-primary mr-2" type="submit" id="collection_button">Submit</button></div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END: Page content-->
@endsection
