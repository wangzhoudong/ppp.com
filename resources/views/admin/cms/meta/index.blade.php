@extends('admin.layout') 

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">

	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>META信息管理</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i></a>
					</div>
				</div>
				<div class="ibox-content">
				    <div class="row">
				        <form method="GET" action="" accept-charset="UTF-8">
				        <div class="col-sm-4">
				            <div class="input-group">
								<input type="text" value="{{Request::get('keyword')}}"	placeholder="请输入关键词" name="keyword"class="input-sm form-control"> 
								<span class="input-group-btn">
									<button type="submit" class="btn btn-sm btn-primary">搜索</button>
								</span>
    						</div>
				        </div>
				        </form>
						@if(role('Cms/Meta/create'))
    					<div class="col-sm-3 pull-right">
    					   <a href="{{ U('Cms/Meta/create')}}" class="btn btn-sm btn-primary pull-right">添加</a>
    					</div>
						@endif
					</div>
					
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
						<thead>
    						<tr>
        						<th class="sorting" data-sort="id" width="8%">ID</th>
        						<th class="sorting" data-sort="page" width="12%">页面</th>
        						<th class="sorting" data-sort="title">标题</th>
        						<th class="sorting" data-sort="keywords">关键字</th>
        						<th class="sorting" data-sort="description">描述</th>
        						<th class="sorting" data-sort="created_at">创建时间</th>
        						<th width="22%">相关操作</th>
        					</tr>
						</thead>
						<tbody>
							@foreach($list as $val)
							<tr>
							   <td>{{ $val->id }}</td>
                               <td>{{ $val->page }}</td>
                               <td>{{ $val->title }}</td>
                               <td>{{ $val->keywords }}</td>
                               <td>{{ $val->description }}</td>
                               <td>{{ $val->created_at }}</td>
							   <td>
									<div class="btn-group">
										<button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle" aria-expanded="false"> 操作 <span class="caret"></span></button>
										<ul class="dropdown-menu">
											@if(role('Cms/Meta/update'))
											<li><a href="{{ U('Cms/Meta/update',['id'=>$val->id])}}" class="font-bold">修改</a></li>
											@endif

											@if(role('Cms/Meta/destroy'))
											<li class="divider"></li>
											<li><a href="{{ U('Cms/Meta/destroy',['id'=>$val->id])}}" onclick="return confirm('你确定执行删除操作？');">删除</a></li>
											@endif
										</ul>
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div class="row">
						<div class="col-sm-6">
							<div class="dataTables_info" role="alert" aria-live="polite" aria-relevant="all">每页{{ $list->count() }}条，共{{ $list->lastPage() }}页，总{{ $list->total() }}条。</div>
						</div>
						<div class="col-sm-6">
						<div class="dataTables_paginate paging_simple_numbers">
						{!! $list->setPath('')->appends(Request::all())->render() !!}
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection