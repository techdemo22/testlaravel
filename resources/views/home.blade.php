@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if(!empty($userId))
            	@if(!empty($posts))
            	<div class="d-flex justify-content-between"> <h3>Your Posts</h3>
            		<a href="{{env('APP_URL').'/posts/create'}}" >Create new post</a></div>
            		
            		@foreach($posts as $k=>$val)
            			<div class="card mt-3">
							<div class="card-header"><a href="{{env('APP_URL').'/posts/'.encrypt($val->id)}}">{{ $val->post_title }}</a></div>
							<div class="card-body">
								@if($val->post_status=='0')
									<span class="badge badge-secondary">Draft</span>
								@elseif($val->post_status=='1')
									<span class="badge badge-primary">Published</span>
									<span class="badge badge-success">Members Only</span>
								@else
									@if($val->post_future_date>date('Y-m-d'))
										<span class="badge badge-info">Will publish on {{date('Y-m-d',strtotime($val->post_future_date))}}</span>
									@else
										<span class="badge badge-primary">Published</span>
									@endif									
								@endif								
								<span class="ml-2">Posted: {{date('Y-m-d',strtotime($val->created_at))}}</span> / <span>Updated: {{date('Y-m-d',strtotime($val->updated_at))}}</span>
								<div class="mt-3">
									<a href="{{env('APP_URL').'/posts/'.encrypt($val->id)}}">Detail</a> /
									<a href="{{env('APP_URL').'/posts/'.encrypt($val->id).'/edit'}}">Edit</a> /
									<a href="javascript:void(0);" onClick="deleteConfirm('{{encrypt($val->id)}}')">
										<button class="btn btn-link p-0 border-0 text-danger">Delete</button>
									</a>
								</div>
							</div>
						</div>            			
            		@endforeach	
            	@else
           		 	{{-- If logged-in user doesn't have posts. --}}
            		 <p>You have no posts yet. Create a new post <a href="{{env('APP_URL').'/posts/create'}}">here</a>.</p>
            	@endif
            @else  
           	 	 {{-- If guest users. --}}          	
            	 <p>Please login <a href="{{env('APP_URL').'/login'}}">here</a>.</p>
            	 <p>If you don't have an account, register <a href="{{env('APP_URL').'/register'}}">here</a>.</p>            	
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')
<!-- Include Js -->
<script>
	function deleteConfirm(id){
		if(confirm("Are you sure, you want to delete this post.It will not be restored again!")){
			window.location.href="{{env('APP_URL').'/posts/delete/'}}"+id;
		}
	}
	$(document).on('change',".form-check-input",function(){		
		if($(this).val()==2){
			$("#future_wraper").show();
		}else{
			$("#future_wraper").hide();
		}
	})
</script>
@endsection
