@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{url('/categories')}}">Categories</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
    </ol>
</nav>

@if (session('status'))
<div class="alert alert-success">{{session('status')}}</div>
@endif

@if (session('statusDel'))
<div class="alert alert-danger">{{session('statusDel')}}</div>
@endif


<div class="card mb-4">
    <div class="card-header">Update Category</div>
    <div class="card-body">
        <form method="post" action="{{route('updateCategory')}}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="category_id" value="{{$category->id}}">
            <div class="form-group mb-3">
                <label class="">Name</label>
                <input type="text" class="form-control" name="name" value="{{$category->name}}">
            </div>

            <div class="form-group mb-3">
                <label class="">Parent Category</label>
                <select class="form-select" name="parent_id">
                    <option value ="0">Main Category</option>
                    @foreach($cats as $cat)
                    <option @if($cat->id == $category->parent_id) selected @endif value ="{{$cat->id}}">{{$cat->name}} @if($cat->parent_id == 0) - Main Category @endif</option>
                    @endforeach
                </select>
            </div>

            <button type=”submit” class="btn btn-primary btn-block">Save</button>

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


</div>
@endsection


@if(url()->current() == url('/sub-categories'))
@section('script')
<script type="text/javascript">

    window.onload = function() {
        $.ajax({
            url: window.get_category,
            type: 'get',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                    // console.log(response);
                    $("#categoryList").html(response);
                }
            });
    };

</script>
@endsection
@endif
