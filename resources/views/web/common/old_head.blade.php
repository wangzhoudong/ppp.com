<div class="navbar navbar-index" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <ul class="nav navbar-nav navbar-right PPP-nav-login">
                @if($_user)
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="/web/contents/avatar-1.jpg"/>{{$_user['name'] or "个人中心"}}</a>
                        <ul class="dropdown-menu">
                            <li><a href="/account/userinfo">个人设置</a></li>
                            <li><a href="/login/logout">退出</a></li>
                        </ul>
                    </li>
                @else
                    <a href="/login/index">登录/注册</a>
                @endif


            </ul>
            <a class="navbar-brand" href="/"><img src="/web/contents/logo.png"/>政府与社会资本合作咨询网</a>
        </div>
    </div>
    <div class="navbar-collapse">
        <ul class="PPP-nav-bottom">
            <li <?php if((Request::getRequestUri() === '/')) echo ' class="active"';?>><<a href="/" >主页</a></li>
            <li  <?php if(stristr(Request::getRequestUri(),'/project.html')) echo ' class="active"';?>>
                <a href="/project.html" >我的项目</a>
            </li >
            <li <?php if(stristr(Request::getRequestUri(),'/expert.html')) echo ' class="active"';?>>
                <a href="/expert.html" >专家库</a>
            </li>
            <li <?php if(stristr(Request::getRequestUri(),'/videos.html')) echo ' class="active"';?>>
                <a href="/videos.html" >操作视频</a>
            </li>
            <li <?php if(stristr(Request::getRequestUri(),'/flow.html')) echo ' class="active"';?>>
                <a href="/flow.html" >咨询流程</a>
            </li>
            <li <?php if(stristr(Request::getRequestUri(),'/about.html')) echo ' class="active"';?>>
                <a href="/about.html">关于我们</a>
            </li>
        </ul>
    </div><!--/.nav-collapse -->
</div> <!-- / .navigation -->
<span id="header_shadow" style="width: 100%; top: 30px;"></span>

<!-- Wrapper -->
<div class="wrapper">