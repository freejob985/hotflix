<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertise;
use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    public function index(){
    	$ads = Advertise::orderBy('id','desc')->paginate(15);
    	$empty_message = "No Ads Found";
    	$pageTitle = "Advertises";
    	return view('admin.advertise.index',compact('ads','empty_message','pageTitle'));
    }

    public function store(Request $request){
    	$this->validate($request, [
            'title' => 'required',
            'type' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif'
        ]);

    	$file = $request->image;
    	$path = 'assets/images/ads/';
    	$filename = '';
        if ($request->hasFile('image')) {
    		try {
                if ($file->getClientOriginalExtension() == 'gif'){
                    $filename = uploadFile($file, $path);
                }else{
                    $filename = uploadImage($file, $path, '728x90');
                }
    		} catch (\Exception $e) {
    			$notify[] = ['error','Image Could not uploaded'];
    			return back()->withNotify($notify);
    		}
        }
    	$data = [
        		'image'=>$filename,
        		'link'=>$request->link,
        		'script'=>$request->script,
        	];
        Advertise::insert([
        	'title' => $request->title,
        	'content'=>json_encode($data),
            'type' => $request->type,
        ]);
        $notify[] = ['success','Addvertise uploaded successfully'];
        return back()->withNotify($notify);
	}

    public function edit(Request $request, $id){
    	$this->validate($request, [
            'title' => 'required',
            'type' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif'
        ]);

    	$advertise = Advertise::findOrFail($id);
    	$filename = @$advertise->content->image;
        if ($request->hasFile('image')) {
    		$path = 'assets/images/ads/';
    		$file = $request->image;
    		try {
    		    if ($file->getClientOriginalExtension() == 'gif'){
                    $filename = uploadFile($file, $path, null,@$advertise->content->image);
    		    }else{
                    $filename = uploadImage($file, $path, '728x90',@$advertise->content->image);
                }
    		} catch (\Exception $e) {
    			$notify[] = ['error','Image Could not uploaded'];
    			return back()->withNotify($notify);
    		}
        }
    	$data = [
        		'image'=>$filename,
        		'link'=>$request->link,
        		'script'=>$request->script,
        	];
        $advertise->update([
        	'title' => $request->title,
        	'content'=>$data,
            'type' => $request->type,
        ]);
        $notify[] = ['success','Addvertise uploaded successfully'];
        return back()->withNotify($notify);
	}

	public function remove(Request $request){
		$st = Advertise::findOrFail($request->id);
		removeFile('assets/images/ads/'.@$st->content->image);
    	$st->delete();
    	$notify[] = ['success','Advertise Deleted Successfully'];
    	return back()->withNotify($notify);
	}
}
