@extends('admin.layout')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>申请列表</h5>
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
                                    <input type="text" value="{{Request::get('keyword')}}"	placeholder="请输入关键词 （用户名，邮箱，电话）" name="keyword" class="input-sm form-control"> 
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
								<th class="sorting" data-sort="mobile">修改密码函</th>
								<th class="sorting" data-sort="name">用户名</th>
								<th class="sorting" data-sort="email">邮箱</th>
								<th class="sorting" data-sort="mobile">电话</th>
								<th>相关操作</th>
							</tr>
						</thead>
						<tbody>
						@if(isset($list))
							@foreach($list as $item)
							<tr>
								<td> <a href="{{$item->reset_password_img}}" target="_blank"> <img src="{{$item->reset_password_img}}" width="100" height="100"/> </a></td>

								<td>{{ $item->name or '' }}</td>
								<td>{{ $item->email or '' }}</td>
								<td>{{ $item->mobile or '' }}</td>
								<td>
									<a class="btn btn-warning btn-sm dropdown-toggle"  href="{{ U('Foundation/User/resetPwdPass', ['id' =>$item->id])}}">通过</a>
									<a class="btn btn-warning btn-sm dropdown-toggle" href="{{ U('Foundation/User/resetPwdReject', ['id' =>$item->id])}}">驳回</a>
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
