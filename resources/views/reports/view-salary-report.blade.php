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
            <div class="col-md-10 d-flex justify-content-between align-items-center">
                <h5 class="box-title mb-0">
                    Staff Salary Report
                    <?php echo date('m-d-Y', strtotime($from_date)); ?>
                    To
                    <?php echo date('m-d-Y', strtotime($to_date)); ?>
                </h5>
                <button id="printReport" class="btn btn-sm btn-primary">Print Report</button>

            </div>


        </div>

        <div class="table-responsive">
            <table class="table table-bordered" id="dt-scroll-horizonal" style="width:100%">
                <thead>
                    <tr>
                        <td>S/L</td>
                        <td>Staff Name</td>
                        <td>Staff Mobile</td>
                        <td>Salary Amount</td>
                        <td>Salary Month</td>
                        <td>Payment Date</td>
                </thead>
                </tr>
                <tbody>
                    @foreach ($salary_report as $report)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $report->staff->name }}</td>
                            <td>{{ $report->staff->phone }}</td>
                            <td>{{ $report->salary_amount }}</td>
                            @php
                                $monthNumber = $report->payment_month; // Example month number
                                $monthName = \Carbon\Carbon::create()->month($monthNumber)->format('F');
                            @endphp
                            <td>
                                {{ $monthName }} - {{ $report->payment_year }}
                            </td>
                            <td>{{ date('m-d-Y', strtotime($report->payment_date)) }} </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total:</strong></td>
                        <td><strong>{{ number_format($salary_report->sum('salary_amount'), 2) }}</strong></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>


        </div>
    </div>
</div>
