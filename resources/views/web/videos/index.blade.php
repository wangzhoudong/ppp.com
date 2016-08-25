@extends('web.layout')

@section('content')
        <!--上面head-->	  <!-- Topic Header -->
<div class="topic">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li><a href="/">首页</a></li>
                <li class="active">操作视频</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->
<style>
</style>
<div id="videos" class="container">
    @if($list)
        @foreach($list as $key=>$item)
            <div class="col-sm-3">
                <a target="_blank" href="{{$item->link}}" class="PPP-vedio-box">
                    <img class="PPP-vedio-pic" src="{{$item->image or "/web/contents/video.jpg"}}" title="{{$item->title}}" alt="{{$item->title}}"/>
                    <p class="PPP-vedio-tip">{{$item->title}}</p>
                    <!--<i class="PPP-vedio-ico"></i>-->
                </a>
            </div>
        @endforeach
    @endif


    <div style="clear: both">
    {!! $list->setPath('')->appends(Request::all())->render() !!}
    </div>

</div> <!-- / .container -->

@endsection
