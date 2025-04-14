<style>
    @media print {

        #loader,
        #printReport {
            display: none;
        }

        body {
            font-family: Arial, sans-serif;
        }
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-10  d-flex justify-content-between align-items-center">
                <h5 class="box-title" class="">WorkOrder <?php echo date('m-d-Y', strtotime($from_date)); ?> To <?php echo date('m-d-Y', strtotime($to_date)); ?>
                </h5>
                <button id="printReport" class="btn btn-sm btn-primary">Print Report</button>

            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered w-100" id="dt-responsive">
                <thead>
                    <tr>
                        <td>S/L</td>
                        <td>Date</td>
                        <td>Created By</td>
                        <td>Work Order Number</td>
                        <td>Invoice</td>
                        <td>Client</td>
                        <td>Total Qty</td>
                        <td>Grand Total</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workorder_report as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('m-d-Y', strtotime($order->created_at)) }}</td>
                            <td>{{ $order->user->name }}</td>
                            <td>{{ $order->work_order_number }}</td>
                            <td>{{ $order->invoice }}</td>
                            <td>{{ $order->client->name }} </td>
                            <td>{{ $order->total_qty }}
                            </td>
                            <td>{{ $order->grand_total }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6"><strong>Total:</strong></td>
                        <td><strong>{{ number_format($workorder_report->sum('total_qty'), 2) }}</strong></td>
                        <td><strong>{{ number_format($workorder_report->sum('grand_total'), 2) }}</strong></td>
                        {{-- <td colspan="2"></td> --}}
                    </tr>
                </tfoot>
            </table>


        </div>
    </div>
</div>
