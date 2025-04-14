@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="box-title mb-0">View Bids</h5>
                        <a href="{{ route('bids.index') }}" class="btn btn-light btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        <br>
                        @include('components/alert')

                        <!-- Bids Details -->
                        <h5 class="text-primary">Bids Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Image:</strong>
                                    <span>
                                        @if ($bid->image)
                                            <img src="{{ asset('admin/bids/' . $bid->image) }}" width="100px"
                                                alt="img">
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Grand Total:</strong>
                                    <span>{{ $bid->total_amount }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Total Qty:</strong>
                                    <span>{{ $bid->total_qty }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Status:</strong>
                                    <span>
                                        @if ($bid->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>


                        <!-- Items Section -->
                        <h5 class="text-primary mt-4">Items</h5>
                        <div class="table-responsive mb-4">
                            <table class="table table-striped table-hover mb-4">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($bid->items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->type->name ?? 'N/A' }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->unit_price }}</td>
                                            <td>{{ $item->total_price }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No data found</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                    {{-- <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Add Comment</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('note.store', $workOrder->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="work_order_id" value="{{ $workOrder->id }}">
                            <div class="form-group">
                                <label for="content">Comment:</label>
                                <textarea class="form-control" id="content" name="content" rows="3" placeholder="Write your comment here..."
                                    required></textarea>
                            </div>
                            <div class="form-group mt-3">
                                <label for="images">Upload Images:</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple
                                    accept="image/*">
                                <small class="form-text text-muted">You can upload multiple images (jpg, png,
                                    etc.).</small>
                            </div>
                            <div id="imagePreview" class="mt-3 d-flex flex-wrap"></div>
                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </form>
                    </div>
                </div>

                <!-- Display Comments -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0">Comments</h5>
                    </div>
                    <div class="card-body">
                        @forelse ($comments as $comment)
                            <div class="comment-box border rounded p-3 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-primary">Comment</strong>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-2">{{ $comment->content }}</p>

                                @if (!empty($comment->image))
                                    <div class="row mt-2">
                                        @foreach (json_decode($comment->image, true) as $imageName)
                                            <div class="col-md-3 col-6">
                                                <a href="{{ asset('image/workorder/note/' . $imageName) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('image/workorder/note/' . $imageName) }}"
                                                        style="height: 200px; width:200px;" alt="Comment Image"
                                                        class="img-fluid rounded shadow-sm mb-2">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-muted">No comments available for this Bids.</p>
                        @endforelse
                    </div>
                </div> --}}

                </div>
            </div>



        </div>
        <!-- END: Page content-->
    @endsection

@section('script')
    <script>
        $('#images').on('change', function(event) {
            const imagePreview = $('#imagePreview');
            imagePreview.empty();
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const img = $('<img>').attr('src', e.target.result).css({
                        'max-width': '150px',
                        'margin': '10px'
                    });
                    imagePreview.append(img);
                }

                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
