@extends('admin.layout') 
@section('header')
	<style>
		.WebUploader .spiner-example{
			width: 100px;
			height: 100px;
		}

		.WebUploader .spiner-example img{
			width: 100px;
			height: 100px;
		}

	</style>

@endsection
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">

	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>项目管理</h5>
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
						@if(role('Cms/Video/create'))
    					<div class="col-sm-3 pull-right">
    					   <a href="{{ U('Cms/Video/create')}}" class="btn btn-sm btn-primary pull-right">添加</a>
    					</div>
						@endif
					</div>
					<table class="table table-striped table-bordered table-hover dataTables-example dataTable">
						<thead>
    						<tr>
        						<th class="sorting" data-sort="id" width="8%">ID</th>
        						<th class="sorting" data-sort="image" width="12%">封面</th>
        						<th class="sorting" data-sort="name">项目名</th>
        						<th>初步实施方案</th>
        						<th>其他资料</th>
        						<th class="sorting" data-sort="property">项目属性</th>
        						<th class="sorting" data-sort="total_investment">项目总投资</th>
        						<th class="sorting" data-sort="annual_operating_cost">项目年运营成本</th>
        						<th class="sorting" data-sort="asset_ownership">项目资产归属</th>
        						<th class="sorting" data-sort="description">状态</th>
        						<th class="sorting" data-sort="created_at">创建时间</th>
        						<th width="22%">相关操作</th>
        					</tr>
						</thead>
						<tbody>
							@foreach($list as $val)
							<tr>
							   <td>{{ $val->id }}</td>
                               <td>
								   <div class="list_img">
								   		<?php echo  widget('Project.ImgUpload')->single($val->id,'/upload/project','projectUpload' . $val->id,"video_img",$val->image,['input_data'=>"onpropertychange=\"javascript:alert('值已改变')\" data-id='{$val->id}'"]);?>
								   </div>
								</td>
                               <td>{{ $val->name }}</td>
                               <td>
								   @if($val->pre_scheme_file)
									<a href="{{$val->pre_scheme_file}}" target="_blank">下载</a>
								   @else
									暂无上传
								   @endif

							   </td>
                               <td>
								   @if($val->other_info_file)
									   <?php
									   $files = [];
										$files = json_decode($val->other_info_file,true);
									   ?>
									   @foreach($files as $fileK=>$file)
										   <p><a target="_blank" href="{{$file['url']}}" class="img" >
											   其他资料{{$fileK+1}}
										   </a>
										   </p>
									   @endforeach
								   @else

								   @endif
							   </td>
                               <td>{!! dict()->get('project_info','property',$val->property) !!} </td>
                               <td>{!! $val->total_investment !!} </td>
                               <td>{!! $val->annual_operating_cost !!} </td>
                               <td>{!! dict()->get('project_info','asset_ownership',$val->asset_ownership) !!} </td>
                               <td>{!! dict()->get('project_info','status',$val->status) !!}</td>
                               <td>{{ $val->created_at }}</td>
							   <td>
									   <div class="btn-group">
										   <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle" aria-expanded="false"> 操作 <span class="caret"></span></button>
										   <ul class="dropdown-menu">
											   @if(role('Project/Index/update'))
												   <li>   <a href="{{ U('Project/Info/update',['project_id'=>$val->id])}}" class="font-bold">修改</a></li>
											   @endif

											   @if(role('Project/Index/type'))
												   @if($val->type==1)
													   <li><a href="{{ U('Project/Index/type',['id'=>$val->id,'type'=>2])}}" class="font-bold">设为示例项目</a></li>
												   @else
													   <li><a href="{{ U('Project/Index/type',['id'=>$val->id,'type'=>1])}}" class="font-bold">取消示例项目</a></li>
												   @endif
											   @endif
										   </ul>
									   </div>

								   <div class="btn-group">
									   <button data-toggle="dropdown" class="btn btn-warning btn-sm dropdown-toggle" aria-expanded="false"> 状态变更<span class="caret"></span></button>
									   <ul class="dropdown-menu">
										   @if($aStatuBotton[$val->status])
											   @foreach($aStatuBotton[$val->status] as $button )
												   <li><a href="{{ U('Project/Index/status',['id'=>$val->id,'status'=>$button['status']])}}" class="font-bold">{{$button['name']}}</a></li>
											   @endforeach
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
@section('footer')


@endsection