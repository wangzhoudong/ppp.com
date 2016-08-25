/**
 * Created by wangzd on 2016/6/26.
 */
function mobileSendCode(obj,id) {
    mobile = $("#" + id).val();
    var reg = /^1[34578]\d{9}$/;
    if (!reg.test(mobile)) {
        alert("请输入正确的号码");
        return ;
    }
    if($(obj).attr('authcodement') == 'true') {
        return false;
    }
    layer.load();
    $.ajax({
        type: "POST",
        url:"/api/captcha/sendcode",
        data:{"mobile":mobile},
        dataType:"json",
        success:function(data){

            if(data.status==200) {
                layer.msg('发送成功');
                $(obj).attr('authcodement','true');
                var i=59;
                $(obj).css({"background":"#ccc"}).html(i+"S后，重新获取");
                var setin=setInterval(function(){
                    if(i<=1){
                        clearInterval(setin);
                        $(obj).removeAttr('authcodement');
                        $(obj).removeAttr("style").html("发送验证码");
                    }else{
                        i--;
                        $(obj).css({"background":"#ccc"}).html(i+"S后，重新获取");
                    }
                },1000);
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

}