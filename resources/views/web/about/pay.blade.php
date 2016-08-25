@extends('web.layout')

@section('content')
        <!-- Topic Header -->
<div class="topic">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li><a href="/">首页</a></li>
                <li><a href="/videos.html">视频</a></li>

                <li class="active">如何付费</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
            <div class="sign-form">
                <div class="sign-inner">
                    <h3 class="first-child">如何付费</h3>
                    <hr>
                    <div>
                        <p>为了给用户带来更多直观的体验，本平台向已在本平台完成PPP在线咨询交易的用户提供关于PPP模式简介、PPP物有所值评价、PPP财政承受论证三类免费教程视频，此外，本平台根据目前PPP模式在国内的推广及实施情况，也邀请了PPP行业领域的顶尖专家完成了有关PPP实施方案编制、PPP操作指南解读、PPP典型案例的解析等课程录制，以满足用户需求。</p>
                        <h4>如何付费：</h4>
                        <p>
                            用户需在付费说明页面填写有意愿购买的视频编号，并在备注中留备个人电子邮箱及联系方式，提交后系统会自动弹出本次因购买在线视频需要支付的金额，用户在三个工作日内向在线平台指定银行账户汇入支付款，平台在收款后的两个工作日内会向用户以附件上传的向指定邮箱电邮视频教程文件。
                        </p><p>
                            户名：北京传睿基建信息科技有限公司 <br/>
                            开户银行：********<br/>
                            账号：********<br/>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->
@endsection
