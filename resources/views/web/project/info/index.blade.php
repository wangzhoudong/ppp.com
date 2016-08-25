@extends('web.layout')

@section('content')
        <!--上面head--><!-- Topic Header -->
@include("web.project.info.topic")
<div class="container" id="project">
    <div class="row">
        <div class="col-sm-3">
            @include("web.project.info.left_panel")
        </div>
        <div class="col-sm-9">
            <h4>项目财政信息</h4>
            <table class="table">
                <tbody>
                <tr><td>项目名</td><td>{{$project['name']}}</td></tr>
                <tr><td>所在地</td><td>{{$project['place']}}</td></tr>
                <tr><td>拟定实施机构</td><td>{{$project['builder_company']}}</td>
                </tr>
                <tr><td>实施本项目所采用的财政支付选择</td><td>{{dict()->get('project_info','financial_situation',$project['financial_situation'])}}</td></tr>
                <tr><td>会议时间</td><td>@if($project['counseling_times']){{date("Y-m-d H:i:s",$project['counseling_times'])}}@else 未设置 @endif</td></tr>
                </tbody>
            </table>
            <h4>近五年预算执行情况（单位：万元）<span>以人大通过的文件为准</span></h4>
            <table class="table">
                <thead>
                <tr>
                    <th><label class="control-label z-long"></label></th>
                    <th><label class="control-label">年份</label></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>一般公共预算收入</td>
                    <td>
                        <ul class="yearUL">
                            @foreach($beforeYear as $val)
                                @if(isset($project['recent_5_yearInfo'][$val]['expend'])) <li>{{$val}}:<span>{{ $project['recent_5_yearInfo'][$val]['expend']}}</span></li>@endif
                            @endforeach

                        </ul>
                    </td>
                </tr>
                <tr>
                    <td>一般公共预算支出</td>
                    <td>
                        <ul class="yearUL">
                            @foreach($beforeYear as $val)
                                @if(isset($project['recent_5_yearInfo'][$val]['income'])) <li>{{$val}}:<span>{{ $project['recent_5_yearInfo'][$val]['income']}}</span></li>@endif
                            @endforeach
                        </ul>
                    </td>
                </tr>
                </tbody>
            </table>
            <h4>已纳入财政预算的PPP项及相应年度政府支出（单位：万元）</h4>
            <table class="table">
                <thead>
                <tr>
                    <th><label class="control-label z-long">子项目名称</label></th>
                    <th><label class="control-label">年份</label></th>
                </tr>
                </thead>
                <tbody>

                @if(isset( $project['item_projectInfo']) &&  $project['item_projectInfo'])
                  @foreach( $project['item_projectInfo'] as $key=>$val)
                <tr>
                    <td>{{$val['name']}}</td>
                    <td>
                        <ul class="yearUL">
                            @foreach( $val['year'] as $k=>$val)
                                <li>{{$k}}:<span>{{$val}}</span></li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                  @endforeach
                @endif

                </tbody>
            </table>
            <h4>项目初步实施信息</h4>
            <table class="table">
                <tbody>
                <tr><td>项目属性</td><td>{{dict()->get('project_info','property',$project['property'])}} </td></tr>
                <tr><td>项目运作模式</td><td>{{dict()->get('project_info','operation_pattern',$project['operation_pattern'])}}</td>
                </tr>
                <tr><td>项目资产权属</td><td>{{dict()->get('project_info','asset_ownership',$project['asset_ownership'])}}</td>
                </tr>
                <tr><td>项目性质</td><td>{{dict()->get('project_info','project_nature',$project['asset_ownership'])}}</td>
                </tr>
                </tbody>
            </table>
            <h4>投融资比例（单位：%）</h4>
            <table class="table">
                <tbody>
                <tr><td>政府资本金-政府出资</td><td>{{$project['financing_proportion_zf'] or ""}}</td></tr>
                <tr><td>政府资本金-社会资本出资</td><td>{{$project['financing_proportion_sh'] or ""}}</td></tr>
                <tr><td>项目融资</td><td>{{$project['financing_proportion_xm'] or ""}}</td></tr>
                </tbody>
            </table>
            @if(isset($project['project_financialInfo']) && $project['project_financialInfo'])
            @foreach($project['project_financialInfo'] as $item)
            <h4>项目财务信息@if($project['project_nature']==1){{$item['subname']}}@endif</h4>
            <table class="table">
                <tbody>
                <tr>
                    <td>项目回报机制</td>
                    <td>@if($item['repay']){{dict()->get('project_info','reward_mechanism',$item['repay'])}}@endif</td>
                </tr>
                <tr>
                    <td>项目税前利润率预估（%）</td>
                    <td>{{$item['estimation'] or ""}}</td>
                </tr>
                <tr>
                    <td>项目合作期限-建设期（改建期）（年）</td>
                    <td>{{$item['cooperation_year_operation'] or ""}}</td>
                </tr>
                <tr>
                    <td>项目合作期限-运营期（年）</td>
                    <td>{{$item['cooperation_year_name'] or ""}}</td>
                </tr>
                <tr>
                    <td>项目年运营成本（当期值，单位：万元）</td>
                    <td>{{$item['annual_operating_cost'] or ""}}</td>
                </tr>
                <tr>
                    <td>项目年经营收入（当期值，单位：万元）</td>
                    <td>{{$item['annual_operating_income'] or ""}}</td>
                </tr>
                </tbody>
            </table>
            @endforeach
            @endif
            @if(isset( $project['supporting_planInfo']) && isset( $project['supporting_planInfo'][0]['count']) && $project['supporting_planInfo'][0]['count'])
                <h4>总投资之外，项目建设期政府提供的相关配套金额及投入计划（单位：万元）</h4>
                <table class="table">
                    <thead>
                    <tr>
                        <th><label class="control-label z-long">配套投入</label></th>
                        <th><label class="control-label">年份</label></th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(isset( $project['supporting_planInfo']) &&  $project['supporting_planInfo'])

                        @foreach( $project['supporting_planInfo'] as $key=>$val)
                            <tr>
                                <td>{{$val['count']}}</td>
                                <td>
                                    <ul class="yearUL">
                                        @foreach( $val['year'] as $k=>$val)
                                            <li>{{$k}}:<span>{{$val}}</span></li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            @endif
            <h4>项目其他信息</h4>
            <table class="table">
                <tbody>
                <tr><td>项目进展</td><td>{{$project['current_progress'] or ""}}</td>
                </tr>
                <tr><td>土地获取方式</td><td>{{dict()->get('project_info','land_acquisition',$project['land_acquisition'])}}</td>
                </tr>
                <tr><td>运营期适用的税种及税率，及可享受的税收优惠</td><td>{{$project['operating_taxes'] or ""}}</td>
                </tr>
                <tr><td>有意向社会资本</td><td>{{$project['social_capital'] or ""}}</td>
                </tr>
                <tr><td>接洽过的融资机构以及贷款利率</td><td>{{$project['financing_loans_desc'] or ""}}</td>
                </tr>
                <tr><td>初步实施方案</td><td>@if($project['pre_scheme_file'])
                            <a href="{{$project['pre_scheme_file']}}" target="_blank">下载</a>
                        @else
                            暂无上传
                        @endif</td>
                </tr>
                @if($project['other_info_file'])
                <tr><td>其他资料</td><td>
                        <?php
                        $files = [];
                        $files = json_decode($project['other_info_file'],true);
                        ?>
                        @foreach($files as $fileK=>$file)
                            <p><a target="_blank" href="{{$file['url']}}" class="img" >
                                    其他资料{{$fileK+1}}
                                </a>
                            </p>
                        @endforeach
                    </td>
                </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->

@endsection
