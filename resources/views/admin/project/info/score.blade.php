@extends('admin.project.info.layout')

@section('detail_content')
<style>

    /* qa */
    .PPP-qa-box{ margin-bottom:30px; }
    .PPP-qa-q{ }
    .PPP-qa-a{ }
    .PPP-qa-a li{ background:#fafafa; min-height:72px; padding:6px 6px 6px 72px; border:1px solid #eee; position:relative; list-style:none; margin-bottom:10px; border-radius:2px; }
    .PPP-qa-a img{ position:absolute; top:6px; left:6px; width:60px; height:60px; border-radius:2px; }
    .PPP-qa-name{ font-size:14px; color:#333; }
    .PPP-qa-time{ color:#666; position:absolute; right:6px; top:6px; font-size:12px; }
    .PPP-qa-cont{ margin-top:10px; font-size:12px; line-height:24px; }

</style>
<script src="/web/js/jquery-1.11.0.min.js?v={{config("sys.version")}}"></script>
<script type="text/javascript" src="/base/layer/layer.js?v={{config("sys.version")}}"></script>
<script type="text/javascript" src="/base/service.js?v={{config("sys.version")}}"></script>
<script src="/web/js/bootstrap.min.js?v={{config("sys.version")}}"></script>
<script src="/web/js/scrolltopcontrol.js?v={{config("sys.version")}}"></script>
<script src="/web/js/SmoothScroll.js?v={{config("sys.version")}}"></script>
<script src="/web/js/lightbox-2.6.min.js?v={{config("sys.version")}}"></script>
<script src="/web/js/validate/jquery.validate.min.js"></script>
<script src="/web/js/validate/messages_zh.min.js"></script>
<script src="/web/js/custom.js?v={{config("sys.version")}}"></script>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>定性评分</h5>
            <div class="ibox-tools">
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="ibox-content form-group">
            <div class="row">
                <div class="form-group row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table ppp_worth">
                            <thead>
                            <tr>
                                <th></th>
                                <th>指标</th>
                                <th>权重</th>
                                @foreach($userExpert as $key=>$val)
                                    <th><a href="$val">{{$val->name}}：<br/>{{dict()->get('global','territory',$val->territory)}}</a> </th>
                                @endforeach
                                <th>去掉最高最低平均分</th>
                                <th>加权平均分</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="PPP_wq_basic" rowspan="6">基本指标</td>
                                <td>全生命周期整合程度</td>
                                <td class="ppp_score_qz">{{$data['zb_life_weight'] or '0'}}%</td>

                                @foreach($userExpert as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_life_reason']}}" >{{$val['zb_life_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>风险识别与分配</td>
                                <td class="ppp_score_qz">{{$data['zb_risk_weight'] or '0'}}%</td>

                                @foreach($userExpert as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_risk_reason']}}" >{{$val['zb_risk_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>绩效导向与鼓励创新</td>
                                <td class="ppp_score_qz">{{$data['zb_encourage_weight'] or '0'}}%</td>
                                @foreach($userExpert as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_encourage_reason']}}" >{{$val['zb_encourage_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>潜在竞争程度</td>
                                <td class="ppp_score_qz">{{$data['zb_potential_weight'] or '0'}}%</td>
                                @foreach($userExpert as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_potential_reason']}}" >{{$val['zb_potential_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>政府机构能力</td>
                                <td class="ppp_score_qz">{{$data['zb_gov_weight'] or '0'}}%</td>
                                @foreach($userExpert as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_gov_reason']}}" >{{$val['zb_gov_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>融资可获得性</td>
                                <td class="ppp_score_qz">{{$data['zb_financing_weight'] or '0'}}%</td>
                                @foreach($userExpert as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_financing_reason']}}" >{{$val['zb_financing_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td class="PPP_wq_extro" rowspan="6">补充指标</td>
                                <td>项目规模大小</td>
                                <td class="ppp_score_qz">{{$data['zb_size_weight'] or '0'}}%</td>
                                @foreach($userExpert as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_size_reason']}}" >{{$val['zb_size_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>预期使用寿命长短</td>
                                <td class="ppp_score_qz">{{$data['zb_expected_weight'] or '0'}}%</td>
                                @foreach($userExpert as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_expected_reason']}}" >{{$val['zb_expected_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>主要固定资产种类</td>
                                <td class="ppp_score_qz">{{$data['zb_fixed_weight'] or '0'}}%</td>
                                @foreach($userExpert as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_fixed_reason']}}" >{{$val['zb_fixed_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>全寿命期成本测算准确性</td>
                                <td class="ppp_score_qz">{{$data['zb_measure_weight'] or '0'}}%</td>
                                @foreach($userExpert as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_measure_reason']}}" >{{$val['zb_measure_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>运营收入增长潜力</td>
                                <td class="ppp_score_qz">{{$data['zb_growth_weight'] or '0'}}%</td>
                                @foreach($userExpert as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_growth_reason']}}" >{{$val['zb_growth_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>行业示范性</td>
                                <td class="ppp_score_qz">{{$data['zb_demonstration_weight'] or '0'}}%</td>
                                @foreach($userExpert as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_demonstration_reason']}}" >{{$val['zb_demonstration_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>总得分</td>
                                <td  colspan="{{count($userExpert)+4}}" class="ppp_score_zdf"></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
