@extends('admin.masterAdmin')
@section('content')

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-fullheight">
                <div class="card-header">
                    <h5 class="box-title">User Permission List</h5>
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
                    <form id="" action="{{ route('user_role.update') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="exampleInputEmail1">Role Name <span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="role" placeholder="Role Name" value="@if ($role) {{ $role->name }} @endif" required>
                                    @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

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
                                                <td colspan="3">
                                                    {{ $key }}

                                                    <label class="custom-control custom-checkbox" style="float:right;">
                                                        <input type="checkbox" class="select-all" data-section="{{ $key }}" />
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">Select All</span>
                                                    </label>
                                                </td>

                                            </tr>
                                            @foreach ($value as $permissionCategory)
                                            <tr>
                                                <td>{{ $permissionCategory->id }}</td>
                                                <td>{{ $permissionCategory->title }}</td>
                                                <td>
                                                    <label class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="checkbox-{{ $key }}" name="permission[]" value="view {{ strtolower($permissionCategory->name) }}"
                                                            @if (in_array("view " . strtolower($permissionCategory->name), $permissions)) checked @endif />
                                                        <span class="custom-control-indicator"></span>
                                                        <span class="custom-control-description">View</span>
                                                    </label>

                                                    @if($permissionCategory->type != 'Settings' && $permissionCategory->type != 'Report')
                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="checkbox-{{ $key }}" name="permission[]" value="create {{ strtolower($permissionCategory->name) }}"
                                                                @if (in_array("create " . strtolower($permissionCategory->name), $permissions)) checked @endif />
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Create</span>
                                                        </label>

                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="checkbox-{{ $key }}" name="permission[]" value="edit {{ strtolower($permissionCategory->name) }}"
                                                                @if (in_array("edit " . strtolower($permissionCategory->name), $permissions)) checked @endif />
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Edit</span>
                                                        </label>

                                                        <label class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="checkbox-{{ $key }}" name="permission[]" value="delete {{ strtolower($permissionCategory->name) }}"
                                                                @if (in_array("delete " . strtolower($permissionCategory->name), $permissions)) checked @endif />
                                                            <span class="custom-control-indicator"></span>
                                                            <span class="custom-control-description">Delete</span>
                                                        </label>
                                                    @endif
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.select-all').forEach(function(selectAllCheckbox) {
                selectAllCheckbox.addEventListener('change', function() {
                    const sectionKey = this.getAttribute('data-section');
                    const checkboxes = document.querySelectorAll('.checkbox-' + sectionKey);
                    checkboxes.forEach(function(checkbox) {
                        checkbox.checked = selectAllCheckbox.checked;
                    });
                });
            });
        });
    </script>
@endsection
