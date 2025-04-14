@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Create Expertise</h5>
                        <a href="{{ route('expertise.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        <form action="{{ route('expertise.store') }}" method="POST">
                            @csrf
                            <div class="row">

                                <!-- Name -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="name">Name<span style="color: red;">*</span></label>
                                        <input class="form-control" type="text" name="name" id="name"
                                            placeholder="Enter Name" required>
                                    </div>
                                </div>

                            </div>

                            <!-- Submit Button -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div><!-- END: Page content-->
@endsection
