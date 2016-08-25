@extends('web.layout')

@section('content')
        <!--上面head--><!-- Topic Header -->
@include("web.project.info.topic")
<div class="container" id="project_score_exp">
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
                    <form  action="/api/Project/Info/expertScore" id="validate_Mainform{{$val->id}}">
                        <div class="form-group row">
                            <input type="text" class="ppp_hidden_input" value="" id="worth_quota" name="worth_quota">
                            <div class="col-sm-12 table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>领域:{{dict()->get('global','territory',$val->territory)}}</th>
                                        <th>指标</th>
                                        <th>权重（%）</th>
                                        <th>评分</th>
                                        <th>评分理由</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="PPP_wq_basic" rowspan="7">基本指标</td>
                                        <td>全生命周期整合程度</td>
                                        <td>{{$val->zb_life_weight}}</td>
                                        <td><input type="text" name="zb_life_score" value="{{$val->zb_life_score}}"  class="PPP_tableInput yz-score form-control" placeholder=""></td>
                                        <td><textarea type="text" name="zb_life_reason" value="{{$val->zb_life_reason}}"  class="PPP_tableInput form-control" placeholder="">{{$val->zb_life_reason}}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>风险识别与分配</td>
                                        <td>{{$val->zb_risk_weight}}</td>
                                        <td><input type="text" name="zb_risk_score" value="{{$val->zb_risk_score}}"  class="PPP_tableInput yz-score form-control" placeholder=""></td>
                                        <td><textarea type="text" name="zb_risk_reason" value="{{$val->zb_risk_reason}}"  class="PPP_tableInput form-control" placeholder="">{{$val->zb_risk_reason}}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>绩效导向与鼓励创新</td>
                                        <td>{{$val->zb_encourage_weight}}</td>
                                        <td><input type="text" name="zb_encourage_score" value="{{$val->zb_encourage_score}}"  class="PPP_tableInput yz-score form-control" placeholder=""></td>
                                        <td><textarea type="text" name="zb_encourage_reason" value="{{$val->zb_encourage_reason}}"  class="PPP_tableInput form-control" placeholder="">{{$val->zb_encourage_reason}}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>潜在竞争程度</td>
                                        <td>{{$val->zb_potential_weight}}</td>
                                        <td><input type="text" name="zb_potential_score" value="{{$val->zb_potential_score}}"  class="PPP_tableInput yz-score form-control" placeholder=""></td>
                                        <td><textarea type="text" name="zb_potential_reason" value="{{$val->zb_potential_reason}}"  class="PPP_tableInput form-control" placeholder="">{{$val->zb_potential_reason}}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>政府机构能力</td>
                                        <td>{{$val->zb_gov_weight}}</td>
                                        <td><input type="text" name="zb_gov_score" value="{{$val->zb_gov_score}}"  class="PPP_tableInput yz-score form-control" placeholder=""></td>
                                        <td><textarea type="text" name="zb_gov_reason" value="{{$val->zb_gov_reason}}"  class="PPP_tableInput form-control" placeholder="">{{$val->zb_gov_reason}}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>融资可获得性</td>
                                        <td>{{$val->zb_financing_weight}}</td>
                                        <td><input type="text" name="zb_financing_score" value="{{$val->zb_financing_score}}"  class="PPP_tableInput yz-score form-control" placeholder=""></td>
                                        <td><textarea type="text" name="zb_financing_reason" value="{{$val->zb_financing_reason}}"  class="PPP_tableInput form-control" placeholder="">{{$val->zb_financing_reason}}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>基本指标小计</td>
                                        <td><span class="">{{$val->zb_life_weight+$val->zb_risk_weight+$val->zb_encourage_weight+$val->zb_potential_weight+$val->zb_gov_weight + $val->zb_financing_score}}</span></td>
                                        <td><span class=""></span></td>
                                        <td><span class=""></span></td>
                                    </tr>
                                    <tr>
                                        <td class="PPP_wq_extro" rowspan="7">补充指标</td>
                                        <td>项目规模大小</td>
                                        <td>{{$val->zb_size_weight}}</td>
                                        <td><input type="text" name="zb_size_score" value="{{$val->zb_size_score}}"  class="PPP_tableInput yz-score form-control" placeholder=""></td>
                                        <td><textarea type="text" name="zb_size_reason" value="{{$val->zb_size_reason}}"  class="PPP_tableInput form-control" placeholder="">{{$val->zb_size_reason}}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>预期使用寿命长短</td>
                                        <td>{{$val->zb_expected_weight}}</td>
                                        <td><input type="text" name="zb_expected_score" value="{{$val->zb_expected_score}}"  class="PPP_tableInput yz-score form-control" placeholder=""></td>
                                        <td><textarea type="text" name="zb_expected_reason" value="{{$val->zb_expected_reason}}"  class="PPP_tableInput form-control" placeholder="">{{$val->zb_expected_reason}}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>主要固定资产种类</td>
                                        <td>{{$val->zb_fixed_weight}}</td>
                                        <td><input type="text" name="zb_fixed_score" value="{{$val->zb_fixed_score}}"  class="PPP_tableInput yz-score form-control" placeholder=""></td>
                                        <td><textarea type="text" name="zb_fixed_reason" value="{{$val->zb_fixed_reason}}"  class="PPP_tableInput form-control" placeholder="">{{$val->zb_fixed_reason}}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>全寿命期成本测算准确性</td>
                                        <td>{{$val->zb_measure_weight}}</td>
                                        <td><input type="text" name="zb_measure_score" value="{{$val->zb_measure_score}}"  class="PPP_tableInput yz-score form-control" placeholder=""></td>
                                        <td><textarea type="text" name="zb_measure_reason" value="{{$val->zb_measure_reason}}"  class="PPP_tableInput form-control" placeholder="">{{$val->zb_measure_reason}}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>运营收入增长潜力</td>
                                        <td>{{$val->zb_growth_weight}}</td>
                                        <td><input type="text" name="zb_growth_score" value="{{$val->zb_growth_score}}"  class="PPP_tableInput yz-score form-control" placeholder=""></td>
                                        <td><textarea type="text" name="zb_growth_reason" value="{{$val->zb_growth_reason}}"  class="PPP_tableInput form-control" placeholder="">{{$val->zb_growth_reason}}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>行业示范性</td>
                                        <td>{{$val->zb_demonstration_weight}}</td>
                                        <td><input type="text" name="zb_demonstration_score" value="{{$val->zb_demonstration_score}}" class="PPP_tableInput yz-score form-control" placeholder=""></td>
                                        <td><textarea type="text" name="zb_demonstration_reason" value="{{$val->zb_demonstration_weight}}" class="PPP_tableInput form-control" placeholder="">{{$val->zb_demonstration_weight}}</textarea></td>
                                    </tr>
                                    <tr>
                                        <td>补充指标小计</td>
                                        <td><span class="">{{$val->zb_size_weight+$val->zb_expected_weight+$val->zb_fixed_weight+$val->zb_measure_weight+$val->zb_growth_weight+$val->zb_demonstration_weight}}</span></td>
                                        <td><span class=""></span></td>
                                        <td><span class=""></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">合计</td>
                                        <td>
                                            <span class="">{{$val->zb_life_weight+$val->zb_risk_weight+$val->zb_encourage_weight+$val->zb_potential_weight+$val->zb_gov_weight+$val->zb_financing_weight+$val->zb_size_weight+$val->zb_expected_weight+$val->zb_fixed_weight+$val->zb_measure_weight+$val->zb_growth_weight+$val->zb_demonstration_weight}}</span>
                                        <td><span class=""></span></td>
                                        <td><span class=""></span></td>
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
                                <input type="button" class="btn-animate btn-style btn-d btn-primary exp_weight_submit" value="提交领域：{{dict()->get('global','territory',$val->territory)}}的评分"/>
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
