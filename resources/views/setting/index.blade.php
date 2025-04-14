@extends('admin.masterAdmin')

@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h4>Update Settings</h4>
                    </div>

                    <div class="card-body">
                        @include('components.alert') <!-- For showing success/error messages -->

                        <form action="{{ route('setting.update', $settings->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="logo">Logo</label>
                                <input type="file" accept="image/*" class="form-control" name="logo" id="logo">
                                @if ($settings && $settings->logo)
                                    <img src="{{ asset('image/setting/' . $settings->logo) }}" alt="Logo" class="mt-2"
                                        width="100">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="fav_icon">Favicon</label>
                                <input type="file" accept="image/*" class="form-control" name="fav_icon" id="fav_icon">
                                @if ($settings && $settings->fav_icon)
                                    <img src="{{ asset('image/setting/' . $settings->fav_icon) }}" alt="Favicon"
                                        class="mt-2" width="50">
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ old('name', $settings->name ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone"
                                    value="{{ old('phone', $settings->phone ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    value="{{ old('email', $settings->email ?? '') }}">
                            </div>

                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" name="address" id="address" rows="3">{{ old('address', $settings->address ?? '') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
