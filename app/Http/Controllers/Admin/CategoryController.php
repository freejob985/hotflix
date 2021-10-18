<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function index(){
    	$pageTitle = "Categories";
    	$categories = Category::orderBy('id','desc')->paginate(getPaginate());
    	$empty_message = "Category not found";
    	return view('admin.category.index',compact('pageTitle','categories','empty_message'));
    }

    public function store(Request $request){
    	$request->validate([
    		'name'=>'required',
    	]);
    	Category::insert([
    		'name'=>$request->name,
    	]);
    	$notify[] = ['success','Category has been created successfully'];
    	return back()->withNotify($notify);
    }

    public function status($id){
//        $notify[] = ['warning', 'You can not change anything over this demo.'];
//        $notify[] = ['info', 'This version is for demonstration purposes only and few actions are blocked.'];
//        return back()->withNotify($notify);

    	$category = Category::find($id);
    	if ($category->status == 1) {
    		$category->update(['status'=>0]);
    	}else{
    		$category->update(['status'=>1]);
    	}
    	$notify[] = ['success','Status has been updated successfully'];
    	return back()->withNotify($notify);
    }

    public function nav($id){
        $category = Category::find($id);
        if ($category->nav == 1) {
            $category->update(['nav'=>0]);
        }else{
            $category->update(['nav'=>1]);
        }
        $notify[] = ['success','Nav Status has been updated successfully'];
        return back()->withNotify($notify);
    }

    public function subCatstatus($id){
//        $notify[] = ['warning', 'You can not change anything over this demo.'];
//        $notify[] = ['info', 'This version is for demonstration purposes only and few actions are blocked.'];
//        return back()->withNotify($notify);

    	$category = SubCategory::find($id);
    	if ($category->status == 1) {
    		$category->update(['status'=>0]);
    	}else{
    		$category->update(['status'=>1]);
    	}
    	$notify[] = ['success','Status has been updated successfully'];
    	return back()->withNotify($notify);
    }

    public function update(Request $request,$id){
    	$category = Category::find($id);
    	$request->validate([
    		'name'=>'required',
    	]);
    	$category->update([
    		'name'=>$request->name,
    	]);
    	$notify[] = ['success','Category has been updated successfully'];
    	return back()->withNotify($notify);
    }

    public function subupdate(Request $request,$id){
    	$category = SubCategory::find($id);
    	$request->validate([
    		'name'=>'required'
    	]);
    	$category->update([
    		'name'=>$request->name
    	]);
    	$notify[] = ['success','Category has been updated successfully'];
    	return back()->withNotify($notify);
    }

    public function subcategory(){
    	$pageTitle = "Sub Categories";
    	$categories = Category::active()->orderBy('id','desc')->get();
    	$subcategories = SubCategory::orderBy('id','desc')->with('category')->paginate(getPaginate());
    	$empty_message = "Category not found";
    	return view('admin.category.subcategory',compact('pageTitle','subcategories','empty_message','categories'));
    }

    public function subcategorystore(Request $request){
    	$request->validate([
    		'name'=>'required',
    		'category_id'=>'required',
    	]);
    	SubCategory::insert([
    		'name'=>$request->name,
    		'category_id'=>$request->category_id,
    	]);
    	$notify[] = ['success','Sub category has been created successfully'];
    	return back()->withNotify($notify);
    }
}
