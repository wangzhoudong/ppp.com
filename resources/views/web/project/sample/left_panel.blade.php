<div class="panel-body">
    <ul>
        <li @if(stristr(Request::getRequestUri(),'/project/sample/detail')) class="active" @endif><a href="/project/sample/detail?project_id={{$project['id']}}">项目基本信息@if(isset($_user['notice_project_detail']) &&$_user['notice_project_detail']) <i class="redTip">&nbsp;</i> @endif </a></li>
        <li @if(stristr(Request::getRequestUri(),'/project/sample/expert')) class="active" @endif><a href="/project/sample/expert?project_id={{$project['id']}}">参与专家@if(isset($_user['notice_project_export']) &&$_user['notice_project_export']) <i class="redTip">&nbsp;</i> @endif</a></li>
        <li @if(stristr(Request::getRequestUri(),'/project/sample/question')) class="active" @endif><a href="/project/sample/question?project_id={{$project['id']}}">讨论区@if(isset($_user['notice_project_question']) &&$_user['notice_project_question']) <i class="redTip">&nbsp;</i> @endif</a></li>
        <li @if(stristr(Request::getRequestUri(),'/project/sample/weight')) class="active" @endif><a href="/project/sample/weight?project_id={{$project['id']}}">物有所值指标和权重@if(isset($_user['notice_project_weight']) &&$_user['notice_project_weight']) <i class="redTip">&nbsp;</i> @endif</a></li>
        <li @if(stristr(Request::getRequestUri(),'/project/sample/score')) class="active" @endif><a href="/project/sample/score?project_id={{$project['id']}}">定性评分@if(isset($_user['notice_project_score']) &&$_user['notice_project_score']) <i class="redTip">&nbsp;</i> @endif</a></li>
    </ul>
</div>