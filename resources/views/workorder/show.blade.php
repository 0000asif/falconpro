@extends('admin.masterAdmin')
@section('content')
    <!-- BEGIN: Page content-->
    <div>
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <h5 class="box-title mb-0">View Work Order</h5>
                        <a href="{{ route('work-order.index') }}" class="btn btn-light btn-sm">Back</a>
                    </div>
                    <div class="card-body">
                        @include('components/alert')
                        <br>

                        <!-- Work Order Details -->
                        <h5 class="text-primary">Work Order Details</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Invoice:</strong>
                                    <span>{{ $workOrder->invoice ?? '' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Work Order Number:</strong>
                                    <span>{{ $workOrder->work_order_number ?? '' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Company Order Number:</strong>
                                    <span>{{ $workOrder->company_order_number ?? '' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Company:</strong>
                                    <span>{{ $workOrder->company->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Client:</strong>
                                    <span>{{ $workOrder->client->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Vendor:</strong>
                                    <span>{{ $workOrder->vendor->name ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Due Date:</strong>
                                    <span>{{ date('m-d-Y', strtotime($workOrder->due_date)) }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Grand Total:</strong>
                                    <span>{{ $workOrder->grand_total ?? '' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Total Qty:</strong>
                                    <span>{{ $workOrder->total_qty ?? '' }}</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Attach File:</strong>
                                    <span>
                                        @if ($workOrder->file)
                                            <a href="{{ asset('public/images/work-order/' . $workOrder->file) }}"
                                                download="" class="btn btn-success btn-sm">Download</a>
                                        @else
                                            N/A
                                        @endif
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between border p-2">
                                    <strong>Status:</strong>
                                    <span>
                                        @if ($workOrder->status_id == 1)
                                            <span class="badge badge-success">{{ $workOrder->status->name }}</span>
                                        @elseif($workOrder->status_id == 10)
                                            <span class="badge badge-danger">{{ $workOrder->status->name }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ $workOrder->status->name }}</span>
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
                                    @forelse ($workOrder->items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->type->name ?? 'N/A' }}</td>
                                            <td>{{ $item->description ?? 'N/A' }}</td>
                                            <td>{{ $item->qty }}</td>
                                            <td>{{ $item->unit_price }}</td>
                                            <td>{{ $item->total_price }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td colspan="6">No Data Found</td>
                                            <!-- Ensure colspan matches table columns -->
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @can('view bids')
                    {{-- Bids seciton --}}
                    <div class="card mt-4">
                        <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                            <h5 class="box-title">Bids List</h5>
                            @can('view bids')
                                <a href="{{ route('bids.print', $workOrder->id) }}" class="btn btn-primary btn-sm">Print</a>
                            @endcan
                            @can('create bids')
                                <a href="{{ route('createbids', $workOrder->id) }}" class="btn btn-light btn-sm">Add New</a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <br>
                            @forelse ($bids as $bid)
                                @can('edit bids')
                                    <a class="btn btn-sm btn-danger text-white align-right mb-2"
                                        href="{{ route('bids.edit', $bid->id) }}">Edit</a>
                                @endcan


                                <div class="border rounded p-3 mb-3">
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
                                                <span>{{ $bid->total_amount ?? '' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-between border p-2">
                                                <strong>Total Qty:</strong>
                                                <span>{{ $bid->total_qty ?? '' }}</span>
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
                                                        <td>{{ $item->description ?? 'N/A' }}</td>
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
                            @empty
                                <div class="text-center text-muted">No Bids Found</div>
                            @endforelse


                        </div>
                    </div>
                @endcan

                @can('create client invoice')
                    {{-- Client Invoice --}}
                    <div class="card mt-4">
                        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                            <h5 class="box-title">Client Invoice</h5>
                            @can('view client invoice')
                                <a href="{{ route('clientinvoice.print', $workOrder->id) }}"
                                    class="btn btn-primary btn-sm">Print</a>
                            @endcan
                            @can('create client invoice')
                                <a href="{{ route('clientinvoice', $workOrder->id) }}" class="btn btn-light btn-sm">Add New</a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <br>
                            @forelse ($clientinvoice as $bid)
                                @can('edit client invoice')
                                    <a class="btn btn-sm btn-success text-white align-right mb-2"
                                        href="{{ route('clientinvoice.edit', $bid->id) }}">Edit</a>
                                @endcan

                                <div class="border rounded p-3 mb-3">
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
                                                <span>{{ $bid->total_amount ?? '' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-between border p-2">
                                                <strong>Total Qty:</strong>
                                                <span>{{ $bid->total_qty ?? '' }}</span>
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
                                                        <td>{{ $item->description ?? 'N/A' }}</td>
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
                            @empty
                                <div class="text-center text-muted">No Invoice Found</div>
                            @endforelse

                        </div>
                    </div>
                @endcan

                @can('create vendor invoice')
                    {{-- vendor Invoice --}}
                    <div class="card mt-4">
                        <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                            <h5 class="box-title">Vendor Invoice</h5>
                            @can('view vendor invoice')
                                <a href="{{ route('vendorinvoice.print', $workOrder->id) }}"
                                    class="btn btn-primary btn-sm">Print</a>
                            @endcan
                            @can('create vendor invoice')
                                <a href="{{ route('vendorinvoice', $workOrder->id) }}" class="btn btn-light btn-sm">Add New</a>
                            @endcan
                        </div>
                        <div class="card-body">
                            <br>
                            @forelse ($vendorinvoice as $bid)
                                @can('edit vendor invoice')
                                    <a class="btn btn-sm btn-success text-white align-right mb-2"
                                        href="{{ route('vendorinvoice.edit', $bid->id) }}">Edit</a>
                                @endcan

                                <div class="border rounded p-3 mb-3">
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
                                                <span>{{ $bid->total_amount ?? '' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="d-flex justify-content-between border p-2">
                                                <strong>Total Qty:</strong>
                                                <span>{{ $bid->total_qty ?? '' }}</span>
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
                                                        <td>{{ $item->description ?? 'N/A' }}</td>
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
                            @empty
                                <div class="text-center text-muted">No Invoice Found</div>
                            @endforelse
                        </div>
                    </div>
                @endcan

                @can('create comment')
                    {{-- comments seciton  --}}
                    <div class="card mt-4">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Add Comment</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('note.store', $workOrder->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="work_order_id" value="{{ $workOrder->id }}">

                                <div class="form-group">
                                    <label for="content">Comment:</label>
                                    <textarea class="form-control" id="content" name="content" rows="3"
                                        placeholder="Write your comment here..." required></textarea>
                                </div>
                                <div class="form-group mt-3">
                                    <label for="images">Upload Images:</label>
                                    <input type="file" class="form-control" id="images" name="images[]" multiple
                                        accept="image/*">
                                    <small class="form-text text-muted">You can upload multiple images (jpg, png,
                                        etc.).</small>
                                </div>
                                <div id="imagePreview" class="mt-3 d-flex flex-wrap"></div>

                                <div class="form-group mt-3 {{ $vendor ? 'd-none' : '' }}">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="show_to_vendor"
                                            name="show_to_vendor">
                                        <label class="form-check-label" for="show_to_vendor">
                                            Hide form Vendor
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Submit</button>

                            </form>
                        </div>
                    </div>
                @endcan

                @can('view comment')
                    <!-- Display Comments -->
                    <div class="card mt-4">
                        <div class="card-header">
                            <h5 class="mb-0">Comments</h5>
                        </div>
                        <div class="card-body">
                            @forelse ($comments as $comment)
                                <div class="comment-box border rounded p-3 mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong class="text-primary">{{ Auth::user()->name }}</strong>
                                        <div class="sub-div">
                                            <strong class="mr-2"><a href="{{route('note.edit',$comment->id)}}"><i class="fa fa-edit"></i></a></strong>
                                            <small class="text-muted"> {{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                    <p class="mb-2">{{ $comment->content ?? '' }}</p>

                                    @if (!empty($comment->image))
                                        <div class="row mt-2">
                                            @foreach (json_decode($comment->image, true) as $imageName)
                                                <div class="col-md-3 col-6">
                                                    <a href="{{ asset('image/workorder/note/' . $imageName) }}">
                                                        <img src="{{ asset('image/workorder/note/' . $imageName) }}"
                                                            style="height: 200px; width:250px; object-fit: contain;"
                                                            alt="Comment Image" class="img-fluid rounded shadow-sm mb-2">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <p class="text-muted">No comments available for this work order.</p>
                            @endforelse
                        </div>
                    </div>
                @endcan

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
