<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use App\Models\GeneralSetting;
use App\Models\Item;
use App\Models\Video;
use App\Rules\FileTypeValidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use File;

class EpisodeController extends Controller
{
    public function episodes($id){
        $item = Item::findOrFail($id);
        if ($item->item_type != 2) {
            $notify[] = ['error','Something Wrong'];
            return redirect()->route('admin.dashboard')->withNotify($notify);
        }
        $pageTitle = "All Episode of : ".$item->title;
        $episodes = Episode::where('item_id',$item->id)->paginate(getPaginate());
        return view('admin.item.episode.index',compact('pageTitle','item','episodes'));
    }

    public function addEpisode(Request $request,$id){
        $request->validate([
            'title'=>'required',
            'image'=>'required|image|mimes:jpg,jpeg,png',
        ]);

        $item = Item::findOrFail($id);

        if (isset($request->version) && $request->version != 1 && $request->version != 0) {
            $notify[] = ['error','Something is wrong'];
            return back()->withInput($request->all())->withNotify($notify);
        }

        //landscap image upload
        if ($request->hasFile('image')) {

            //Check image size
            $maxSize = $request->image->getSize() / 1000000;
            if ($maxSize > 3) {
                $notify[0] = ['error','Image size could not be greater than 3mb'];
                return back()->withInput($request->all())->withNotify($notify);
            }
            try {
                $date = date('Y').'/'.date('m').'/'.date('d');
                $path = 'assets/images/item/episode/'.$date;
                $image = $date.'/'.uploadImage($request->image,$path);
            } catch (\Exception $e) {
                $notify[0] = ['error','Image could not be uploaded'];
                return back()->withInput($request->all())->withNotify($notify);
            }
        }

        $episode = Episode::create([
            'item_id'=>$item->id,
            'title'=>$request->title,
            'image'=>$image,
            'status'=>1,
            'version'=>$request->version
        ]);
        $notify[] = ['success','Episode added successfully'];
        return redirect()->route('admin.item.episode.addVideo',$episode->id)->withNotify($notify);

    }


    public function addEpisodeVideo($id){
        $episode = Episode::findOrFail($id);
        $pageTitle = "Add Video To : ".$episode->title;
        $video = $episode->video;
        $prevUrl = route('admin.item.episodes',$episode->item_id);
        return view('admin.item.video.upload',compact('pageTitle','episode','video','prevUrl'));
    }

    public function episodeStatus($id){
//        $notify[] = ['warning', 'You can not change anything over this demo.'];
//        $notify[] = ['info', 'This version is for demonstration purposes only and few actions are blocked.'];
//        return back()->withNotify($notify);

        $episode = Episode::findOrFail($id);
        if ($episode->status == 1) {
            $episode->status = 0;
            $notify[] = ['success','Episode inactivated successfully'];
        }else{
            $episode->status = 1;
            $notify[] = ['success','Episode activated successfully'];
        }
        $episode->save();
        return back()->withNotify($notify);
    }

    public function editEpisode(Request $request,$id){
        $request->validate([
            'title'=>'required',
            'image'=>'nullable|image|mimes:jpg,jpeg,png',
        ]);

        if (isset($request->version) && $request->version != 1 && $request->version != 0) {
            $notify[] = ['error','Something is wrong'];
            return back()->withInput($request->all())->withNotify($notify);
        }


        $episode = Episode::findOrFail($id);
        $item = $episode->item;
        if (!$item) {
            $notify[] = ['error','Item not found'];
            return back()->withNotify($notify);
        }
        $image = $episode->image;
        //landscap image upload
        if ($request->hasFile('image')) {

            //Check image size
            $maxSize = $request->image->getSize() / 1000000;
            if ($maxSize > 3) {
                $notify[0] = ['error','Image size could not be greater than 3mb'];
                return back()->withInput($request->all())->withNotify($notify);
            }
            try {
                $date = date('Y').'/'.date('m').'/'.date('d');
                $path = 'assets/images/item/episode/'.$date;
                removeFile('assets/images/item/episode/'.$episode->image);
                $image = $date.'/'.uploadImage($request->image,$path);
            } catch (\Exception $e) {
                $notify[0] = ['error','Image could not be uploaded'];
                return back()->withInput($request->all())->withNotify($notify);
            }
        }

        $episode->update([
            'title'=>$request->title,
            'image'=>$image,
            'version'=>$request->version
        ]);
        $notify[] = ['success','Episode edited successfully'];
        return back()->withNotify($notify);
    }

    public function storeEpisodeVideo(Request $request,$id){

//        $notify[] = ['warning', 'You can not change anything over this demo.'];
//        $notify[] = ['info', 'This version is for demonstration purposes only and few actions are blocked.'];
//        return response()->json(['demo'=>$notify]);


        ini_set('memory_limit', '-1');
        if ($request->video_type == 1) {
            $validation_rule['video'] = ['required_without:link',new FileTypeValidate(['mp4', 'mkv', '3gp'])];
        }
        $validation_rule['video_type'] = 'required|integer';
        $validation_rule['link'] = 'required_without:video';

        $validator = Validator::make($request->all(),$validation_rule);

        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        $gnl = GeneralSetting::first(['server']);
        $episode = Episode::findOrFail($id);
        $video = $episode->video;

        if ($video) {
            return response()->json(['errors'=>'Already video exist']);
        }
        //Upload Video
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
         'episode_id'=>$episode->id,
         'video_type'=>$request->video_type,
         'content'=>$video,
         'server'=>$server
        ]);
        return response()->json('success');
    }

    public function updateEpisodeVideo($id){
        $episode = Episode::findOrFail($id);
        $video = $episode->video;
        if (!$video) {
            $notify[] = ['error','Video Not Found'];
            return back()->withNotify($notify);
        }
        $gnl = GeneralSetting::first();
        $pageTitle = "Update video of: ".$episode->title;
        $image = getImage('assets/images/item/episode/'.$episode->image);
        if ($video->server == 0) {
            $videoFile = asset('assets/videos/'.$video->content);
        }elseif($video->server == 1){
            $storage = Storage::disk('custom-ftp');
            $videoFile = @$gnl->ftp->domain.'/'.Storage::disk('custom-ftp')->url($video->content);
        }else{
            $videoFile = $video->content;
        }
        $prevUrl = route('admin.item.episodes',$episode->item_id);
        return view('admin.item.video.update',compact('pageTitle','video','image','videoFile','prevUrl'));
    }

    public function editEpisodeVideo(Request $request,$id){


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

        $episode = Episode::findOrFail($id);
        $content = $episode->video;
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
}
