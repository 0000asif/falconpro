<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bids</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: #f8f9fa;
            margin: 0;
            padding: 0;
        }


        P {
            font-size: 11px;
        }

        .invoice-container {
            background: lightblue;
            margin: auto;
            border: 1px solid #ddd;
            padding: 20px;
        }


        .invoice-meta p {
            margin: 0;
        }

        .section-title {
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .table {
            font-size: 12px;
        }

        .table th {
            background-color: lightblue;
            border: 1px solid #000;
        }

        .table td,
        .table th {
            vertical-align: middle;
            background-color: lightblue;
            border: 1px solid #000;
        }


        .footer-note {
            margin-top: 50px;
            text-align: center;
            font-style: italic;
        }

        .footer-note strong {
            display: block;
            margin-top: 5px;
            font-style: normal;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    @php
        $settings = \App\Models\Setting::first();
    @endphp
    <div class="invoice-container">

        <div class="row invoice-meta">
            <div class="col-6">
                <div class="row d-flex align-items-center">
                    <img src="{{ asset('image/setting/' . $settings->logo) }}" class="img-fluid"
                        style="max-width: 150px; margin-bottom: 20px;">
                    <h1 style="display: contents; font-weight: 900;">Falcon Pro <br> Services</h1>
                </div>
            </div>
            <div class="col-6 text-end">
                <h2 style="font-weight: 600">BIDS DETAILS</h2>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <p>{{ $settings->address }}<br>
                    P: {{ $settings->phone }}<br>
                    E: {{ $settings->email }}</p>
            </div>
        </div>


        @forelse ($bids as $bid)
            <div class=" ">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex p-2">
                            <strong>Work Order Number:</strong>
                            <span>{{ $bid->workOrder->work_order_number ?? '' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Items Section -->
                <div class="table-responsive">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bid->items as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->type->name ?? 'N/A' }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td class="text-center">${{ $item->qty }}</td>
                                    <td class="text-end">${{ $item->unit_price }}</td>
                                    <td class="text-end">${{ $item->total_price }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No data found</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end">Subtotal</td>
                                <td class="text-end">${{ number_format($bid->items->sum('total_price'), 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="text-end">Total</td>
                                <td class="text-end">${{ $bid->total_amount }}</td>
                            </tr>
                    </table>
                </div>
            </div>
        @empty
            <div class="text-center text-muted">No Bids Found</div>
        @endforelse


        <div class="footer-note">
            <p>Thank you for your Business</p>
            <strong>We Listen, We Care, We Deliver</strong>
        </div>
    </div>
    <script>
        window.print();
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>

</html>
