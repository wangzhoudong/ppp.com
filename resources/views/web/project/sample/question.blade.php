@extends('web.layout')

@section('content')
        <!--上面head--><!-- Topic Header -->
@include("web.project.sample.topic")
<div class="container" id="project">
    <div class="row">
        <div class="col-sm-3">
            @include("web.project.sample.left_panel")
        </div>
        <div class="col-sm-9">

            @if($question)
            @foreach($question as $item)
            <div class="PPP-qa-box">
                <p class="PPP-qa-q"><span>【问】</span>{{$item->title}}？</p>
                <ul class="PPP-qa-a">

                    @foreach($item->dataInfo as $item1)
                        <li>
                            <a target="_blank" href="/expert/detail/{{$item1->user_id}}">
                                <img src="@if($item1->baseUser->avater){{$item1->baseUser->avater}}.middle.jpg @else /web/contents/head2.jpg @endif" title="" alt="">
                            </a>
                            <a target="_blank" class="PPP-qa-name" href="/expert/detail/{{$item1->user_id}}">{{$item1->nickname}}</a>
                            <span class="PPP-qa-time">{{$item1->created_at}}</span>
                            <p class="PPP-qa-cont"><span>【答】</span>{{$item1->content}}</p>
                        </li>
                    @endforeach
                </ul>
            </div>
            @endforeach
            @endif
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->

@endsection
