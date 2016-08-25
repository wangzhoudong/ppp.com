<div class="form-group row">
    <label for="" class="col-sm-3 control-label">项目名：</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="itemName" name="itemName" value="{{$data['name'] or ""}}" placeholder="请输入项目名">
    </div>
</div>
<div class="form-group row">
    <label class="control-label col-sm-3">所在地：</label>
    <div class="col-sm-2">
        <select class="form-control" id="cmbProvince" name="place_province_id"></select>
    </div>
    <div class="col-sm-2">
        <select class="form-control" id="cmbCity" name="place_city_id"></select>
    </div>
    <div class="col-sm-2">
        <select class="form-control" id="cmbArea" name=""></select>
    </div>
    <script type="text/javascript" src="/base/js/areadata.min.js"></script>
    <script type="text/javascript">
        var BASE_URL = '/base/webuploader';
        areadata({_cmbProvince:'cmbProvince',//省
            _cmbCity:'cmbCity',//市
            _cmbArea:'cmbArea',//县
            _infoname:'place_area_id',
            _default:"{{ $data['place_area_id'] or '' }}"//默认县
        });
    </script>
</div>
<div class="form-group row">
    <label for="" class="col-sm-3 control-label">项目实施机构：</label>
    <div class="col-sm-4">
        <input type="text" class="form-control" id="builder_company" name="builder_company" value="{{$data['builder_company'] or ""}}"  placeholder="请输入项目所在地">
    </div>
</div>
<div class="form-group row">
    <label for="radio" class="col-sm-3 control-label">实施本项目所采用的财政支付选择：</label>
    <div class="col-sm-6">
        @foreach(dict()->get('project_info','financial_situation') as $key=>$val)
            <div class="radio-inline"><label><input name="financial_situation" value="{{$key}}"  @if(isset($data['financial_situation']) && $data['financial_situation']==$key)checked @endif  type="radio">{{$val}}</label></div>
        @endforeach

    </div>
</div>
<div class="form-group row">
    <label for="radio" class="col-sm-3 control-label">近五年预算执行情况：<br/>（单位：万元）<br/><span class="help-block">以人大通过的文件为准</span></label>
    <input type="text" class="ppp_hidden_input" id="budget_performance" name="budget_performance">
    <div class="col-sm-9 table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th><label class="control-label z-long"></label></th>
                <th><label class="control-label">年份</label></th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th scope="row"><label class="control-label">一般公共预算收入</label></label></th>
                <td>
                    <ul class="yearUL">
                        @foreach($beforeYear as $val)
                            <li>{{$val}}<input type="text" class="PPP_tableInput yz-floor2 yz-noreq form-control valid" @if(isset($data['recent_5_yearInfo'][$val]['expend'])) value="{{ $data['recent_5_yearInfo'][$val]['expend']}}" @endif name="recent_5_year[expend][{{$val}}]" id="" placeholder=""></li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            <tr>
                <th scope="row"><label class="control-label">一般公共预算支出</label></th>
                <td>
                    <ul class="yearUL">
                        @foreach($beforeYear as $val)
                            <li>{{$val}}<input type="text" class="PPP_tableInput yz-floor2 yz-noreq form-control valid" @if(isset($data['recent_5_yearInfo'][$val]['income'])) value="{{ $data['recent_5_yearInfo'][$val]['income']}}" @endif name="recent_5_year[income][{{$val}}]" id="" placeholder=""></li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="form-group row">
    <label for="radio" class="col-sm-3 control-label">已纳入财政预算的PPP项及相应年度政府支出：<br/>（单位：万元）</span></label>
    <input type="text" class="ppp_hidden_input" id="approved_fund" name="approved_fund">
    <div class="col-sm-9 table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th><label class="control-label z-long">子项目名称</label></th>
                <th><label class="control-label">年份</label></th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @if(isset( $data['item_projectInfo']) &&  $data['item_projectInfo'])

                @foreach( $data['item_projectInfo'] as $key=>$val)
                    <tr>
                        <th>
                            <textarea type="text" class="form-control PPP_tableInput z-error" name="item_project[name][]" placeholder="">{{$val['name']}}</textarea></th>
                        <td>
                            <ul class="yearUL">
                                @foreach( $val['year'] as $k=>$val)
                                    <li>{{$k}}:<input type="text" class="PPP_tableInput yz-noreq yz-floor2 form-control" name="item_project[year][{{$k}}][]" value="{{$val}}" id="" placeholder=""></li>
                                @endforeach
                            </ul>
                            <a class="btn btn-xs PPP_yearUlToggle">显示更多</a>
                        </td>

                        <td></td>
                    </tr>
                @endforeach

            @else
                <tr>
                    <th>
                        <textarea type="text" class="form-control PPP_tableInput z-error" name="item_project[name][]" placeholder=""></textarea></th>
                    <td>
                        <ul class="yearUL">
                            @foreach($afterYear as $val)
                                <li>{{$val}}:<input type="text" class="PPP_tableInput yz-noreq yz-floor2 form-control" name="item_project[year][{{$val}}][]" id="" placeholder=""></li>
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
