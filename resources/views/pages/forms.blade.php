@extends('layouts.app')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Form</li>
    </ol>
</nav>

@if (session('status'))
<div class="alert alert-success">{{session('status')}}</div>
@endif

@if (session('statusDel'))
<div class="alert alert-danger">{{session('statusDel')}}</div>
@endif


<div class="card mb-4">
    <div class="card-header">Form</div>
    <div class="card-body">
        <form method="post" action="{{route('formSubmit')}}" enctype="multipart/form-data">
            @csrf

            <div class="form-group mb-3">
                <label class="">Name</label>
                <input type="text" class="form-control" name="name" >
            </div>
            <div class="form-group mb-3">
                <label class="">Email</label>
                <input type="email" class="form-control" name="email" >
            </div>

            <div class="form-group mb-3 cat-fg">
                <label class="">Category</label>
                <select class="form-select" name="categories[]" onchange ="getSubCats(event)" required="">
                    @foreach($cats as $cat)
                    <option value ="{{$cat->id}}">{{$cat->name}}</option>
                    @endforeach
                </select>
                @if(count($cats[0]->childs))
                @include('include.category-select',['cats' => $cats[0]->childs])
                @endif
            </div>

            <div class="form-group mb-3">
                <label class="">Message</label>
                <textarea class="form-control py-3" name="message" placeholder="Write here ..."></textarea>
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

<div class="card mb-4">
    <div class="card-header text-center fs-4">Form List</div>
    <div class="card-body">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Email</th>
              <th scope="col">Message</th>
              <th scope="col">Categories</th>
              <th scope="col">Handle</th>
          </tr>
      </thead>
      <tbody>
         @foreach($forms as $form)
         <tr>
          <th scope="row">{{ $form->email }}</th>
          <td>{{ $form->message }}</td>
          <td>d</td>
          <td><form class="d-inline-block" method="post" action="{{url('/delete-form/'.$form->id)}}" onsubmit="return confirm ('if you want to delete. then click ok')">
            @csrf
            <button type="submit" class="btn bg-danger py-1 px-2 text-white ms-2 fs-6">Delete</button>
        </form></td>
    </tr>
    @endforeach
</tbody>
</table>

</div>

</div>
<div class="mt-5">
    {{ $forms->links() }}
</div>
</div>
@endsection


@section('script')
<script type="text/javascript">
    function getSubCats(e) {
     let val = $(e.target).val();
     $(e.target).nextAll('.csg').remove();
     $.ajax({
        url: window.get_cat_select,
        type: 'get',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: val
        },
        success: function(response) {
                    // console.log(response);
                    $(".cat-fg").append(response);
                }
            });
 }

</script>
@endsection
