@extends('web.layout')

@section('content')
        <!-- Topic Header -->
<div class="topic">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">  <li><a href="/">首页</a></li>
                <li><a href="/project.html">我的项目</a></li>
                <li class="active">提交新项目</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->

<div class="container project_form" id="project_add1">
    @include("web.project.add_nav")
    <div class="row">
        <div class="">
            <div class="sign-form">
                <div class="sign-inner">
                    <h3 class="first-child">项目财政信息</h3>
                    <hr>
                    <form class="validate" id="validate_Mainform" method="post" role="form">
                      @include("base.project.add1_input")
                        <div class="form-group row">
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

                            <input type="button" id="project_add1_sumbit" class="btn-animate btn-style btn-d btn-primary" value="下一步"/>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->

<script type="text/javascript">
    $(function(){
        $('.changeInput').click();
    } );
    $("#project_add1_sumbit").click(function() {
        if(!$("#validate_Mainform").valid()){
            return false;
        }
        layer.load();
        $.ajax({
            type: "POST",
            url:$('#validate_Mainform').attr("action"),
            data:$('#validate_Mainform').serialize(),
            dataType:"json",
            success:function(data){
                if(data.status==200) {
                    layer.msg("已保存");
                    location.href="/project/add2?project_id=" + data.data.id;
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
    });

</script>
@endsection
