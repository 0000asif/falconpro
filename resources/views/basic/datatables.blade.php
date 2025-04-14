@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">Datatable</h5>
            </div>
            <div class="card-body">
                <br>
                @include('components/alert')
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="dt-responsive">

                        <thead class="thead-light">
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Added By</th>
                                <th>Payment Type</th>
                                <th>Courier</th>
                                <th>Payment Amount</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Date</th>
                                <th>Added By</th>
                                <th>Payment Type</th>
                                <th>Courier</th>
                                <th>Payment Amount</th>
                                <th>Remarks</th>
                                <th>Action</th>
                            </tr>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>


    </div>
    <!-- END: Page content-->

@endsection
