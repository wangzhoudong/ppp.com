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
                <li><a href="/login/gov">政府方登录</a></li>
                <li class="active">政府方注册</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
            <div class="sign-form">
                <div class="sign-inner">
                    <h3 class="first-child">政府方注册</h3>
                    <hr>
                    <form class="validate" id="validate_Mainform"  action="/api/register/gov" method="post" role="form">
                    <div class="form-group row">
                      <span class="col-sm-4">项目名：</span>
                      <div class="col-sm-8">
                        <input type="text" id="itemName" name="itemName" class="form-control" placeholder="限20个汉字">
                      </div>
                    </div>
                    <div class="form-group row">
                      <span class="col-sm-4">实施单位：</span>
                      <div class="col-sm-8">
                        <input type="text" id="builder_company" name="builder_company" class="form-control">
                      </div>
                    </div>
                    <div class="form-group row">
                      <span class="col-sm-4">该单位固定电话：</span>
                      <div class="col-sm-8">
                        <input type="text" id="company_tel" name="company_tel" class="form-control"  placeholder="区号-电话号（8位）">
                      </div>
                    </div>
                    <div class="form-group row">
                      <span class="col-sm-4">登录用户名：</span>
                      <div class="col-sm-8">
                        <input type="text" id="loginName" name="loginName" class="form-control" placeholder="汉字或者拼音，20字符以下">
                      </div>
                    </div>
                    <div class="form-group row">
                      <span class="col-sm-4">项目联系人：</span>
                      <div class="col-sm-8">
                        <input type="text" id="linkman" name="linkman" class="form-control"  placeholder="限6个汉字">
                      </div>
                    </div>
                    <div class="form-group row">
                      <span class="col-sm-4">联系人电话：</span>
                      <div class="col-sm-8">
                        <input type="text" id="linkman_mobile" name="linkman_mobile" class="form-control"  placeholder="11位数字">
                      </div>
                    </div>
                    <div class="form-group row">
                        <span class="col-sm-4">联系人邮箱：</span>
                        <div class="col-sm-8">
                            <input type="text" id="linkman_email" name="linkman_email" class="form-control"  placeholder="联系人邮箱">
                        </div>
                    </div>
                    <div class="form-group row">
                      <span class="col-sm-4">政府批文照片：</span>
                      <div class="col-sm-8">
                       <?php echo  widget('Tools.ImgUpload')->single2('/upload/user','articleUpload1',"approve_pic");?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <span class="col-sm-offset-4 col-sm-8">2M以下，支持jpeg,png,bmp格式</span>
                    </div>
                    <div class="form-group row">
                      <span class="col-sm-4">登录密码：</span>
                      <div class="col-sm-8">
                        <input type="password" autocomplete="off"  id="password" name="password" class="form-control"  placeholder="密码以字母开头，长度在6个字符以上，可以用字母/数字/下划线" >
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="checkbox">
                        <label>
                          <input id="agree" name="agree" type="checkbox"> 我已阅读并同意 <a href="#">PPP项目 网站用户使用协议</a>
                        </label>
                      </div>
                    </div>
                    <input type="button" id="reg_gov_submit"  class="btn-animate btn-style btn-d btn-primary" value="注册"/>
                </form>
                </div>
            </div>
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->
@endsection
@section('footer')
    <script type="text/javascript">
        $(function(){

        } );
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
                        layer.confirm('注册成功,请耐心等待审核!!!', {
                            btn: ['先随便逛逛'] //按钮
                        }, function(){
                            location.href='/';
                        });
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