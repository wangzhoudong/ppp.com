@extends('web.layout')
@section('header')
@endsection
@section('content')
        <!-- Topic Header -->
<div class="topic">
    <div class="container">
        <div class="row">
            <ol class="breadcrumb hidden-xs">
                <li><a href="index.php">首页</a></li>
                <li class="active">个人设置 - 专家版</li>
            </ol>
        </div> <!-- / .row -->
    </div> <!-- / .container -->
</div> <!-- / .Topic Header -->


<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
            <div class="sign-form">
                <div class="sign-inner">
                    <h3 class="first-child">个人设置-专家版</h3>
                    <hr>
                    <form class="validate" method="post" id="reg_expert_form" role="form">
                        <div class="form-group row">
                            <span class="col-sm-4">咨询时间：</span>
                            <div class="col-sm-8">
                                <div class="col-sm-8">
                                    <div>可接受会议的时间（多选）</div>
                                    <?php
                                        if($_userInfo->expertInfo->meet_time) {
                                            $data['meet_timeInfo'] = explode(',',$_userInfo->expertInfo->meet_time);
                                        }
                                    ?>
                                    @foreach(dict()->get("project_info","counseling_time") as $key=>$val)
                                        <div class="radio"><label><input name="meet_time[]" @if(isset( $data['meet_timeInfo']) && in_array($key,$data['meet_timeInfo'])) checked @endif value="{{$key}}" type="checkbox">{{$val}}</label></div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <span class="col-sm-4">姓名：</span>
                            <div class="col-sm-8">
                                <input type="text" id="name" name="name" value="{{$_userInfo->name}}" class="form-control col-sm-8"  placeholder="限6个汉字">
                            </div>
                        </div>
                        <div class="form-group row">
                            <span class="col-sm-4">头像照片：</span>
                            <div class="col-sm-8">
                                <?php echo  widget('Tools.ImgUpload')->single2('/upload/user','avaterUpload',"avater",$_userInfo->avater);?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <span class="col-sm-offset-4 col-sm-8">2M以下，支持jpeg,png,bmp格式</span>
                        </div>
                        <div class="form-group row">
                            <span class="col-sm-4">邮箱：</span>
                            <div class="col-sm-8">
                                <input type="email" id="email" name="email" class="form-control" value="{{$_userInfo->email}}"  placeholder="请输入邮箱">
                            </div>
                        </div>
                        <div class="form-group row">
                            <span class="col-sm-4">专业领域：</span>
                            <div class="col-sm-8">
                                @foreach(dict()->get('global',"territory") as $key=>$val)
                                    <div class="radio block">
                                        <label>
                                            <input value="{!! $key !!}" @if($key==$_userInfo->expertInfo->territory) checked @endif name="territory" type="radio">
                                            {{$val}}</label>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                        <div class="form-group row"> <span class="col-sm-4">职务：</span>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="position" value="{{$_userInfo->expertInfo->position}}" placeholder="限20个汉字">
                            </div>
                        </div>
                        <div class="form-group row"> <span class="col-sm-4">毕业院校：</span>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" name="academy" value="{{$_userInfo->expertInfo->academy}}"   placeholder="限20个汉字">
                            </div>
                        </div>
                        <div class="form-group row"> <span class="col-sm-4">最高学历：</span>
                            <div class="col-sm-8"> @foreach(dict()->get('global',"education") as $key=>$val)
                                    <div class="radio block">
                                        <label>
                                            <input name="education"   @if($key==$_userInfo->expertInfo->education) checked @endif value="{!! $key !!}" type="radio">
                                            {{$val}}</label>
                                    </div>
                                @endforeach </div>
                        </div>
                        <div class="form-group row"> <span class="col-sm-4">曾参与PPP项目：</span>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="project_desc"  placeholder="限200个汉字">{{$_userInfo->expertInfo->project_desc}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row"> <span class="col-sm-4">个人简介：</span>
                            <div class="col-sm-8">
                                <textarea type="text" class="form-control" name="resume"  placeholder="限200个汉字">{{$_userInfo->expertInfo->resume}}</textarea>
                            </div>
                        </div>
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                        <input type="button" id="reg_expert_submit" class="btn-animate btn-style btn-d btn-primary" value="保存"/>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- / .row -->
</div> <!-- / .container -->

@endsection
@section('footer')
<script type="text/javascript">
	$("#reg_expert_form").validate({
		  rules:{
			"name":{ required:true, hanzi:true, maxlength:6 },
			"avater":{ required:true, ppp_img:true, fileSizeM:2 },
			"mobile":{ required:true, mobile:true },
			identiCode:{ required:true, rangelength:[4,6]},
			 "email":{ email:true },
			"territory":{ required:true },
			"education":{ required:true },
			"position":{ required:true, hanzi:true, maxlength:20 },
			"academy":{ required:true, hanzi:true, maxlength:20 },
			"project_desc":{ required:true, hanzi:true, maxlength:200 },
			"resume":{ required:true, hanzi:true, maxlength:200 },
		  },
			messages: {
			"name":{ required:"请输入专家姓名" },
			"avater":{ required:"请上传头像照片" },
			"mobile":{ required:"请输入登录手机号" },
			identiCode:{ required:"请输验证码", remote:"您输入的验证码有误" },
			"email":{required:"请输入邮箱" },
			"territory":{ required:"请选择专业领域" },

			"education":{ required:"请选择最高学历" },
			"position":{ required:"请输入职务" },
			"academy":{ required:"请输入毕业院校" },
			"project_desc":{ required:"请输入曾参与PPP项目" },
			"resume":{ required:"请输入个人简介" },
		  }
		});
    $("#reg_expert_submit").click(function() {
		if(!$("#reg_expert_form").valid()){
			return false;
		}
		layer.load();
		$.ajax({
			type: "POST",
			url:$('#reg_expert_form').attr("action"),
			data:$('#reg_expert_form').serialize(),
			dataType:"json",
			success:function(data){
				 if(data.status==200) {
					layer.msg('操作成功');
				}else{
					layer.msg(data.msg);
				}
				layer.closeAll('loading');
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				 layer.msg('网络异常，请稍后刷新后再试');
				 layer.closeAll('loading');
			},
		});
	});

</script>
@endsection