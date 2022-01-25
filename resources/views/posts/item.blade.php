@if(!empty($posts->count()))
                   @foreach($posts as $k=>$val)                   
                  		<div class="card mt-3">
							<div class="card-header"><a href="{{env('APP_URL').'/posts/'.encrypt($val->id)}}">{{ $val->post_title }}</a></div>
							<div class="card-body d-flex justify-content-between">
								<span>{{ $val->username }}</span>
								<span>{{ date('Y-m-d',strtotime($val->created_at)) }}</span>
							</div>
						</div>
                   @endforeach
            @endif
   
