@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mt-4 mb-5">Multiple Image CRUD & Hierarchical Categories Managment System</h2>
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card mb-4">
                <div class="card-header text-center fs-4">Category List</div>
                <div class="card-body">
                    <div class="tree">
                        <ul id="tree1">
                            @foreach($categories as $category)
                            <li>
                                <div class="d-flex align-items-center my-2">
                                   <span class="fs-5"> {{ $category->name }}</span>
                                   @auth
                                   <span class="d-inline-block ms-2">
                                    <a  href="{{url('/edit-category/'.$category->id)}}" class="btn btn-primary text-white py-1 px-2 ml-2 fs-6">Edit</a>
                                    <form class="d-inline-block" method="post" action="{{url('/delete-category/'.$category->id)}}" onsubmit="return confirm ('if you want to delete. then click ok')">
                                        @csrf
                                        <button type="submit" class="btn bg-danger py-1 px-2 text-white ms-2 fs-6">Delete</button>
                                    </form>
                                </span>
                                @endauth
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
    </div>
</div>

<div class="mt-5">
    {{ $categories->links() }}
</div>

</div>
@endsection
