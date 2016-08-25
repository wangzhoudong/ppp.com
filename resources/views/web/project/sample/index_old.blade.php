@extends('web.layout')

@section('content')
        <!--上面head--><!-- Topic Header -->
@include("web.project.sample.topic")
<div class="container" id="project">
    <div class="row">
        <div class="col-sm-3">
            @include("web.project.sample.left_panel")
        </div>
        <div class="col-sm-9">
            <table class="table">
                <tbody>
                <tr><td>项目名</td><td>{{$project['name']}}</td></tr>
                <tr><td>所在地</td><td>{{$project['place']}}</td></tr>
                <tr><td>财政情况</td><td>{{dict()->get('project_info','financial_situation',$project['financial_situation'])}}</td></tr>
                </tbody>
            </table>
            <h4>近五年预算执行情况（单位：万元）<span>以人大通过的文件为准</span></h4>
            <table class="table">
                <thead>
                <tr>
                    <th><label class="control-label z-long"></label></th>
                    @foreach($beforeYear as $val)
                        <th><label class="control-label">{{$val}}</label></th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>一般公共预算收入</td>
                    @foreach($beforeYear as $val)
                      <td> @if(isset($project['recent_5_yearInfo'][$val]['expend'])) {{ $project['recent_5_yearInfo'][$val]['expend']}} @endif </td>
                    @endforeach
                </tr>
                <tr>
                    <td>一般公共预算支出</td>
                    @foreach($beforeYear as $val)
                        <td> @if(isset($project['recent_5_yearInfo'][$val]['expend'])) {{ $project['recent_5_yearInfo'][$val]['income']}} @endif </td>
                    @endforeach
                </tr>
                <tr>
                    <td>财政盈亏</td>
                    @foreach($beforeYear as $val)
                        <td>@if(isset($project['recent_5_yearInfo'][$val]['count'])){{ $project['recent_5_yearInfo'][$val]['count']}} @endif </td>
                    @endforeach
                </tr>
                </tbody>
            </table>
            <h4>已批复的PPP项目以及占用资金（单位：万元）</h4>
            <table class="table">
                <thead>
                <tr>
                    <th><label class="control-label z-long">子项目名称</label></th>
                    @foreach( $project['item_projectInfo'][0]['year'] as $key=>$val)
                        <th><label class="control-label">{{$key}}</label></th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach( $project['item_projectInfo'] as $key=>$val)

                    <tr>
                        <td>{{$val['name']}}</td>
                        @foreach( $val['year'] as $key=>$val)
                        <td>{{$val}}</td>
                        @endforeach
                    </tr>
                @endforeach

                </tbody>
            </table>
            <table class="table">
                <tbody>
                <tr><td>项目属性</td><td>{!!  dict()->get('project_info','property',$project['property'])!!}</td></tr>
                <tr><td>项目总投资</td><td>{!!  $project['total_investment'] !!} 万元</td></tr>
                <tr><td>项目年运营成本</td><td>{!!  $project['annual_operating_cost'] !!} 万元</td></tr>
                <tr><td>项目年经营性收入</td><td>{!!  $project['annual_operating_cost'] !!}万元</td></tr>
                <tr><td>项目运作模式</td><td>{{$project['operation_pattern'] or ""}}</td>
                </tr>
                <tr><td>拟定实施机构</td><td>{{$project['builder_company'] or ""}}</td>
                </tr>
                </tbody>
            </table>
            <h4>合作年限（单位：年）</h4>
            <table class="table">
                <thead>
                <tr>
                    <th><label class="control-label z-long">子项目名称</label></th>
                    <th><label class="control-label">建设期年限</label></th>
                    <th><label class="control-label">运营期年期</label></th>
                </tr>
                </thead>
                <tbody>
                @if(isset( $project['cooperation_yearInfo']) &&  $project['cooperation_yearInfo'])
                    @foreach($project['cooperation_yearInfo'] as $val)
                    <tr>
                        <td>"{{$val['name']}}</td>
                        <td>{{$val['construction']}}</td>
                        <td>{{$val['operation']}}</td>
                    </tr>
                    @endforeach
                @endif

                </tbody>
            </table>
            <table class="table">
                <tbody>
                </tr>
                <tr><td>项目资产归属</td><td>{{dict()->get('project_info',$project['asset_ownership'],$project['asset_ownership'])}}</td>
                </tr>
                <tr><td>项目目前进展</td><td>{{$project['current_progress']}}</td>
                </tr>
                </tbody>
            </table>
            <h4>投融资比例（单位：%）</h4>
            <table class="table">
                <tbody>
                <tr><td>政府资本金-政府出资</td><td>{{$project['financing_proportion_zf']}}%</td></tr>
                <tr><td>政府资本金-社会资本出资</td><td>{{$project['financing_proportion_sh']}}%</td></tr>
                <tr><td>项目融资</td><td>23</td>{{$project['financing_proportion_xm']}}%</tr>
                </tbody>
            </table>
            <table class="table">
                <tbody>
                <tr><td>项目回报机制</td><td>{{dict()->get('project_info','reward_mechanism',$project['reward_mechanism'])}}</td>
                </tr>
                <tr><td>利润率预估</td><td>{{$project['profit_estimation']}}%</td>
                </tr>
                </tbody>
            </table>
            @if(isset( $project['supporting_planInfo']) &&  $project['supporting_planInfo'])
            <h4>总投资之外，项目建设期政府提供的相关配套金额及投入计划（单位：万元）</h4>
            <table class="table">
                <thead>
                <tr>
                    <th><label class="control-label z-long">配套投入</label></th>
                    @foreach( $project['supporting_planInfo'][0]['year'] as $key=>$val)
                        <th><label class="control-label">{{$key}}</label></th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach( $project['supporting_planInfo'] as $key=>$val)
                    <tr>
                        <td>{{$val['count']}}</td>
                        @foreach( $val['year'] as $key=>$val)
                            <td>{{$val}}</td>
                        @endforeach
                    </tr>
                @endforeach

                </tbody>
            </table>
            @endif
            <table class="table">
                <tbody>
                <tr><td>土地获取方式</td><td>{{dict()->get('project_info','land_acquisition',$project['land_acquisition'])}}</td>
                </tr>
                <tr><td>项目运营期适用的税种及税率</td><td>{{$project['operating_taxes']}}</td>
                </tr>
                <tr><td>可享受的税收优惠及时效</td><td>{{$project['tax_preference']}}</td>
                </tr>
                <tr><td>有意向社会资本</td><td>{{$project['social_capital']}}</td>
                </tr>
                <tr><td>洽过的融资机构以及贷款利率</td><td>{{$project['financing_loans_desc']}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->

@endsection
