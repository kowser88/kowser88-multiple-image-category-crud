<!-- <option selected value="0">Select Category</option> -->
@foreach($cats as $cat)
<option value="{{$cat->id}}">{{$cat->name}}</option>
@endforeach