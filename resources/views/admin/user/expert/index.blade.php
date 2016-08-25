@extends('admin.layout')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
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
        						<div class="input-group">
                                    <input type="text" value="{{Request::get('keyword')}}"	placeholder="请输入关键词 （用户名，职务，毕业院校，个人简介,等）" name="keyword" class="input-sm form-control">
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
								<th class="sorting" data-sort="mobile">登录用户名</th>
								<th class="sorting" data-sort="territory">专业领域</th>
								<th class="sorting" data-sort="position">职务</th>
								<th class="sorting" data-sort="education">学历</th>
								<th>访问加密视频</th>
								<th class="sorting" data-sort="hot">热度</th>
								<th class="sorting" data-sort="linkman_email">状态</th>
								<th class="sorting" data-sort="linkman_email">最后登录时间</th>
								<th>相关操作</th>
							</tr>
						</thead>
						<tbody>
						@if(isset($list))
							@foreach($list as $item)
							<tr>
								<td>{{ $item->mobile or '' }}</td>
								<td>{{ dict()->get('global','territory',$item->territory) }}</td>
								<td>{{ $item->position or '' }}</td>
								<td>{{ dict()->get("global","education",$item->education)}}</td>
								<td>
									@if($item->visit_video ===1)
										<strong class="text-success">允许</strong>
									@else
										<strong class="text-warning">禁止</strong>
									@endif

								</td>
								<td>{{ $item->hot or '' }}</td>
								<td>
									@if($item->status ===1)
										<strong class="text-success">正常</strong>
									@else
										<strong class="text-warning">待审核</strong>
									@endif

								</td>
								<td>{{date("Y-m-d H:i:s",$item->last_login_time) }}</td>
								<td>
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle" aria-expanded="false">
											操作 <span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
											@if(role('User/Expert/update'))
											<li><a href="{{ U('User/Expert/update')}}?id={{ $item->id }}" class="font-bold">修改</a></li>
											@endif
											@if(role('Foundation/User/status'))
												@if($item->status == 0)
													<li><a href="{{ U('Foundation/User/status', ['id' =>$item->id,'status'=>1])}}">通过审核</a></li>
												@elseif($item->status ==1)
													<li><a href="{{ U('Foundation/User/status', ['id' =>$item->id,'status'=>0])}}">置为待审核</a></li>
												@endif
											@endif
										</ul>
									</div>
								</td>
							</tr>
							@endforeach
					    @endif
						</tbody>
					</table>
					@if(isset($list))
					<div class="row">
						<div class="col-sm-6">
							<div class="dataTables_info" id="DataTables_Table_0_info"
								role="alert" aria-live="polite" aria-relevant="all">每页{{ $list->count() }}条，共{{ $list->lastPage() }}页，总{{ $list->total() }}条。</div>
						</div>
						<div class="col-sm-6">
						<div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
						{!! $list->setPath('')->appends(Request::all())->render() !!}
						</div>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
