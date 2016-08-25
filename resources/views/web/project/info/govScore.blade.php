@extends('web.layout')

@section('content')
        <!--上面head--><!-- Topic Header -->
@include("web.project.info.topic")
<div class="container" id="project_quota_gov">
    <div class="row">
        <div class="col-sm-3">
            @include("web.project.info.left_panel")
         </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="form-group row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table ppp_worth">
                            <thead>
                            <tr>
                                <th></th>
                                <th>指标</th>
                                <th>权重</th>
                                @foreach($data as $key=>$val)
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
                                <td class="ppp_score_qz">{{$project['zb_life_weight'] or '0'}}%</td>

                                @foreach($data as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_life_reason']}}" >{{$val['zb_life_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>风险识别与分配</td>
                                <td class="ppp_score_qz">{{$project['zb_risk_weight'] or '0'}}%</td>

                                @foreach($data as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_risk_reason']}}" >{{$val['zb_risk_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>绩效导向与鼓励创新</td>
                                <td class="ppp_score_qz">{{$project['zb_encourage_weight'] or '0'}}%</td>
                                @foreach($data as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_encourage_reason']}}" >{{$val['zb_encourage_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>潜在竞争程度</td>
                                <td class="ppp_score_qz">{{$project['zb_potential_weight'] or '0'}}%</td>
                                @foreach($data as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_potential_reason']}}" >{{$val['zb_potential_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>政府机构能力</td>
                                <td class="ppp_score_qz">{{$project['zb_gov_weight'] or '0'}}%</td>
                                @foreach($data as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_gov_reason']}}" >{{$val['zb_gov_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>融资可获得性</td>
                                <td class="ppp_score_qz">{{$project['zb_financing_weight'] or '0'}}%</td>
                                @foreach($data as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_financing_reason']}}" >{{$val['zb_financing_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td class="PPP_wq_extro" rowspan="6">补充指标</td>
                                <td>项目规模大小</td>
                                <td class="ppp_score_qz">{{$project['zb_size_weight'] or '0'}}%</td>
                                @foreach($data as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_size_reason']}}" >{{$val['zb_size_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>预期使用寿命长短</td>
                                <td class="ppp_score_qz">{{$project['zb_expected_weight'] or '0'}}%</td>
                                @foreach($data as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_expected_reason']}}" >{{$val['zb_expected_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>主要固定资产种类</td>
                                <td class="ppp_score_qz">{{$project['zb_fixed_weight'] or '0'}}%</td>
                                @foreach($data as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_fixed_reason']}}" >{{$val['zb_fixed_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>全寿命期成本测算准确性</td>
                                <td class="ppp_score_qz">{{$project['zb_measure_weight'] or '0'}}%</td>
                                @foreach($data as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_measure_reason']}}" >{{$val['zb_measure_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>运营收入增长潜力</td>
                                <td class="ppp_score_qz">{{$project['zb_growth_weight'] or '0'}}%</td>
                                @foreach($data as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_growth_reason']}}" >{{$val['zb_growth_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>行业示范性</td>
                                <td class="ppp_score_qz">{{$project['zb_demonstration_weight'] or '0'}}%</td>
                                @foreach($data as $key=>$val)
                                    <td  class="ppp_score"  title="{{$val['zb_demonstration_reason']}}" >{{$val['zb_demonstration_score']}}</td>
                                @endforeach
                                <td class="ppp_score_pj"></td>
                                <td class="ppp_score_jqpj"></td>
                            </tr>
                            <tr>
                                <td>总得分</td>
                                <td  colspan="{{count($data)+4}}" class="ppp_score_zdf"></td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> <!-- / .row -->
</div> <!-- / .container -->
<script type="text/javascript">
    $(".exp_weight_submit").click(function() {
        var from = $(this).parent().parent().parent();
        layer.load();
        $.ajax({
            type: "POST",
            url:from.attr("action"),
            data:from.serialize(),
            dataType:"json",
            success:function(data){
                if(data.status==200) {
                    layer.msg("操作成功");
                }else{
                    layer.msg(data.msg);
                }
                layer.closeAll('loading');
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                layer.msg('网络异常，请稍后刷新后再试');
                layer.closeAll('loading');
            },
        });
        return false;
    });


</script>
@endsection
