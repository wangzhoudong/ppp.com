@extends('web.layout')
@section('header')

@endsection
@section('content') 
<!-- Topic Header -->
<div class="topic">
  <div class="container">
    <div class="row">
      <ol class="breadcrumb hidden-xs">
        <li><a href="/">首页</a></li>
        <li><a href="/login/index">角色选择</a></li>
        <li><a href="/login/expert">专家登录</a></li>
        <li class="active">专家注册</li>
      </ol>
    </div>
    <!-- / .row --> 
  </div>
  <!-- / .container --> 
</div>
<!-- / .Topic Header -->

<div class="container">
  <div class="row">
    <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2">
      <div class="sign-form">
        <div class="sign-inner">
          <h3 class="first-child">专家注册</h3>
          <hr>
          <form name="reg_expert_form" id="reg_expert_form" action="/api/register/expert" role="form">
            <div class="form-group row"> <span class="col-sm-4">姓名：</span>
              <div class="col-sm-8">
                <input type="text" name="name" id="name" class="form-control col-sm-8"  placeholder="限6个汉字">
              </div>
            </div>
            <div class="form-group row"> <span class="col-sm-4">头像照片：</span>
              <div class="col-sm-8">
                <?php echo  widget('Tools.ImgUpload')->single2('/upload/user','avaterUpload',"avater");?>
              </div>
            </div>
            <div class="form-group row"> <span class="col-sm-offset-4 col-sm-8">2M以下，支持jpeg,png,bmp格式</span> </div>

            <div class="form-group row"> <span class="col-sm-4">邮箱：</span>
              <div class="col-sm-8">
                <input type="email" name="email" class="form-control"  placeholder="请输入邮箱">
              </div>
            </div>
            <div class="form-group row"> <span class="col-sm-4">专业领域：</span>
              <div class="col-sm-8"> @foreach(dict()->get('global',"territory") as $key=>$val)
                <div class="radio block">
                  <label>
                    <input value="{!! $key !!}" name="territory" type="radio">
                    {{$val}}</label>
                </div>
                @endforeach </div>
            </div>
            <div class="form-group row"> <span class="col-sm-4">职务：</span>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="position"  placeholder="限20个汉字">
              </div>
            </div>
            <div class="form-group row"> <span class="col-sm-4">毕业院校：</span>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="academy"   placeholder="限20个汉字">
              </div>
            </div>
            <div class="form-group row"> <span class="col-sm-4">最高学历：</span>
              <div class="col-sm-8"> @foreach(dict()->get('global',"education") as $key=>$val)
                <div class="radio block">
                  <label>
                    <input name="education"  value="{!! $key !!}" type="radio">
                    {{$val}}</label>
                </div>
                @endforeach </div>
            </div>
            <div class="form-group row"> <span class="col-sm-4">曾参与PPP项目：</span>
              <div class="col-sm-8">
                <textarea type="text" class="form-control"  name="project_desc"  placeholder="限200个汉字"></textarea>
              </div>
            </div>
            <div class="form-group row"> <span class="col-sm-4">个人简介：</span>
              <div class="col-sm-8">
                <textarea type="text" class="form-control" name="resume"  placeholder="限200个汉字"></textarea>
              </div>
            </div>
            <div class="form-group row"> <span class="col-sm-4">专家承诺书：</span>
              <div class="col-sm-8">
                <?php echo  widget('Tools.ImgUpload')->single2('/upload/user','articleUpload1',"undertaking");?>
              </div>
            </div>
            <div class="form-group row"> <span class="col-sm-offset-4 col-sm-8">2M以下，支持jpeg,png,bmp格式<br/>
              <a target="_blank" href="/base/专家承诺书.docx">承诺书模板下载</a>签字后请扫描上传 </span> </div>
              <div class="form-group row"> <span class="col-sm-4">登录手机号：</span>
                  <div class="col-sm-8">
                      <div class="input-group">
                          <input type="text" name="mobile" id="exp_mobile" class="form-control" placeholder="输入手机号"/>
                  <span class="input-group-btn">
                  <button onclick="mobileSendCode(this,'exp_mobile')" class="mobileSendCode btn btn-secondary" type="button">发送验证码</button>
                  </span> </div>
                  </div>
              </div>
              <div class="form-group row"> <span class="col-sm-4">登录验证码：</span>
                  <div class="col-sm-8">
                      <input type="text" class="form-control"  id="identiCode" name="identiCode" placeholder="4或6位数字">
                  </div>
              </div>
            <div class="checkbox">
              <label>
                          <input id="agree" name="agree" type="checkbox"> 我已阅读并同意 <a target="_blank" href="/about/protocol.html">PPP在线咨询网站用户使用协议</a>
                        </label>
            </div>
            <input type="button" id="reg_expert_submit" class="btn-animate btn-style btn-d btn-primary" value="注册"/>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- / .row --> 
</div>
<!-- / .container --> 

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
			"undertaking":{ required:true, ppp_img:true, fileSizeM:2 }, 
			agree:"required",
			meetTime:{}, 
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
			"undertaking":{ required:"请上传专家承诺书" },
			 agree:{ required:"必须同意用户协议才能继续" },
			meetTime:{}, 
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
                     layer.confirm('注册成功,请耐心等待审核!!!', {
                         btn: ['先随便逛逛'] //按钮
                     }, function(){
                         location.href='/';
                     });
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