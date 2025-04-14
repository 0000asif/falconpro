<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice {{$workOrder->invoice}}</title>
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
                <h1 style="font-weight: 900">INVOICE</h1>
                <p><strong>Invoice #:</strong>{{ $workOrder->invoice }} </p>
                <p><strong>Invoice date:</strong> {{ date('m-d-Y', strtotime($workOrder->due_date)) }}</p>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <p>{{ $settings->address }}<br>
                    P: {{ $settings->phone }}<br>
                    E: {{ $settings->email }}</p>
            </div>
            <div class="col-6 text-end">
                <div class="section-title">Bill to: </div>
                <p>{{$workOrder->client->name}}</p>
                <p>
                    {{$workOrder->client->city_id}}<br>
                {{$workOrder->client->address}} </p>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Description</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Unit Price</th>
                    <th class="text-end">Total Price</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($workOrder->items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->type->name ?? 'N/A' }}</td>
                        <td>{{ $item->description ?? 'N/A' }}</td>
                        <td class="text-center">${{ $item->qty }}</td>
                        <td class="text-end">${{ $item->unit_price }}</td>
                        <td class="text-end">${{ $item->total_price }}</td>
                    </tr>
                @empty
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td colspan="6">No Data Found</td>
                        <!-- Ensure colspan matches table columns -->
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-end">Subtotal</td>
                    <td class="text-end">${{ number_format($workOrder->items->sum('total_price'), 2) }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-end">Total</td>
                    <td class="text-end">${{ $workOrder->grand_total }}</td>
                </tr>
            </tfoot>
        </table>


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
