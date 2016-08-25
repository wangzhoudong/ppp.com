@extends('web.layout')

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
                    <h3 class="first-child">政府方登录</h3>
                    <hr>
                   <form class="validate"  action="" method="post" id="validate_Mainform" role="form">
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-user"></i></span>
                          <input type="text" id="loginName" autocomplete="off"  name="loginName" class="form-control" placeholder="登录用户名/邮箱" />
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="input-group">
                          <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                          <input type="password" id="password" autocomplete="off"  name="password" class="form-control" placeholder="密码" title=""/>
                        </div>
                      </div>
                      <div class="form-group">
                          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                      <input href="#" type="submit" class="btn-animate btn-style btn-d btn-primary" value="登录" />
                      </div>
                      <hr>

                    </form>
                    <span>没有注册? <a href="/register/gov">注册成为政府方代表</a></span>
                    <span class="f-r"><a href="/login/resetPwd">修改密码？</a></span>
                </div>
            </div>
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->

@endsection
