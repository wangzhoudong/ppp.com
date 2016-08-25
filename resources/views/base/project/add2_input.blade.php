<div class="form-group row">
    <label for="radio" class="col-sm-3 control-label">项目属性：</label>
    <div class="col-sm-6">
        @foreach(dict()->get('project_info','property') as $key=>$val)
            <div class="radio-inline"><label><input name="itemProperty"  @if(isset($data['property']) && $data['property']==$key)checked @endif  value="{{$key}}" type="radio">{{$val}}</label></div>
        @endforeach
    </div>
</div>
<div class="form-group row">
    <label for="radio" class="col-sm-3 control-label">项目运作模式：</label>
    <div class="col-sm-6">
        @foreach(dict()->get('project_info','operation_pattern') as $key=>$val)
            <div class="radio-inline"><label><input name="operation_pattern"  @if(isset($data['operation_pattern']) && $data['operation_pattern']==$key)checked @endif  value="{{$key}}" type="radio">{{$val}}</label></div>
        @endforeach
    </div>
</div>

<div class="form-group row">
    <label for="radio" class="col-sm-3 control-label">投融资比例：<br/>（单位：%）</label>
    <input type="text" class="ppp_hidden_input" id="financing_ratio" name="financing_ratio">
    <div class="col-sm-9 table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th><label class="control-label">政府资本金<br/>政府出资</label></th>
                <th><label class="control-label">政府资本金<br/>社会资本出资</label></th>
                <th><label class="control-label">项目融资</label></th>
                <th><label class="control-label">比例总和</label></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td><input type="text" class="PPP_tableInput yz-floor2 form-control" value="{{$data['financing_proportion_zf'] or ""}}" name="financing_proportion_zf" placeholder=""></td>
                <td><input type="text" class="PPP_tableInput yz-floor2 form-control" value="{{$data['financing_proportion_sh'] or ""}}"  name="financing_proportion_sh" placeholder=""></td>
                <td><input type="text" class="PPP_tableInput yz-floor2 form-control" value="{{$data['financing_proportion_xm'] or ""}}"  name="financing_proportion_xm"  placeholder="">
                <input type="hidden" class="PPP_tableInput yz-floor2 form-control" value="0"  name="financing_proportion_xm_count"  placeholder="">
                </td>
                <td><span class="PPP_countBox">{{$data['financing_proportion'] or ""}}</span></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="form-group row">
    <label for="radio" class="col-sm-3 control-label">项目资产归属：</label>
    <div class="col-sm-6">
        @foreach(dict()->get('project_info','asset_ownership') as $key=>$val)
            <div class="radio-inline"><label><input name="asset_ownership" value="{{$key}}" @if(isset($data['asset_ownership']) && $data['asset_ownership']==$key) checked @endif type="radio">{{$val}}</label></div>
        @endforeach
    </div>
</div>
<div class="form-group row">
    <label for="radio" class="col-sm-3 control-label">项目性质：</label>
    <div class="col-sm-6">
        @foreach(dict()->get('project_info','project_nature') as $key=>$val)
            <div class="radio-inline"><label><input name="project_nature" value="{{$key}}" @if(isset($data['project_nature']) && $data['project_nature']==$key) checked @endif type="radio">{{$val}}</label></div>
        @endforeach
    </div>
</div>