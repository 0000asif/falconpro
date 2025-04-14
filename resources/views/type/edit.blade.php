@extends('admin.masterAdmin')
@section('content')
   <!-- BEGIN: Page content-->
   <div>
      <div class="row">
         <div class="col-lg-12">
            <div class="card card-fullheight">
               <div class="card-header">
                  <h5 class="box-title">Edit Type</h5>
                  <a href="{{ Route('type.index') }}" class="btn btn-sm btn-success">Back</a>
               </div>
               <div class="card-body">
                  @include('components/alert')

                  {!! Form::model($type, ['route' => ['type.update', $type->id], 'method' => 'put', 'files' => true]) !!}
                  <div class="row">

                     <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group mb-4">
                           <label>Name<span style="color: red;">*</span></label>
                           <input class="form-control" placeholder="Type Name" type="text" name="name"
                              value="{{ $type->name }}" required>
                        </div>
                     </div>

                     <!-- Status Dropdown -->
                     <div class="col-12 col-md-6 col-lg-6">
                        <div class="form-group mb-4">
                           <label for="status">Status<span style="color: red;">*</span></label>
                           <select class="form-control" name="status" id="status" required>
                              <option value="1" {{ $type->status == 1 ? 'selected' : '' }}>Active</option>
                              <option value="0" {{ $type->status == 0 ? 'selected' : '' }}>Inactive</option>
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
