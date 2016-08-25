@extends('web.layout')

@section('content')
        <!--上面head-->
<!-- Topic Header -->
<div class="topic">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li><a href="/">首页</a></li>
                <li class="active">咨询流程</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->

<div class="container">
    <div class="sign-form">
        <div class="sign-inner">
            <h3 class="first-child">咨询流程</h3>
            <hr>
            <div class="row ppp-flow-left">
                <div class="ppp-flow-step"><span  page_key="setep1" >  {!! $page_param['setep1'] or ' 完善个人资料，<br/>提交项目政府批文'!!}</span></div>
                <div class="ppp-flow-arrow left"><span class="ppp-flow-tip"><span><span  page_key="setep1_1" >{!! $page_param['setep1_1'] or ' 注册成功'!!}</span></span></span><i class="line"></i><i class="head"></i></div>
                <div class="ppp-flow-step"><span page_key="setep2">{!! $page_param['setep2'] or '填写尽职调查文档，提交项目初步实施方案'!!}</span></div>

                <div class="ppp-flow-arrow left"><span class="ppp-flow-tip">
                        <span><span page_key="setep2_2">
                                 @if(isset($_uesr['type']) && $_user['type'] == 3)
                                {!! $page_param['setep2_2'] or '签订合同<br/>付咨询费定金<b>（咨询费定金50%）</b>'!!}
                                @endif
                               </span></span></span><i class="line"></i><i class="head"></i></div>


                <div class="ppp-flow-step"><span page_key="setep3">{!! $page_param['setep3'] or '平台为项目匹配专家'!!}</span></div>
            </div>
            <div class="row ppp-flow-right">
                <div class="ppp-flow-arrow down"><span class="ppp-flow-tip"><span><span page_key="setep4">{!! $page_param['setep4'] or '审核通过'!!}</span></span></span><i class="line"></i><i class="head"></i></div>
            </div>
            <div class="row ppp-flow-right">
                <div class="ppp-flow-step"><span  page_key="setep5">{!! $page_param['setep5'] or '确定开会时间'!!}</span></div>
                <div class="ppp-flow-arrow right"><i class="line"></i><i class="head"></i></div>
                <div class="ppp-flow-step"><span page_key="setep6">{!! $page_param['setep6'] or '会前专家完善物有所值指标和权重，以及在项目讨论区回答政府方提出的问题'!!}</span></div>
                <div class="ppp-flow-arrow right"><i class="line"></i><i class="head"></i></div>
                <div class="ppp-flow-step"><span page_key="setep7">{!! $page_param['setep7'] or '到约定时间，政府方，平台和专家一起电话会议'!!}</span></div>
            </div>
            <div class="row ppp-flow-left">
                <div class="ppp-flow-arrow down"><i class="line"></i><i class="head"></i></div>
            </div>
            <div class="row ppp-flow-left">
                <div class="ppp-flow-step"><span  page_key="setep8">{!! $page_param['setep8'] or '专家完成定性评分'!!}</span></div>
                <div class="ppp-flow-arrow left"><i class="line"></i><i class="head"></i></div>
                <div class="ppp-flow-step"><span page_key="setep9">{!! $page_param['setep9'] or '平台出具咨询报告'!!}</span></div>
                <div class="ppp-flow-arrow left"><i class="line"></i><i class="head"></i></div>
                <div class="ppp-flow-step"><span page_key="setep10">{!! $page_param['setep10'] or '专家/平台配合政府完成项目后续审核工作'!!}</span></div>
            </div>
            <div class="row ppp-flow-right">
                <div class="ppp-flow-arrow down"><span class="ppp-flow-tip"><span><span page_key="setep11">{!! $page_param['setep11'] or '支付剩余咨询费'!!}</span></span></span><i class="line"></i><i class="head"></i></div>
            </div>
            <div class="row ppp-flow-right">
                <div class="ppp-flow-step"><span page_key="setep12">{!! $page_param['setep12'] or '项目圆满完成'!!}</span></div>
            </div> <!-- / .row -->

        </div>
    </div>
</div> <!-- / .container -->
@endsection
