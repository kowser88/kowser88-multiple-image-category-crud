<div class="csg my-2 ms-2">
	<select class="form-select" name="categories[]" onchange="getSubCats(event)">
		@foreach($cats as $cat)
		<option value ="{{$cat->id}}">{{$cat->name}}</option>
		@endforeach
	</select>
	@if(count($cats[0]->childs))
	@include('include.category-select',['cats' => $cats[0]->childs])
	@endif
</div>