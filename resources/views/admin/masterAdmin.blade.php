<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="keywords"
        content="admin template, angular admin template, bootstrap admin template, modern admin template, modern design admin template, dashboard template, responsive admin template, angular web app, crypto dashboard, bitcoin dashboard">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin | Dashboard</title>
    <!-- GLOBAL VENDORS-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" media="all">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="{{ URL::to('admin/assets/vendors/feather-icons/feather.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('admin/assets/vendors/themify-icons/themify-icons.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('admin/assets/vendors/line-awesome/css/line-awesome.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('admin/assets/vendors/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
    <!-- PAGE LEVEL VENDORS-->
    <link href="{{ URL::to('admin/assets/vendors/DataTables/datatables.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('admin/assets/vendors/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('admin/assets/vendors/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}"
        rel="stylesheet" />
    <link
        href="{{ URL::to('admin/assets/vendors/smalot-bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet" />
    <link href="{{ URL::to('admin/assets/vendors/jvectormap/jquery-jvectormap-2.0.3.css') }}" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="{{ URL::to('admin/assets/vendors/animate.css/animate.min.css') }}" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="{{ URL::to('admin/assets/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('admin/assets/vendors/multiselect/css/multi-select.css') }}" rel="stylesheet" />
    <!-- THEME STYLES-->
    <link href="{{ URL::to('admin/assets/vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::to('admin/assets/css/app.min.css') }}" rel="stylesheet" /><!-- PAGE LEVEL STYLES-->
    {{-- font-awesome cdn --}}
    <link rel="stylesheet"
        href="{{ URL::to('//stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css') }}">
    <link href="{{ URL::to('//cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.min.css') }}" rel="stylesheet">
    <style>
        .tasks-list>li {
            padding-right: 0;
            padding-left: 0;
            padding: .8rem 1.5rem;
        }

        .task-actions {
            display: none;
            position: absolute;
            right: 20px;
            top: 50%;
            margin-top: -15px;
        }

        .task-actions>a.dropdown-toggle {
            color: #aaa;
            height: 30px;
            width: 30px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .task-info {
            padding-left: 34px;
        }

        .tasks-list>li .checkbox input:checked~span {
            text-decoration: line-through;
        }

        .tasks-list>li:hover .task-actions {
            display: block
        }

        .data-widget-icon {
            position: absolute;
            top: 20px;
            right: 20px;
            font-size: 40px;
            color: #6a89d7;
        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="content-wrapper">
            @include('admin.sidebar')
            <!-- BEGIN: Content-->
            <div class="content-area">
                @include('admin.header')
                <div class="page-content fade-in-up">
                    @yield('content')
                </div>
                <!-- BEGIN: Footer-->
                <footer class="page-footer flexbox">
                    <div class="text-muted"><?php echo date('Y'); ?> © <strong>copyrights</strong>. All rights reserved</div>
                    <a class="btn btn-primary btn-rounded" href="https://itplanbd.com/" target="_blank">Design &
                        Developed By IT Plan
                        BD</a>
                </footer><!-- END: Footer-->
            </div><!-- END: Content-->
        </div>
    </div>
    <!-- BEGIN: Search form-->
    <div class="modal fade" id="search-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document" style="margin-top: 100px">
            <div class="modal-content">
                <form class="search-top-bar" action="#"><input class="form-control search-input" type="text"
                        placeholder="Search..."><button class="reset input-search-icon" type="submit"><i
                            class="ft-search"></i></button><button class="reset input-search-close" type="button"
                        data-dismiss="modal"><i class="ft-x"></i></button></form>
            </div>
        </div>
    </div><!-- END: Search form-->

    <!-- BEGIN: Page backdrops-->
    <div class="sidenav-backdrop backdrop"></div>
    <div class="preloader-backdrop">
        <div class="page-preloader">Loading</div>
    </div><!-- END: Page backdrops-->
    <!-- CORE PLUGINS-->
    <script src="{{ URL::to('admin/assets/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/vendors/DataTables/datatables.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/vendors/metismenu/dist/metisMenu.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/vendors/perfect-scrollbar/dist/perfect-scrollbar.min.js') }}"></script><!-- PAGE LEVEL PLUGINS-->
    <script src="{{ URL::to('admin/assets/vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::to('admin/assets/vendors/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/vendors/smalot-bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}">
    </script>
    <script src="{{ URL::to('admin/assets/vendors/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/vendors/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/vendors/jvectormap/jquery-jvectormap-2.0.3.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/vendors/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script><!-- CORE SCRIPTS-->
    <script src="{{ URL::to('admin/assets/vendors/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/vendors/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/vendors/multiselect/js/jquery.multi-select.js') }}"></script><!-- CORE SCRIPTS-->
    <script src="{{ URL::to('//cdn.jsdelivr.net/npm/sweetalert2@11.10.6/dist/sweetalert2.all.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/js/app.min.js') }}"></script>
    <script src="{{ URL::to('admin/assets/js/scripts/sweetalert-demo.js') }}"></script>
    <script src="{{ URL::to('//code.jquery.com/ui/1.12.1/jquery-ui.min.js') }}"></script>

    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous">
    </script> --}}
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
    <script>
        $(function() {
            $(".select2_demo").select2({
                //placeholder: "Select an option",
            });
            $("#select2_placeholder").select2({
                placeholder: "Select a state",
                allowClear: !0
            });
            $("#select2_limit").select2({
                placeholder: "Select a state",
                maximumSelectionLength: 2
            });
            $("#select2_hide_search").select2({
                placeholder: "Select an option",
                minimumResultsForSearch: Infinity
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },

            });
        });

        $('#dt-responsive').DataTable({
            responsive: true,
        });

        formSuccess = function(responseText, statusText, xhr, $form) {
            // swal({
            //  title: "Success",
            //  text: responseText.message,
            //  icon: "success"
            // });
            // removeLoadingButton($form.find("button[type=submit]"));

            swal("Congratulations!", responseText.message, "success");
        };

        formError = function(xhr, status, error, $form) {

            var obj = JSON.parse(xhr.responseText);
            //swal({
            //  title: "Errors!",
            // text: obj.message,
            // icon: "error"
            //});

            swal("Errors!", obj.message, "error");

            // removeLoadingButton($form.find("button[type=submit]"));

            $.each(obj.errors, function(key, error) {
                if (document.getElementById(key)) {
                    if ($form.find(":input[id=" + key + "]")) {
                        displayErrorMessage($form.find(":input[id=" + key + "]"), error[0]);
                    } else if ($form.find(":select[id=" + key + "]")) {
                        displayErrorMessage($form.find(":select[id=" + key + "]"), error[0]);
                    } else if ($form.find(":textarea[id=" + key + "]")) {
                        displayErrorMessage($form.find(":textarea[id=" + key + "]"), error[0]);
                    }
                } else {
                    if ($form.find(":input[name=" + key + "]")) {
                        displayErrorMessage($form.find(":input[name=" + key + "]"), error[0]);
                    } else if ($form.find(":select[name=" + key + "]")) {
                        displayErrorMessage($form.find(":select[name=" + key + "]"), error[0]);
                    } else if ($form.find(":textarea[name=" + key + "]")) {
                        displayErrorMessage($form.find(":textarea[name=" + key + "]"), error[
                            0]);
                    }
                }
            });
        };

        displayErrorMessage = function(element, message) {
            element.addClass('form-control-danger').removeClass('form-control-success');
            if (typeof message !== "undefined") {
                element.after(
                    $("<div class='form-control-feedback'>" + message + "</div>")
                );
            }
        };
    </script>
    <script>
        $(function() {
            $(".datetimepicker_5").datetimepicker({
                todayHighlight: !0,
                autoclose: !0,
                startView: 2,
                minView: 2,
                format: "mm-dd-yyyy",
            });
        });

        $("#datetimepicker_1, #datetimepicker_2").datetimepicker({
            todayHighlight: !0,
            autoclose: !0,
            startView: 2,
            minView: 1,
            format: "dd-mm-yyyy hh:ii",
        });
    </script>


    <!-- PAGE LEVEL SCRIPTS-->
    @yield('script')

</body>

</html>
