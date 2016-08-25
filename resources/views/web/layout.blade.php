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
	<link href="/web/css/style.css?v={{config("sys.version")}}" rel="stylesheet">
	<link href="/web/css/font-awesome.min.css?v={{config("sys.version")}}" rel="stylesheet">
	<link href="/web/css/animate.css?v={{config("sys.version")}}" rel="stylesheet">
	<link href="/web/css/lightbox.css?v={{config("sys.version")}}" rel="stylesheet">
	<link href='http://fonts.useso.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
	<link href="/web/css/patch.css?v={{config("sys.version")}}" rel="stylesheet">
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
@include("web.common.head")

	<!--上面head-->

@yield('content')


		<!--下面foot-->
</div> <!-- / .wrapper -->

<!-- Footer -->
<div class="footer">
	<div class="container">
		<div class="row">


			<div>
				<ul class="footer-link">
					<li>
						<a href="/about.html">关于我们</a>
					</li>
					<li>
						<a href="/about/protocol.html">法律声明</a>
					</li>
					<li>
						<a href="/about/user.html">网站用户使用协议</a>
					</li>
				</ul>

				<p>
					©2016 PPP  京ICP证030173号
					京公网安备11000002000001号 All right reserved by ppp。
				</p>
			</div><!-- / .Contact Us -->



		</div> <!-- / .row -->

	</div> <!-- / .container -->
</div><!-- / .Footer -->

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

@include('web.common.blockeditor')

</body>
</html>
