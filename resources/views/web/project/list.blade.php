@extends('web.layout')

@section('content')
    <!--上面head--><!-- Topic Header -->
<div class="topic">
  <div class="container">
    <div class="row">
      <ol class="breadcrumb hidden-xs">
        <li><a href="/">首页</a></li>
        <li class="active">我的项目</li>
      </ol>
    </div> <!-- / .row -->
  </div> <!-- / .container -->
</div> <!-- / .Topic Header -->

<div class="container" id="project">
    <div class="responsive-design">
      @if(isset($data) && count($data))
      <h4 class="f-l m-l-lg m-b-xxlg">选择要查看的项目：</h4>
      @if($_user['type']==3)
      <h4 class="f-r m-r-lg m-b-xxlg">
        <a href="/project/add1"><i class="fa fa-plus"></i> 提交新项目</a></div>
      </h4>
      @endif
      <div class="c-b"></div>
      @foreach($data as $item)
          <div class="col-md-4 col-sm-4 col-xs-12">
            @if($item->status ==1)
                <a  title="{{dict()->get("project_info","status",$item->status)}}" href="/project/add1?project_id={{$item['id']}}" class="PPP-item-box">
             @else
                <a title="{{dict()->get("project_info","status",$item->status)}}" href="/project/info/detail?project_id={{$item['id']}}" class="PPP-item-box">
             @endif
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
       @else
        @if($_user['type']==3)
          <div>你还没创建任何项目，请先提交项目</div>
        @endif
         @if($_user['type']==4)
            <div>目前您还没有参与的项目，如果有需要请先设置你的空闲时间</div>
             <div>去<a href="/account/userinfo">设置空闲时间</a> </div>
         @endif
       @endif
    </div> <!-- / .container -->
</div>
@endsection
