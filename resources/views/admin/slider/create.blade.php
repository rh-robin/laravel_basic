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
                        @if (session('fail'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('fail') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif
                        <div class="row p-3">
                            <div class="col">
                                <h2 class="float-left">Create Slider</h2>
                                <a href="{{ route('all.slider') }}" class="btn btn-primary float-right">All Slider</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form action="{{ route("store.slider") }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Title</label>
                                    <input name="title" type="text" class="form-control" id="title" value="{{ old('title') }}">
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image</label>
                                    <input name="image" type="file" class="form-control" id="image" value="{{ old('title') }}">
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="button_link" class="form-label">Button Link</label>
                                    <input name="button_link" type="text" class="form-control" id="button_link" value="{{ old('button_link') }}">
                                    <span class="">Leave it empty if there is no button</span>
                                    @error('button_link')
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
