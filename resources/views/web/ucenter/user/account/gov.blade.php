@extends('web.layout')
@section('header')
<link href="/base/webuploader/webuploader.css" rel="stylesheet" type="text/css">
<script src="/base/webuploader/webuploader.min.js" type="text/javascript"></script>
@endsection
@section('content')
        <!-- Topic Header -->
<div class="topic">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li><a href="index.php">首页</a></li>
                <li class="active">个人设置 - 政府版</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
            <div class="sign-form">
                <div class="sign-inner">
                    <h3 class="first-child"> 个人资料管理</h3>
                    <hr>
                    <form class="validate" id="validate_Mainform" method="post"  role="form">
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">项目名</label>
                            <div class="col-sm-8">
                                <input type="text" id="itemName" name="itemName" value="{{$_userInfo->govInfo->project_name}}" class="form-control col-sm-8"  placeholder="限20个汉字" value="深圳财政局民生工程">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">项目负责人</label>
                            <div class="col-sm-8">
                                <input type="text" id="linkman" name="linkman" class="form-control"  placeholder="限6个汉字" value="{{$_userInfo->govInfo->linkman}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">固定电话</label>
                            <div class="col-sm-8">
                                <input type="text" id="company_tel" name="company_tel" value="{{$_userInfo->govInfo->linkman_tel}}" class="form-control"  placeholder="区号-电话号（8位）">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">联系手机</label>
                            <div class="col-sm-8">
                                <input type="text" id="linkman_mobile" name="linkman_mobile" class="form-control"  value="{{$_userInfo->govInfo->linkman_mobile}}" placeholder="11位数字">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 control-label">联系邮箱</label>
                            <div class="col-sm-8">
                                <input type="email" id="email" name="linkman_email" value="{{$_userInfo->govInfo->linkman_email}}"  class="form-control" placeholder="请输入邮箱" >
                            </div>
                        </div>
                        <!--<div class="form-group row">
                            <span class="col-sm-2">初步实施方案：</span>
                            <div class="col-sm-8">
                                <?php echo  widget('Tools.ImgUpload')->single('/upload/user','pre_schemeUpload',"pre_scheme",$_userInfo->govInfo->pre_scheme);?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <span class="col-sm-2">其他资料：</span>
                            <div class="col-sm-8">
                                <?php echo  widget('Tools.ImgUpload')->single('/upload/user','other_infoUpload',"other_info",$_userInfo->govInfo->other_info);?>
                            </div>
                        </div>-->

                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                        <input type="button" id="reg_gov_submit" class="btn-animate btn-style btn-d btn-primary m-l-xxlg" value="保存"/>
                        <hr>
                    </form>
                    <p class="m-l-xxlg"><a href="/login/resetPwd">修改密码？</a></p>
                </div>
            </div>
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->
@endsection
@section('footer')
    <script type="text/javascript">
        $("#reg_gov_submit").click(function() {
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
                        layer.msg('操作成功');
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
