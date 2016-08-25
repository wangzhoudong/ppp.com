@extends('web.layout')

@section('content')
        <!-- Topic Header -->
<div class="topic">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li><a href="/">首页</a></li>
                <li class="active">About Us</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
            <div class="sign-form">
                <div class="sign-inner">
                    <h3 class="first-child">关于我们</h3>
                    <hr>
                    <div page_key="about_content" >
                        {!! $page_param['about_content'] or ' <p>伴随新一轮PPP改革大潮，作为站在基础设施和公用事业供给侧改革门口之人，我们以客户服务为导向，最大程度地整合已有PPP专业资源，积极发挥专业作用，构建中国PPP知识库和交流平台，为政府部门、社会资本、专业公司和金融机构以及相关从业者提供优质的信息、专业的服务、快捷的PPP线上咨询合作平台与在线教程平台，我们专注PPP项目前期识别阶段业务咨询，为客户提供具体PPP项目物有所值评价和财政承受能力论证咨询服务及付费型视频教程，旨在为行业、为企事业单位不断创造价值。</p>

                        <h4>我们的业务、物有所值评价咨询</h4>
                        <p>VFM理论是利用全寿命周期理论评价政府部门能否从项目产品或服务中获得最大收益的一种评价方法，我司拥有专业的咨询团队,将基于客户需求和PPP项目基础资料应用物有所值评价技术来评价该项目采用PPP模式与采用政府传统采购模式相比能否增加供给、优化风险分配、提高运营效率、促进创新和公平竞争等,为客户决策提供专业的咨询建议。</p>
                        财政承受能力论证咨询
                        <p>财政承受能力论证是指识别、测算PPP项目的各项财政支出责任，科学评估项目实施对当前及今后年度财政支出的影响，为PPP项目财政管理提供依据。我司掌握先进的基于蒙特卡洛技术的折现现金流财务分析技术、基于数据的风险量化手段和财政收支预测技术，在财政承受能力论证技术方面占据行业领先地位，我司将基于客户诉求对目标项目进行财政承受能力论证，加强PPP项目的财政支出预算管理。</p>
                        <h4>PPP在线视频培训</h4>
                        <p>本平台的在线视频培训包括但不限于PPP模式理论基础培训、PPP物有所值评价培训、PPP财政承受能力论证培训、PPP项目采购培训、PPP财务分析与建模培训、PPP典型案例教程培训，录制视频的讲师来源于PPP行业的学术研究、政策把控、实务操作等多个领域的专家，具备PPP模式运作的丰富经验和专业素养。本平台的用户完成一项线上咨询业务交易可免费观看PPP模式理论基础培训、PPP物有所值评价培训、PPP财政承受能力论证培训视频，其余视频教程为付费视频。</p>

                        <h4>联系我们</h4>
                        </p>' !!}

                    </div>
                </div>
            </div>
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->

@endsection
