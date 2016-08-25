var BlockEditor=function(t){
	this.Block=t,
	this.BlockDate=function(){
		var d=new Date;
		return d.getTime();
	},
	this.BlockUrl="http://www.baidu.com/?t="+this.BlockDate(),
	this.BlockMs=false,
	this.BlockThis=function(){
		return $("*["+this.Block+"]:visible");
	},
	this.BlockMoveHtml=function(id,style){//'{widht:;height:;top:;left:;}'
		if($('#Blick'+id).length==0){
			return '<div class="Blickcookroom" id="Blick'+id+'" style="'+style+'position: absolute; z-index:900; border:1px dashed #4da1da; background:rgba(0,0,0,0.02); ">\
					<a href="javascript:;" data-block="'+id+'" style="float: right; width:50px; height:25px; line-height:25px;position: relative; top:-25px;right:-1px;  text-align: center; color: #fff;background:#4da1da;">编辑</a>\
					</div>';
					//<div class="Blickbg'+id+'" style="position: fixed; z-index:890;left:0px; top:0px; width:100%; height:100%;"></div>';
		}else{
			$('#Blick'+id).attr("style",style+'position: absolute; z-index:900; border:1px dashed #3497db;background:rgba(0,0,0,0.02);');
			//$('.Blickbg'+id).show();
		}
		
	}
}
BlockEditor.prototype.boxObject=function(data){//弹出窗体
	layer.open({
	  type: 2,
	  title: '编辑弹出',
	  shadeClose: true,
	  shade: false,
	  maxmin: true, //开启最大化最小化按钮
	  area: ['893px', '600px'],
	  content: this.BlockUrl + "&" + this.Block + "=" + data + "&uri=" + this.BlockUri
	});
}
BlockEditor.prototype.show = function(){
	var _this=this;
		this.blickMsg=false;
	setInterval(function(){
		if(_this.blickMsg) {return false;}
		$.each(_this.BlockThis(),function(i,v){	
			if($(_this.showIndex[i]).attr("page_key") != $(v).attr("page_key")){				
				_this.blickMsg = true;
				_this.showIndex = _this.BlockThis();
				_this.showthis();
				return false;
			}
		});
		
	},600);
};
BlockEditor.prototype.initialization=function(t,url,uri){
	this.Block=t?t:this.Block;
	this.BlockUri=uri;
	this.BlockUrl=url ? url+"?t="+this.BlockDate() : this.BlockUrl;
	this.showIndex=this.BlockThis();
	var _this=this;
	if(this.BlockMs){
		this.BlockThis().hoverIntent(function(){
			var h=$(this).height()-2,
				w=$(this).width()+2,
				l=$(this).offset().left-4,
				t=$(this).offset().top,
				_this2=this;
			$("body").append(_this.BlockMoveHtml($(this).attr(_this.Block),"width:"+w+"px;height:"+h+"px;top:"+t+"px;left:"+l+"px;"));
			$('#Blick'+$(this).attr(_this.Block)).find("a").unbind("click").click(function(){
				_this.boxObject($(this).attr('data-block'));
			});
			setTimeout(function(){
				$(".Blickbg"+$(_this2).attr(_this.Block)).mouseover(function(){
					$('#Blick'+$(_this2).attr(_this.Block)).hide();
					$(this).hide();
				});
			},200);
		});
	}else{
		this.showthis();
		this.show();
	}
	
}
BlockEditor.prototype.showthis=function(){
	var _this=this;
	$(".Blickcookroom").remove();
	for(var i=0; i<this.BlockThis().length; i++){
		var h=this.BlockThis().eq(i).height()-2,
			w=this.BlockThis().eq(i).width()+2,
			l=this.BlockThis().eq(i).offset().left-4,
			t=this.BlockThis().eq(i).offset().top,
			_this2=this.BlockThis().eq(i);				
		$("body").append(_this.BlockMoveHtml(_this2.attr(_this.Block),"width:"+w+"px;height:"+h+"px;top:"+t+"px;left:"+l+"px;"));
		$('#Blick'+_this2.attr(_this.Block)).hover(function(){
			$(this).css({"border":"#e76700 dashed 1px","z-index":"950"});
			$(this).find("a").css("background","#e76700");
		},function(){
			$(this).css({"border":"#4da1da dashed 1px","z-index":"900"});
			$(this).find("a").css("background","#4da1da");
		}).find("a").unbind("click").click(function(){
			_this.boxObject($(this).attr('data-block'));
		});			
	}
	this.blickMsg=false;
}
var $BloEditor=new BlockEditor("page_key");
