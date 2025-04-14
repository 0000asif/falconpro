@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">Client List</h5>

                    <div class="">
                        <form method="GET" action="{{ route('client.index') }}" class="form-inline">
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
                <a href="{{ route('client.create') }}" class="btn btn-success btn-sm">Add New</a>
            </div>
            <div class="card-body">

                <br>
                @include('components/alert')
                <div class="table-responsive">
                    <table class="table table-bordered w-100" id="dt-responsive">

                        <thead class="thead-light">
                            <tr>
                                <th>SL</th>
                                <th>Created By</th>
                                <th>Company</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>State</th>
                                <th>Zip Code </th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($clients as $key => $value)
                                <tr>
                                    <th>{{ $key + 1 }}</th>
                                    <td>{{ $value->user->name }}</td>
                                    <td>{{ $value->company->name ?? 'N/A' }}</td>
                                    <td>{{ $value->name }} </td>
                                    <td>{{ $value->email }} </td>
                                    <td>{{ $value->phone }} </td>
                                    <td>{{ $value->city_id ?? 'N/A' }} </td>
                                    <td>{{ $value->state_id }} </td>
                                    <td>{{ $value->zip_code }} </td>
                                    <td>
                                        @if ($value->status == 0)
                                            <span class="badge badge-danger">InActive</span>
                                        @else
                                            <span class="badge badge-success">Active</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="{{ route('client.edit', $value->id) }}"
                                                class="btn btn-sm btn-warning text-white"><i class="ti-pencil-alt"></i></a>

                                            <form action="{{ route('client.destroy', $value->id) }}" method="POST"
                                                id="delete-form-{{ $value->id }}" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    onclick="confirmDelete({{ $value->id }})"><i
                                                        class="fa fa-trash"></i>
                                                </button>
                                            </form>
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
