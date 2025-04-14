@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Edit Category</h5>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        {!! Form::open(['route' => ['IEcategory.update', $data->id], 'method' => 'put', 'files' => true]) !!}
                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Category Name<span style="color: red;">*</span></label>
                                    <input class="form-control" type="text" name="name" value="{{ $data->name }}"
                                        required>
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label>Status<span style="color: red;">*</span></label>
                                    <select name="status" id="" class="form-control">
                                        <option value="1" {{ $data->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $data->status == 0 ? 'selected' : '' }}>INActive</option>
                                    </select>
                                </div>
                            </div>


                        </div>


                        <div class="form-group"><button class="btn btn-primary mr-2" type="submit"
                                id="collection_button">Update</button></div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div><!-- END: Page content-->
@endsection
