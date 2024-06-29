<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\Category;

class ImageController extends Controller
{

	public function images()
	{
		$data['images'] = Image::simplePaginate(18);
		return view('pages.images', $data);
	}

	public function addImages(Request $req) {

		$messages = [
			'images.required' => 'Images is required.',
			'images.*.mimes' => 'Only jpeg, png, jpg, gif, svg, webp and bmp images are allowed.',
			'images.*.max' => 'Sorry! Maximum allowed size for an image is 2MB.',
		];

		$this->validate($req, [
			'images' => 'required',
			'images.*' => 'mimes:jpeg,png,jpg,webp,gif,svg,bmp|max:2048'
		],$messages);

		$i=0;
		foreach ($req->images as $s_image) {
			if($s_image){
				$file= $s_image;
				$filename= 'image_'. $i++ . time().'.'.$s_image->getClientOriginalExtension();
				$file-> move(public_path('uploads/images'), $filename);
			}

			$add_c = new Image;
			if($s_image){
				$add_c->name = $filename;
			}
			$add_c->save();
		}

		return redirect()->back()->with('status', 'Image Added successfully!');

	}

	public function updateImages(Request $req) {

		$messages = [
			'image.required' => 'Image is required.',
			'image.*.mimes' => 'Only jpeg, png, jpg, gif, svg, webp and bmp images are allowed.',
			'image.*.max' => 'Sorry! Maximum allowed size for an image is 2MB.',
		];

		$this->validate($req, [
			'image' => 'required',
			'image.*' => 'mimes:jpeg,png,jpg,webp,gif,svg,bmp|max:2048'
		],$messages);

		$add_c = Image::find($req->image_id);

		if($req->image){
			if($add_c->name){
				$file= $req->image;
				$filename= $add_c->name;
				$file-> move(public_path('uploads/images'), $filename);
			}else{
				$file= $req->image;
				$filename= 'image_' . time().'.'.$req->image->getClientOriginalExtension();
				$file-> move(public_path('uploads/images'), $filename);
				$add_c->image = $filename;
			}
		}

		if($req->image){
			$add_c->name = $filename;
		}

		$add_c->save();

		return back()->with('status', 'Image updated successfully!');

	}

	public function deleteImages($id = null) {

		$image = Image::find($id);

		if($image->name) {
			unlink(public_path('uploads/images/'.$image->name));
		}

		$image->delete();

		return back()->with('statusDel', 'Image deleted successfully!');
	}
}
