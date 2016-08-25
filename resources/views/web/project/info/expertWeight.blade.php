@extends('web.layout')

@section('content')
        <!--上面head--><!-- Topic Header -->
@include("web.project.info.topic")
<div class="container" id="project_quota_exp">
    <div class="row">
        <div class="col-sm-3">
            @include("web.project.info.left_panel")
         </div>
        <div class="col-sm-9">
            <div class="row">
                <div class="">
                    <ul class="nav nav-tabs">
                        @foreach($data as $key=>$val)
                        <li @if($key==0)class="active"@endif><a data-toggle="tab" href="#tab-{{$key+1}}" @if($key==0)aria-expanded="true" @else aria-expanded="false"@endif>领域:{{dict()->get('global','territory',$val->territory)}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="tab-content">
                    @foreach($data as $key=>$val)
                    <div id="tab-{{$key+1}}" class="tab-pane @if($key==0) active @endif">
                    <form class="validate"  action="/api/Project/Info/expertWeight" id="validate_Mainform_{{$val->id}}" role="form">
                        <div class="form-group row">
                            <input type="text" class="ppp_hidden_input" value="" id="worth_quota" name="worth_quota">
                            <div class="col-sm-12 table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>领域:{{dict()->get('global','territory',$val->territory)}}</th>
                                        <th>指标</th>
                                        <th>建议权重（%）</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="PPP_wq_basic" rowspan="7">基本指标</td>
                                        <td>全生命周期整合程度</td>
                                        <td> {{$project->zb_life_weight}}<input type="hidden" name="zb_life_weight" value="{{$project->zb_life_weight}}"  class="PPP_tableInput yz-floor2 form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>风险识别与分配</td>
                                        <td> {{$project->zb_risk_weight}}<input type="hidden" name="zb_risk_weight" value="{{$project->zb_risk_weight}}"  class="PPP_tableInput yz-floor2 form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>绩效导向与鼓励创新</td>
                                        <td> {{$project->zb_encourage_weight}}<input type="hidden" name="zb_encourage_weight" value="{{$project->zb_encourage_weight}}"  class="PPP_tableInput yz-floor2 form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>潜在竞争程度</td>
                                        <td> {{$project->zb_potential_weight}}<input type="hidden" name="zb_potential_weight" value="{{$project->zb_potential_weight}}"  class="PPP_tableInput yz-floor2 form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>政府机构能力</td>
                                        <td> {{$project->zb_gov_weight}}<input type="hidden" name="zb_gov_weight" value="{{$project->zb_gov_weight}}"  class="PPP_tableInput yz-floor2 form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>融资可获得性</td>
                                        <td> {{$project->zb_financing_weight}}<input type="hidden" name="zb_financing_weight" value="{{$project->zb_financing_weight}}"  class="PPP_tableInput yz-floor2 form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>基本指标小计</td>
                                        <td><span class="PPP_countBox">{{$project->zb_life_weight+$project->zb_risk_weight+$project->zb_encourage_weight+$project->zb_potential_weight+$project->zb_gov_weight +$project->zb_financing_weight}}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="PPP_wq_extro" rowspan="7">补充指标</td>
                                        <td>项目规模大小</td>
                                        <td><input type="text" name="zb_size_weight" value="{{$val->zb_size_weight}}"  class="PPP_tableInput yz-floor2 form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>预期使用寿命长短</td>
                                        <td><input type="text" name="zb_expected_weight" value="{{$val->zb_expected_weight}}"  class="PPP_tableInput yz-floor2 form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>主要固定资产种类</td>
                                        <td><input type="text" name="zb_fixed_weight" value="{{$val->zb_fixed_weight}}"  class="PPP_tableInput yz-floor2 form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>全寿命期成本测算准确性</td>
                                        <td><input type="text" name="zb_measure_weight" value="{{$val->zb_measure_weight}}"  class="PPP_tableInput yz-floor2 form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>运营收入增长潜力</td>
                                        <td><input type="text" name="zb_growth_weight" value="{{$val->zb_growth_weight}}"  class="PPP_tableInput yz-floor2 form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>行业示范性</td>
                                        <td><input type="text" name="zb_demonstration_weight" value="{{$val->zb_demonstration_weight}}" class="PPP_tableInput yz-floor2 form-control" placeholder=""></td>
                                    </tr>
                                    <tr>
                                        <td>补充指标小计</td>
                                        <td><span class="PPP_countBox">{{$val->zb_size_weight+$val->zb_expected_weight+$val->zb_fixed_weight+$val->zb_measure_weight+$val->zb_growth_weight+$val->zb_demonstration_weight}}</span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">合计</td>
                                        <td>
                                            <span class="PPP_countBox">{{$val->zb_life_weight+$val->zb_risk_weight+$val->zb_encourage_weight+$val->zb_potential_weight+$val->zb_gov_weight+$val->zb_financing_weight+$val->zb_size_weight+$val->zb_expected_weight+$val->zb_fixed_weight+$val->zb_measure_weight+$val->zb_growth_weight+$val->zb_demonstration_weight}}</span>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-sm-3 control-label"></label>
                            <div class="col-sm-4">
                                <input type="hidden" name="project_expert_id" value="{{$val->id}}" />
                                <input type="button" class="btn-animate btn-style btn-d btn-primary exp_weight_submit" value="提交领域：{{dict()->get('global','territory',$val->territory)}}的指标权重"/>
                            </div>
                        </div>
                     </form>
                        <script type="text/javascript">



                        </script>
                </div>
                    @endforeach
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
