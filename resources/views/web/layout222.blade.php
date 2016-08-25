<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
	<meta name="viewport" content="initial-scale=1.0,user-scalable=no,maximum-scale=1,width=device-width">
	<link rel="shortcut icon" href="ico/favicon.ico">
	@include('web.common.meta')
	<meta name="_token" content="{{ csrf_token() }}"/>

	<!-- Bootstrap core CSS -->
	<!--<link href="css/bootstrap.min.css" rel="stylesheet">-->
	<link href="/web/css/style.css" rel="stylesheet">
	<link href="/web/css/font-awesome.min.css" rel="stylesheet">
	<link href="/web/css/animate.css" rel="stylesheet">
	<link href="/web/css/lightbox.css" rel="stylesheet">
	<link href='http://fonts.useso.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<script src="/web/js/jquery-1.11.0.min.js?v={{config("sys.version")}}"></script>
	<script type="text/javascript" src="/base/layer/layer.js?v={{config("sys.version")}}"></script>
	<script type="text/javascript" src="/base/service.js?v={{config("sys.version")}}"></script>

	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js?v={{config("sys.version")}}"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js?v={{config("sys.version")}}"></script>\
	<![endif]-->
	@yield('header')
</head>

<body>
<!-- 头部   -->
<!-- 页面内容 -->
<!-- Navigation -->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<ul class="nav navbar-nav navbar-right PPP-nav-login">
				<li><a href="role_choose.html">登录/注册</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="/web/contents/avatar-1.jpg"/>专家：李狗蛋</a>
					<ul class="dropdown-menu">
						<li><a href="role_gov_edit.html">个人设置-政府</a></li>
						<li><a href="role_exp_edit.html">个人设置-专家</a></li>
						<li><a href="#">退出</a></li>
					</ul>
				</li>
			</ul>
			<a class="navbar-brand" href="/"><img src="/web/contents/logo.png"/>政府与社会资本合作咨询网</a>
		</div>
		<div class="collapse navbar-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li class="active">
					<a href="/" >主页</a>
				</li>
				<li>
					<a href="/project" >我的项目</a>
				</li>
				<li>
					<a href="/expert" >专家库</a>
				</li>
				<li>
					<a href="/flow" >咨询流程</a>

				</li>
				<li>
					<a href="/about">关于我们</a>
				</li>
				@if($_user)
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$_user['name'] or "个人中心"}}</a>
						<ul class="dropdown-menu">

							<li><a href="/account/userinfo">个人设置</a></li>
							<li><a href="/login/logout">退出</a></li>
						</ul>
					</li>
				@else
					<li>
						<a href="/login/index">登录/注册</a>
					</li>
				@endif
			</ul>
		</div><!--/.nav-collapse -->
	</div>
</div> <!-- / .navigation -->
<span id="header_shadow" style="width: 100%; top: 30px;"></span>

<!-- Wrapper -->
<div class="wrapper">
	<!--上面head-->

	@yield('content')


			<!--下面foot-->
</div> <!-- / .wrapper -->

<!-- Footer -->
<footer>
	<div class="container">
		<div class="row">

			<!-- Contact Us -->
			<div>
				<p>
					©2016 PPP  京ICP证030173号
					京公网安备11000002000001号 All right reserved by XXX。联系电话：12345678
				</p>
			</div><!-- / .Contact Us -->


		</div> <!-- / .row -->
	</div> <!-- / .container -->
</footer><!-- / .Footer -->


<!-- JavaScript -->
<script src="/web/js/bootstrap.min.js?v={{config("sys.version")}}"></script>
<script src="/web/js/scrolltopcontrol.js?v={{config("sys.version")}}"></script>
<script src="/web/js/SmoothScroll.js?v={{config("sys.version")}}"></script>
<script src="/web/js/lightbox-2.6.min.js?v={{config("sys.version")}}"></script>
<script src="/web/js/validate/jquery.validate.min.js"></script>
<script src="/web/js/validate/messages_zh.min.js"></script>
<script src="/web/js/custom.js?v={{config("sys.version")}}"></script>
<script src="/web/js/index.js?v={{config("sys.version")}}"></script>
<script type="text/javascript">
	$.ajaxSetup({
		headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
	});
	@if (session("message"))
		layer.msg('{{session("message")}}');
	{{ session()->forget('message') }}
	@endif
</script>
@yield('footer')

</body>
</html>