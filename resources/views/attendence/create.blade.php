@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Staff Attendence</h5>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        <div class="attendance-buttons mt-3">
                            @if (!$todayAttendance)
                                <form action="{{ route('attendence.store') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Check In</button>
                                </form>
                            @elseif(!$todayAttendance->check_out)
                                <form action="{{ route('check-out') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Check Out</button>
                                </form>
                            @else
                                <div class="alert alert-info">
                                    You have already completed your attendance for today.
                                </div>
                            @endif
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div><!-- END: Page content-->
@endsection
