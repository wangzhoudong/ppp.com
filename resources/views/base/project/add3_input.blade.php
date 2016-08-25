@foreach($data['project_financialInfo'] as $item)
    <div class="PPP_subItemBox">
        <div class="form-group row">
            <label for="" class="col-sm-3 control-label">项目名称：</label>
            <div class="col-sm-4">
                @if($data['project_nature']==1)
                    <input type="text" class="form-control" required="true" name="project_financial[subname][]" value="{{$item['subname']}}" placeholder="请填写项目名称"/>
                @else
                    {{$data['name']}}
                    <input type="hidden" value="{{$data['name']}}" class="form-control" required="true" name="project_financial[subname][]" placeholder="请填写项目名称"/>
                @endif
            </div>
        </div>
        <div class="form-group row">
            <label for="radio" class="col-sm-3 control-label">项目回报机制：</label>
            <div class="col-sm-9">
                @foreach(dict()->get('project_info','reward_mechanism') as $key=>$val)
                    <div class="radio-inline"><label><input name="project_financial[repay][]"  @if(isset($item['repay']) && $item['repay']==$key)checked @endif  value="{{$key}}" type="radio">{{$val}}</label></div>
                @endforeach
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 control-label">项目税前利润率预估（%）：</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" required="true" floor2="true"  value="{{$item['estimation'] or ""}}"   name="project_financial[estimation][]" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 control-label">项目年运营成本（当期值，单位：万元）：</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" required="true" floor2="true"  value="{{$item['annual_operating_cost'] or ""}}"   name="project_financial[annual_operating_cost][]" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 control-label">项目年经营收入（当期值，单位：万元）：</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" required="true" floor2="true"  value="{{$item['annual_operating_income'] or ""}}"  name="project_financial[annual_operating_income][]" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 control-label">合作年限-建设期（改建期）：</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" required="true" int="true"  value="{{$item['cooperation_year_operation'] or ""}}"  name="project_financial[cooperation_year_operation][]" placeholder="">
            </div>
        </div>
        <div class="form-group row">
            <label for="" class="col-sm-3 control-label">合作年限-运营期：</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" required="true" int="true"  value="{{$item['cooperation_year_name'] or ""}}"  name="project_financial[cooperation_year_name][]" placeholder="">
            </div>
        </div>
    </div>
@endforeach
@if($data['project_nature']==1)
    <div class="form-group row">
        <label for="radio" class="col-sm-3 control-label"></label>
        <div class="col-sm-9">
            <div class="PPP_tableAdd2 btn btn-xs btn-blue">+新增子项目</div>
        </div>
    </div>
@endif