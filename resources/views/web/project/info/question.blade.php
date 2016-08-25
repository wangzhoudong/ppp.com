@extends('web.layout')

@section('content')
        <!--上面head--><!-- Topic Header -->
@include("web.project.info.topic")
<div class="container" id="project">
    <div class="row">
        <div class="col-sm-3">
            @include("web.project.info.left_panel")
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
                <form  method="post" action="/api/Project/Info/questionData" class="exp_answer questionFrom">

                    <textarea name="content" class="content form-control" placeholder="输入回答"></textarea>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                    <input type="hidden" name="project_question_id" value="{{$item->id}}"/>
                    <input type="hidden" name="project_id" value="{{$project['id']}}"/>
                    <input type="button" class="btn btn-blue questionFromData" value="保存回答">
                </form>
            </div>
            @endforeach
            @endif
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->

<script type="text/javascript">
    $(".questionFromData").click(function() {

        var from = $(this).parent();
        if(from.find(".content").val()=="") {
            layer.msg("请输入内容");
            return true;
        }
        var content = $(this).parent().parent().find(".PPP-qa-a");
        layer.load();
        $.ajax({
            type: "POST",
            url:from.attr("action"),
            data:from.serialize(),
            dataType:"json",
            success:function(data){
                if(data.status==200) {
                    content.append('<li>\
                                <a target="_blank" href="/expert/detail/' + data.data.project_question_id + '">\
                                <img src="' + data.data.avater + '" title="" alt="">\
                                </a>\
                                <a target="_blank" class="PPP-qa-name" href="/expert/detail/61">' + data.data.nickname + '</a>\
                                <span class="PPP-qa-time">刚刚</span>\
                        <p class="PPP-qa-cont"><span>【答】</span>' +  data.data.content + '</p>\
                        </li>');
                    layer.msg("操作成功");
                }else{
                    layer.msg(data.msg);
                }
                layer.closeAll('loading');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('网络异常，请稍后刷新后再试');
                layer.closeAll('loading');
            },
        });
        return false;
    });


</script>
@endsection
