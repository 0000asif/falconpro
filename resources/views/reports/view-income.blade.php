<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-10">
                <h5 class="box-title" class="">Income Report <?php echo date('m-d-Y', strtotime($from_date)); ?> To <?php echo date('m-d-Y', strtotime($to_date)); ?>
                </h5>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered w-100" id="dt-responsive">
                <thead>
                    <tr>
                        <td>S/L</td>
                        <td>Category Name</td>
                        <td>Project</td>
                        <td>Income Amount</td>
                        <td>Date</td>
                        <td>Note</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($expense_report as $expense_head)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $expense_head->category->name }}</td>
                            <td>{{ $expense_head->project->project_name ?? 'No project Found' }}
                            </td>
                            <td>{{ $expense_head->income_amount }}</td>
                            <td>{{ date('m-d-Y', strtotime($expense_head->date)) }}</td>
                            <td>{{ $expense_head->note ? $expense_head->note : 'Note Not Found' }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total:</strong></td>
                        <td><strong>{{ number_format($expense_report->sum('income_amount'), 2) }}</strong></td>
                        <td colspan="2"></td>
                    </tr>
                </tfoot>
            </table>


        </div>
    </div>
</div>
