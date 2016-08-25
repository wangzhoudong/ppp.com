@extends('admin.layout') 

@section('content')
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-sm-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>页面管理</h5>
						<div class="ibox-tools">
							<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">

						<div class="row">
							<div class="col-sm-1 pull-left">
								<div class="input-group">
									<a href="{{ $jump_url }}" class="btn btn-sm btn-primary pull-right" target="_blank">点击我去管理里面</a>
									<a href="/Operate/Page/logout" class="btn btn-sm btn-primary pull-right">退出管理</a>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
