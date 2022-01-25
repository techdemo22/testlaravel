<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use DB;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	
	private $post;
	private $status_list;

    public function __construct(Post $post)
    {
        $this->post = $post;
		$this->status_list = config('app.status_list');
    }
    public function index(Request $request,Post $post)
    {//post listing page
        
		$page=1;//current page
		if(!empty($request->get('page'))){
			$page=$request->get('page');
		}
		$pageHeading ='All posts';
		$posts = DB::table('posts')->orderBy(DB::raw('RAND()'))
			->whereRaw('posts.post_status = ? or (post_status=? and DATE(post_future_date)<= ?)',['1','2',date('Y-m-d')])		
			->select('posts.*','users.id as userid','users.name as username')
			->leftjoin('users', 'users.id', '=', 'posts.post_posted_by')
			->paginate(1);
		
		return view('posts.index',compact(['posts','pageHeading','page']));		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //create form
		$pageHeading  = 'Post: Add New post';
		$status_list=$this->status_list;

        return view('posts.create',compact(['pageHeading','status_list']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {//add post
        //check validation      
		
		$validatorRules = [
			'title'=>'required|max:100',
			'content'=>'required|max:50000',
			'status'=>'required|in:0,1,2',
			 'future_date' => 'required_if:status,2'
		];

        $validator  =   Validator::make($request->all(), $validatorRules);
        if ($validator->fails()) {	//validation fails		
        	return redirect()
        				->back()
        				->withErrors($validator)
        				->withInput();
        } else {
			
			$post = new Post([
                'post_title' => strip_tags($request->get('title')),
				'post_content' => strip_tags($request->get('content')),
				'post_status' => $request->get('status'),				               			 	
				'post_posted_by' => auth()->id(),				               			 	
            ]);
			
			if($request->get('status')==2){
				$post['post_future_date']=date('Y-m-d',strtotime($request->get('future_date')));
			}

            $post->save();
            return redirect('/your-posts')->with('success', __('post.messages.added_success') );
		}
		
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		//post detail
        $id=decrypt($id);
		$pageHeading ='show post';
		$post=DB::table('posts')->whereRaw('posts.id = ?',[$id])
		->select('posts.*','users.id as userid','users.name as username')
		->leftjoin('users', 'users.id', '=', 'posts.post_posted_by')->get()->first();		
		
		return view('posts.show',compact(['pageHeading','post']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$id=decrypt($id);
        if (!$post = $this->post->find($id))
            return redirect()->back();
		
			
		$pageHeading  = 'Post: Update post';
		$status_list=$this->status_list;
       

        // return view('', compact('pageTitle','page'));
        return view('posts.create',compact(['pageHeading','status_list', 'post']) );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {	
		$id=decrypt($id);
		
        //check post found or not
		if (!$post = $this->post->find($id))
            return redirect()->back();		
		
		$validatorRules = [
			'title'=>'required|max:100',
			'content'=>'required|max:50000',
			'status'=>'required|in:0,1,2',
			'future_date' => 'required_if:status,2'
		];

        $validator  =   Validator::make($request->all(), $validatorRules);
        if ($validator->fails()) {	//validation fails		
        	return redirect()
        				->back()
        				->withErrors($validator)
        				->withInput();
        } else {
			//post store values
			$posts = [
                'post_title' => strip_tags($request->get('title')),
				'post_content' => strip_tags($request->get('content')),
				'post_status' => $request->get('status'),				               			 	
				'post_posted_by' => auth()->id(),				               			 	
				'updated_at' => date('Y-m-d H:i:s'),				               			 	
            ];
			
			if($request->get('status')==2){//future date in case of future status selectd
				$posts['post_future_date']=date('Y-m-d',strtotime($request->get('future_date')));
			}
			
            $post->update($posts);
			return redirect('/your-posts')->with('success', __('Post Updated successfully') );
		}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post,$id)
    {
        $id=decrypt($id);
		//check the post is belongs to loggedin user or not
		$post = DB::table("posts")->whereRaw('id = ?',[$id])->whereRaw('post_posted_by = ?',[auth()->id()])->get()->first();
		
		if (!$post)//if fails
             return redirect('/your-posts')->with('error', __('Invalid Request') );
		if(!empty($post)){	//delete post		
            $output = DB::table("posts")->whereRaw('id = ?',[$id])->delete();
            return redirect('/your-posts')->with('success', __('Post deleted successfully') );

        } else {
            return redirect('/your-posts')->with('error', __('Some error occurs') );
        }
    }
	
	public function myposts(Request $request){ //Home page content
		$userId = auth()->id();		
		$pageHeading ='My posts';
		$posts=(Object) array();
		if(!empty($userId)){//logged in user's Post
			$posts=DB::table('posts')->whereRaw('posts.post_posted_by = ?',[$userId])
			->select('posts.*')
			->orderBy('created_at','desc')
			->get()->all();
		}			
		
		return view('home',compact(['pageHeading','posts','userId']));
	}
}
