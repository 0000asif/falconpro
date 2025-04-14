@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Create payment method</h5>
                        <a href="{{ route('payment_method.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        {!! Form::open(['route' => 'payment_method.store', 'method' => 'post', 'files' => true]) !!}
                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Method Name<span style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Method Name" type="text" name="name"
                                        value="{{ old('name') }}" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Branch Name</label>
                                    <input class="form-control" placeholder="Branch Name" type="text" name="branch_name"
                                        value="{{ old('branch_name') }}">
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Account Number<span style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Account Number" type="number"
                                        name="account_number" value="{{ old('account_number') }}" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Balance<span style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Account Balance" type="number" name="balance"
                                        value="{{ old('balance') }}" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Opening Date<span style="color: red;">*</span></label>
                                    <input class="form-control datetimepicker_5" type="text"  placeholder="Opening date" name="opening_date"
                                        value="{{ date('m-d-Y') }}" required>
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
