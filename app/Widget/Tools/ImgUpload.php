<?php
/**
 * 图片上传
 * User: wangzd
 * Email: wangzhoudong@liwejia.com
 * Date: 2016/6/21
 * Time: 11:45
 */


namespace App\Widget\Tools;

use App\Models\CmsLinkModel;

class ImgUpload {

    /**
     * 单个图片上传
     * @param $folder
     * @param string $position
     * @param array $option
     */
    public function single($folder,$id,$name="data[image]",$img ="",$option=[]) {
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
                            <i class=\"fa fa-remove \"></i>
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
                            fileSizeLimit: 10 * 1024 * 1024,
                            fileSingleSizeLimit: 10 * 1024 * 1024,
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

    public function single2($folder, $id, $name="data", $img="", $option=[]){
        $folder = urlencode($folder);
        $imgHtml =  "";
        $option['callback'] = isset($option['callback']) ? $option['callback'] : "";
        if(!$option['callback'] && !empty($img)) {
            $imgHtml .=  " <li><em class=\"close\" onclick='$(this).parent().remove()'>×</em>
                    <img src=\"{$img}\" alt=\"{$img}\">
                    <p class=\"rate\" style=\"display: none;\"><span style=\"width: 100%;\"></span></p>
                    <p class=\"yes\" style=\"display: none;\"></p>
                    <p class=\"no\"></p>
                    <input type=\"hidden\" name=\"{$name}\" value=\"{$img}\">
                </li>";
        }

        $html = <<<EOF
           <script type="text/javascript" src="/base/imguploader/uploader.js"></script>
            <div class="layout_upload">
                <ul class="ullit">
                    $imgHtml
                    <li>
                        <a class="layout_upload_but" id="$id">&nbsp;</a>
                    </li>
                    <div class="ov_h"></div>
                </ul>
            </div>
            <script type="text/javascript">
            /*
             UploaderPick:"#",                       //绑定按钮id
             UploaderUrl:"",                         //百度插件地址
             UploaderServer:"",                      //上传api
             UploaderMax:1                           //现在最大上传个数
             UploadHiddenField:""                    //隐藏域name
             */
            new upload({
                UploaderPick:"#$id",
                UploaderMax:0,
                UploadHiddenField:"$name",
                UploaderServer:"/api/attachment/webupload?elementid=&folder=$folder&_time=" + Math.random(),
                UploaderSingle:true
            });
        </script>
EOF;
        return $html;
    }

    /**
     * 统一上传
     * @param $folder
     * @param $id
     * @param string $name
     * @param array $imgs
     * @param null $callBackFun
     * @return string
     */
    public function multi($folder, $id, $name="data[image]", $imgs=[], $option=[]){
        $file_types = 'jpg|jpeg|gif|png|bmp';
        $url = U("tools/uploadImg",['fooder'=>$folder,'time'=>SYSTEM_TIME,'token'=>md5($folder. LOGIN_MARK_SESSION_KEY . SYSTEM_TIME)]);

        $imgHtml =  "";
        $option['callback'] = isset($option['callback']) ? $option['callback'] : "";
        if(!$option['callback'] && !empty($imgs)) {
            foreach($imgs as $key=>$val) {
                if(is_string($val)) {
                    $img['url'] = $val;
                    $img['alt'] = '';
                }else{
                    $img = $val;
                }
                $imgHtml .=  "<a class=\"fancybox\"title=\"图片\">
                    <input type=\"hidden\" name=\"{$name}[url][]\" value=\"{$img['url']}\" />
                   <em class=\"fa fa-remove\" onclick='removeUploadImg{$id}(this)'></em>
                   <img alt=\"image\" src=\"{$img['url']}\" />
                   <textarea class='form-control' name='{$name}[alt][]'>{$img['alt']}</textarea>
               </a>";
            }
        }
        $herfUrl = request()->fullUrl();
        $html = <<<EOF
                            <div style="clear:both">
                            <div>
                               <button class="btn btn-white"  id="$id" type="button">开始上传</button>
                            </div>


                            <div id="{$id}list" class="upload-ibox-content ibox-content sortable-list ui-sortable">
                                    $imgHtml
                             </div>
                             <script>
                                $(document).ready(function(){
                                   $("#{$id}list").sortable({connectWith:"#{$id}list",tag:"a",constraint:"horizontal",scroll:false}).disableSelection()});
                            </script>

                             </div>
                            <script type="text/javascript">
                                $("#$id").click(function() {
                                    layer.open({
                                        type: 2,
                                        title: '图片上传',
                                        shadeClose: true,
                                        shade: 0.8,
                                        area: ['80%', '90%'],
                                        content: '$url',
                                        btn: ['完成上传'],
                                        yes:function(index, layero){
                                            var iframeWin = window[layero.find('iframe')[0]['name']];
                                            var data = iframeWin.\$filePaths;
                                            for(i=0;i<data.length;i++) {
                                                console.log(data[i]);
                                                 $("#{$id}list").append('<a class="fancybox"  title="图片1">'+
                                                 '<input type="hidden" name="{$name}[url][]" value="' + data[i].fileurl +  '"/>' +
                                                '<em class="fa fa-remove" onclick="removeUploadImg{$id}(this)" ></em>' +
                                                '<img alt="image" src="' + data[i].fileurl +  '" />' +
                                                '<textarea class="form-control" name="{$name}[alt][]">' + data[i].filename +  '</textarea>' +
                                             '</a>');
                                            }
                                            layer.close(index);
                                        },
                                        end:function(index,msg){ }
                                    });
                                });
                                function callbackUploadImg$id(data){
                                    for(i=0;i<data.length;i++) {
                                        console.log(data[i]);
                                         $("#{$id}list").append('<a class="fancybox"  title="图片1">'+
                                         '<input type="hidden" name="{$name}[url][]" value="' + data[i].fileurl +  '"/>' +
                                        '<em class="fa fa-remove" onclick="removeUploadImg{$id}(this)" ></em>' +
                                        '<img alt="image" src="' + data[i].fileurl +  '" />' +
                                                '<textarea class="form-control" name="{$name}[alt][]">' + data[i].filename +  '</textarea>' +
                                     '</a>');
                                    }
                                }
                                function removeUploadImg$id(obj){
                                    $(obj).parent().remove();
                                }

                            </script>

EOF;
        return $html;

    }

    public function multi2($folder, $id, $name="data[image]", $imgs=[], $option=[]){
        $folder = urlencode($folder);

        $imgHtml =  "";
        $option['callback'] = isset($option['callback']) ? $option['callback'] : "";
        $option['max'] = isset($option['max']) ? $option['max'] : 5;
        $option['max'] = $option['max']-count($imgs);
        if(!$option['callback'] && !empty($imgs)) {
            foreach($imgs as $key=>$val) {
                if(is_string($val)) {
                    $img['url'] = $val;
                    $img['alt'] = '';
                }else{
                    $img = $val;
                }
                $imgHtml .=  " <li><em class=\"close\" onclick='$(this).parent().remove()'>×</em>
                        <img src=\"{$img['url']}\" alt=\"{$img['alt']}\">
                        <p class=\"rate\" style=\"display: none;\"><span style=\"width: 100%;\"></span></p>
                        <p class=\"yes\" style=\"display: none;\"></p>
                        <p class=\"no\"></p>
                        <input type=\"hidden\" name=\"{$name}[alt][]\" value=\"{$img['alt']}\">
                        <input type=\"hidden\" name=\"{$name}[url][]\" value=\"{$img['url']}\">
                    </li>";
            }
        }

        $html = <<<EOF
           <script type="text/javascript" src="/base/imguploader/uploader.js"></script>
            <div class="layout_upload">
                <ul class="ullit">
                                    $imgHtml

                    <li>
                        <a class="layout_upload_but" id="$id">&nbsp;</a>
                    </li>
                    <div class="ov_h"></div>
                </ul>
            </div>
            <script type="text/javascript">
            /*
             UploaderPick:"#",                       //绑定按钮id
             UploaderUrl:"",                         //百度插件地址
             UploaderServer:"",                      //上传api
             UploaderMax:5                           //现在最大上传个数
             UploadHiddenField:""                    //隐藏域name
             */
            new upload({
                UploaderPick:"#$id",
                UploaderMax:{$option['max']},
                UploaderServer:"/api/attachment/webupload?elementid=&folder=$folder&_time=" + Math.random(),
                UploadHiddenField:"$name"
            });
        </script>
EOF;
        return $html;
    }
}