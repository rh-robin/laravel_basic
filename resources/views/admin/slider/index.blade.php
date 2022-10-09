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
                                <h2 class="float-left">All Slider</h2>
                                <a href="{{ route('create.slider') }}" class="btn btn-primary float-right">Add Slider</a>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            <table class="table table-hover brandsBackend">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="">
                                    @foreach($sliders as $slider)
                                    <tr>
                                        <th scope="row" style="vertical-align: middle">{{ $loop->index+1 }}</th>
                                        <td style="vertical-align: middle">{{ $slider->title }}</td>
                                        <td style="vertical-align: middle">
                                            <img src="{{ asset($slider->image) }}" alt="" style="width:70;height:50px;">
                                        </td>
                                        <td style="vertical-align: middle">
                                            {{ $slider->description }}
                                        </td>
                                        <td style="vertical-align: middle">
                                            <a href="{{ url('slider/edit/'.$slider->id) }}" class="btn btn-info btn-sm">Edit</a>
                                            <form class="d-inline" action="{{ url('slider/delete/'.$slider->id) }}" method="POST">
                                                @csrf
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure to delete?')" class="btn btn-danger btn-sm text-white">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
@endsection
