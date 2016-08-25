@extends('admin.layout')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo isset($data['id']) ? '编辑' : '添加'; ?>用户信息</h5>
					<div class="ibox-tools">
						<a class="collapse-link"> <i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">
                    @if(role('User/Expert/index'))
				    <div class="row">
    					<div class="col-sm-3 pull-right">
    					   <a href="{{ U('User/Expert/index')}}" class="btn btn-sm btn-primary pull-right">返回列表</a>
    					</div>
					</div>
                    @endif

		            <div class="row">
                        <div class="col-lg-10">
                            <form name="form_product" id="form-validation" action="" class="form-horizontal form-validation" accept-charset="UTF-8" method="post">


                                <div class="form-group">
                                    <label class="control-label col-sm-3">专业领域</label>
                                    <div class="col-sm-9">
                                        <?php echo dict()->select('global', 'territory', $data->expertInfo->territory , ['name'=>'data[territory]', 'class'=>'form-control']); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">职务</label>
                                    <div class="col-sm-9">
                                        <input id="c_page" name="data[position]" class="form-control" value="{{ $data->expertInfo->position or ''}}" required="" aria-required="true" placeholder="职务">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">毕业院校</label>
                                    <div class="col-sm-9">
                                        <input id="c_page" name="data[linkman_tel]" class="form-control" value="{{ $data->expertInfo->position or ''}}" required="" aria-required="true" placeholder="毕业院校">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3">学历</label>
                                    <div class="col-sm-9">
                                        <?php echo dict()->select('global', 'education', $data->expertInfo->education , ['name'=>'data[education]', 'class'=>'form-control']); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3">曾参与PPP项目</label>
                                    <div class="col-sm-9">
                                        <textarea name="info[project_desc]" class="form-control" id="info_mark" required="" aria-required="true" rows="3">{{ $data->expertInfo->project_desc or ''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">个人简介</label>
                                    <div class="col-sm-9">
                                        <textarea name="data[resume]" class="form-control" id="info_mark" required="" aria-required="true" rows="3">{{ $data->expertInfo->resume or ''}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3">热度</label>
                                    <div class="col-sm-9">
                                        <input id="txt_title" name="data[hot]" class="form-control" value="{{ $data->expertInfo->hot or ''}}" placeholder="数字越大，排序越前">数字越大，排序越前
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3">密码</label>
                                    <div class="col-sm-9">
                                        <input id="c_page" name="data[password]" class="form-control" value="" placeholder="不修改请留空">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3">浏览加密视频</label>
                                    <div class="col-sm-9">
                                        <label class="radio-inline">
                                            <input type="radio" name="data[visit_video]" value="0" <?php if(isset($data['visit_video']) && $data['visit_video'] == 0){ echo ' checked="checked"'; } ?>>禁止
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="data[visit_video]" value="1" <?php if(isset($data['visit_video']) && $data['visit_video'] == 1){ echo ' checked="checked"'; } ?>>允许
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-sm-3">状态</label>
                                    <div class="col-sm-9">
                                        <label class="radio-inline">
                                            <input type="radio" name="data[status]" value="0" <?php if(isset($data['status']) && $data['status'] == 0){ echo ' checked="checked"'; } ?>>待审核
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="data[status]" value="1" <?php if(isset($data['status']) && $data['status'] == 1){ echo ' checked="checked"'; } ?>>启用
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