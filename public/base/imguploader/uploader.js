/*
 *  @tanqilin 2016 07 05
 *  百度上传插件
 * 
 *  UploaderPick:"#",                       //绑定按钮id
 *  UploaderUrl:"",                         //百度插件地址
 *  UploaderServer:"",                      //上传api
 *  UploaderMax:5                           //现在最大上传个数
 *  UploadHiddenField:""                    //隐藏域name

*/
function upload(obj){
    this.upobj = {
        UploaderUrl : obj.UploaderUrl ? obj.UploaderUrl : "http://cdn.staticfile.org/webuploader/0.1.0/webuploader.js",
        UploaderServer : obj.UploaderServer ? obj.UploaderServer :"/api/attachment/webupload?elementid=&_time=" + Math.random() ,
        UploaderPick : obj.UploaderPick ? obj.UploaderPick : "#upload01" ,
        UploaderMax  : obj.UploaderMax ? obj.UploaderMax : 100,
        UploaderSingle  : obj.UploaderSingle ? obj.UploaderSingle : false,
        UploadHiddenField : obj.UploadHiddenField ? obj.UploadHiddenField : "field[]"
    },
    this.loadJS = function(url, callback){
        var head = document.getElementsByTagName("head")[0];
        var script = document.createElement("script");
        script.src = url;
        var done = false;
        script.onload = script.onreadystatechange = function() {
            if (!done && (!this.readyState || this.readyState == "loaded" || this.readyState == "complete")) {
                done = true;
                callback();
                script.onload = script.onreadystatechange = null;
                head.removeChild(script);
            }
        };
        head.appendChild(script);
    }
	var _this=this;
    this.attachEventload(function(){
    	_this.loadCom();
    });
}
upload.prototype.attachEventload = function(argument){
    // 判断页面是否加载完毕
    if (window.attachEvent) { 
        window.attachEvent("onload",argument); 
    } else if (window.addEventListener) { 
        window.addEventListener("load",argument, false);   
    }
};
upload.prototype.loadCom = function() {
    var _this=this;
    $("body").append("<style type='text/css'>div.layout_upload ul,div.layout_upload li{ padding: 0px; margin: 0px;list-style-type:none;word-wrap:break-word; white-space:normal; word-break:break-all;}div.layout_upload ul.ullit li{float:left;width:60px;height:60px;border:solid 1px #ccc;position:relative;z-index:5;zoom:1;margin:0 10px 10px 0}div.layout_upload ul.ullit li em{font-weight: 100;opacity: 1;box-shadow: none;font-size: 12px;width:15px;height:15px;cursor:pointer;font-style:normal;line-height:15px;border-radius:15px;-moz-border-radius:15px;-webkit-border-radius:15px;-o-border-radius:15px;-ms-border-radius:15px;background:#999;color:#fff;text-align:center;position:absolute;z-index:30;zoom:1;right:-7px;top:-7px}div.layout_upload ul.ullit li img{width:100%;height:100%;display:block}div.layout_upload ul.ullit li .layout_upload_but{width:60px;height:60px;display:block;line-height:60px;text-align:center;background:url(/base/imguploader/img/uploadCamera.png) no-repeat center center #ccc}div.layout_upload ul.ullit li .rate{width:100%;height:4px;background:#9e9e9e;overflow:hidden;position:absolute;z-index:20;zoom:1;left:0;bottom:0;display:none}div.layout_upload ul.ullit li .rate span{overflow:hidden;width:0;height:4px;background:#36c3be;display:block;transition:all 400ms ease-out 0s;-o-transition:all 400ms ease-out 0s;-moz-transition:all 400ms ease-out 0s;-webkit-transition:all 400ms ease-out 0s;transform-origin:center}div.layout_upload ul.ullit li .yes,div.layout_upload ul.ullit li .no{background:url(http://img-staging.liweijia.com/pc/common/images/rgba.png);display:none;color:#fff;font-size:12px;text-align:center;position:absolute;z-index:10;zoom:1;bottom:0;left:0;width:100%;height:100%;line-height:60px; margin: 0;}div.layout_upload ul.ullit li .yes{height:20px;line-height:20px}.layout_love h3{height:65px;line-height:65px;position:relative;z-index:5;zoom:1;text-align:center}.layout_love h3 span{background:#fff;position:relative;z-index:10;zoom:1;font-size:18px;font-weight:100;display:inline-block;padding:0 10px}</style>")
    if(typeof WebUploader != 'undefined'){
        _this.upLoader();
    }else{
    	this.loadJS(this.upobj.UploaderUrl + "?t=" + Math.random() ,function(){
            _this.upLoader();
        }); 
    }
};
upload.prototype.upLoader=function(){
    var _this = this;
    // 百度上传插件初始化
    var uploader = WebUploader.create({
        // swf文件路径
        swf:'/base/imguploader/uploader.swf',

        // 文件接收服务端。
        server: this.upobj.UploaderServer,

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: this.upobj.UploaderPick,

        //现在最大上传数
        fileNumLimit: _this.upobj.UploaderMax,

        fileSizeLimit: 500 * 1024 * 1024,

        fileSingleSizeLimit: 10 * 1024 * 1024,

        // 是否选择就上传
        auto: true,

        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }

        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        //resize: false
    });

    // 传递参数
//  uploader.option("formData", {
//      _token : "$token",
//      elementid: "s",
//      _time: Math.random()
//  });

    // 判断格式
    uploader.on("error",function(type){
        //仅支持JPG、GIF、PNG、JPEG、BMP格式，
        if(type=='F_EXCEED_SIZE'||type=='Q_EXCEED_SIZE_LIMIT'){
            layer.msg("上传的图片不大于5MB", {icon: 2});
            return false;
        }else if(type=="Q_TYPE_DENIED"){
            layer.msg("请上传JPG、GIF、PNG、JPEG、BMP格式", {icon: 2});
            return false;
        }else if(type=="Q_EXCEED_NUM_LIMIT"){
            layer.msg("超过图片最大上传数量", {icon: 2});
            return false;
        }else {
            layer.msg("服务器繁忙请稍候再试", {icon: 2});
            return false;
        }
    });

    // 上传进度
    uploader.on("uploadProgress",function(file,percentage){
        var $li=$("#rt_"+file.source.ruid).parent().parent().parent().find("li[data-uploaderId='"+file.id+"']");  
        $li.find(".rate").show().find("span").css({"width":percentage*100+"%"});          
        if(percentage==1){
            $li.find(".rate").hide(); 
            $li.find("p.yes").show().html("正在保存数据");
        }
    });

    // 生成预览图
    uploader.on("fileQueued",function(file,percentage){
        var butThis = _this.upobj,
            file = file;
        uploader.makeThumb( file, function( error, src ) {                
            if ( error ) {
                layer.msg("图片不能预览", {icon: 2});
                return;
            }
            var $li = '<li data-uploaderId="'+file.id+'">\
                        <em class="close">×</em>\
                        <img src="'+src+'" alt="" />\
                        <p class="rate"><span></span></p>\
                        <p class="yes">上传成功</p>\
                        <p class="no">上传失败</p>\
                    </li>';
            if(_this.upobj.UploaderSingle) {
                if($("#rt_"+file.source.ruid).parent().parent().parent().children("li").eq(0).find("img").attr('src')){
                    $("#rt_"+file.source.ruid).parent().parent().parent().children("li").eq(0).find("img").attr('src',src);
                    $("#rt_"+file.source.ruid).parent().parent().parent().children("li").eq(0).attr('data-uploaderId',file.id);
                }else{
                    $("#rt_"+file.source.ruid).parent().parent().before($li);
                }
            }else{
                $("#rt_"+file.source.ruid).parent().parent().before($li);

            }
            $("#rt_"+file.source.ruid).parent().parent().parent().find(".close").click(function(){                    
                uploader.removeFile($(this).parent().attr("data-uploaderId"));
                $(this).parent().fadeOut("slow",function(){$(this).remove();})
            });
        },100,100); 

    });

    // 服务器回调
    uploader.on('uploadSuccess', function( file, response ) {
        var ruid=$("#rt_"+file.source.ruid).parent().parent().parent();
        if(response.code==200){
            console.log(response);
            ruid.find("li[data-uploaderId='"+file.id+"'] p.yes").html("上传成功").show();
            if(_this.upobj.UploaderSingle) {
                ruid.find("li[data-uploaderId='"+file.id+"']").append('<input type="hidden" name="'+_this.upobj.UploadHiddenField+'" value="'+response.fileurl+'"　>');
            }else{
                ruid.find("li[data-uploaderId='"+file.id+"']").append('<input type="hidden" name="'+_this.upobj.UploadHiddenField+'[url][]" value="'+response.fileurl+'"　>');
                ruid.find("li[data-uploaderId='"+file.id+"']").append('<input type="hidden" name="'+_this.upobj.UploadHiddenField+'[alt][]" value="'+response.filename+'"　>');
            }


        }else{
            ruid.find("li[data-uploaderId='"+file.id+"'] p.yes").hide();
            ruid.find("li[data-uploaderId='"+file.id+"'] p.no").html("保存失败").show();
        }        
    });

    //所有文件上传后触发    
    uploader.on('uploadComplete', function(file) {
    });
}