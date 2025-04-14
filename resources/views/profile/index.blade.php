@extends('admin.masterAdmin')
@section('content')
    <div>
        <div class="card">
            <div class="card-header">
                <h5 class="box-title">Your Profile</h5>
            </div>
            <div class="card-body">
                <br>
                @include('components/alert')
                <div class="profile-info">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Joined:</strong> {{ $user->created_at->format('F j, Y') ?? '' }}</p>
                </div>

                <div class="edit-profile">
                    <a href="{{ route('profile.edit', $user->id) }}" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>


    </div>
@endsection
