<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
	<meta name="crm" content="http://{{env('CRM_DOMAIN','kefu.liweijia.com')}}/"/>
    <title>PPP</title>

    <link href="/admin-skins/css/bootstrap.min.css?v=3.4.0.css" rel="stylesheet">
    <link href="/admin-skins/css/font-awesome.min.css?v=4.3.0.css" rel="stylesheet">

    <!-- Data Tables -->
    <link href="/admin-skins/css/plugins/dataTables/dataTables.bootstrap.css"rel="stylesheet">

    <link href="/admin-skins/css/animate.min.css?v={{config("sys.version")}}"  rel="stylesheet">
    <link href="/admin-skins/css/style.min.css?v={{config("sys.version")}}" rel="stylesheet">
   
   	<!-- 全局js -->
    <script src="/admin-skins/js/jquery-2.1.1.min.js?v={{config("sys.version")}}" ></script>
    <script src="/admin-skins/js/bootstrap.min.js?v=3.4.0" ></script>
    <link href="/base/webuploader/webuploader.css" rel="stylesheet" type="text/css">
    <script src="/base/webuploader/webuploader.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="/base/layer/layer.js?v={{config("sys.version")}}"></script>



    @yield('header')
</head>

<body class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
       @yield('content')
    </div>
    
    <!-- layer Date -->
    <script src="/admin-skins/js/laydate/laydate.js?v={{config("sys.version")}}" type="text/javascript" ></script>
    <script type="text/javascript"> !function(){ laydate.skin('molv'); }(); </script>
    
    <!-- 自定义js -->
    <script src="/admin-skins/js/content.min.js?v=1.0.0" ></script>

    
    <!-- jQuery Validation plugin javascript-->
    <script src="/admin-skins/js/plugins/validate/jquery.validate.min.js?v={{config("sys.version")}}" ></script>
    <script src="/admin-skins/js/plugins/validate/messages_zh.min.js?v={{config("sys.version")}}" ></script>
    <script src="/base/js/jquery.tableSort.js?v={{config("sys.version")}}" ></script>
    <script>
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN' : '{{ csrf_token() }}' }
        });
		$.validator.setDefaults({
			highlight : function(a) {
				$(a).closest(".form-group").removeClass(
						"has-success").addClass("has-error")
			},
			success : function(a) {
				a.closest(".form-group").removeClass("has-error")
						.addClass("has-success")
			},
			errorElement : "span",
			errorPlacement : function(a, b) {
				if (b.is(":radio") || b.is(":checkbox")) {
					a.appendTo(b.parent().parent().parent())
				} else {
					a.appendTo(b.parent())
				}
			},
			errorClass : "help-block m-b-none",
			validClass : "help-block m-b-none"
		});
		$(".dataTable").tableSort(['sorting','sorting_asc','sorting_desc']);
		$().ready(function() {
			$("#form-validation").validate();
			
		});
        @if (session("message"))
		layer.msg('{{session("message")}}');
        {{ session()->forget('message') }}
        @endif
	</script>
	
    @yield('footer')

</body>

</html>