@extends('layouts.app')

@section('content')
 <div class="container">
  <div class="row justify-content-center">
        <div class="col-md-8">
		   <div class="card mt-3">
				<div class="card-header"><a href="{{env('APP_URL').'/posts/'.encrypt($post->id)}}">{{ $post->post_title }}</a></div>
				<div class="card-body ">
				   <p>{!! nl2br($post->post_content)!!}</p>
				</div>
				<div class="card-footer d-flex justify-content-between">
				   	<span>{{ $post->username }}</span>
					<span>{{ date('Y-m-d' ,strtotime($post->created_at)) }}</span>
				 </div>
			</div>
		</div>
	</div>
</div>
@endsection