@extends('web.layout')
@section('content')
        <!-- Topic Header -->
<div class="topic">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li><a href="index.php">首页</a></li>
                <li class="active">选择角色</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->

<div class="container">
  <div class="row">
    <div class="choose-box col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
      <div class="sign-form">
        <div class="sign-inner">
          <h3 class="first-child">选择您的角色</h3>
          <hr>
          <div class="ppp_choose_head">
            <a href="/login/gov" class="col-md-12 btn btn-lg btn-red">
              <i class="fa fa-user"></i>
              <span>政府人员</span>
            </a>
            <a href="/login/expert" class="col-md-12 btn btn-lg btn-blue">
              <i class="fa fa-book"></i>
              <span>专家</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div> <!-- / .row -->
</div> <!-- / .container -->
@endsection
