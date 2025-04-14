@extends('admin.masterAdmin')
@section('content')

<!-- BEGIN: Page content-->
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="box-title">User Role List</h5>
                    @can('create user role')
                        <a href="{{ route('user-role') }}" class="btn btn-primary btn-sm mb-10">Add User Role</a>
                    @endcan
                </div>
                <div class="card-body">
                    <?php if(Session::get('success') != null) { ?>
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <a href="#" class="fa fa-times" data-dismiss="alert" aria-label="close"></a>
                            <strong><?php echo Session::get('success') ;  ?></strong>
                            <?php Session::put('success',null) ;  ?>
                        </div>
                    <?php } ?>
                    <div class="table-responsive">
                        <table class="table table-bordered w-100 nowrap" id="dt-scroll-horizonal" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Role Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($role_permissions as $role_permission)
                                <tr>
                                    <td>{{$role_permission->id}}</td>
                                    <td style="text-transform:capitalize;">{{$role_permission->name}}</td>
                                    <td>
                                        @can('edit user role')
                                            <a href="{{route('user-role',['role'=>$role_permission->name])}}" class="btn btn-primary"> View</a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div><!-- END: Page content-->

<div class="modal fade" id="UserAdd" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form id="UserAddUpdate" action="{{ route('user.insert') }}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" id="hidden-id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">User Add/Update</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputEmail1">User Name <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" name="name" placeholder="User Name">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputEmail1">E-mail <span class="text-danger">*</span></label>
                                        <input class="form-control" type="email" name="email" placeholder="E-mail">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mb-4">
                                        <label for="exampleInputEmail1">Password <span class="text-danger">*</span></label>
                                        <input class="form-control" type="password" name="password" placeholder="Password">
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
@section('script')
<script>
    $(function() {


        $(document).on('click', '.UserAddButton', function() {
            $('#hidden-id').attr("disabled", "true");
            $("#UserAdd").modal('show');
        });

        $('#UserAddUpdate').ajaxForm({
            success: function(responseText, statusText, xhr, $form) {
                formSuccess(responseText, statusText, xhr, $form);
                $('#dt-scroll-horizonal').DataTable().draw(true);
                $("#UserAdd").modal('hide');
                $('#hidden-id').setAttribute("disabled");
            }
            , clearForm: true
            , resetForm: true
        });

        $('#dt-scroll-horizonal').DataTable({
            scrollX: true
        });

        $(document).on('click', '.tableDelete', function() {
            swal({
                title: 'Are you sure?'
                , text: "You won't be able to revert this!"
                , type: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.value) {
                    let Id = $(this).data('id');
                    $(this).ajaxSubmit({
                        data: {
                            "delete": Id
                        }
                        , method: 'POST'
                        , dataType: 'json'
                        , url: "{{ route('user.insert') }}"
                        , success: function(responseText) {
                            // formSuccess(responseText, statusText, xhr, $form);
                            swal("Congratulations!", responseText.message, "success");
                            $('#dt-scroll-horizonal').DataTable().draw(true);
                        }
                    });
                    // swal("Congratulations!", responseText.message, "success");
                } else {
                    swal("Congratulations!", "Your imaginary file is safe!", "success");
                }
            });

        });

        $('#UserAdd').on('hidden.bs.modal', function() {
            $("#UserAddUpdate").trigger("reset");
        });

        $(document).on('click', '.tableEdit', function() {
            let Id = $(this).data('id');
            $('#hidden-id').removeAttr("disabled");
            $('#hidden-id').val(Id);
            $(this).ajaxSubmit({
                data: {
                    "id": Id
                }
                , dataType: 'json'
                , method: 'GET'
                , url: "{{ route('user.edit') }}"
                , success: function(responseText) {
                    $('input[name^="name"]').val(responseText.data.name);
                    $('input[name^="email"]').val(responseText.data.email);
                    $("#UserAdd").modal('show');
                }
            });
        });


    });

</script>
@endsection
