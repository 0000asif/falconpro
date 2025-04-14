@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Create Income</h5>
                        <a href="{{ route('income.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        {!! Form::open(['route' => 'income.store', 'method' => 'post', 'files' => true]) !!}
                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Income Category<span style="color: red;">*</span></label>
                                    <select class="form-control select2_demo" id="income_expence_category_id"
                                        name="income_expence_category_id" required>
                                        <option value="">Select an Option</option>
                                        @foreach ($categories as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Payment Method<span style="color: red;">*</span></label>
                                    <select class="form-control select2_demo" id="payment_method_id"
                                        name="payment_method_id" required>
                                        <option value="">Select an Option</option>
                                        @foreach ($methods as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Projects</label>
                                    <select class="form-control select2_demo" id="project_id" name="project_id">
                                        <option value="">Select an Option</option>
                                        @foreach ($projects as $value)
                                            <option value="{{ $value->id }}">{{ $value->project_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Customer</label>
                                    <select class="form-control select2_demo" id="customer_id" name="lead_id">
                                        <option value="">Select an Option</option>
                                        @foreach ($leads as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Date <span style="color: red;">*</span> </label>
                                    <input class="form-control datetimepicker_5" type="text" name="date"
                                        value="" placeholder="Date" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Amount <span style="color: red;">*</span></label>
                                    <input type="number" name="income_amount" id="" class="form-control"
                                        placeholder="Enter Amount">
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Reference </label>
                                    <input class="form-control" placeholder="If any reference" type="text"
                                        name="reference">
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Note</label>
                                    <textarea name="note" class="form-control">{{ old('note') }}</textarea>
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
