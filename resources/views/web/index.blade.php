@extends('web.layout')

@section('content')
    <div id="index" class="container">
        <div class="responsive-design">
            <h3>项目库</h3>
            @foreach($projectInfo as $item)
            <div class="col-md-4 col-sm-4 col-xs-12">

                <a title="{{dict()->get("project_info","status",$item->status)}}" href="/project/sample/detail?project_id={{$item['id']}}" class="PPP-item-box">
                <img class="PPP-item-pic" src="@if($item['image']){{$item['image']}} @else /web/contents/project.jpg @endif" title="{{dict()->get("project_info","status",$item->status)}}" alt="{{dict()->get("project_info","status",$item->status)}}"/>

                <p class="PPP-item-tip title">{{ str_limit($item['name'], 30) }}</p>
                <p class="PPP-item-tip place">
                  <i class="fa fa-map-marker m-r-sm"></i> {{$item['place']}}
                </p>
                <dl class="PPP-item-tip dl-horizontal">
                  <dt>实施机构</dt>
                  <dd>{{$item['builder_company']}}</dd>
                  <dt>项目进度</dt>
                  <dd>{{dict()->get("project_info","status",$item->status)}}</dd>
                  <dt>会议时间</dt>
                  <dd>
                    @if($item['counseling_times']){{date("Y-m-d H:i",$item['counseling_times'])}}@else 未设置 @endif
                  </dd>
                </dl>
              </a>
            </div>
            @endforeach
            <div style="clear: both"></div>
             <!-- / .row -->
            <h3>专家库</h3>
            @foreach($userExpert as $key=>$item)
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="team-member text-center">
                        <a class="head" target="_blank" href="/expert/detail/{{$item->user_id}}"><img class="img-responsive" src="@if($item->baseUser->avater) {{$item->baseUser->avater}}.middle.jpg @else /web/contents/head2.jpg @endif" alt="..."></a>
                        <div class="info">
                            <h3><a class="name" target="_blank" href="/expert/detail/{{$item->user_id}}"><strong>{{$item->name}}</strong></a><i>/</i><a class="area" target="_blank" href="/expert.html?territory={{$item->territory}}">{!! dict()->get("global","territory",$item->territory)  !!}</a></h3>

                            <p><span>{{$item->resume}}</span></p>
                        </div>
                    </div>
                </div>
            @endforeach
            <div style="clear: both"></div>

            <h3>教程试看</h3>
            @foreach($videoInfo as $key=>$item)
                <div class="col-sm-3">
                    <a target="_blank" href="{{$item->link}}" class="PPP-vedio-box">
                        <img class="PPP-vedio-pic" src="{{$item->image or "/web/contents/video.jpg"}}" title="{{$item->title}}" alt="{{$item->title}}"/>
                        <p class="PPP-vedio-tip">{{$item->title}}</p>
                        <!--<i class="PPP-vedio-ico"></i>-->
                    </a>
                </div>
            @endforeach
            <div style="clear: both"></div>
        </div> <!-- / .template-thumbnails -->
    </div> <!-- / .container -->

@endsection
