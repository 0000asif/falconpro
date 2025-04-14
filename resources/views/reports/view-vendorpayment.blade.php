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
                <h5 class="box-title">Vendor Payment, <?php echo date('m-d-Y', strtotime($from_date)); ?> To <?php echo date('m-d-Y', strtotime($to_date)); ?>
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
                        <td>Company</td>
                        <td colspan="2">Vendor Payment</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($workorder_report as $workOrder)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ date('m-d-Y', strtotime($workOrder->created_at)) }}</td>
                            <td>{{ $workOrder->user->name }}</td>
                            <td>{{ $workOrder->work_order_number }}</td>
                            <td>{{ $workOrder->company->name ?? 'Unknown Company' }}</td>
                            <td colspan="2">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Vendor</th>
                                            <th>Amount Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($workOrder->vendorinvoice as $invoice)
                                            <tr>
                                                <td>{{ $workOrder->vendor->name ?? 'NA' }}</td>
                                                <td>{{ number_format($invoice->total_amount ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td><strong>Total:</strong></td>
                                            <td><strong>{{ number_format($workOrder->vendorinvoice->sum('total_amount'), 2) }}</strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5"><strong>Total:</strong></td>
                        <td><strong>{{ number_format($workorder_report->sum(function ($workOrder) {return $workOrder->vendorinvoice->sum('total_amount');}),2) }}</strong>
                        </td>
                    </tr>
                </tfoot>
            </table>


        </div>
    </div>
</div>
