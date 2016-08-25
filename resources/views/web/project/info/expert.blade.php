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
                @foreach($data as $val)
                <div class="col-xs-12 col-sm-6 col-md-6">
                    <div class="team-member text-center">
                        <a class="head"  target="_blank" href="/expert/detail/{{$val->user_id}}"><img class="img-responsive" src="{{ $val->avater }}" alt="..."></a>
                        <div class="info">
                            <h3><a class="name" target="_blank" href="/expert/detail/{{$val->user_id}}"><strong>{{ $val->name }}</strong></a><i>/</i><a class="area"  target="_blank" href="/expert.html?territory={{$val->territory}}">{!! dict()->get("global","territory",$val->territory)  !!} </a></h3>

                            <p><span>{{$val->resume}}</span></p>
                        </div>
                    </div>
                    @if($_user['type']==3)
                    <form method="post" action="/api/Project/Info/govScore" class="exp_score">
                        <div class="PPP-star">匿名评分：
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <input type="hidden" name="project_expert_id" value="{{$val->id}}"/>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

                        <input type="hidden" value="{{$val->gov_score}}" class="score" name="exp_score"/>
                        <input type="button" class="btn btn-xs btn-blue score_from_submit" value="保存修改">
                        <textarea name="score_desc" class="form-control" maxlength="100" placeholder="匿名评价专家，留空视为满意，限100字以内">{{$val->gov_score_desc}}</textarea>
                    </form>
                    @endif
                </div>
                @endforeach
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->
<script type="text/javascript">
    $(".score_from_submit").click(function() {
        var from = $(this).parent();

        layer.load();
        $.ajax({
            type: "POST",
            url:from.attr("action"),
            data:from.serialize(),
            dataType:"json",
            success:function(data){
                if(data.status==200) {
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
