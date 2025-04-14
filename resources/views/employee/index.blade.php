@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">Employee List</h5>
                <div class="">
                    <form method="GET" action="{{ route('employee.index') }}" class="form-inline">
                        <label for="companyFilter" class="mr-2">Filter by Company:</label>
                        <select name="company_id" id="companyFilter" class="form-control mr-2">
                            <option value="">Select One</option>
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}"
                                    {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
                                </option>
                            @endforeach
                        </select>
                        {{-- <button type="submit" class="btn btn-primary">Filter</button> --}}
                    </form>
                </div>
                @can('create employee')
                    <a href="{{ route('employee.create') }}" class="btn btn-success btn-sm">Add New</a>
                @endcan
            </div>

            <div class="card-body">
                <br>

                @include('components/alert')
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="dt-responsive">

                        <thead class="thead-light">
                            <tr>
                                <th>SL</th>
                                <th>Company</th>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Designation</th>
                                <th>Salary</th>
                                <th>Join date</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($members as $key => $value)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $value->company->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($value->image)
                                            <img src="{{ asset('/admin/employee/' . $value->image) }}"
                                                alt="{{ __('image') }}" width="250px">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $value->name }} </td>
                                    <td>{{ $value->email }} </td>
                                    <td>{{ $value->phone }} </td>
                                    <td>{{ $value->designation->name }}</td>
                                    <td>{{ $value->salary }} </td>
                                    <td>{{ date('m-d-Y', strtotime($value->join_date)) }}</td>

                                    <td>
                                        <div class="btn-group">
                                            @can('edit employee')
                                            <a href="{{ route('employee.edit', $value->id) }}"
                                                class="btn btn-sm btn-warning text-white"><i class="ti-pencil-alt"></i></a>
                                            @endcan
                                            @can('delete employee')
                                                <form action="{{ route('employee.destroy', $value->id) }}" method="POST"
                                                    id="delete-form-{{ $value->id }}" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                        onclick="confirmDelete({{ $value->id }})"><i
                                                            class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>
                </div>
            </div>
        </div>


    </div>
    <!-- END: Page content-->
@endsection

@section('script')
    <script>
        document.getElementById('companyFilter').addEventListener('change', function() {
            this.form.submit();
        });
    </script>
@endsection
