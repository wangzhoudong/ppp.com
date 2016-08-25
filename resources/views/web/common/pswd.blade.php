
                <div class="pwd-lost">
                  <div class="pwd-lost-q show"><a href="#">修改密码？</a></div>
                  <div class="pwd-lost-f hidden">
                    <p class="text-muted">在此提交新密码，运营人员会在一个工作日之内通过预留的固定电话与您联系。或者您可以选择通过注册时填写的固定电话打给xxxxxx，由运营人员人工修改密码。</p>
                    <form class="validate" id="validate_FindPsw" method="post" enctype="multipart/form-data"  action="/api/user/resetpwd" role="form">
                      <div class="form-group row">
                        <span class="col-sm-4">用户名：</span>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" id="fp_loginName" name="fp_loginName" placeholder="" required="true">
                        </div>
                      </div>
                      <div class="form-group row">
                        <span class="col-sm-4">新密码：</span>
                        <div class="col-sm-8">
                          <input type="password" id="fp_password" name="fp_password" class="form-control"  placeholder="密码以字母开头，长度在6个字符以上，可以用字母/数字/下划线" required="true" ppp_pws="true">
                        </div>
                      </div>
                      <div class="form-group row">
                        <span class="col-sm-12">提交密码修改函(加盖政府公章)：</span>
                      </div>
                      <div class="form-group row">
                        <div class="col-sm-12">

                          <input type="file" id="fp_official_remarks" name="fp_official_remarks" class="form-control">
                        </div>
                      </div>
                      <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

                      <button type="button" id="FindPsw_submit" class="btn btn-style btn-k">提交修改密码请求</button>
                    </form>
                  </div>
                </div>
                <script type="text/javascript">
                  $("#FindPsw_submit").click(function() {
                    if(!$("#validate_FindPsw").valid()){
                         return false;
                    }
                    return true;
                    layer.load();
                    $.ajax({
                      type: "POST",
                      url:$('#validate_FindPsw').attr("action"),
                      data:$('#validate_FindPsw').serialize(),
                      dataType:"json",
                      success:function(data){
                        if(data.status==200) {
                          layer.msg('注册成功');
                          location.href='/';
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