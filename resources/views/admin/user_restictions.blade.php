@extends('admin.masterAdmin')
@section('content')

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-fullheight">
                <div class="card-header">
                    <h5 class="box-title">User Permission List - {{ $user->name }}</h5>
                    {{-- <a href="{{ route('category') }}" class="btn btn-primary btn-sm mb-10" style="float:right;">Category List</a> --}}
                </div>
                <div class="card-body">
                    <?php if(Session::get('success') != null) { ?>
                    <div class="alert alert-info alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong><?php echo Session::get('success') ;  ?></strong>
                        <?php Session::put('success',null) ;  ?>
                    </div>
                    <?php } ?>
                    <form id="" action="{{ route('user_restictions.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            @if ($user)
                                <input type="hidden" name="id" value="{{ $user->id }}">
                            @endif
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Module Name</th>
                                            <th>Restictions <input type="checkbox" onclick="checkAll(this)">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissionCategorys as $key => $value)
                                        <tr style="background-color:#6C8BEF; color:white;text-align:center;text-transform:capitalize;font-weight:bolder;">
                                            <td colspan="3">{{ $key }}</td>
                                        </tr>
                                            @foreach ($value as $permissionCategory)
                                            <tr>
                                                <td>{{ $permissionCategory->id }}</td>
                                                <td>{{ $permissionCategory->title }}</td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="" name="permission[]" value="view {{ $permissionCategory->name }}" @if (in_array("view $permissionCategory->name", $permissions)) checked @endif />
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">View</span>
                                                    </label>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="" name="permission[]" value="edit {{ $permissionCategory->name }}" @if (in_array("edit $permissionCategory->name", $permissions)) checked @endif />
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Edit</span>
                                                    </label>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="" name="permission[]" value="delete {{ $permissionCategory->name }}" @if (in_array("delete $permissionCategory->name", $permissions)) checked @endif />
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Delete</span>
                                                    </label>
                                                </td>
                                            </tr>
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="col-lg-12 form-group mb-4">
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div><!-- END: Page content-->

@endsection
@section('script')
    <script>
        function checkAll(bx) {
            var cbs = document.getElementsByTagName('input');
            for (var i = 0; i < cbs.length; i++) {
                if (cbs[i].type == 'checkbox') {
                    cbs[i].checked = bx.checked;
                }
            }
        }
    </script>
@endsection
