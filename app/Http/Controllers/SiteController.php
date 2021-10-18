<?php

namespace App\Http\Controllers;
use App\Models\AdminNotification;
use App\Models\Advertise;
use App\Models\Category;
use App\Models\Episode;
use App\Models\Frontend;
use App\Models\GeneralSetting;
use App\Models\Item;
use App\Models\Language;
use App\Models\Page;
use App\Models\Slider;
use App\Models\SubCategory;
use App\Models\Subscriber;
use App\Models\Subscription;
use App\Models\SupportAttachment;
use App\Models\SupportMessage;
use App\Models\SupportTicket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Session;

class SiteController extends Controller
{
    public function __construct(){
        $this->activeTemplate = activeTemplate();
    }

    public function index(){
      


        $count = Page::where('tempname',$this->activeTemplate)->where('slug','home')->count();
        if($count == 0){
            $page = new Page();
            $page->tempname = $this->activeTemplate;
            $page->name = 'HOME';
            $page->slug = 'home';
            $page->save();
        }

        $reference = @$_GET['reference'];
        if ($reference) {
            session()->put('reference', $reference);
        }

        $pageTitle = 'Home';
        $sections = Page::where('tempname',$this->activeTemplate)->where('slug','home')->first();
        $sliders = Slider::orderBy('id','desc')->with('item','item.category','item.video')->get();
        $featured_movies = Item::active()->hasVideo()->where('featured',1)->orderBy('id','desc')->get(['title','image','id','version','item_type', 'category_id', 'sub_category_id', 'view']);
//        dd($data['featured_movies']);
        return view($this->activeTemplate . 'home', compact('pageTitle','sections', 'sliders', 'featured_movies'));
    }

    public function pages($slug)
    {
        $page = Page::where('tempname',$this->activeTemplate)->where('slug',$slug)->firstOrFail();
        $pageTitle = $page->name;
        $sections = $page->secs;
        return view($this->activeTemplate . 'pages', compact('pageTitle','sections'));
    }


    public function contact()
    {
        $pageTitle = "Contact Us";
        return view($this->activeTemplate . 'contact',compact('pageTitle'));
    }


    public function contactSubmit(Request $request)
    {

        $attachments = $request->file('attachments');
        $allowedExts = array('jpg', 'png', 'jpeg', 'pdf');

        $this->validate($request, [
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'subject' => 'required|max:100',
            'message' => 'required',
        ]);


        $random = getNumber();

        $ticket = new SupportTicket();
        $ticket->user_id = auth()->id() ?? 0;
        $ticket->name = $request->name;
        $ticket->email = $request->email;
        $ticket->priority = 2;


        $ticket->ticket = $random;
        $ticket->subject = $request->subject;
        $ticket->last_reply = Carbon::now();
        $ticket->status = 0;
        $ticket->save();

        $adminNotification = new AdminNotification();
        $adminNotification->user_id = auth()->id() ?? 0;
        $adminNotification->title = 'A new support ticket has opened ';
        $adminNotification->click_url = urlPath('admin.ticket.view',$ticket->id);
        $adminNotification->save();

        $message = new SupportMessage();
        $message->supportticket_id = $ticket->id;
        $message->message = $request->message;
        $message->save();

        $notify[] = ['success', 'ticket created successfully!'];

        return redirect()->route('ticket.view', [$ticket->ticket])->withNotify($notify);
    }

    public function changeLanguage($lang = null)
    {
        $language = Language::where('code', $lang)->first();
        if (!$language) $lang = 'en';
        session()->put('lang', $lang);
        return redirect()->back();
    }

    public function cookieAccept(){
        session()->put('cookie_accepted',true);
        return response()->json(['success' => 'Cookie accepted successfully']);
    }

    public function placeholderImage($size = null){
        $imgWidth = explode('x',$size)[0];
        $imgHeight = explode('x',$size)[1];
        $text = $imgWidth . '×' . $imgHeight;
        $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
        $fontSize = round(($imgWidth - 50) / 8);
        if ($fontSize <= 9) {
            $fontSize = 9;
        }
        if($imgHeight < 100 && $fontSize > 30){
            $fontSize = 30;
        }

        $image     = imagecreatetruecolor($imgWidth, $imgHeight);
        $colorFill = imagecolorallocate($image, 100, 100, 100);
        $bgFill    = imagecolorallocate($image, 175, 175, 175);
        imagefill($image, 0, 0, $bgFill);
        $textBox = imagettfbbox($fontSize, 0, $fontFile, $text);
        $textWidth  = abs($textBox[4] - $textBox[0]);
        $textHeight = abs($textBox[5] - $textBox[1]);
        $textX      = ($imgWidth - $textWidth) / 2;
        $textY      = ($imgHeight + $textHeight) / 2;
        header('Content-Type: image/jpeg');
        imagettftext($image, $fontSize, 0, $textX, $textY, $colorFill, $fontFile, $text);
        imagejpeg($image);
        imagedestroy($image);
    }

    public function cron(){
        $subscriptions = Subscription::where('status',1)->where('expired_date','<=',Carbon::now())->get();
        $gnl = GeneralSetting::first();
        $now = Carbon::now();
        $gnl->last_cron = $now;
        $gnl->save();
        foreach ($subscriptions as $key => $subscription) {
            $user = $subscription->user;
            $subscription->status = 2;
            $subscription->save();
            $user->plan_id = 0;
            $user->exp = null;
            $user->save();
            notify($user,'SUBSCRIPTION_EXPIRED',[
                'plan'=>$subscription->plan->name,
                'duration'=>$subscription->plan->duration,
                'price'=>$subscription->plan->pricing,
                'subscribe_date'=>$subscription->created_at,
                'currency'=>$gnl->cur_text,
            ]);
        }
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

        }

        return view($this->activeTemplate.'sections.'.$request->sectionname,$data);
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
                return redirect()->route('user.login')->withNotify($notify);
            }
            $user = auth()->user();
            //Checking user has a plan or not
            if ($user->plan_id == 0 && $user->exp == null) {
                $notify[] = ['info','Please Subscribe a plan to view our paid items'];
                return redirect()->route('user.home')->withNotify($notify);
            }
        }

        //Check it's a episode item
        if ($item->item_type == 2) {
            $episodes = Episode::hasVideo()->where('item_id',$item->id)->get();
            $related_episodes = Item::hasVideo()->orderBy('id','desc')->where('item_type',2)->where('id', '!=', $id)->limit(6)->get(['image','id','version','item_type']);
            $pageTitle = 'Episode Details';

            if ($episodes->count() <= 0) {
                $notify[] = ['error','Oops! There is no video'];
                return back()->withNotify($notify);
            }
            $isFree = $episodes->where('version',0)->count();
            //Check have any free item or not
            if ($isFree <= 0) {
                //Checking user is login
                if(!auth()->check()){
                    $notify[] = ['info','Please Login'];
                    return redirect()->route('user.login')->withNotify($notify);
                }
                $user = auth()->user();
                //Checking user has a plan or not
                if ($user->plan_id == 0 && $user->exp == null) {
                    $notify[] = ['info','Please Subscribe a plan to view our paid items'];
                    return redirect()->route('user.home')->withNotify($notify);
                }
            }
            return view($this->activeTemplate.'watch_episode',compact('pageTitle','item','episodes', 'related_episodes'));
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

        $pageTitle = 'Movie Details';
        $related_items = Item::hasVideo()->orderBy('id','desc')->where('item_type',1)->where('id', '!=', $id)->limit(6)->get(['image','id','version','item_type']);
        return view($this->activeTemplate.'watch',compact('pageTitle','item','videoFile', 'related_items'));
    }

    public function category($id){
        $category = Category::findOrFail($id);
        $items = Item::hasVideo()->where('category_id',$id)->orderBy('id','desc')->limit(12)->get();
        $pageTitle = $category->name;
        return view($this->activeTemplate.'items',compact('pageTitle','items','category'));
    }

    public function subCategory($id){
        $sub_category = SubCategory::findOrFail($id);
        $items = Item::hasVideo()->where('sub_category_id',$id)->orderBy('id','desc')->limit(12)->get();
        $pageTitle = $sub_category->name;
        return view($this->activeTemplate.'items',compact('pageTitle','items','sub_category'));
    }

    public function search(Request $request){
        $search = $request->search;
        if (!$search) {
            return redirect()->route('home');
        }
        $items = Item::search($search)->where('status',1)->where(function($query){
            $query->orWhereHas('video')->orWhereHas('episodes',function($video){
                $video->where('status',1)->whereHas('video');
            });
        })->orderBy('id','desc')->limit(12)->get();
        $pageTitle = "Result Showing For ".$search;
        return view($this->activeTemplate.'items',compact('pageTitle','items','search'));
    }

    public function loadMore(Request $request){
        if (isset($request->category_id)) {
            $data['category'] = Category::find($request->category_id);
            $data['items'] = Item::hasVideo()->where('category_id',$request->category_id)->orderBy('id','desc')->where('id','<',$request->id)->take(6)->get();
        }elseif(isset($request->sub_category_id)){
            $data['sub_category'] = SubCategory::find($request->sub_category_id);
            $data['items'] = Item::hasVideo()->where('sub_category_id',$request->sub_category_id)->orderBy('id','desc')->where('id','<',$request->id)->take(6)->get();
        }elseif(isset($request->search)){
            $data['search'] = $request->search;
            $data['items'] = Item::hasVideo()->search($request->search)->orderBy('id','desc')->where('id','<',$request->id)->take(6)->get();
        }else{
            return response('end');
        }

        if ($data['items']->count() <= 0) {
            return response('end');
        }

        return view($this->activeTemplate.'item_ajax',$data);
    }

    public function policy($id,$slug){
        $item = Frontend::where('id',$id)->where('data_keys','extra.element')->firstOrFail();
        $pageTitle = $item->data_values->title;
        return view($this->activeTemplate.'links_details',compact('pageTitle','item'));
    }

    public function links($id,$slug){
        $item = Frontend::where('id',$id)->where('data_keys','short_links.element')->firstOrFail();
        $pageTitle = $item->data_values->title;
        return view($this->activeTemplate.'links_details',compact('pageTitle','item'));
    }

    public function addclick(Request $request){
        $ad = Advertise::find($request->id);
        $ad->increment('click');
        return response()->json("Successfull");
    }

    public function subscribe(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email|max:40|unique:subscribers',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors'=>$validator->errors()->all()]);
        }
        Subscriber::create($request->only('email'));
        return response()->json(['success'=>'Subscribe successfully']);
    }
}
