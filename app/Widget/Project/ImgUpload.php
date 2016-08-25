<?php
/**
 * 图片上传
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2016/6/21
 * Time: 11:45
 */


namespace App\Widget\Project;


class ImgUpload {

    /**
     * 单个图片上传
     * @param $folder
     * @param string $position
     * @param array $option
     */
    public function single($projectId,$folder,$id,$name="data[image]",$img ="",$option=[]) {
        $file_types = 'jpg|jpeg|gif|png|bmp';
        if($img) {
            $style = "display:block;";
        }else{
            $style = "display:none;";
        }
        $option['button_class'] = isset($option['button_class']) ? $option['button_class'] : "";
        $option['input_data'] = isset($option['input_data']) ? $option['input_data'] : "";
        $option['div_class'] = isset($option['div_class']) ? $option['div_class'] : "spiner-example";
        $option['callback'] = isset($option['callback']) ? $option['callback'] : "";
        $imgHtml = "";
        if(!$option['callback']) {
            $imgHtml = " <div class=\"{$option['div_class']}\" style=\"$style\">
                            <input class=\"upimg_hidden\" {$option['input_data']} type=\"hidden\" value=\"$img\" name=\"$name\"/>
                            <img src=\"$img\" class=\"upimg\" style=\"\"   />
                            <div class=\"sk-spinner sk-spinner-wave\"  style=\"display:none\">
                                <div class=\"sk-rect1\"></div>
                                <div class=\"sk-rect2\"></div>
                                <div class=\"sk-rect3\"></div>
                                <div class=\"sk-rect4\"></div>
                                <div class=\"sk-rect5\"></div>
                                <span>50%</span>
                            </div>
                     </div>";
        }
        $token = csrf_token();
        $html = <<<EOF
                <div class="WebUploader">
                   <div class="WebUploader_button">
                             <div id="$id" class="{$option['button_class']}"/>上传图片</div>
                   </div>
                    $imgHtml
                </div>
                 <script type="text/javascript">
                    function webUpload$id() {
                        var uploaderthis="#$id";
                        $(uploaderthis).parent().parent().find(".fa-remove").click(function() {
                            $(this).parent().hide();
                            $(this).parent().find(".upimg_hidden").val('');
                             $(this).parent().find(".upimg").attr('src','');
                        });
                        var uploader = WebUploader.create({
                            auto: true,
                            pick: {
                                id: uploaderthis,
                                multiple: false,
                            },
                            accept: {
                                title: 'Images',
                                extensions: 'gif,jpg,jpeg,bmp,png',
                                mimeTypes: 'image/*'
                            },
                            swf: "/base/webuploader/uploader.swf",
                            server: "/api/attachment/webupload",
                            fileNumLimit: 300,
                            fileSizeLimit: 5 * 1024 * 1024,
                            fileSingleSizeLimit: 5 * 1024 * 1024,
                        });
                        uploader.option("formData", {
                            _token : "$token",
                            elementid : "",
                             folder : "$folder",
                            _time: Math.random()
                        });
                        uploader.on("error",function(type){
                            //仅支持JPG、GIF、PNG、JPEG、BMP格式，
                            if(type=='F_EXCEED_SIZE'){
                                layer.msg("上传的图片不大于5MB", {icon: 2});
                                return false;
                            }else if(type=="Q_TYPE_DENIED"){
                                layer.msg("请上传JPG、GIF、PNG、JPEG、BMP格式", {icon: 2});
                                return false;
                            }else {
                                layer.msg("服务器繁忙请稍候再试", {icon: 2});
                                return false;
                            }
                        });
                        uploader.on("uploadProgress",function(file,percentage){
                            var re = /([0-9]+\.[0-9]{2})[0-9]*/;
                            aNew = parseFloat(percentage*100).toFixed(0);
                            $(uploaderthis).parent().parent().find(".spiner-example").show().find(".sk-spinner").show().find("span").html(aNew+"%");
                            if(percentage==1){
                                $(uploaderthis).parent().parent().find(".sk-spinner").find("span").html('上传完成，加载图片...');
//                              $(uploaderthis).parent().parent().find(".sk-spinner").hide();
                            }
                        });
                        uploader.on('uploadSuccess', function( file, response ) {

                            uploader.removeFile( file );

                            if(response.code == 200){
                                 $.ajax({
                                    type: "POST",
                                    url:"/Project/Index/upimg",
                                    data:{'project_id':$projectId,'url':response.fileurl},
                                    dataType:"json",
                                    success:function(data){
                                         if(data.status==200) {
                                             layer.msg('更新成功')
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
                              $(uploaderthis).parent().parent().find(".upimg").attr("src",response.fileurl + "?t=" +  Math.random()).load(function() {
                                  $(uploaderthis).parent().parent().find(".sk-spinner").hide();
                              });
                              $(uploaderthis).parent().parent().find(".upimg_hidden").val(response.fileurl);
                            }else{
                                layer.msg(response.message, {icon: 2});
                                $(uploaderthis).parent().parent().find(".sk-spinner").hide();
                                $(uploaderthis).parent().parent().find(".spiner-example").hide();
                            }
                        });

                    }
                    webUpload$id();
                </script>
EOF;

        return $html;

    }

}