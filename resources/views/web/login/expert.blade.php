@extends('web.layout')

@section('content')
        <!-- Topic Header -->
<div class="topic">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li><a href="/">首页</a></li>
                <li><a href="/login/index">角色选择</a></li>
                <li class="active">专家登录</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
            <div class="sign-form">
                <div class="sign-inner">
                    <h3 class="first-child">专家登录</h3>
                    <hr>
                    <form class="validate" action="" method="post" id="validate_Mainform" role="form">
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-user"></i></span>
                      <input type="text" class="form-control" autocomplete="off"  id="exp_mobile" name="exp_mobile" placeholder="输入手机号"/>
                      <span class="input-group-btn"><button  class="mobileSendCode btn btn-secondary" type="button">发送验证码</button></span>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                      <input type="text" id="identiCode" name="identiCode" class="form-control" placeholder="请输入发送到手机的验证码">
                    </div>
                  </div>
                  <div class="form-group">
                      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                    <input type="submit" class="btn-animate btn-style btn-d btn-primary" value="登录" />
                  </div>                
                  <hr>
                </form>
                    <p>没有注册? <a href="/register/expert">注册成为专家</a></p>
                </div>
            </div>
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->
@endsection

@section("footer")
    <script type="text/javascript">


        $(".mobileSendCode").click(function() {
            var mobile = $('#exp_mobile').val();
            var sendCode = $(this);
            if(mobile.length==11) {
                layer.load();
                $.getJSON('/api/user/checkMobile?mobile='+mobile,function(data) {
                    if(data.status!=200) {
                        layer.msg("手机号不存在请先注册");
                    }else{
                        mobileSendCode(sendCode,'exp_mobile');
                    }
                });
                layer.closeAll('loading');
            }else{
                layer.msg('请输入正确的手机号');
            }

        });

    </script>

@endsection
