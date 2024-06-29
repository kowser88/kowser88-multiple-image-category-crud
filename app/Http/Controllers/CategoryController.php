<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Form;

class CategoryController extends Controller
{

	public function categories()
	{
		$data['categories'] = Category::where('parent_id', '=', 0)->simplePaginate(8);

		return view('pages.categories', $data);

	}

	public function subCategories()
	{
		$data['categories'] = Category::where('parent_id', '=', 0)->simplePaginate(8);

		return view('pages.categories', $data);
	}


	public function addCategory(Request $req) {

		$messages = [
			'name.required' => 'Name is required.',
			'name.max' => 'Maximum 255 character allowed.'
		];

		$this->validate($req, [
			'name' => 'required|max:255'
		],$messages);

		$add_c = new Category;

		$add_c->name = $req->name;
		if($req->parent_id) {
			$add_c->parent_id = $req->parent_id;
		}

		$add_c->save();
		
		return redirect()->back()->with('status', 'Category Added successfully!');

	}

	public function editCategory($id)
	{
		$data['category'] = Category::find($id);
		$data['cats'] = Category::whereNotIn('id', [$id])->whereNotIn('parent_id', [$id])->get();
		return view('pages.edit-category', $data);
	}

	public function updateCategory(Request $req) {
		$messages = [
			'name.required' => 'Name is required.',
			'name.max' => 'Maximum 255 character allowed.'
		];

		$this->validate($req, [
			'name' => 'required|max:255'
		],$messages);

		$add_c = Category::find($req->category_id);

		$add_c->name = $req->name;
		$add_c->parent_id = $req->parent_id;

		$add_c->save();

		return redirect('/categories')->with('status', 'Category updated successfully!');

	}

	public function deleteCategory($id = null) {

		$category = Category::find($id);

		if (count($category->childs) > 0) {
			$this->deleteSubCategories($category->childs);
		}

		$category->delete();

		return back()->with('statusDel', 'Category deleted successfully!');
	}

	public function deleteSubCategories($categories)
	{
		foreach ($categories as $category) {
			if (count($category->childs) > 0) {
				$this->deleteSubCategories($category->childs);
			}

			$category->delete();
		}

	}

	public function forms()
	{
		$data['cats'] = Category::where('parent_id', '=', 0)->get();
		$data['forms'] = Form::simplePaginate(20);

		return view('pages.forms', $data);

	}

	public function getCategory()
	{
		$cats = Category::get();

		$html = view('include.category-options', compact('cats'))->render();

		return $html;
	}

	public function getCatSelect(Request $req)
	{
		$cats = Category::find($req->id)->childs;
		if($cats->count() > 0){
			$html = view('include.category-select', compact('cats'))->render();

			return $html;
		}
		
	}
	public function formSubmit(Request $req) {
		$messages = [
			'name.required' => 'Name is required.',
			'name.max' => 'Maximum 255 character allowed.',
		];

		$this->validate($req, [
			'name' => 'required|max:255',
			'email' => 'required|email',
			'message' => 'required|max:2000'
		],$messages);

		$add_c = new Form;
		$add_c->name = $req->name;
		$add_c->email = $req->email;
		$add_c->categories = json_encode($req->categories);
		$add_c->message = $req->message;

		$add_c->save();
		
		return redirect()->back()->with('status', 'Form submitted successfully!');

	}
	public function deleteForm($id = null) {

		$form = Form::find($id);

		$form->delete();

		return back()->with('statusDel', 'Form deleted successfully!');
	}

}
