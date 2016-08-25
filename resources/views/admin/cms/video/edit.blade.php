@extends('admin.layout')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo isset($data['id']) ? '编辑' : '添加'; ?>视频信息</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
                    @if(role('Cms/Video/index'))
				    <div class="row">
    					<div class="col-sm-3 pull-right">
    					   <a href="{{ U('Cms/Video/index')}}" class="btn btn-sm btn-primary pull-right">返回列表</a>
    					</div>
					</div>
                    @endif

		            <div class="row">
                        <div class="col-lg-10">
                            <form name="form_product" id="form-validation" action="" class="form-horizontal form-validation" accept-charset="UTF-8" method="post">

                                <div class="form-group">
                                    <label class="control-label col-sm-3">封面图</label>
                                    <div class="col-sm-4">
                                        <?php echo  widget('Tools.ImgUpload')->single('/upload/video','videUpload',"data[image]",isset($data['image']) ? $data['image'] : "");?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3">视频名称</label>
                                    <div class="col-sm-9">
                                        <input id="txt_title" name="data[title]" class="form-control" value="{{ $data['title'] or ''}}" placeholder="视频名称">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">视频链接</label>
                                    <div class="col-sm-9">
                                        <input id="c_page" name="data[link]" class="form-control" value="{{ $data['link'] or ''}}" required="" aria-required="true" placeholder="输入视频链接">
                                    </div>
                                </div>
                                <!--
                                <div class="form-group">
                                    <label class="control-label col-sm-3">类型</label>
                                    <div class="col-sm-9">
                                        <label class="radio-inline">
                                            <input type="radio" name="info[type]" value="1" <?php if(isset($data['type']) && $data['type'] == 0){ echo ' checked="checked"'; } ?>>开放
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="info[type]" value="2" <?php if(isset($data['type']) && $data['type'] == 1){ echo ' checked="checked"'; } ?>>付费
                                        </label>
                                    </div>
                                </div>
                                !-->
                                <div class="form-group">
                                    <label class="control-label col-sm-3">热度</label>
                                    <div class="col-sm-9">
                                        <input id="txt_title" name="data[hot]" class="form-control" value="{{ $data['hot'] or ''}}" placeholder="数字越大，排序越前">数字越大，排序越前
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">状态</label>
                                    <div class="col-sm-9">
                                        <label class="radio-inline">
                                            <input type="radio" name="info[status]" value="0" <?php if(isset($data['status']) && $data['status'] == 0){ echo ' checked="checked"'; } ?>>下架
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="info[status]" value="1" <?php if(isset($data['status']) && $data['status'] == 1){ echo ' checked="checked"'; } ?>>启用
                                        </label>
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