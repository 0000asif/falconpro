@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Make Salary</h5>
                        <a href="{{ route('salary.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        {!! Form::open(['route' => 'salary.store', 'method' => 'post', 'id' => 'salaryForm', 'files' => true]) !!}
                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="staff_id">Select Employee <span style="color: red;">*</span></label>
                                    <select name="employee_id" class="form-control select2_demo" id="staff_id" required>
                                        <option value="">Select One Option</option>
                                        @foreach ($staff as $employee)
                                            <option value="{{ $employee->id }}" data-salary="{{ $employee->salary }}">
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Salary Amount</label>
                                    <input type="number" readonly disabled id="salary" class="form-control">
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
                                    <label for="year">Year <span style="color: red;">*</span></label>
                                    <select name="payment_year" id="year" class="form-control select2_demo" required>
                                        <option value="">Select an Option</option>
                                        @for ($i = now()->year; $i >= now()->year - 5; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="month">Month <span style="color: red;">*</span></label>
                                    <select name="payment_month" id="month" class="form-control select2_demo" required>
                                        <option value="">Select an Option</option>
                                        @foreach (range(1, 12) as $m)
                                            <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 10)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Amount <span style="color: red;">*</span></label>
                                    <input type="number" name="salary_amount" id="amount" class="form-control"
                                        placeholder="Enter Amount">
                                </div>
                            </div>


                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Bonous </label>
                                    <input type="number" name="bonous" id="" class="form-control"
                                        placeholder="If want">
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Date <span style="color: red;">*</span> </label>
                                    <input class="form-control datetimepicker_5" type="text" name="payment_date"
                                        value="{{ date('m-d-Y') }}" placeholder="Date" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>note</label>
                                    <textarea name="note" class="form-control">{{ old('description') }}</textarea>
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

@section('script')
    <script>
        // jQuery
        $(document).ready(function() {
            $('#staff_id').on('change', function() {
                const selectedOption = $(this).find(':selected');
                const salary = parseFloat(selectedOption.data('salary')) || 0;

                // Update the salary field (assuming there's an input field with ID 'salary')
                $('#salary').val(salary.toFixed(2)); // Fixed to 2 decimal places
            });

            $('#amount').on('keyup', function() {
                let amount = $(this).val();
                let due_amount = parseFloat($('#salary').val());
                if (amount > due_amount) {
                    alert('Enter valid amount');
                    $('#amount').val('');
                }
            });

        });
    </script>
@endsection
