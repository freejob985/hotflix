<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Episode;
use App\Models\GeneralSetting;
use App\Models\Item;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomePageController extends Controller
{
    public function getAllSection(){
        return [
            'recent_added',
            'end',
            'latest_series',
            'single',
            'latest_trailer',
            'free_zone',
            'top',
            'entersection'
        ];
    }
    public function getSection(Request $request){
        if ($request->sectionname == 'end') {
            return response('end');
        }

        if ($request->sectionname == 'recent_added') {

            $data['recent_added'] = Item::hasVideo()->orderBy('id','desc')->where('item_type',1)->limit(18)->get(['title','image','id','version','item_type']);

        }elseif($request->sectionname == 'latest_series'){

            $data['latestSerieses'] = Item::hasVideo()->orderBy('id','desc')->where('item_type',2)->limit(12)->get(['title','image','id','version','item_type']);

        }elseif($request->sectionname == 'single'){

            $data['single'] = Item::hasVideo()->orderBy('id','desc')->where('single',1)->with('category')->first(['image','title','ratings','preview_text','view','ratings','id','version','item_type']);

        }elseif($request->sectionname == 'latest_trailer'){

            $data['latest_trailers'] = Item::hasVideo()->where('item_type',3)->orderBy('id','desc')->limit(12)->get(['image','title','ratings','id']);

        }elseif($request->sectionname == 'free_zone'){

            $data['frees'] = Item::hasVideo()->free()->orderBy('id','desc')->limit(12)->get(['image','title','id']);

        }elseif($request->sectionname == 'top'){

            $data['mostViewsTrailer'] = Item::hasVideo()->where('item_type',3)->orderBy('view','desc')->first();
            $data['topRateds'] = Item::hasVideo()->orderBy('ratings','desc')->limit(4)->get(['image','title','ratings','view','id','version','item_type']);
            $data['trendings'] = Item::hasVideo()->orderBy('view','desc')->where('trending',1)->limit(4)->get(['image','title','ratings','view','id','version','item_type']);

        }else{
            $sectionname = 'entersection';
            $data = [
                $sectionname => []
            ];
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>[
                    $sectionname,$data
                ]
            ]);
        }

        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>[
                $request->sectionname,$data
            ]
        ]);
    }
    public function allCategories(){
        $category = Category::get();
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>[
                'category'=>$category
            ]
        ]);
    }
    public function category($id){
        $category = Category::findOrFail($id);
        $items = Item::hasVideo()->where('category_id',$id)->orderBy('id','desc')->limit(12)->get();
        $pageTitle = $category->name;
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>[
                'category'=>$items
            ]
        ]);
    }


    public function watchVideo($id){
        //Find Item
        $item = Item::where('status',1)->where('id',$id)->firstOrFail();
        //Checking It a Single Item and it's paid
        $item->increment('view');

        if ($item->item_type == 1 && $item->version == 1) {
            //Checking user is login
            if(!auth()->check()){
                $notify[] = ['info','Please Login'];
                return response()->json([
                    'code'=>200,
                    'status'=>'ok',
                    'message'=>[
                        $notify
                    ]
                ]);
                //return redirect()->route('user.login')->withNotify($notify);
            }

            $user = auth()->user();
            //Checking user has a plan or not
            if ($user->plan_id == 0 && $user->exp == null) {
                $notify[] = ['info','Please Subscribe a plan to view our paid items'];
                return response()->json([
                    'code'=>200,
                    'status'=>'ok',
                    'message'=>[
                        $notify
                    ]
                ]);
/*                return redirect()->route('user.home')->withNotify($notify);*/
            }
        }

        //Check it's a episode item
        if ($item->item_type == 2) {
            $episodes = Episode::hasVideo()->where('item_id',$item->id)->get();
            $related_episodes = Item::hasVideo()->orderBy('id','desc')->where('item_type',2)->where('id', '!=', $id)->limit(6)->get(['image','id','version','item_type']);
            $pageTitle = 'Episode Details';

            if ($episodes->count() <= 0) {
                $notify[] = ['error','Oops! There is no video'];
                return response()->json([
                    'code'=>200,
                    'status'=>'ok',
                    'message'=>[
                        $notify
                    ]
                ]);
                //return back()->withNotify($notify);
            }
            $isFree = $episodes->where('version',0)->count();
            //Check have any free item or not
            if ($isFree <= 0) {
                //Checking user is login
                if(!auth()->check()){
                    $notify[] = ['info','Please Login'];
                    return response()->json([
                        'code'=>200,
                        'status'=>'ok',
                        'message'=>[
                            $notify
                        ]
                    ]);
                    //return redirect()->route('user.login')->withNotify($notify);
                }
                $user = auth()->user();
                //Checking user has a plan or not
                if ($user->plan_id == 0 && $user->exp == null) {
                    $notify[] = ['info','Please Subscribe a plan to view our paid items'];
                    return response()->json([
                        'code'=>200,
                        'status'=>'ok',
                        'message'=>[
                            $notify
                        ]
                    ]);
                    //return redirect()->route('user.home')->withNotify($notify);
                }
            }
            $type = 'episode';
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'MovieDetails'=>[
                    'item'=>$episodes,
                    'related_items'=>$related_episodes,
                    'type'=>$type,

                ]
            ]);
           // return view($this->activeTemplate.'watch_episode',compact('pageTitle','item','episodes', 'related_episodes'));
        }
        $video = $item->video;
        $general = GeneralSetting::first();
        if ($video->server == 0) {
            $videoFile = asset('assets/videos/'.$video->content);
        }elseif($video->server == 1){
            $videoFile = $general->ftp->domain.'/'.Storage::disk('custom-ftp')->url($video->content);
        }else{
            $videoFile = $video->content;
        }
        $pageTitle = 'MovieDetails';
        $related_items = Item::hasVideo()->orderBy('id','desc')->where('item_type',1)->where('id', '!=', $id)->limit(6)->get(['image','id','version','item_type']);
        $type = 'movie';

        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'MovieDetails'=>[
                'item'=>$item,
                'related_items'=>$related_items,
                'type'=>$type,
            ]
        ]);

        //return view($this->activeTemplate.'watch',compact('pageTitle','item','videoFile', 'related_items'));
    }
    public function allFilms(){
        $movies = Item::where('status',1)->get();
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'data'=>[
                'movies'=>$movies
            ]
        ]);

    }

    public function search(Request $request)
    {
        $search = $request->search;
        $items = Item::search($search)->where('status', 1)->where(function ($query) {
        })->orderBy('id', 'desc')->limit(12)->get();
        $pageTitle = 'Result Showing For ' . $search;
        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>[
                'search'=>$items
            ]
        ]);
        //return view($this->activeTemplate . 'items', compact('pageTitle', 'items', 'search'));
    }
    public function wishlistView(Request $request){
       $user_id =  auth()->user()->id;
       $list = Wishlist::where('user_id',$user_id)->get();
       foreach($list as $l){
           $l->movie_id = Item::find($l->movie_id);
       }
       return $list ;

    }
    public function wishlistAdd(Request $request){
        $user_id =  auth()->user()->id;
        $movie_id = $request->movie_id;
        $list = Wishlist::where('user_id',$user_id)->where('movie_id',$movie_id)->get();
        if(count($list) > 0) {
            $notify[] = ['info','You added this item before'];
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>[
                    $notify
                ]
            ]);
        }else{
            DB::table('user_movies_wishlist')->insert([
                'user_id'=>intval($user_id),
                'movie_id'=>intval($movie_id)
            ]);
            $notify[] = ['info','You added this item successfully'];
            return response()->json([
                'code'=>200,
                'status'=>'ok',
                'message'=>[
                    $notify
                ]
            ]);
        }
    }
    public function wishlistRemove(Request $request){
       $relation_id = $request->relation_id;
       Wishlist::find($relation_id)->delete();
        $notify[] = ['info','You deleted this item successfully'];

        return response()->json([
            'code'=>200,
            'status'=>'ok',
            'message'=>[
                $notify
            ]
        ]);
    }
}
