@extends('web.layout')
@section('header')

    @endsection
@section('content')
        <!-- Topic Header -->
<div class="topic">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li><a href="/">首页</a></li>
                <li><a href="/login/index">角色选择</a></li>
                <li class="active">政府方登录</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="sign-form">
                <div class="sign-inner">
                    <h3 class="first-child">密码重置</h3>
                    <div class="pwd-lost-f">
                        <p class="text-muted">在此提交新密码，运营人员会在一个工作日之内通过预留的固定电话与您联系。或者您可以选择通过注册时填写的固定电话打给xxxxxx，由运营人员人工修改密码。</p>
                        <form class="validate" id="validate_FindPsw" method="post" action="" role="form">
                            <div class="form-group row">
                                <span class="col-sm-4">用户名：</span>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="fp_loginName" name="fp_loginName" placeholder="" required="true">
                                </div>
                            </div>
                            <div class="form-group row">
                                <span class="col-sm-4">新密码：</span>
                                <div class="col-sm-8">
                                    <input type="password" id="fp_password" name="fp_password" class="form-control"  placeholder="密码以字母开头，长度在6个字符以上，可以用字母/数字/下划线" required="true" ppp_pws="true">
                                </div>
                            </div>
                            <div class="form-group row">
                                <span class="col-sm-12">提交密码修改函(加盖政府公章)：</span>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-12">
                                    <?php echo  widget('Tools.ImgUpload')->single2('/upload/user','fp_official_remarksUpload1',"fp_official_remarks");?>
                                </div>
                            </div>
                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

                            <button type="button" id="FindPsw_submit" class="btn btn-style btn-k">提交修改密码请求</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->
<script type="text/javascript">
    $("#FindPsw_submit").click(function() {
        if(!$("#validate_FindPsw").valid()){
            return false;
        }
        layer.load();
        $.ajax({
            type: "POST",
            url:$('#validate_FindPsw').attr("action"),
            data:$('#validate_FindPsw').serialize(),
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
