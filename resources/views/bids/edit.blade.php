@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Edit Bids</h5>
                        <a href="{{ route('work-order.show', $bid->work_order_id) }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        <form action="{{ route('bids.update', $bid->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <input type="hidden" name="work_order_id" value="{{ $bid->work_order_id }}">
                                <!-- Status Dropdown -->
                                <div class="col-12 col-md-6 col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="status">Status<span style="color: red;">*</span></label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="1" {{ $bid->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $bid->status == 0 ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>


                                <!-- Image Upload -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="image" class="form-label">Upload Image</label>
                                        <input type="file" accept="image/*" name="image" class="form-control" />
                                        @if ($bid->image)
                                            <img src="{{ asset('admin/bids/' . $bid->image) }}" alt="Bid Image"
                                                class="img-thumbnail mt-2" width="100">
                                        @endif
                                    </div>
                                </div>

                                <div class=" mt-4 col-12">
                                    <div class="card shadow">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="mb-0">Bids Management</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Dynamic Rows -->
                                            <div id="dynamic-rows">
                                                @if ($bid->items->isEmpty())
                                                    <div class="row dynamic-row align-items-center mb-3">
                                                        <!-- Type -->
                                                        <div class="col-md-2">
                                                            <label for="type" class="form-label">Type</label>
                                                            <select name="type[]" class="form-control">
                                                                <option value="">Select Type</option>
                                                                @foreach ($types as $type)
                                                                    <option value="{{ $type->id }}">{{ $type->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <!-- Description -->
                                                        <div class="col-md-3">
                                                            <label for="description" class="form-label">Description</label>
                                                            <textarea name="description[]" class="form-control" rows="2" placeholder="Enter description"></textarea>
                                                        </div>

                                                        <!-- Quantity -->
                                                        <div class="col-md-1">
                                                            <label for="qty" class="form-label">Qty</label>
                                                            <input type="number" name="qty[]" class="form-control qty"  step="any" 
                                                                placeholder="Qty" />
                                                        </div>

                                                        <!-- Unit Price -->
                                                        <div class="col-md-2">
                                                            <label for="unit_price" class="form-label">Unit Price</label>
                                                            <input type="number" name="unit_price[]" step="any" 
                                                                class="form-control unit_price" placeholder="Unit Price" />
                                                        </div>

                                                        <!-- Total Price -->
                                                        <div class="col-md-2">
                                                            <label for="total_price" class="form-label">Total Price</label>
                                                            <input type="text" name="total_price[]"
                                                                class="form-control total_price" placeholder="Total Price"
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
                                                @else
                                                    @foreach ($bid->items as $detail)
                                                        <div class="row dynamic-row align-items-center mb-3">
                                                            <!-- Type -->
                                                            <div class="col-md-2">
                                                                <label for="type" class="form-label">Type</label>
                                                                <select name="type[]" class="form-control">
                                                                    <option value="">Select Type</option>
                                                                    @foreach ($types as $type)
                                                                        <option value="{{ $type->id }}"
                                                                            {{ $type->id == $detail->type_id ? 'selected' : '' }}>
                                                                            {{ $type->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>

                                                            <!-- Description -->
                                                            <div class="col-md-3">
                                                                <label for="description"
                                                                    class="form-label">Description</label>
                                                                <textarea name="description[]" class="form-control" rows="2" placeholder="Enter description">{{ $detail->description }}</textarea>
                                                            </div>

                                                            <!-- Quantity -->
                                                            <div class="col-md-1">
                                                                <label for="qty" class="form-label">Qty</label>
                                                                <input type="number" name="qty[]"  step="any" 
                                                                    class="form-control qty" placeholder="Qty"
                                                                    value="{{ $detail->qty }}" />
                                                            </div>

                                                            <!-- Unit Price -->
                                                            <div class="col-md-2">
                                                                <label for="unit_price" class="form-label">Unit
                                                                    Price</label>
                                                                <input type="number" name="unit_price[]" step="any" 
                                                                    class="form-control unit_price"
                                                                    placeholder="Unit Price"
                                                                    value="{{ $detail->unit_price }}" />
                                                            </div>

                                                            <!-- Total Price -->
                                                            <div class="col-md-2">
                                                                <label for="total_price" class="form-label">Total
                                                                    Price</label>
                                                                <input type="text" name="total_price[]"
                                                                    class="form-control total_price"
                                                                    placeholder="Total Price"
                                                                    value="{{ $detail->total_price }}" readonly />
                                                            </div>

                                                            <!-- Actions -->
                                                            <div class="col-md-2 text-center">
                                                                <label class="form-label d-block">&nbsp;</label>
                                                                <button type="button"
                                                                    class="btn btn-success add-row me-2">
                                                                    <i class="fa fa-plus"></i>
                                                                </button>
                                                                <button type="button" class="btn btn-danger delete-row">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>

                                            <!-- Grand Total -->
                                            <div class="row mt-4">
                                                <div class="col-md-8 text-end">
                                                    <h5 class="mb-0">Grand Total:</h5>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" id="grand_total"
                                                        class="form-control text-center fw-bold" readonly
                                                        value="{{ $bid->total_amount }}" />
                                                </div>
                                            </div>
                                        </div>
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

                dynamicRows.append(newRow);
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
        });
    </script>
@endsection
