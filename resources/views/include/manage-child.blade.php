<ul>
	@foreach($childs as $child)
	<li>
		<div class="d-flex align-items-center my-2">
			{{ $child->name }}

			@auth
			<span class="d-inline-block ms-2">
				<a  href="{{url('/edit-category/'.$child->id)}}" class="text-primary py-1 px-2 ml-2 fs-6"><small>Edit</small></a>
				<form class="d-inline-block" method="post" action="{{url('/delete-category/'.$child->id)}}" onsubmit="return confirm ('if you want to delete. then click ok')">
					@csrf
					<button type="submit" class="btn bg-transparent p-0 text-danger ms-2 fs-6"><small>Delete</small></button>
				</form>
			</span>
			@endauth
		</div>
		@if(count($child->childs))
		@include('include.manage-child',['childs' => $child->childs])
		@endif
	</li>
	@endforeach
</ul>