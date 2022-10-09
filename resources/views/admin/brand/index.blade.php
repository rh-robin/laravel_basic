@extends('admin.admin_master')

@section('adminContent')

    <div class="py-12">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        @if (session('fail'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('fail') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <div class="card-header">
                            <h4>All Brand</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover brandsBackend">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Brand Name</th>
                                        <th scope="col">Brand Image</th>
                                        <th scope="col">Created At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    @foreach($brands as $brand)
                                    <tr>
                                        <th scope="row" style="vertical-align: middle">{{ $brands->firstItem()+$loop->index }}</th>
                                        <td style="vertical-align: middle">{{ $brand->brand_name }}</td>
                                        <td style="vertical-align: middle">
                                            <img src="{{ asset($brand->brand_image) }}" alt="" style="width:70;height:50px;">
                                        </td>
                                        <td style="vertical-align: middle">
                                            @if($brand->created_at == NULL)
                                            <span class="text-danger">No date set</span>
                                            @else
                                            {{ Carbon\Carbon::parse($brand->created_at)->diffForHumans() }}
                                            @endif
                                        </td>
                                        <td style="vertical-align: middle">
                                            <a href="{{ url('brand/edit/'.$brand->id) }}" class="btn btn-info btn-sm">Edit</a>
                                            <form class="d-inline" action="{{ url('brand/delete/'.$brand->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete?')" class="btn btn-danger btn-sm text-white">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{ $brands->links() }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Add Brand</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route("store.brand") }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="brand_name" class="form-label">Brand Name</label>
                                    <input name="brand_name" type="text" class="form-control" id="brand_name">
                                    @error('brand_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="brand_image" class="form-label">Brand Image</label>
                                    <input name="brand_image" type="file" class="form-control" id="brand_image">
                                    @error('brand_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary">Add</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
