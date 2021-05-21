<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Topic;
use App\TopicDocument;
use App\TopicVideo;
use App\VideoTypes;
use DataTables;
use Validator;
use Session;
use Auth;
use Flash;
use Redirect;

class TopicVideoController extends Controller
{
    public function list(Request $request)
    {
        return view('Admin.TopicVideo.list');
    }
    public function datatable(Request $request)
    {
        $TopicVideo = TopicVideo::get();
        return Datatables::of($TopicVideo)
        ->editColumn('topic_id', function($TopicVideo) {
            return ($TopicVideo->Topic) ? $TopicVideo->Topic->title : '-';
        })
        ->editColumn('is_paid', function($TopicVideo) {
            return ($TopicVideo->is_paid == 1) ? 'Paid' : 'Free';
        })
        ->addColumn('image', function($TopicVideo) {
            $image = ' - ';
            if($TopicVideo->image!=''){
                $image = '<div class="image-product-div"><img src="'.$TopicVideo->image.'" onerror=this.src="'.asset('No_image_available.png').'" width="100px" class="image-product"></div>';
            }
            return $image;
        })
        ->addColumn('action', function($TopicVideo) {
            $edit_link = '<a href="'.route('admin.topic.video.edit',$TopicVideo->id).'" data-toggle="tooltip" data-original-title="Edit"><i class="fas fa-pencil-alt text-inverse m-r-10"></i> </a>';
            $delete_link = '<a href="javascript:void(0);" onclick="delete_confirmation(this,'.$TopicVideo->id.')" data-toggle="tooltip" data-original-title="Delete"><i class="fas fa-window-close text-danger"></i> </a>';
            return $edit_link.$delete_link;
        })
        ->escapeColumns(['*'])
        ->make(true);
    }
    public function add()
    {
        $Topic = Topic::all();
        $VideoTypes = VideoTypes::all();
        return view('Admin.TopicVideo.add',compact('Topic','VideoTypes'));
    }
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|max:255',
            'title' => 'required|max:255',
            //'video_type'=> 'required|max:255',
            'is_paid' => 'required',
            //'topic_video_image' => 'required|mimes:jpeg,jpg,gif,png',
            //'video' => 'required',
        ]);
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $filename = '';
        if($request->hasFile('topic_video_image'))
        {
            $file = $request->file('topic_video_image');
            $filename = time().'_'.trim($file->getClientOriginalName());
            $file->move(public_path().'/uploads/topic_video', $filename);
        }
        $video='';$c='';$t='';
        if($request->video_type == "1"){
            $file = $request->file('video');
            $vfilename = time().'_'.trim($file->getClientOriginalName());
            $file->move(public_path().'/uploads/topic_video', $vfilename);
            $c = $vfilename;
            $t = $request->video_type;
        }else{
            $c= $request->video;
            $t = $request->video_type;
        }
        if(!empty($request->videop)){
            $c = explode(',', $request->videop);
            //return $c[0];
            $TopicVideo = TopicVideo::create([
                'topic_id'  => $request->topic,
                'video'     => $c[0],
                'video_type'=> $c[1],
                'image'     => $filename,
                'title'     => $request->title,
                'is_paid'   => $request->is_paid,
            ]);
        }else{
            $TopicVideo = TopicVideo::create([
                'topic_id'  => $request->topic,
                'video'     => $c,
                'video_type'=> $t,
                'image'     => $filename,
                'title'     => $request->title,
                'is_paid'   => $request->is_paid,
            ]);
        }
        Session::flash('success', 'Topic Video Saved Successful.'); 
        return Redirect()->route('admin.topic.video.list');
    }
    public function edit(Request $request,$id)
    {
        $Topic = Topic::all();
        $VideoTypes = VideoTypes::all();
        $TopicVideo = TopicVideo::where('id',$id)->first();
        return view('Admin.TopicVideo.edit',compact('Topic','TopicVideo','VideoTypes'));
    }
    public function update(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'topic' => 'required|max:255',
            'title' => 'required|max:255',
            'video_type'=> 'required|max:255',
            'is_paid' => 'required',
        ]);
        if($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $TopicVideo = TopicVideo::where('id',$id)->first();
        // $filename = $TopicVideo->image;
        if($request->hasFile('topic_video_image'))
        {
            $file = $request->file('topic_video_image');
            $filename = time().'_'.trim($file->getClientOriginalName());
            $file->move(public_path().'/uploads/topic_video', $filename);
            $TopicVideo = TopicVideo::where('id',$id)->update([
                'image' => $filename,
            ]);
        }
        $video='';
        
        $exisfile       =   $request->sidevalueup;
        $video_typeup   =   $request->video_typeup;
        $image_path     =   public_path().'/uploads/topic_video/'.$exisfile;
        
        if($video_typeup == "2"){
            unlink($image_path);
        }
        
        if($request->video_type == "1"){
            if($request->hasFile('video')){
                $file       =   $request->file('video');
                $vfilename  =   time().'_'.trim($file->getClientOriginalName());
                $file->move(public_path().'/uploads/topic_video', $vfilename);
                $c = $vfilename;
                $TopicVideo = TopicVideo::where('id',$id)->update([
                    'video' => $vfilename,
                ]);
            }
        }else{
            if($request->video){
                $TopicVideo = TopicVideo::where('id',$id)->update([
                    'video' => $request->video,
                ]);
            }
        }
        $TopicVideo = TopicVideo::where('id',$id)->update([
            'topic_id' => $request->topic,
            'video_type'=>$request->video_type,
            'title' => $request->title,
            'is_paid' => $request->is_paid,
        ]);
        Session::flash('success', 'Topic Video Update Successful.'); 
        return Redirect()->route('admin.topic.video.list');
    }
    public function delete(Request $request){
        $TopicVideo = TopicVideo::where('id',$request->id)->delete();
        return response()->json(['succsess'=>true]);
    }
    public function toipcvideo(Request $request){
        $sub_cate_list = TopicVideo::where('topic_id', $request->topic)->where('is_active', 1)->get();
        $html = '';
        if(!$sub_cate_list->isEmpty())
        {
            foreach ($sub_cate_list as $key => $category) {
                $html .= '<option value="'.$category->video.','.$category->video_type.'">'.$category->title.'</option>';
            }
        }
        return response()->json(array('status'=>true,'html'=>$html));
    }
}
