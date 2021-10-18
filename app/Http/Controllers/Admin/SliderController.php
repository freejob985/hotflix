<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index(){
    	$pageTitle = "Sliders";
    	$items = Item::where('status',1)->orderBy('id','desc')->get();
    	$sliders = Slider::orderBy('id','desc')->with('item')->paginate(getPaginate());
    	return view('admin.sliders.index',compact('pageTitle','items','sliders'));
    }

    public function addSlider(Request $request){
    	$request->validate([
    		'item'=>'required|integer',
    		'image'=>'required|image|mimes:jpg,jpeg,png',
    	]);

    	if ($request->hasFile('image')) {
    		try {
    			$path = imagePath()['slider']['path'];
    			$size = imagePath()['slider']['size'];
    			$image = uploadImage($request->image,$path,$size,null,null,true);
    		} catch (\Exception $e) {
    			$notify[] = ['error','Image could not be uploaded'];
    			return back()->withNotify($notify);
    		}
    	}

    	Slider::create([
    		'item_id'=>$request->item,
    		'image'=>$image,
    		'caption_show'=>$request->caption_show ? 1 : 0,
    	]);

    	$notify[] = ['success','Slider added successfully'];
    	return back()->withNotify($notify);
    }

    public function update(Request $request,$id){
        $request->validate([
            'image'=>'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $slider = Slider::findOrFail($id);
        $image = $slider->image;
        if ($request->hasFile('image')) {
            try {
                $path = imagePath()['slider']['path'];
                $size = imagePath()['slider']['size'];
                $image = uploadImage($request->image,$path,$size,$slider->image,null,true);
            } catch (\Exception $e) {
                $notify[] = ['error','Image could not be uploaded'];
                return back()->withNotify($notify);
            }
        }

        $slider->update([
            'image'=>$image,
            'caption_show'=>$request->caption_show ? 1 : 0,
        ]);
        $notify[] = ['success','Slider updated successfully'];
        return back()->withNotify($notify);
    }

    public function remove(Request $request){
        $request->validate([
            'id'=>'required|integer'
        ]);

        $slider = Slider::findOrFail($request->id);
        removeFile('assets/images/slider/'.$slider->image);
        $slider->delete();
        $notify[] = ['success','Slider deleted successfully'];
        return back()->withNotify($notify);
    }
}
