<div class="row">
    <div class="">
        <ul class="nav nav-tabs">
            <li  @if(stristr(Request::getRequestUri(),'/project/add1')) class="active" @endif><a @if(isset($data['id']) && $data['id']) href="/project/add1?project_id={{$data['id']}}" @else href="/project/add1" @endif>步骤1：项目财政信息</a></li>
            <li @if(stristr(Request::getRequestUri(),'/project/add2')) class="active" @endif><a @if(isset($data['id']) && $data['id'])) href="/project/add2?project_id={{$data['id']}}" @else href="javascript:;" @endif>步骤2：项目初步实施信息</a></li>
            <li @if(stristr(Request::getRequestUri(),'/project/add3')) class="active" @endif><a @if(isset($data['id']) && $data['id'])) href="/project/add3?project_id={{$data['id']}}" @else href="javascript:;" @endif>步骤3：项目财务信息</a></li>
            <li @if(stristr(Request::getRequestUri(),'/project/add4')) class="active" @endif><a @if(isset($data['id']) && $data['id'])) href="/project/add4?project_id={{$data['id']}}" @else href="javascript:;" @endif>步骤4：项目其他信息</a></li>
            <li @if(stristr(Request::getRequestUri(),'/project/add5')) class="active" @endif><a @if(isset($data['id']) && $data['id'])) href="/project/add5?project_id={{$data['id']}}" @else href="javascript:;" @endif>步骤5：上传初步实施方案</a></li>
        </ul>
    </div>
</div>