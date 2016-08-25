
<!-- Navigation -->
<div class="pNavs pNavs01">
    <div class="pNavs-inner">
        <div class="show01">
            <ul>
                <li class="li01">
                    <a href="/" class="a01">主页</a>
                  </li>
                  <li class="li02">
                    <a href="/project.html" class="a01">我的项目</a>
                  </li>
                  <li class="li03">
                    <a href="/expert.html" class="a01">专家库</a>
                  </li>
                  <li class="li04">
                    <a href="/videos.html" class="a01">操作视频</a>
                  </li>
                  <li class="li05">
                    <a href="/flow.html" class="a01">咨询流程</a>
                  </li>
                  <li class="li06">
                    <a href="/about.html" class="a01">关于我们</a>
                  </li>
              </ul>
          </div>
      </div>
  </div>
<div class="top">
    <div class="phoneList" style="display:none;">
        <a href="#2" class="a03"></a>
    </div>
    <div class="wrappers clearfix">
        <a href="/" class="logo fleft"><img src="/web/img/icons02.png" alt="" /></a>
        <div class="nav fleft">
            <ul class="clearfix">
                <li>
                    <a href="/">
                        <span>主页</span>
                    </a>
                </li>
                <li <?php if((Request::getRequestUri() === '/project.html')) echo ' class="active"';?>>
                    <a href="/project.html">
                        @if(isset($_user['id']))
                        @if($_user['notice_project_detail'] || $_user['notice_project_export'] || $_user['notice_project_question'] || $_user['notice_project_weight'] || $_user['notice_project_score']  )
                        <i class="redTip">&nbsp;</i>
                        @endif
                        @endif
                        <span>我的项目</span>
                    </a>
                </li>
                <li <?php if((Request::getRequestUri() === '/expert.html')) echo ' class="active"';?>>
                    <a href="/expert.html">
                        <span>专家库</span>
                    </a>
                </li>
                <li<?php if((Request::getRequestUri() === '/videos.html')) echo ' class="active"';?>>
                    <a href="/videos.html">
                        <span>操作视频</span>
                    </a>
                </li>
                <li<?php if((Request::getRequestUri() === '/flow.html')) echo ' class="active"';?>>
                    <a href="/flow.html">
                        <span>咨询流程</span>
                    </a>
                </li>
                <li<?php if((Request::getRequestUri() === '/about.html')) echo ' class="active"';?>>
                    <a href="/about.html">
                        <span>关于我们</span>
                    </a>
                </li>
            </ul>
        </div>
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

<!-- Wrapper -->
<div class="wrapper">
    <!--上面head-->
