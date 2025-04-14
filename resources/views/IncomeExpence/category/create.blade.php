@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Create Category</h5>
                        <a href="{{ route('IEcategory.index') }}" class="btn btn-success btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        {!! Form::open(['route' => 'IEcategory.store', 'method' => 'post', 'files' => true]) !!}
                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Category Name<span style="color: red;">*</span></label>
                                    <input class="form-control" type="text" name="name" value="" required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Status<span style="color: red;">*</span></label>
                                    <select name="status" id="" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">INActive</option>
                                    </select>
                                    {{-- <se class="form-control" type="text" name="status" value="" required> --}}
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
