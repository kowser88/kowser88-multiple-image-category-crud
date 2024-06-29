@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
    <div class="alert alert-success">{{session('status')}}</div>
    @endif

    @if (session('statusDel'))
    <div class="alert alert-danger">{{session('statusDel')}}</div>
    @endif


    <div class="card mb-4">
        <div class="card-header">Add Images</div>
        <div class="card-body">
            <form method="post" action="{{route('addImages')}}" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-2">
                    <label class="">Image <small class="text-success">(can upload multiple)</small></label>
                    <input type="file" class="form-control" name="images[]" multiple>
                </div>
                <button type=”submit” class="btn btn-primary btn-block">Upload</button>
            </form>
        </div>
    </div>


    @if ($errors->any())
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
        <div>{{$error}}</div>
        @endforeach
    </div>
    @endif


    @if($images->count())
    <h2 class="mb-4">Image List:</h2>
    <div class="row">
        @foreach(@$images as $image)
        <div class="col-md-4 mb-3">
            <div class="card">
                <button class="btn btn-primary d-flex align-items-center justify-content-between collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$image->id}}" aria-expanded="false" aria-controls="collapse{{$image->id}}">
                    <img width="60" src="{{asset('uploads/images/'.$image->name)}}" alt="img"> 
                    <span>&#11165;</span>
                </button>
                <div class="collapse" id="collapse{{$image->id}}">
                    <div class="card-body">
                        <div class="card mb-4">
                            <div class="card-header d-md-flex align-items-center justify-content-center">
                                <form class="d-inline-block" method="post" action="{{url('/delete-images/'.$image->id)}}" onsubmit="return confirm ('if you want to delete. then click ok')">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{route('updateImages')}}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" class="form-control" name="image_id" value="{{$image->id}}">
                                    <div class="form-group mb-2">
                                        <label class="">Image</label>
                                        <input type="file" class="form-control mb-2" name="image">
                                        @if($image->name)
                                        <img class="mb-2 img-fluid" src="{{asset('uploads/images/'.$image->name)}}" alt="img">
                                        @endif
                                    </div>
                                    <button type=”submit” class="btn btn-primary btn-block">Save</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="my-3">
        {{ $images->links() }}
    </div>
    
    @endif
</div>
@endsection
