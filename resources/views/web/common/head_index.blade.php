
<!-- Navigation -->

<div class="indexBan">
    <div class="phoneList" style="display:none;">
    </div>
    <div class="top indexTop">
        <div class="wrappers clearfix">
            <a href="/" class="logo fleft"><img src="/web/img/icons02.png" alt="" /></a>
            <div class="search clearfix">
                @if($_user)
                    <div class="later-login fleft">
                        <ul class="clearfix">
                            <li>
                                <a href="#2" class="a01 fleft"><img src="/web/img/icons58.png" alt="" /></a>
                            </li>
                            <li class="li02">
                                <a href="#2" class="a02">{{$_user['username'] or "个人中心"}}</a>
                                <div class="later-list" style="display:none;">
                                    <a href="/account/userinfo">个人设置</a>
                                    <a href="/login/logout">退出</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                @else
                    <div class="login-register fleft" style="display:;">
                        <a href="/login/index">登录丨注册</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="indexNav">
        <div class="wrappers clearfix">
            <div class="w1000">
                <a href="/"><span class="span01">主页</span></a>
                <a href="/project.html"><span class="span01">我的项目</a>
                <a href="/expert.html"><span class="span01">专家库</a>
                <a href="/videos.html"><span class="span01">操作视频</span></a>
                <a href="/flow.html"><span class="span01">咨询流程</span></a>
                <a href="/about.html"><span class="span01">关于我们</span></a>
            </div>
        </div>
    </div>
    <div class='indexBg'></div>
    <ul class="slidePot">
        <li></li>
        <li></li>
        <li></li>
    </ul>
</div>
<!-- Wrapper -->
<div class="wrapper indexCont">
    <div class="bgFir"></div>
    <!--上面head-->
