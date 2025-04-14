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
                        <td>Work Order Number</td>
                        <td>Type</td>
                        <td>Qty</td>
                        <td>Unit Price</td>
                        <td>Total Price</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workorder_report as $order)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('m-d-Y', strtotime($order->created_at)) }}</td>
                            <td>{{ $order->workOrder->work_order_number }}</td>
                            <td>{{ $order->type->name }}</td>
                            <td>{{ $order->qty }}</td>
                            <td>{{ $order->unit_price }}
                            </td>
                            <td>{{ $order->total_price }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4"><strong>Total:</strong></td>
                        <td><strong>{{ number_format($workorder_report->sum('qty'), 2) }}</strong></td>
                        <td></td>
                        <td><strong>{{ number_format($workorder_report->sum('total_price'), 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>


        </div>
    </div>
</div>
