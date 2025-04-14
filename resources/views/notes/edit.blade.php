@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fullheight">
                    <div class="card-header">
                        <h5 class="box-title">Edit Comments</h5>
                    </div>
                    <div class="card-body">
                        @include('components/alert')
                        <form action="{{ route('note.update', $note->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-4">
                                        <label for="status">Status<span style="color: red;">*</span></label>
                                        <select class="form-control" name="status" id="status" required>
                                            <option value="1" {{ $note->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $note->status == 0 ? 'selected' : '' }}>InActive
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mt-3">
                                        <label for="images">Upload Images:</label>
                                        <input type="file" class="form-control" id="images" name="images[]" multiple
                                            accept="image/*">

                                    </div>
                                    <div id="imagePreview" class="mt-3 d-flex flex-wrap">
                                        @if (!empty($note->image))
                                            @foreach (json_decode($note->image, true) as $imageName)
                                                <a href="{{ asset('image/workorder/note/' . $imageName) }}" target="_blank">
                                                    <img src="{{ asset('image/workorder/note/' . $imageName) }}"
                                                        style="height: 100px; width:100px;" alt="Comment Image"
                                                        class="img-fluid rounded shadow-sm mb-2">
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>


                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="content">Comment:</label>
                                        <textarea class="form-control" id="content" name="content" rows="3" placeholder="Write your comment here..."
                                            required>{{ $note->content }}</textarea>
                                    </div>
                                </div>


                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Update</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Page content-->
@endsection
