@extends('admin.layout')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo isset($data['id']) ? '编辑' : '添加'; ?>META信息</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
                    @if(role('Cms/Meta/index'))
				    <div class="row">
    					<div class="col-sm-3 pull-right">
    					   <a href="{{ U('Cms/Meta/index')}}" class="btn btn-sm btn-primary pull-right">返回列表</a>
    					</div>
					</div>
                    @endif

		            <div class="row">
                        <div class="col-lg-10">
                            <form name="form_product" id="form-validation" action="" class="form-horizontal form-validation" accept-charset="UTF-8" method="post">
        
                                <div class="form-group">
                                    <label class="control-label col-sm-3">链接页面</label>
                                    <div class="col-sm-9">
                                        <input id="c_page" name="data[page]" class="form-control" value="{{ $data['page'] or ''}}" required="" aria-required="true" placeholder="输入页面地址不带域名">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">标题</label>
                                    <div class="col-sm-9">
                                        <input id="txt_title" name="data[title]" class="form-control" value="{{ $data['title'] or ''}}" placeholder="标题">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">关键字</label>
                                    <div class="col-sm-9">
                                        <textarea id="txt_keywords" name="data[keywords]" class="form-control" rows="3" placeholder="关键字">{{ $data['keywords'] or ''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">描述</label>
                                    <div class="col-sm-9">
                                        <textarea id="txt_description" name="data[description]" class="form-control" rows="3" placeholder="描述">{{ $data['description'] or ''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">&nbsp;</label>
                                    <div class="col-sm-9">
                                        <input type="hidden" name="_referer" value="<?php echo urlencode($_SERVER['HTTP_REFERER']);?>"/>
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                                        <input type="submit" class="btn btn-success" style="margin-right:20px;">
                                        <input type="reset" class="btn btn-default" >
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.col-lg-10 -->
                    </div>
                    <!-- /.row -->
				</div>
			</div>
		</div>
	</div>
</div>

@endsection