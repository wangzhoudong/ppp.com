@extends('web.layout')

@section('content')
        <!--上面head--><!-- Topic Header -->
@include("web.project.sample.topic")
<div class="container" id="project_quota_gov">
    <div class="row">
        <div class="col-sm-3">
            @include("web.project.sample.left_panel")
         </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="form-group row">
                    <div class="col-sm-12 table-responsive">
                        <table class="table ppp_worth">
                            <thead>
                            <tr>
                                <th></th>
                                <th>指标（单位%）</th>
                                @foreach($data as $key=>$val)
                                    <th><a href="$val">{{$val->name}}：<br/>{{dict()->get('global','territory',$val->territory)}}</a> </th>
                                @endforeach
                                <th>最终指标</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="PPP_wq_basic" rowspan="7">基本指标</td>
                                <td>全生命周期整合程度</td>
                                @foreach($data as $key=>$val)
                                    <td >{{$val['zb_life_weight']}}</td>
                                @endforeach
                                <td >{{$project['zb_life_weight']}}</td>

                            </tr>
                            <tr>
                                <td>风险识别与分配</td>
                                @foreach($data as $key=>$val)
                                    <td title="">{{$val['zb_risk_weight']}}</td>
                                @endforeach
                                <td >{{$project['zb_risk_weight']}}</td>

                            </tr>
                            <tr>
                                <td>绩效导向与鼓励创新</td>
                                @foreach($data as $key=>$val)
                                    <td  title="">{{$val['zb_encourage_weight']}}</td>
                                @endforeach
                                <td >{{$project['zb_encourage_weight']}}</td>

                            </tr>
                            <tr>
                                <td>潜在竞争程度</td>
                                @foreach($data as $key=>$val)
                                    <td  title="">{{$val['zb_potential_weight']}}</td>
                                @endforeach
                                <td >{{$project['zb_potential_weight']}}</td>

                            </tr>
                            <tr>
                                <td>政府机构能力</td>
                                @foreach($data as $key=>$val)
                                    <td  title="">{{$val['zb_gov_weight']}}</td>
                                @endforeach
                                <td >{{$project['zb_gov_weight']}}</td>

                            </tr>
                            <tr>
                                <td>融资可获得性</td>
                                @foreach($data as $key=>$val)
                                    <td  title="">{{$val['zb_financing_weight']}}</td>
                                @endforeach
                                <td >{{$project['zb_financing_weight']}}</td>

                            </tr>
                            <tr>
                                <td>基本指标小计</td>
                                @foreach($data as $key=>$val)
                                    <td>{{$val->zb_life_weight+$val->zb_risk_weight+$val->zb_encourage_weight+$val->zb_potential_weight+$val->zb_gov_weight+$val->zb_financing_weight}}</td>
                                @endforeach
                                <td >{{$project->zb_life_weight+$project->zb_risk_weight+$project->zb_encourage_weight+$project->zb_potential_weight+$project->zb_gov_weight+$project->zb_financing_weight}}</td>

                            </tr>
                            <tr>
                                <td class="PPP_wq_extro" rowspan="7">补充指标</td>
                                <td>项目规模大小</td>
                                @foreach($data as $key=>$val)
                                    <td  title="">{{$val['zb_size_weight']}}</td>
                                @endforeach
                                <td >{{$project['zb_size_weight']}}</td>

                            </tr>
                            <tr>
                                <td>预期使用寿命长短</td>
                                @foreach($data as $key=>$val)
                                    <td  title="">{{$val['zb_expected_weight']}}</td>
                                @endforeach
                                <td >{{$project['zb_expected_weight']}}</td>

                            </tr>
                            <tr>
                                <td>主要固定资产种类</td>
                                @foreach($data as $key=>$val)
                                    <td  title="">{{$val['zb_fixed_weight']}}</td>
                                @endforeach
                                <td >{{$project['zb_fixed_weight']}}</td>

                            </tr>
                            <tr>
                                <td>全寿命期成本测算准确性</td>
                                @foreach($data as $key=>$val)
                                    <td>{{$val['zb_measure_weight']}}</td>
                                @endforeach
                                <td >{{$project['zb_measure_weight']}}</td>

                            </tr>
                            <tr>
                                <td>运营收入增长潜力</td>
                                @foreach($data as $key=>$val)
                                    <td  title="">{{$val['zb_growth_weight']}}</td>
                                @endforeach
                                <td >{{$project['zb_growth_weight']}}</td>

                            </tr>
                            <tr>
                                <td>行业示范性</td>
                                @foreach($data as $key=>$val)
                                    <td  title="">{{$val['zb_demonstration_weight']}}</td>
                                @endforeach
                                <td >{{$project['zb_demonstration_weight']}}</td>

                            </tr>
                            <tr>
                                <td>补充指标小计</td>
                                @foreach($data as $key=>$val)
                                    <td>{{$val->zb_size_weight+$val->zb_expected_weight+$val->zb_fixed_weight+$val->zb_measure_weight+$val->zb_growth_weight+$val->zb_demonstration_weight}}</td>
                                @endforeach
                                <td >{{$project->zb_size_weight+$project->zb_expected_weight+$project->zb_fixed_weight+$project->zb_measure_weight+$project->zb_growth_weight+$project->zb_demonstration_weight}}</td>

                            </tr>
                            <tr>
                                <td colspan="2">合计</td>
                                @foreach($data as $key=>$val)
                                    <td>{{$val->zb_life_weight+$val->zb_risk_weight+$val->zb_encourage_weight+$val->zb_potential_weight+$val->zb_gov_weight+$val->zb_financing_weight+$val->zb_size_weight+$val->zb_expected_weight+$val->zb_fixed_weight+$val->zb_measure_weight+$val->zb_growth_weight+$val->zb_demonstration_weight}}%</td>
                                @endforeach
                                <td >{{$project->zb_life_weight+$project->zb_risk_weight+$project->zb_encourage_weight+$project->zb_potential_weight+$project->zb_gov_weight+$project->zb_financing_weight+$project->zb_size_weight+$project->zb_expected_weight+$project->zb_fixed_weight+$project->zb_measure_weight+$project->zb_growth_weight+$project->zb_demonstration_weight}}%</td>

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
