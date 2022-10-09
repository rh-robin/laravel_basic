@extends('admin.admin_master')

@section('adminContent')

    <div class="py-12">
        <div class="container">
            <div class="row">
                
                <div class="col">
                    <div class="card">
                        @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>{{ session('success') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <div class="card-header">
                            <h4>Edit {{ $brand->brand_name }}</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ url("brand/update/".$brand->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="old_image" value="{{ $brand->brand_image }}">
                                <div class="mb-3">
                                    <label for="brand_name" class="form-label">Brand Name</label>
                                    <input name="brand_name" type="text" class="form-control" id="brand_name" value="{{ $brand->brand_name }}">
                                    @error('brand_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="brand_image" class="form-label">Brand Image</label>
                                    <input name="brand_image" type="file" class="form-control" id="brand_image" value="{{ $brand->brand_image }}">
                                    @error('brand_image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <img src="{{ asset($brand->brand_image) }}" alt="" style="width:100px">
                                </div>
                                <button type="submit" class="btn btn-primary">Update Brand</button>
                                <a href="{{ route('all.brand') }}" class="btn btn-secondary ml-2">Back</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
