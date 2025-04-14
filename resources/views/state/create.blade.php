@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Create State</h5>
                        <a href="{{ Route('state.index') }}" class="btn btn-sm btn-success">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        {!! Form::open(['route' => 'state.store', 'method' => 'post', 'files' => true]) !!}
                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Select City<span style="color: red;">*</span></label>
                                    <select class="form-control select2_demo" id="city_id" name="city_id" required>
                                        <option value="">Select an option</option>
                                        @foreach ($city as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Name<span style="color: red;">*</span></label>
                                    <input class="form-control" placeholder="State Name" type="text" name="name"
                                        value="" required>
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
