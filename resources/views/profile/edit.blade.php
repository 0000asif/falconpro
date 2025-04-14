@extends('admin.masterAdmin')
@section('content')
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Edit Your Profile</h5>
                        <a href="{{ route('profile.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')

                        {!! Form::open(['route' => ['profile.update', $user->id], 'method' => 'put', 'files' => true]) !!}
                        <div class="row">

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="name">Company Name</label>
                                    <input type="text" id="name" name="name"
                                        value="{{ old('name', $user->name) }}"
                                        class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email"
                                        value="{{ old('email', $user->email) }}"
                                        class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="old_password">Old Password</label>
                                    <input type="password" id="old_password" name="old_password"
                                        class="form-control @error('old_password') is-invalid @enderror" required>
                                    @error('old_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="password">New Password (leave blank to keep current)</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group mb-4">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control">
                                </div>
                            </div>


                            @php
                                $company_id = getuser();
                                if($company_id){
                                    $classname = 'd-none';
                                }else{
                                    $classname = '';
                                }
                            @endphp
                            <div class="col-12 col-md-6 col-lg-6 {{ $classname }}">
                                <div class="form-group mb-4">
                                    <label for="exampleInputEmail1">Role <span class="text-danger">*</span></label>
                                    <select name="user_role" class="form-control" required>
                                        <option>Select One</option>
                                        @foreach ($role_permissions as $role)
                                            <option value="{{$role->name}}">{{$role->name}}</option>
                                        @endforeach
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
    </div>
@endsection
