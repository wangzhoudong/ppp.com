@extends('web.layout')

@section('content')
        <!--上面head-->  <!-- Topic Header -->
<div class="topic">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li><a href="/">首页</a></li>
                <li class="active">专家库</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->
<div class="container" id="expert">
        @foreach($data as $key=>$item)
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="team-member text-center">
                <a class="head" target="_blank" href="/expert/detail/{{$item->user_id}}"><img class="img-responsive" src="@if($item->baseUser->avater) {{$item->baseUser->avater}}.middle.jpg @else /web/contents/head2.jpg @endif" alt="{{$item->name}}"></a>
                <div class="info">
                    <h3><a class="name" target="_blank" href="/expert/detail/{{$item->user_id}}"><strong>{{$item->name}}</strong></a><i>/</i><a class="area" target="_blank" href="/expert.html?territory={{$item->territory}}">{!! dict()->get("global","territory",$item->territory)  !!}</a></h3>

                    <p><span>{{$item->resume}}</span></p>
                </div>
            </div>
        </div>
        @endforeach
    <div style="clear: both"></div>
    <div style="clear: both">
        {!! $data->setPath('')->appends(Request::all())->render() !!}
    </div>
</div> <!-- / .container -->

@endsection
