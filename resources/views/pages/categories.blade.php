@extends('layouts.app')

@section('content')
<div class="container">

    @if (session('status'))
    <div class="alert alert-success">{{session('status')}}</div>
    @endif

    @if(session('statusDel'))
    <div class="alert alert-danger">{{session('statusDel')}}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Add Category</div>
        <div class="card-body">
            <form method="post" action="{{route('addCategory')}}" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label class="">Name</label>
                    <input type="text" class="form-control" name="name">
                </div>

                @if(url()->current() == url('/sub-categories'))
                <div class="form-group mb-3">
                    <label class="">Parent Category</label>
                    <select class="form-select" name="parent_id" id="categoryList">
                    </select>
                </div>
                @endif

                <button type=”submit” class="btn btn-primary btn-block">Save</button>

            </form>
        </div>
    </div>

    @if(url()->current() == url('/categories'))
    <div class="mt-3 mb-4">
        <a class="fw-bold" href="{{url('/sub-categories')}}">Add Sub Category</a>
    </div>
    @endif


    @if ($errors->any())
    <div class="alert alert-warning">
        @foreach ($errors->all() as $error)
        <div>{{$error}}</div>
        @endforeach
    </div>
    @endif


    <div class="card mb-4">
        <div class="card-header text-center fs-4">Category List</div>
        <div class="card-body">
            <div class="tree">
                <ul id="tree1">
                    @foreach($categories as $category)
                    <li>
                        <div class="d-flex align-items-center my-2">
                           <span class="fs-5"> {{ $category->name }}</span>
                           <span class="d-inline-block ms-2">
                            <a  href="{{url('/edit-category/'.$category->id)}}" class="btn btn-primary text-white py-1 px-2 ml-2 fs-6">Edit</a>
                            <form class="d-inline-block" method="post" action="{{url('/delete-category/'.$category->id)}}" onsubmit="return confirm ('if you want to delete. then click ok')">
                                @csrf
                                <button type="submit" class="btn bg-danger py-1 px-2 text-white ms-2 fs-6">Delete</button>
                            </form>
                        </span>
                    </div>
                    @if(count($category->childs))
                    @include('include.manage-child',['childs' => $category->childs])
                    @endif
                </li>
                @endforeach
            </ul>
        </div>

    </div>
</div>


<div class="mt-5">
    {{ $categories->links() }}
</div>

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
