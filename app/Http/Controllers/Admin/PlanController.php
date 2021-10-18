<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
    	$pageTitle = "Subscription Plans";
        $plans = Plan::get();
    	return view('admin.plan.index',compact('pageTitle','plans'));
    }

    public function store(Request $request){
    	$request->validate([
    		'name'=>'required',
    		'price'=>'required|numeric|gt:0',
    		'duration'=>'required|integer|gt:0',
    		'icon'=>'required',
    	]);
    	Plan::create([
    		'name'=>$request->name,
    		'pricing'=>$request->price,
    		'duration'=>$request->duration,
            'icon'=>$request->icon,
    		'status'=>1,
    	]);
    	$notify[] = ['success','Plan Created Successfully'];
    	return back()->withNotify($notify);
    }

    public function update(Request $request,$id){
        $request->validate([
            'name'=>'required',
            'price'=>'required|numeric|gt:0',
            'duration'=>'required|integer|gt:0',
            'icon'=>'required',
        ]);
        $plan = Plan::findOrFail($id);
        $plan->update([
            'name'=>$request->name,
            'pricing'=>$request->price,
            'duration'=>$request->duration,
            'icon'=>$request->icon,
        ]);
        $notify[] = ['success','Plan Updated Successfully'];
        return back()->withNotify($notify);
    }

    public function status($id){

//        $notify[] = ['warning', 'You can not change anything over this demo.'];
//        $notify[] = ['info', 'This version is for demonstration purposes only and few actions are blocked.'];
//        return back()->withNotify($notify);


        $plan = Plan::findOrFail($id);
        if ($plan->status == 1) {
            $plan->status = 0;
            $notify[] = ['success','Plan Deactivated Successfully'];
        }else{
            $plan->status = 1;
            $notify[] = ['success','Plan Activated Successfully'];
        }
        $plan->save();
        return back()->withNotify($notify);
    }
}
