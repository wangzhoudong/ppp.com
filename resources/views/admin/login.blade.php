<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>PPP项目-管理后台</title>
    <meta name="keywords" content="PPP项目-管理后台">
    <link href="/admin-skins/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin-skins/css/font-awesome.min.css"  rel="stylesheet">

    <link href="/admin-skins/css/animate.min.css" rel="stylesheet">
    <link href="/admin-skins/css/style.min.css"  rel="stylesheet">

</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name">PPP</h1>

            </div>

            <form class="m-t" role="form" accept-charset="UTF-8" method="post" action="/login-post">
                <div class="form-group">
                    <input name="email" class="form-control" placeholder="用户名" required="">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="密码" required="">
                </div>
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
                </p>

            </form>
        </div>
    </div>

    <!-- 全局js -->
    <script src="/admin-skins/js/jquery-2.1.1.min.js" ></script>
    <script src="/admin-skins/js/bootstrap.min.js?v=3.4.0" ></script>
    
    
    <!--统计代码，可删除-->

</body>

</html>