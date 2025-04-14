<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bids</title>

    <style>
        /* Basic Page Layout */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .container {
            margin: 0 auto;
            padding: 20px;
            max-width: 900px;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h5 {
            color: #007bff;
            margin-bottom: 1rem;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
        }

        .card-body {
            padding: 20px;
        }

        .row {
            display: flex;
            flex-wrap: wrap;
            margin: -10px;
        }

        .col-md-6 {
            width: 50%;
            padding: 10px;
            box-sizing: border-box;
        }

        .d-flex {
            display: flex;
            justify-content: space-between;
        }

        .border {
            border: 1px solid #ddd;
            padding: 10px;
        }

        .badge {
            padding: 5px 10px;
            font-size: 0.875rem;
            border-radius: 5px;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 10px 0;
        }

        .thead-dark {
            background-color: #343a40;
            color: white;
        }

        th,
        td {
            padding: 8px 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        /* Hide elements not needed on print */
        .no-print {
            display: none;
        }

        /* Print-specific Styles */
        @media print {
            body {
                background-color: white;
                margin: 0;
                padding: 0;
            }

            .container {
                box-shadow: none;
                /* width: 100%;
                max-width: none;
                padding: 20px; */
            }

            .row {
                display: block;
            }

            .col-md-6 {
                width: 100%;
                padding: 5px 0;
            }

            .badge {
                font-size: 1rem;
            }

            .table-responsive {
                margin-top: 20px;
            }

            .table {
                width: 100%;
                margin-top: 10px;
            }

            .no-print {
                display: none;
            }

            /* Hide header and footer on print */
            #header {
                background-color: transparent;
            }

            .no-print {
                display: none;
            }

            .d-flex {
                display: block;
            }

            h4 {
                color: #000;
            }
        }
    </style>
</head>

<body>

    <!-- BEGIN: Page content-->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Work Order Section Here (same as previous) -->

                {{-- Bids Section --}}
                <div class="card mt-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center"
                        id="header">
                        @php
                            $settings = \App\Models\Setting::first();
                        @endphp
                        <div class="d-flex align-items-center">
                            <!-- Company Logo -->
                            @if ($settings->logo)
                                <img src="{{ asset('image/setting/' . $settings->logo) }}" alt="Logo" class="mt-2"
                                    width="100">
                            @endif
                            <!-- Company Name -->
                            <h4 class="box-title text-white mb-0">{{ $settings->name }}</h4>
                        </div>
                    </div>
                    <div class="card-body">

                        <!-- Bids Details -->
                        <h3 class="text-primary">Bids Details</h3>
                        @forelse ($bids as $bid)
                            <div class="border rounded p-3 mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between border p-2">
                                            <strong>Work Order Number:</strong>
                                            <span>{{ $bid->workOrder->work_order_number ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between border p-2">
                                            <strong>Image:</strong>
                                            <span>
                                                @if ($bid->image)
                                                    <img src="{{ asset('admin/bids/' . $bid->image) }}" width="100px"
                                                        alt="img">
                                                @else
                                                    N/A
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between border p-2">
                                            <strong>Grand Total:</strong>
                                            <span>{{ $bid->total_amount ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between border p-2">
                                            <strong>Total Qty:</strong>
                                            <span>{{ $bid->total_qty ?? '' }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between border p-2">
                                            <strong>Status:</strong>
                                            <span>
                                                @if ($bid->status == 1)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Items Section -->
                                <h3 class="text-primary mt-4">Items</h3>
                                <div class="table-responsive mb-4">
                                    <table class="table table-striped table-hover mb-4">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>#</th>
                                                <th>Type</th>
                                                <th>Description</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($bid->items as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->type->name ?? 'N/A' }}</td>
                                                    <td>{{ $item->description }}</td>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ $item->unit_price }}</td>
                                                    <td>{{ $item->total_price }}</td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">No data found</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted">No Bids Found</div>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script to trigger print for Bids section -->
    <script>
        window.print();
    </script>
</body>

</html>
