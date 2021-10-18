<?php

namespace App\Http\Controllers\Admin;

use App\Rules\FileTypeValidate;
use File;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Models\Item;
use App\Models\SubCategory;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function items(){
        $pageTitle = "Video Items";
        $items = Item::orderBy('id','desc')->with('category','sub_category', 'video')->paginate(getPaginate());
        return view('admin.item.index',compact('pageTitle','items'));
    }

    public function singleItems(){
        $pageTitle = "Single Video Items";
        $items = Item::singleItems()->orderBy('id','desc')->with('category','sub_category', 'video')->paginate(getPaginate());
        return view('admin.item.index',compact('pageTitle','items'));
    }

    public function episodeItems(){
        $pageTitle = "Episode Video Items";
        $items = Item::episodeItems()->orderBy('id','desc')->with('category','sub_category', 'video')->paginate(getPaginate());
        return view('admin.item.index',compact('pageTitle','items'));
    }

    public function trailerItems(){
        $pageTitle = "Trailer Video Items";
        $items = Item::trailerItems()->orderBy('id','desc')->with('category','sub_category', 'video')->paginate(getPaginate());
        return view('admin.item.index',compact('pageTitle','items'));
    }

    public function create(){
        $pageTitle = "Upload Single Video Item";
        $categories = Category::active()->orderBy('id','desc')->get();
        return view('admin.item.singleCreate',compact('pageTitle','categories'));
    }

    public function store(Request $request){
        //Validation
        $request->validate([
            'title'=>'required',
            'category'=>'required',
            'sub_category_id'=>'nullable',
            'preview_text'=>'required',
            'description'=>'required',
            'director'=>'required',
            'producer'=>'required',
            'casts'=>'required',
            'tags'=>'required',
            'item_type'=>'required',
            'portrait' => 'required|image|mimes:jpg,jpeg,png',
            'landscape' => 'required|image|mimes:jpg,jpeg,png',
            'ratings' => 'required|numeric'
        ]);
        if ($request->item_type == 1) {
            if ($request->version == null) {
                $notify[] = ['error','Version Required'];
                return back()->withInput($request->all())->withNotify($notify);
            }
        }
        if ($request->item_type != 1 && $request->item_type != 2 && $request->item_type != 3) {
            $notify[] = ['error','Something wrong'];
            return back()->withInput($request->all())->withNotify($notify);
        }
        if (isset($request->version) && $request->version != 1 && $request->version != 0) {
            $notify[] = ['error','Something is wrong'];
            return back()->withInput($request->all())->withNotify($notify);
        }
        if ($request->item_type == 1) {
            $version = $request->version;
        }else{
            $version = null;
        }
        //landscap image upload
        if ($request->hasFile('landscape')) {
            //Check image size
            $maxLandScapSize = $request->landscape->getSize() / 1000000;
            if ($maxLandScapSize > 3) {
                $notify[0] = ['error','Landscape image size could not be greater than 3mb'];
                return back()->withInput($request->all())->withNotify($notify);
            }
            try {
                $date = date('Y').'/'.date('m').'/'.date('d');
                $path = 'assets/images/item/landscape/'.$date;
                $landscape = $date.'/'.uploadImage($request->landscape,$path);
            } catch (Exception $e) {
                $notify[0] = ['error','Landscape image could not be uploaded'];
                return back()->withInput($request->all())->withNotify($notify);
            }
        }

        //portrait image upload
        if ($request->hasFile('portrait')) {

            //Check image size
            $maxLandScapSize = $request->portrait->getSize() / 1000000;
            if ($maxLandScapSize > 3) {
                $notify[0] = ['error','Portrait image size could not be greater than 3mb'];
                return back()->withInput($request->all())->withNotify($notify);
            }
            try {
                $date = date('Y').'/'.date('m').'/'.date('d');
                $path = 'assets/images/item/portrait/'.$date;
                $portrait = $date.'/'.uploadImage($request->portrait,$path);
            } catch (\Exception $e) {
                $notify[] = ['error','Portrait image could not be uploaded'];
                return back()->withInput($request->all())->withNotify($notify);
            }
        }

        $team = [
            'director'=>$request->director,
            'producer'=>$request->producer,
            'casts'=>implode(',',$request->casts),
        ];
        $image = [
            'landscape'=>$landscape,
            'portrait'=>$portrait
        ];
        $item = Item::create([
            'category_id'=>$request->category,
            'sub_category_id'=>$request->sub_category_id,
            'title'=>$request->title,
            'preview_text'=>$request->preview_text,
            'description'=>$request->description,
            'team'=>$team,
            'item_type'=>$request->item_type,
            'tags'=>implode(',',$request->tags),
            'status'=>1,
            'image'=>$image,
            'version'=>$version,
            'ratings'=>$request->ratings,
        ]);

        $notify[] = ['success','Item Uploaded successfully'];
        if ($request->item_type == 2) {
            return redirect()->route('admin.item.episodes',$item->id)->withNotify($notify);
        }else{
            return redirect()->route('admin.item.uploadVideo',$item->id)->withNotify($notify);
        }

    }

    public function edit($id){
        $item = Item::findOrFail($id);
        $pageTitle = "Edit : ".$item->title;
        $categories = Category::active()->orderBy('id','desc')->get();
        $sub_categories = SubCategory::where('status',1)->where('category_id',$item->category_id)->orderBy('id','desc')->get();
        return view('admin.item.edit',compact('pageTitle','item','categories','sub_categories'));
    }

    public function update(Request $request,$id){
        //Validation
        $request->validate([
            'title'=>'required',
            'category'=>'required',
            'sub_category_id'=>'nullable',
            'preview_text'=>'required',
            'description'=>'required',
            'director'=>'required',
            'producer'=>'required',
            'casts'=>'required',
            'tags'=>'required',
            'portrait' => 'nullable|image|mimes:jpg,jpeg,png',
            'landscape' => 'nullable|image|mimes:jpg,jpeg,png',
            'version' => 'nullable',
            'ratings' => 'required|numeric',
        ]);
        if (isset($request->version) && $request->version != 1 && $request->version != 0) {
            $notify[] = ['error','Something is wrong'];
            return back()->withInput($request->all())->withNotify($notify);
        }
        $item = Item::findOrFail($id);
        $landscape = @$item->image->landscape;
        $portrait = @$item->image->portrait;
        //landscap image upload
        if ($request->hasFile('landscape')) {

            //Check image size
            $maxLandScapSize = $request->landscape->getSize() / 1000000;
            if ($maxLandScapSize > 3) {
                $notify[0] = ['error','Landscape image size could not be greater than 3mb'];
                return back()->withInput($request->all())->withNotify($notify);
            }
            try {
                $date = date('Y').'/'.date('m').'/'.date('d');
                $path = 'assets/images/item/landscape/'.$date;
                removeFile('assets/images/item/landscape/'.@$item->image->landscape);
                $landscape = $date.'/'.uploadImage($request->landscape,$path);
            } catch (Exception $e) {
                $notify[0] = ['error','Landscape image could not be uploaded'];
                return back()->withInput($request->all())->withNotify($notify);
            }
        }

        //portrait image upload
        if ($request->hasFile('portrait')) {

            //Check image size
            $maxLandScapSize = $request->portrait->getSize() / 1000000;
            if ($maxLandScapSize > 3) {
                $notify[0] = ['error','Portrait image size could not be greater than 3mb'];
                return back()->withInput($request->all())->withNotify($notify);
            }
            try {
                $date = date('Y').'/'.date('m').'/'.date('d');
                $path = 'assets/images/item/portrait/'.$date;
                removeFile('assets/images/item/portrait/'.@$item->image->portrait);
                $portrait = $date.'/'.uploadImage($request->portrait,$path);
            } catch (Exception $e) {
                $notify[0] = ['error','Portrait image could not be uploaded'];
                return back()->withInput($request->all())->withNotify($notify);
            }
        }

        $team = [
            'director'=>$request->director,
            'producer'=>$request->producer,
            'casts'=>implode(',',$request->casts),
        ];
        $image = [
            'landscape'=>$landscape,
            'portrait'=>$portrait
        ];
        $item->update([
            'category_id'=>$request->category,
            'sub_category_id'=>$request->sub_category_id,
            'title'=>$request->title,
            'preview_text'=>$request->preview_text,
            'description'=>$request->description,
            'team'=>$team,
            'tags'=>implode(',',$request->tags),
            'image'=>$image,
            'version'=>$request->version,
            'ratings'=>$request->ratings,
        ]);
        $notify[] = ['success','Item Updated successfully'];
        return back()->withNotify($notify);
    }

    public function status($id){

//        $notify[] = ['warning', 'You can not change anything over this demo.'];
//        $notify[] = ['info', 'This version is for demonstration purposes only and few actions are blocked.'];
//        return back()->withNotify($notify);

        $item = Item::findOrFail($id);

        if ($item->status == 1) {

            if ($item->single){
                $notify[] = ['warning','Please select another one as single section to deactive!'];
                return back()->withNotify($notify);
            }

            $item->status = 0;
            $notify[] = ['success','Item inactivated successfully'];
        }else{
            $item->status = 1;
            $notify[] = ['success','Item activated successfully'];
        }
        $item->save();
        return back()->withNotify($notify);
    }

    public function uploadVideo($id){
        $item = Item::findOrFail($id);
        $video = $item->video;
        if ($video) {
            $notify[] = ['error','Already video exist'];
            return back()->withNotify($notify);
        }
        $pageTitle = "Upload video to: ".$item->title;
        $prevUrl = route('admin.item.index');
        return view('admin.item.video.upload',compact('item','pageTitle','video','prevUrl'));
    }
    public function upload(Request $request,$id){

//        $notify[] = ['warning', 'You can not change anything over this demo.'];
//        $notify[] = ['info', 'This version is for demonstration purposes only and few actions are blocked.'];
//        return response()->json(['demo'=>$notify]);

        ini_set('memory_limit', '-1');
        $validation_rule['video_type'] = 'required';
        $validation_rule['link'] = 'required_without:video';
        if ($request->video_type == 1) {
            $validation_rule['video'] = ['required_without:link',new FileTypeValidate(['mp4', 'mkv', '3gp'])];
        }

        $validator = Validator::make($request->all(),$validation_rule);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $item = Item::findOrFail($id);
        $video = $item->video;

        if ($video) {
            return response()->json(['errors'=>'Already video exist']);
        }

        $gnl = GeneralSetting::first();

        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $videoSize = $file->getSize();
            $disk = $gnl->server;
            if ($videoSize > 4194304000) {
                return response()->json(['errors'=>'File size must be lower then 4 gb']);
            }
            $date = date('Y').'/'.date('m').'/'.date('d');
            if ($disk == 'current') {

                try{
                    $location = 'assets/videos/'.$date;
                    $video = $date.'/'.upload_video($file,$location);
                }catch (\Exception $exp) {
                    return response()->json(['errors'=>'Could not upload the Video']);
                }

                $server = 0;

            }else{
                try{
                    $fileExtension = $request->file('video')->getClientOriginalExtension();
                    $file = File::get($request->video);
                    $location = 'videos/'.$date;
                    $responseValue = upload_disk_video($file,$location,$fileExtension,$disk);
                    if ($responseValue[0] == 'error') {
                        return response()->json(['errors'=>$responseValue[1]]);
                    }else{
                        $video = $responseValue[1];
                    }
                }catch(\Exception $e){
                    return response()->json(['errors'=>'Could not upload the Video']);
                }
                $server = 1;
            }
        }else{
            $video = $request->link;
            $server = 2;
        }


        Video::create([
         'item_id'=>$item->id,
         'video_type'=>$request->video_type,
         'content'=>$video,
         'server'=>$server,
        ]);
        return response()->json('success');
    }

    public function updateVideo(Request $request,$id){
        $item = Item::findOrFail($id);
        $video = $item->video;
        if (!$video) {
            $notify[] = ['error','Video Not Found'];
            return back()->withNotify($notify);
        }
        $pageTitle = "Update video of: ".$item->title;
        $image = getImage('assets/images/item/landscape/'.@$item->image->landscape);
        $general = GeneralSetting::first();
        if ($video->server == 0) {
            $videoFile = asset('assets/videos/'.$video->content);
        }elseif($video->server == 1){
            $storage = Storage::disk('custom-ftp');
            $videoFile = $general->ftp->domain.'/'.Storage::disk('custom-ftp')->url($video->content);
        }else{
            $videoFile = $video->content;
        }
        $prevUrl = route('admin.item.index');
        return view('admin.item.video.update',compact('item','pageTitle','video','videoFile','image','prevUrl'));
    }

    public function updateItemVideo(Request $request,$id){
//        $notify[] = ['warning', 'You can not change anything over this demo.'];
//        $notify[] = ['info', 'This version is for demonstration purposes only and few actions are blocked.'];
//        return response()->json(['demo'=>$notify]);


        ini_set('memory_limit', '-1');
        //Validation
        if ($request->video_type == 1) {
            $validation_rule['video'] = ['required_without:link',new FileTypeValidate(['mp4', 'mkv', '3gp'])];
        }
        $validation_rule['video_type'] = 'required';
        $validation_rule['link'] = 'required_without:video';
        $validator = Validator::make($request->all(),$validation_rule);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }

        $item = Item::findOrFail($id);
        $content = $item->video;
        if (!$content) {
            return response()->json(['errors'=>'Video not found']);
        }


        $gnl = GeneralSetting::first();
        $video = $content->content;
        $server = 2;
        $disk = $gnl->server;
        //Upload Video
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $videoSize = $file->getSize();
            if ($videoSize > 4194304000) {
                return response()->json(['errors'=>'File size must be lower then 4 gb']);
            }
            $date = date('Y').'/'.date('m').'/'.date('d');

            if ($disk == 'current') {

                try{
                    $location = 'assets/videos/'.$date;
                    $video = $date.'/'.upload_video($file,$location,$content->content);
                }catch (\Exception $exp) {
                    return response()->json(['errors'=>'Could not upload the Video']);
                }

                $server = 0;

            }else{
                try{
                    $fileExtension = $request->file('video')->getClientOriginalExtension();
                    $file = File::get($request->video);
                    $location = 'videos/'.$date;
                    removeVideoFile($content->content,$disk);
                    $responseValue = upload_disk_video($file,$location,$fileExtension,$disk);
                    if ($responseValue[0] == 'error') {
                        return response()->json(['errors'=>$responseValue[1]]);
                    }else{
                        $video = $responseValue[1];
                    }
                }catch(\Exception $e){
                    return response()->json(['errors'=>'Could not upload the Video']);
                }
                $server = 1;
            }
        }else{

            if ($request->video_type == 0) {
                if ($content->server == 1) {
                    removeVideoFile($content->content,$disk);
                }else{
                    removeFile('assets/videos/' . $content->content);
                }
                $video = $request->link;
            }
        }

        $content->update([
         'video_type'=>$request->video_type,
         'content'=>$video,
         'server'=>$server,
        ]);
        return response()->json('success');
    }

    public function subCat(Request $request){
        $data = SubCategory::where('category_id',$request->id)->where('status',1)->get();
        return response()->json($data);
    }


    public function singleSection($id){

//        $notify[] = ['warning', 'You can not change anything over this demo.'];
//        $notify[] = ['info', 'This version is for demonstration purposes only and few actions are blocked.'];
//        return back()->withNotify($notify);


        $item = Item::findOrFail($id);
        if ($item->single == 1) {
            $notify[] = ['warning','Select another one as single section'];
            return back()->withNotify($notify);
        }

        if ($item->status == 0) {
            $notify[] = ['error','Please select a active item!'];
            return back()->withNotify($notify);
        }

        $exist = Item::where('single', 1)->first();
        $exist->single = 0;
        $exist->save();

        $item->single = 1;
        $item->save();

        $notify[] = ['success','Item added to single section'];
        return back()->withNotify($notify);
    }

    public function featured($id){

//        $notify[] = ['warning', 'You can not change anything over this demo.'];
//        $notify[] = ['info', 'This version is for demonstration purposes only and few actions are blocked.'];
//        return back()->withNotify($notify);


        $item = Item::findOrFail($id);
        if ($item->featured == 1) {
            $item->featured = 0;
            $notify[] = ['success','Item unfeatureded successfully'];
        }else{
            $item->featured = 1;
            $notify[] = ['success','Item featureded successfully'];
        }
        $item->save();
        return back()->withNotify($notify);
    }

    public function trending($id){

//        $notify[] = ['warning', 'You can not change anything over this demo.'];
//        $notify[] = ['info', 'This version is for demonstration purposes only and few actions are blocked.'];
//        return back()->withNotify($notify);


        $item = Item::findOrFail($id);
        if ($item->trending == 1) {
            $item->trending = 0;
            $notify[] = ['success','Item removed from trend section successfully'];
        }else{
            $item->trending = 1;
            $notify[] = ['success','Item sended to trend section successfully'];
        }
        $item->save();
        return back()->withNotify($notify);
    }

    public function search(Request $request){
        if (!$request->search) {
            return redirect()->route('admin.item.index');
        }
        $search = $request->search;
        $items = Item::orderBy('id','desc')->where(function($query) use ($search){
            $query->orWhere('title','LIKE',"%$search%")->orWhereHas('category',function($category) use ($search){
                $category->where('name','LIKE',"%$search%");
            });
        })->with('category','sub_category')->paginate(getPaginate());
        $pageTitle = "Result Showing For: ".$search;
        $items->appends(['search'=>$search]);
        return view('admin.item.index',compact('pageTitle','items','search'));
    }

}
