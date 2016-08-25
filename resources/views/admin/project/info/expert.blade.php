@extends('admin.project.info.layout')

@section('detail_content')

    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>项目参与专家</h5>
            <div class="ibox-tools">
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                会议时间:@if(isset($data['counseling_times']) && $data['counseling_times']){{ date("Y-m-d H:i:s",$data['counseling_times']) }}@endif
                <table class="table table-striped table-bordered table-hover dataTables-example ">
                    <thead>
                    <tr>
                        <th data-sort="id" width="8%">头像</th>
                        <th data-sort="page" width="12%">ID</th>
                        <th  data-sort="title">专家名</th>
                        <th data-sort="keywords">专家领域</th>
                        <th  data-sort="description">电话</th>
                        <th data-sort="created_at">职务</th>
                        <th data-sort="created_at">参与项目</th>
                        <th data-sort="created_at">政府方评分</th>
                        <th data-sort="created_at">平台评分</th>
                        <th data-sort="created_at">总评分</th>
                        <th width="22%">相关操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($expert as $val)
                        <tr>
                            <td><img width="50" height="50" src=" {{ $val->avater }}"/></td>
                            <td>{{ $val->id }}</td>
                            <td>{{ $val->name }}</td>
                            <td>{!! dict()->get("global","territory",$val->territory)  !!} </td>
                            <td>{{ $val->mobile }}</td>
                            <td>{{$val->position}}</td>
                            <td>
                                @if($val['projectInfo'])
                                    @foreach($val['projectInfo'] as $item1)
                                       <p>{{$item1->name}}</p>
                                    @endforeach
                                    @endif

                            </td>
                            <td>{{$val->user_gov_score}}</td>
                            <td>{{$val->gov_score}}</td>
                            <td>
                                @if($val->gov_score+$val->user_gov_score)
                                {{round(($val->gov_score+$val->user_gov_score)/2,2)}}
                                @endif
                            </td>
                            <td>
                                <a href="{{ U('Project/Info/delExpert',['id'=>$val->id])}}" onclick="return confirm('你确定执行删除操作？');">删除</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>专家用户列表</h5>
            <div class="ibox-tools">
                <a class="collapse-link"> <i class="fa fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-sm-4">
                    <form method="GET" action="" accept-charset="UTF-8">
                        <input type="hidden" name="project_id" value="{{request('project_id')}}"/>

                        <div class="input-group">
                            <input id="checkbox1"  name="is_meet_time" value="1" @if(request('is_meet_time')) checked @endif type="checkbox">
                            <label for="checkbox1">
                                只看空闲时间一致的
                            </label>
                            <input type="text" value="{{Request::get('keyword')}}"	placeholder="请输入关键词 （姓名,手机号，职务，毕业院校，个人简介,等）" name="keyword" class="input-sm form-control">
                            <span class="input-group-btn">
                                <button type="submit" class="btn btn-sm btn-primary">搜索</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
            <table class="table table-striped table-bordered table-hover dataTables-example dataTable">
                <thead>
                <tr>
                    <th class="sorting" data-sort="name">姓名</th>
                    <th class="sorting" data-sort="mobile">手机</th>
                    <th class="sorting" data-sort="gov_score">评分</th>
                    <th class="sorting" data-sort="territory">专业领域</th>
                    <th class="sorting" data-sort="position">职务</th>
                    <th class="sorting" data-sort="education">学历</th>
                    <th  data-sort="">空闲时间</th>
                    <th data-sort="">最后登录时间</th>
                    <th>相关操作</th>
                </tr>
                </thead>
                <tbody>
                @if(isset($searchExpert))
                    @foreach($searchExpert as $item)
                        <tr>
                            <td>{{ $item->name or '' }}</td>
                            <td>{{ $item->mobile or '' }}</td>
                            <td>{{ $item->gov_score or '' }}</td>
                            <td>{{ dict()->get('global','territory',$item->territory) }}</td>
                            <td>{{ $item->position or '' }}</td>
                            <td>{{ dict()->get("global","education",$item->education)}}</td>
                            <td>
                                {!! getMeetTime($item->meet_time) !!}
                            </td>
                            <td>{{date("Y-m-d H:i:s",$item->last_login_time) }}</td>
                            <td>
                                <form class="user_add_from" name="user_add_from" action="/Project/Info/addExpert" method="post">
                                    <input type="hidden" value="{{$data['id']}}" name="project_id"/>
                                    <input type="hidden" value="{{$item->user_id}}" name="user_id"/>
                                    <div class="input-group">
                                    <select id="territory_val" class="form-control input-sm" name="territory">
                                        <option value="">手动选择领域</option>
                                        {!! dict()->option('global','territory',request('type')) !!}
                                    </select>
                                    <button type="submit" class="btn btn-sm btn-primary search_add">添加到项目</button>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
            @if(isset($searchExpert))
                <div class="row">
                    <div class="col-sm-6">
                        <div class="dataTables_info" id="DataTables_Table_0_info"
                             role="alert" aria-live="polite" aria-relevant="all">每页{{ $searchExpert->count() }}条，共{{ $searchExpert->lastPage() }}页，总{{ $searchExpert->total() }}条。</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                            {!! $searchExpert->setPath('')->appends(Request::all())->render() !!}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script>
        $('.user_add_from').submit(function() {
            layer.load();
            $.ajax({
                type: "POST",
                url:$(this).attr('action') ,
                data:$(this).serialize(),
                dataType:"json",
                success:function(data){
                    if(data.status==200) {
                        layer.msg('添加成功');
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

    </script>
@endsection
