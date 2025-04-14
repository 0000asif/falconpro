@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Edit workOrder</h5>
                        <a href="{{ Route('work-order.index') }}" class="btn btn-sm btn-success">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        {!! Form::model($workOrder, [
                            'route' => ['work-order.update', $workOrder->id],
                            'method' => 'put',
                            'files' => true,
                        ]) !!}

                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Work Order Number<span style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="Work Order Number" type="text"
                                        name="work_order_number"
                                        value="{{ old('work_order_number', $workOrder->work_order_number) }}" required>
                                </div>
                            </div>

                            <!-- Company Dropdown -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="company_id">Select Company<span style="color: red;">*</span></label>
                                    <select class="form-control select2_demo" name="company_id" id="company_id" required>
                                        <option value="">Select Company</option>
                                        @foreach ($companies as $company)
                                            <option value="{{ $company->id }}"
                                                {{ $workOrder->company_id == $company->id ? 'selected' : '' }}>
                                                {{ $company->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Client Dropdown -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="client_id">Select Client<span style="color: red;">*</span></label>
                                    <select class="form-control select2_demo" name="client_id" id="client_id" required>
                                        <option value="">Select Client</option>
                                        @foreach ($clients as $client)
                                            <option value="{{ $client->id }}"
                                                {{ $workOrder->client_id == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Vendor Dropdown -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="vendor_id">Select Vendor<span style="color: red;">*</span></label>
                                    <select class="form-control select2_demo" name="vendor_id" id="vendor_id">
                                        <option value="">Select Vendor</option>
                                        @foreach ($vendors as $vendor)
                                            <option value="{{ $vendor->id }}"
                                                {{ $workOrder->vendor_id == $vendor->id ? 'selected' : '' }}>
                                                {{ $vendor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- State Dropdown -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="state_id">Enter State<span style="color: red;">*</span></label>
                                    <input required type="text" name="state_id" id="state_id" class="form-control"
                                        value="{{ $workOrder->state_id }}" placeholder="Enter State name">
                                </div>
                            </div>

                            <!-- Zip Code -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="zip_code">Zip Code<span style="color: red;">*</span></label>
                                    <input class="form-control" type="text" name="zip_code" id="zip_code"
                                        placeholder="Enter Zip Code" value="{{ old('zip_code', $workOrder->zip_code) }}"
                                        required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>File </label>
                                    <input type="file" class="form-control" name="file">
                                </div>
                                <div class="mt-2">

                                    @if ($workOrder->file)
                                        <p>Current File</p>
                                        <a href="{{ asset('public/images/work-order/' . $workOrder->file) }}"
                                            download="" class="btn btn-success btn-sm">Download</a>
                                    @endif
                                </div>
                            </div>

                            <!-- Address -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="address">Address<span style="color: red;">*</span></label>
                                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Enter Address" required>{{ old('address', $workOrder->address) }}</textarea>
                                </div>
                            </div>

                            <!-- Dynamic Rows for Work Info -->
                            <div class="mt-4 col-12">
                                <div class="card shadow">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Work Info Management</h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Dynamic Rows -->
                                        <div id="dynamic-rows">
                                            <!-- Existing Items -->
                                            @foreach ($workOrder->items as $item)
                                                <div class="row dynamic-row align-items-center mb-3">
                                                    <!-- Type -->
                                                    <div class="col-md-2">
                                                        <label for="type" class="form-label">Type</label>
                                                        <select name="type[]" class="form-control">
                                                            <option value="">Select Type</option>
                                                            @foreach ($types as $type)
                                                                <option value="{{ $type->id }}"
                                                                    {{ $item->type_id == $type->id ? 'selected' : '' }}>
                                                                    {{ $type->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <!-- Description -->
                                                    <div class="col-md-3">
                                                        <label for="description" class="form-label">Description</label>
                                                        <textarea name="description[]" class="form-control" rows="2">{{ old('description', $item->description) }}</textarea>
                                                    </div>

                                                    <!-- Quantity -->
                                                    <div class="col-md-1">
                                                        <label for="qty" class="form-label">Qty</label>
                                                        <input type="number" step="any" name="qty[]"
                                                            class="form-control qty"
                                                            value="{{ old('qty', $item->qty) }}" />
                                                    </div>

                                                    <!-- Unit Price -->
                                                    <div class="col-md-2">
                                                        <label for="unit_price" class="form-label">Unit Price</label>
                                                        <input type="number" name="unit_price[]" step="any"
                                                            class="form-control unit_price"
                                                            value="{{ old('unit_price', $item->unit_price) }}" />
                                                    </div>

                                                    <!-- Total Price -->
                                                    <div class="col-md-2">
                                                        <label for="total_price" class="form-label">Total Price</label>
                                                        <input type="text" name="total_price[]"
                                                            class="form-control total_price"
                                                            value="{{ old('total_price', $item->total_price) }}"
                                                            readonly />
                                                    </div>

                                                    <!-- Actions -->
                                                    <div class="col-md-2 text-center">
                                                        <label class="form-label d-block">&nbsp;</label>
                                                        <button type="button" class="btn btn-success add-row me-2">
                                                            <i class="fa fa-plus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-danger delete-row">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach


                                        </div>

                                        <!-- Grand Total -->
                                        <div class="row mt-4">
                                            <div class="col-md-8 text-end">
                                                <h5 class="mb-0">Grand Total:</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" id="grand_total"
                                                    class="form-control text-center fw-bold" readonly />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @foreach ($workOrder->items as $item)
                                    <div class="row dynamic-row align-items-center mb-3">
                                        <input type="hidden" name="item_id[]" value="{{ $item->id }}">
                                        <!-- rest of your row -->
                                    </div>
                                @endforeach
                            </div>

                            <!-- Status Dropdown -->
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="status">Status<span style="color: red;">*</span></label>
                                    <select class="form-control select2_demo" name="status_id" id="status" required>
                                        <option value="">Slecct an option</option>
                                        @foreach ($status as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $workOrder->status_id ? 'selected' : '' }}>
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Due Date -->
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="due_date">Due Date<span style="color: red;">*</span></label>
                                    <input type="text" class="form-control datetimepicker_5"
                                        value="{{ old('due_date', date('m-d-Y', strtotime($workOrder->due_date))) }}"
                                        name="due_date" id="due_date" required>
                                </div>
                            </div>

                        </div>

                        <div class="form-group"><button class="btn btn-primary mr-2" type="submit"
                                id="collection_button">Update</button></div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END: Page content-->
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            const dynamicRows = $('#dynamic-rows');
            const grandTotalField = $('#grand_total');

            // Add new row
            dynamicRows.on('click', '.add-row', function() {
                const newRow = $(this).closest('.dynamic-row').clone();

                // Clear inputs in the cloned row
                newRow.find('input').val('');
                newRow.find('textarea').val('');
                newRow.find('select').val('');
                newRow.find('.total_price').val('');

                // Append the new row
                dynamicRows.append(newRow);

                // Reinitialize events (if needed for plugins or additional logic)
            });

            // Delete row
            dynamicRows.on('click', '.delete-row', function() {
                if ($('.dynamic-row').length > 1) {
                    $(this).closest('.dynamic-row').remove();
                    calculateGrandTotal(); // Recalculate grand total after deletion
                } else {
                    alert('You cannot delete the main row!');
                }
            });

            // Calculate total price per row
            dynamicRows.on('input', '.qty, .unit_price', function() {
                const row = $(this).closest('.dynamic-row');
                const qty = parseFloat(row.find('.qty').val()) || 0;
                const unitPrice = parseFloat(row.find('.unit_price').val()) || 0;
                const totalPrice = (qty * unitPrice).toFixed(2);

                row.find('.total_price').val(totalPrice);

                calculateGrandTotal(); // Recalculate grand total whenever a row's total price changes
            });

            // Calculate grand total
            function calculateGrandTotal() {
                let grandTotal = 0;

                $('.total_price').each(function() {
                    grandTotal += parseFloat($(this).val()) || 0;
                });

                grandTotalField.val(grandTotal.toFixed(2));
            }

            // Initialize existing data
            function initializeRows() {
                $('.dynamic-row').each(function() {
                    const row = $(this);
                    const qty = parseFloat(row.find('.qty').val()) || 0;
                    const unitPrice = parseFloat(row.find('.unit_price').val()) || 0;
                    const totalPrice = (qty * unitPrice).toFixed(2);

                    row.find('.total_price').val(totalPrice);
                });

                calculateGrandTotal();
            }

            // Run initialization for existing rows
            initializeRows();
        });
    </script>
@endsection
