<div class="form-group row">
    <label class="col-sm-3 control-label">项目目前进展：</label>
    <div class="col-sm-6"><textarea name="current_progress" id="current_progress" class="form-control">{{$data['current_progress'] or ""}} </textarea></div>
</div>

<div class="form-group row">
    <label for="radio" class="col-sm-3 control-label">  总投资之外，项目建设期政府提供的相关配套金额及投入计划(没有请不填写）：</label>
    <input type="text" class="ppp_hidden_input" id="construction_investment_plan" name="construction_investment_plan">
    <div class="col-sm-9 table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th><label class="control-label z-long">配套投入</label></th>
                <th><label class="control-label">年份</label></th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @if(isset( $data['supporting_planInfo']) &&  $data['supporting_planInfo'])

                @foreach( $data['supporting_planInfo'] as $key=>$val)
                    <tr>
                        <th>
                            <textarea type="text" class="form-control yz-noreq PPP_tableInput" name="supporting_plan[count][]" placeholder="">{{$val['count']}}</textarea></th>
                        <td>
                            <ul class="yearUL">
                                @foreach( $val['year'] as $k=>$val)
                                    <li>{{$k}}:<input type="text" class="PPP_tableInput yz-noreq yz-floor2 form-control" name="supporting_plan[year][{{$k}}][]" value="{{$val}}" id="" placeholder=""></li>
                                @endforeach
                            </ul>
                            <a class="btn btn-xs PPP_yearUlToggle">显示更多</a>
                        </td>

                        <td> @if($key>0)
                                <div class="PPP_tableDel btn btn-xs btn-red">删除</div>
                            @endif</td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <th>
                        <textarea type="text" class="form-control PPP_tableInput z-error" name="supporting_plan[count][]" placeholder=""></textarea></th>
                    <td>
                        <ul class="yearUL">
                            @foreach($afterYear as $val)
                                <li>{{$val}}:<input type="text" class="PPP_tableInput yz-noreq yz-floor2 form-control" name="supporting_plan[year][{{$val}}][]" id="" placeholder=""></li>
                            @endforeach
                        </ul>

                        <a class="btn btn-xs PPP_yearUlToggle">显示更多</a>

                    </td>
                    <td></td>
                </tr>
            @endif


            <tr>
                <th scope="row"><div class="PPP_tableAdd btn btn-xs btn-blue">+新增子项目</div></th>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="form-group row">
    <label for="radio" class="col-sm-3 control-label">土地获取方式：</label>
    <div class="col-sm-9">
        @foreach(dict()->get('project_info','land_acquisition') as $key=>$val)
            <div class="radio-inline"><label><input name="land_acquisition" @if(isset($data['land_acquisition']) && $data['land_acquisition']==$key)checked @endif value="{{$key}}" type="radio">{{$val}}</label></div>
        @endforeach
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-3 control-label">运营期适用的税种及税率，若有可享受的税收优惠，请一并说明：</label>
    <div class="col-sm-6">
        <textarea type="text" class="form-control" id="operating_taxes" name="operating_taxes" placeholder=""> {{$data['operating_taxes'] or ""}}</textarea>
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-3 control-label">有意向社会资本：</label>
    <div class="col-sm-6">
        <textarea type="text" class="form-control" id="social_capital" name="social_capital" placeholder="">{{$data['social_capital'] or ""}}</textarea>
    </div>
</div>

<div class="form-group row">
    <label for="" class="col-sm-3 control-label">洽过的融资机构以及贷款利率：</label>
    <div class="col-sm-6">
        <textarea type="text" class="form-control" id="" name="financing_loans_desc" placeholder="">{{$data['financing_loans_desc'] or ""}}</textarea>
    </div>
</div>