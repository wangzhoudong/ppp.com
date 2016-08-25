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
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>物有所值指标和权重</h5>
            <div class="ibox-tools">
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <form class="validate" action="" id="validate_Mainform_6" role="form">
        <div class="ibox-content form-group">
            <table class="table ppp_worth">
                <thead>
                <tr>
                    <th></th>
                    <th>指标（单位%）</th>
                    @foreach($userExpert as $key=>$val)
                        <th><a href="$val">{{$val->name}}：<br/>{{dict()->get('global','territory',$val->territory)}}</a> </th>
                    @endforeach
                    <th width="200">最终指标</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="PPP_wq_basic" rowspan="7">基本指标</td>
                    <td>全生命周期整合程度</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val['zb_life_weight']}}%</td>
                    @endforeach
                    <td><input type="text" class="form-control PPP_tableInput jb_input" id="zb_life_weight" name="data[zb_life_weight]" value="{{$data['zb_life_weight']}}"/> </td>
                </tr>
                <tr>
                    <td>风险识别与分配</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val['zb_risk_weight']}}%</td>
                    @endforeach
                    <td><input type="text" class="form-control PPP_tableInput jb_input" id="zb_risk_weight"  name="data[zb_risk_weight]" value="{{$data['zb_risk_weight']}}"/> </td>

                </tr>
                <tr>
                    <td>绩效导向与鼓励创新</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val['zb_encourage_weight']}}%</td>
                    @endforeach
                    <td><input type="text" class="form-control PPP_tableInput jb_input" id="zb_encourage_weight" name="data[zb_encourage_weight]" value="{{$data['zb_encourage_weight']}}"/> </td>

                </tr>
                <tr>
                    <td>潜在竞争程度</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val['zb_potential_weight']}}%</td>
                    @endforeach
                    <td><input type="text" class="form-control PPP_tableInput jb_input" id="zb_potential_weight" name="data[zb_potential_weight]" value="{{$data['zb_potential_weight']}}"/> </td>

                </tr>
                <tr>
                    <td>政府机构能力</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val['zb_gov_weight']}}%</td>
                    @endforeach
                    <td><input type="text" class="form-control PPP_tableInput jb_input"  id="zb_gov_weight" name="data[zb_gov_weight]" value="{{$data['zb_gov_weight']}}"/> </td>

                </tr>
                <tr>
                    <td>融资可获得性</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val['zb_financing_weight']}}%</td>
                    @endforeach
                    <td><input type="text" class="form-control PPP_tableInput jb_input" id="zb_financing_weight"  name="data[zb_financing_weight]" value="{{$data['zb_financing_weight']}}"/> </td>

                </tr>
                <tr>
                    <td>基本指标小计</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val->zb_life_weight+$val->zb_risk_weight+$val->zb_encourage_weight+$val->zb_potential_weight+$val->zb_gov_weight+$val->zb_financing_weight}}</td>
                    @endforeach
                    <td > <span class="ji_PPP_countBox">{{$data->zb_life_weight+$data->zb_risk_weight+$data->zb_encourage_weight+$data->zb_potential_weight+$data->zb_gov_weight+$data->zb_financing_weight}}</span></td>

                </tr>
                <tr>
                    <td class="PPP_wq_extro" rowspan="7">补充指标</td>
                    <td>项目规模大小</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val['zb_size_weight']}}</td>
                    @endforeach
                    <td><input type="text" class="form-control PPP_tableInput bu_input" name="data[zb_size_weight]" value="{{$data['zb_size_weight']}}"/> </td>

                </tr>
                <tr>
                    <td>预期使用寿命长短</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val['zb_expected_weight']}}</td>
                    @endforeach
                    <td><input type="text" class="form-control PPP_tableInput bu_input" name="data[zb_expected_weight]" value="{{$data['zb_expected_weight']}}"/> </td>

                </tr>
                <tr>
                    <td>主要固定资产种类</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val['zb_fixed_weight']}}</td>
                    @endforeach
                    <td><input type="text" class="form-control PPP_tableInput bu_input" name="data[zb_fixed_weight]" value="{{$data['zb_fixed_weight']}}"/> </td>

                </tr>
                <tr>
                    <td>全寿命期成本测算准确性</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val['zb_measure_weight']}}</td>
                    @endforeach
                    <td><input type="text" class="form-control PPP_tableInput bu_input" name="data[zb_measure_weight]" value="{{$data['zb_measure_weight']}}"/> </td>

                </tr>
                <tr>
                    <td>运营收入增长潜力</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val['zb_growth_weight']}}</td>
                    @endforeach
                    <td><input type="text" class="form-control PPP_tableInput bu_input" name="data[zb_growth_weight]" value="{{$data['zb_growth_weight']}}"/> </td>

                </tr>
                <tr>
                    <td>行业示范性</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val['zb_demonstration_weight']}}</td>
                    @endforeach
                    <td><input type="text" class="form-control PPP_tableInput bu_input" name="data[zb_demonstration_weight]" value="{{$data['zb_demonstration_weight']}}"/> </td>

                </tr>
                <tr>
                    <td>补充指标小计</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val->zb_size_weight+$val->zb_expected_weight+$val->zb_fixed_weight+$val->zb_measure_weight+$val->zb_growth_weight+$data->zb_demonstration_weight}}</td>
                    @endforeach
                    <td><span class="bu_PPP_countBox">{{$data->zb_financing_weight+$data->zb_size_weight+$data->zb_expected_weight+$data->zb_fixed_weight+$data->zb_measure_weight+$data->zb_growth_weight+$data->zb_demonstration_weight}}</span> </td>

                </tr>
                <tr>
                    <td colspan="2">合计</td>
                    @foreach($userExpert as $key=>$val)
                        <td>{{$val->zb_life_weight+$val->zb_risk_weight+$val->zb_encourage_weight+$val->zb_potential_weight+$val->zb_gov_weight+$val->zb_financing_weight+$val->zb_size_weight+$val->zb_expected_weight+$val->zb_fixed_weight+$val->zb_measure_weight+$val->zb_growth_weight}}%</td>
                    @endforeach
                    <td id="weight_count">
                        <span class="PPP_countBox">{{$data->zb_life_weight+$data->zb_risk_weight+$data->zb_encourage_weight+$data->zb_potential_weight+$data->zb_gov_weight+$data->zb_financing_weight+$data->zb_size_weight+$data->zb_expected_weight+$data->zb_fixed_weight+$data->zb_measure_weight+$data->zb_growth_weight+$data->zb_demonstration_weight}}</span>%
                    </td>

                </tr>
                </tbody>
            </table>
        </div>
            <div class="row">
                <div class="form-group">
                    <label class="control-label col-sm-3">&nbsp;</label>
                    <div class="col-sm-9">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                        <input type="submit" class="btn btn-success" style="margin-right:20px;">
                    </div>
                </div>
            </div>
            </form>
    </div>
    <script type="text/javascript">
        $('#validate_Mainform_6').submit(function() {
            layer.load();
            $.ajax({
                type: "POST",
                url:$(this).attr('action') ,
                data:$(this).serialize(),
                dataType:"json",
                success:function(data){
                    if(data.status==200) {
                        layer.msg('操作成功');
                        location.reload();
                    }else{
                        if(typeof(data.msg) == "object") {
                            layer.msg(data.msg[0]);
                        }else{
                            layer.msg(data.msg);
                        }

                    }
                    layer.closeAll('loading');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    layer.msg('网络异常，请稍后刷新后再试');
                    layer.closeAll('loading');
                },
            });
            return false;
        })

        $(function(){
            //2个浮点数加
            function accAdd(arg1,arg2){
                var r1,r2,m;
                try{r1=arg1.toStri.sng().split(".")[1].length}catch(e){r1=0}
                try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}
                m=Math.pow(10,Math.max(r1,r2))
                return (arg1*m+arg2*m)/m
            }
            $(".form-group").on("blur",".PPP_tableInput",function(){
                var jbCount = 0;
                $(".jb_input").each(function() {
                    jbCount = accAdd(jbCount,$(this).val());
                });
                $(".ji_PPP_countBox").html(jbCount);

                var buCount = 0;
                $(".bu_input").each(function() {
                    buCount = accAdd(buCount,$(this).val());
                });

                $(".bu_PPP_countBox").html(buCount);

                $(".PPP_countBox").html(accAdd(jbCount,buCount));
            })

        });
        $("")
    </script>

@endsection
