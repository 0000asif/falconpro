@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Create Designation</h5>
                        <a href="{{ route('designation.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        {!! Form::open(['route' => 'designation.store', 'method' => 'post', 'files' => true]) !!}
                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Name<span style="color: red;">*</span></label>
                                    <input class="form-control" type="text" name="name" value="{{ old('name') }}"
                                        required>
                                </div>
                            </div>

                        </div>


                        <div class="form-group"><button class="btn btn-primary mr-2" type="submit"
                                id="collection_button">Submit</button></div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END: Page content-->
@endsection
