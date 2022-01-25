@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h3>All Posts</h3>           
            @include('posts.item',array('post'=>$posts))                     
        </div>
        
    </div>
    {{-- Add pagination only if post is more than 5 --}}
    @if($posts->hasPages())
    <div class="paginations d-flex justify-content-center mt-3">
                   {{$posts->links('paginators',['page'=>$page])}}                    
                </div>
                @endif
</div>
@endsection
