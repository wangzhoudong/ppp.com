<div class="panel-body">
    <ul>
        <li @if(stristr(Request::getRequestUri(),'/project/info/detail')) class="active" @endif><a href="/project/info/detail?project_id={{$project['id']}}">项目基本信息@if(isset($_user['notice_project_detail']) &&$_user['notice_project_detail']) <i class="redTip">&nbsp;</i> @endif </a></li>
        <li @if(stristr(Request::getRequestUri(),'/project/info/expert')) class="active" @endif><a href="/project/info/expert?project_id={{$project['id']}}">参与专家@if(isset($_user['notice_project_export']) &&$_user['notice_project_export']) <i class="redTip">&nbsp;</i> @endif</a></li>
        <li @if(stristr(Request::getRequestUri(),'/project/info/question')) class="active" @endif><a href="/project/info/question?project_id={{$project['id']}}">讨论区@if(isset($_user['notice_project_question']) &&$_user['notice_project_question']) <i class="redTip">&nbsp;</i> @endif</a></li>
        <li @if(stristr(Request::getRequestUri(),'/project/info/weight')) class="active" @endif><a href="/project/info/weight?project_id={{$project['id']}}">物有所值指标和权重@if(isset($_user['notice_project_weight']) &&$_user['notice_project_weight']) <i class="redTip">&nbsp;</i> @endif</a></li>
        <li @if(stristr(Request::getRequestUri(),'/project/info/score')) class="active" @endif><a href="/project/info/score?project_id={{$project['id']}}">定性评分@if(isset($_user['notice_project_score']) &&$_user['notice_project_score']) <i class="redTip">&nbsp;</i> @endif</a></li>
    </ul>
    @if($_user['type']==3)
    <div class="add"><a href="/project/add1?project_id={{$project['id']}}">修改项目</a></div>
    <div class="add"><a href="/project/add1">提交新项目</a></div>
    @endif
</div>