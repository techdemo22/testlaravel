@extends('layouts.app')

@section('content')
@php
    $pageUrl='store';
    $buttonText='Save';
    if(isset($post)){
        $pageUrl=env('APP_URL').'/posts/update/'.encrypt($post->id); 
        $buttonText='Update';
    }  
    
@endphp
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>Create a New Post</h3>
            <div class="card mt-3">
                <div class="card-body">
                   @if(isset($post))
                   <form action="{{$pageUrl}}" method="POST" class="profile_form" name="pageForm" id="pageForm">
                   @else
                   <form action="{{$pageUrl}}" method="POST" class="profile_form" name="pageForm" id="pageForm">
                   @endif
					 		  
						@csrf
					
						
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" value="{{$post->post_title ?? old('title')}}" class="form-control required" id="title" required maxlength="100" >
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea class="form-control required" name="content" id="content" rows="3" required maxlength="50000">{{$post->post_content ?? old('content')}}</textarea>
                        </div>
                        
                         <div class="form-group">
                        	<label for="status">Choose Status</label>
							@foreach($status_list as $k=>$val)
							<div class=" form-check radio-inline">
								<input type="radio" name="status" value="{{$k}}" class="form-check-input" id="status{{$k}}" @if(!empty($post) && $post->post_status==$k) checked @endif>
								<label class="form-check-label required" for="status{{$k}}">{{$val}}</label>
							</div>
							@endforeach
                        </div>
                        <div id="future_wraper" class="form-group " style="display: none;">
                            <label for="posted">Choose future date<small class="text-muted">(post will be available publically only after this date)</small></label>
                            <input type="date" name="future_date" value="{{$post->post_future_date ?? old('future_date')}}" class="form-control" id="future_date" min="{{date("Y-m-d")}}" >
                        </div>
                        
                        <button type="submit" class="btn btn-primary">{{$buttonText}}</button>
					   </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('script')
<!-- Include Js -->
<script>
	$(document).ready(function(e){	
	
		var f=document.getElementById('pageForm');
		//
		setTimeout(function(e){
			
			if($(".form-check-input:checked").val()=='2'){
				$("#future_wraper").show();
			}else{
				$("#future_wraper").hide();
			}
		},500)
			
	})
	$(document).on('change',".form-check-input",function(){		
		if($(this).val()==2){
			$("#future_wraper").show();
		}else{
			$("#future_wraper").hide();
		}
	})
</script>
@endsection
