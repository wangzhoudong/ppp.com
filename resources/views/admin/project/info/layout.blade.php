@extends('admin.layout')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-2">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>项目基本信息</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div id="treeview" class="test treeview">
                        <ul class="list-group">

                            <li class="list-group-item">
                                <a class="font-bold" href="{{U('Project/Info/update',['project_id'=>request('project_id')])}}" class="menuItem">项目基本信息</a>
                            </li>
                            <li class="list-group-item">
                                <a class="font-bold" href="{{U('Project/Info/meeting',['project_id'=>request('project_id')])}}" class="menuItem">专家会</a>
                            </li>
                            <li class="list-group-item">
                                <a class="font-bold" href="{{U('Project/Info/expert',['project_id'=>request('project_id')])}}" class="menuItem">参与专家</a>
                            </li>
                            <li class="list-group-item">
                                <a class="font-bold" href="{{U('Project/Info/question',['project_id'=>request('project_id')])}}" class="menuItem">讨论区</a>
                            </li>

                            <li class="list-group-item">
                                <a class="font-bold" href="{{U('Project/Info/weight',['project_id'=>request('project_id')])}}" class="menuItem">物有所值指标和权重</a>
                            </li>
                            <li class="list-group-item">
                                <a class="font-bold" href="{{U('Project/Info/score',['project_id'=>request('project_id')])}}" class="menuItem">定性评分</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-10">

            @yield('detail_content')

        </div>
    </div>
</div>

@endsection

