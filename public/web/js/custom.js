/* ===== Navbar Search ===== */

$('#navbar-search > a').on('click', function() {
    $('#navbar-search > a > i').toggleClass('fa-search fa-times');
    $("#navbar-search-box").toggleClass('show hidden animated fadeInUp');
    return false;
});

/*===== Pricing Bonus ===== */

$('#bonus .pricing-number > .fa-scissors').on('click', function() {
    $(this).css('left', '100%');    /* Cutting */
    setTimeout(function(){          /* Removing the scissors */$('#bonus .pricing-number > .fa-scissors').addClass('hidden');$('#bonus .pricing-body ul').addClass('animated fadeOutDown');
    }, 2000);
    return false;
});

/* ===== Lost password form ===== */

$('.pwd-lost > .pwd-lost-q > a').on('click', function() {
    $(".pwd-lost > .pwd-lost-q").toggleClass("show hidden");
    $(".pwd-lost > .pwd-lost-f").toggleClass("hidden show animated fadeIn");
    return false;
});

/* ===== Thumbs rating ===== */

$('.rating .voteup').on('click', function () {
    var up = $(this).closest('div').find('.up');
    up.text(parseInt(up.text(),10) + 1);
    return false;
});
$('.rating .votedown').on('click', function () {
    var down = $(this).closest('div').find('.down');
    down.text(parseInt(down.text(),10) + 1);
    return false;
});

/* ===== Responsive Showcase ===== */

$('.responsive-showcase ul > li > i').on('click', function() {
    var device = $(this).data('device');
    $('.responsive-showcase ul > li > i').addClass("inactive");
    $(this).removeClass("inactive");
    $('.responsive-showcase img').removeClass("show");
    $('.responsive-showcase img').addClass("hidden");
    $('.responsive-showcase img' + device).toggleClass("hidden show");
    $('.responsive-showcase img' + device).addClass("animated fadeIn");
    return false;
});

/* ===== Tooltips ===== */

$('#tooltip').tooltip();

/* ===== validator ===== */

  //设置特定密码格式验证
$.validator.addMethod("ppp_pws", function(value, element) { 
var length = value.length; 
var ppp_pws = /^[a-zA-Z][a-zA-Z0-9_]*$/ 
return this.optional(element) || ( (length>=6) && ppp_pws.test(value));
}, "密码必须长度最少6个英文或字母!!!");

//设置图片格式
$.validator.addMethod("ppp_img", function(value,element,param) {
    var file=element.files[0];
    if(!file){return true;}//没有文件则不判断
    var fN=file.name.split(".")[1];
    var formatOk=(fN=='jpeg'||fN=='JPEG'||fN=='jpg'||fN=='JPG'||fN=='bmp'||fN=='BMP'||fN=='png'||fN=='PNG');
    if( formatOk){ return true; }else{ return false; }
}, "文件格式只支持jpeg、bmp、png"); 

  //初始设置
$.validator.setDefaults({
    errorClass:"PPP_error",
    errorPlacement: function(error, element) {
      error.appendTo(element.closest(".form-group"));  
    }
});
$().ready(function() {
    $("#validate_Mainform").validate({
      rules:{
        //公共
        agree:"required",
        password:{ required:true, ppp_pws:true },
        email:{ email:true },
        identiCode:{ required:true, rangelength:[4,6] },
        itemName:{ required:true, maxlength:20 },
        builder_company:{ required:true, maxlength:20 },
        //政府注册修改
        loginName:{ required:true, maxlength:20 },
        linkman:{ required:true, maxlength:6 },
        linkman_mobile:{ required:true, mobile:true },
        company_tel:{ required:true, itTel:true },
        official_remarks:{ required:true, ppp_img:true, fileSizeM:2 },
        preScheme:{ ppp_img:true, fileSizeM:2 },
        otherInfo:{ ppp_img:true, fileSizeM:2 },
        //专家注册修改
        expName:{ required:true, maxlength:6 },
        HeadPic:{ required:true, ppp_img:true, fileSizeM:2 },
        exp_mobile:{ required:true, mobile:true },
        proField:{ required:true },
        education:{ required:true },
        duty:{ required:true, maxlength:20 }, 
        graduate:{ required:true, maxlength:20 }, 
        PPPitems:{ required:true, maxlength:200 }, 
        profile:{ required:true, maxlength:200 }, 
        commitment:{ required:true, ppp_img:true, fileSizeM:2 }, 
        meetTime:{ required:true }, 
        //尽职调查
        itemPlace:{ required:true, maxlength:20 },
        financial_situation:{ required:true },
        budget_performance:{ required:true },
        approved_fund:{ required:true },
        itemProperty:{ required:true },
        itemProperty_other:{ required:true },
        total_investment:{ required:true, floor2:true },
        annual_operating_cost:{ required:true, floor2:true },
        annual_operating_income:{ required:true, floor2:true },
        operation_pattern:{ required:true, },
        operation_pattern_other:{ required:true, maxlength:200 },
        cooperation_period:{ required:true },
        asset_ownership:{ required:true },
        current_progress:{ required:true, maxlength:200 },
        financing_ratio:{ required:true },
        reward_mechanism:{ required:true },
        profit_estimation:{ required:true },
        construction_investment_plan:{},
        land_acquisition:{ required:true },
        operating_taxes:{ required:true, maxlength:100 },
        tax_preference:{ required:true, maxlength:100 },
        social_capital:{ required:true, maxlength:100 },
        lending_rate:{ required:true, maxlength:100 },
        preScheme_required:{ required:true, ppp_img:true, fileSizeM:2 },
        project_nature:{ required:true },
        //物有所值
        worth_quota:{ required:true },
        worth_score:{ required:true }
      },
	    messages: {
        //公共
        agree:{ required:"必须同意用户协议才能继续" },
        password:{ required:"请输入密码" },
        email:{},
        identiCode:{ required:"请输验证码", remote:"您输入的验证码有误" },
        itemName:{ required:"请输入项目名" },
        builder_company:{ required: "请输实施机构" },
        //政府注册
        loginName:{ required:"请输入登录名" },
        linkman:{ required:"请输入施项目联系人" },
        linkman_mobile:{ required:"请输入施联系人电话" },
        company_tel:{ required:"请填写单位固定电话" },
        official_remarks:{ required:"请上传初步实施方案" },
        preScheme:{},
        otherInfo:{},
        //专家注册
        expName:{ required:"请输入专家姓名" },
        HeadPic:{ required:"请上传头像照片" },
        exp_mobile:{ required:"请输入登录手机号" },
        proField:{ required:"请选择专业领域" },
        education:{ required:"请选择最高学历" },
        duty:{ required:"请输入职务" },
        graduate:{ required:"请输入毕业院校" },
        PPPitems:{ required:"请输入曾参与PPP项目" },
        profile:{ required:"请输入个人简介" },
        commitment:{ required:"请上传专家承诺书" },
        meetTime:{ required:"请选择会议时间" }, 
        //尽职调查
        itemPlace:{ required:"请填写项目所在地" },
        financial_situation:{ required:"请选择财政情况" },
        budget_performance:{ required:"请正确填写近30年预算执行情况：每个空只能填数字，且最多保留两位小数" },
        approved_fund:{ required:"请正确填写已纳入财政预算的PPP项及相应年度政府支出：项目名必填，数字最多保留两位小数" },
        itemProperty:{ required:"请选择项目属性" },
        itemProperty_other:{ required:"请填写其他项目属性" },
        total_investment:{ required:"请填写项目总投资" },
        annual_operating_cost:{ required:"请填写项目年运营成本" },
        annual_operating_income:{ required:"请填写项目年经营性收入" },
        operation_pattern:{ required:"请选择项目运作模式" },
        operation_pattern_other:{ required:"请填写其他项目运作模式" },
        cooperation_period:{ required:"请填写合作年限：每个空必填，数字必须为整数" },
        asset_ownership:{ required:"请选择项目资产归属" },
        current_progress:{ required:"请填写项目目前进展" },
        financing_ratio:{ required:"请填写投融资比例：每个空必填数字，最多保留两位小数，且比例总和要为100" },
        reward_mechanism:{ required:"请填写项目回报机制" },
        profit_estimation:{ required:"请填写利润率预估" },
        construction_investment_plan:{ required:"请正确填写建设期政府投入计划：每个空必填，数字最多保留两位小数" },
        land_acquisition:{ required:"请选择土地获取方式" },
        operating_taxes:{ required:"请填写项目运营期适用的税种及税率" },
        tax_preference:{ required:"请填写可享受的税收优惠及时效" },
        social_capital:{ required:"请填写有意向社会资本" },
        lending_rate:{ required:"请填写洽过的融资机构以及贷款利率" },
        preScheme_required:{ required:"请选择初步实施方案" },
        project_nature:{ required:"请选择项目性质" },
        //物有所值
        worth_quota:{ required:"请正确填写物有所值指标，每个空必填数字，且最多保留两位小数，其总计必须为100" },
        worth_score:{ required:"请正确填写评分，评分必填，且最多保留两位小数" }
      }
    });
    //因为在有些页面和主表单同时出现多个表,所以单独设置
    $("#validate_FindPsw").validate({
      rules:{
        fp_loginName:{ required:true, hanzipy:true, maxlength:20 },
        fp_password:{ required:true, ppp_pws:true },
        fp_official_remarks:{ required:true, ppp_img:true, fileSizeM:2 }
      },
	    messages: {
        fp_loginName:{ required:"请输入登录名" },
        fp_password:{ required:"请输入密码" },
        fp_official_remarks:{ required:"请上传政府批文照片" }
      }
    })
    //发送验证码时确定手机号是否正确
    $(".validate .sendCodebtn").click(function(e){
      var invalid=$(this).closest(".input-group").find("input").attr("aria-invalid");
      if(invalid!="false"){e.preventDefault();alert('手机号有误')
      }
    });
    //尽职调查 表格中的表单处理
    var ppp_form={
      //近五年预算负债计算
      spliter:"&&",
      bpA:[],
      bpCount:function(form_group,i,v){
        var n=i%5;
        if(i<5){//第一排的收入数据先暂存
          this.bpA[n]=v;
        }else{//第二排的支出数据则算出盈亏并输出
          var a=this.bpA[n];
          var b=v;
          r=accSub(a,b);
          form_group.find(".PPP_countBox").eq(n).text(r)
        }
      },
      frV:0,
      frCheck:function(form_group,i,v){
        if(i==3&&this.frV==100){//只有4个PPP_tableInput 最后一个判断
          return true;
        }else if(i<3){//只验证前三个比例总和
          var a=this.frV;
          this.frV=accAdd(a,v);
          form_group.find(".PPP_countBox").text(this.frV)
          return false;
        }else{//i==3 frV!=100
          return false;
        }
      },
      wqA:[0,0],//基本指标条数，补充指标条数
      wqV:[0,0],//基本指标总计，补充指标总计
      wqCheck:function(form_group,i,v){
        if(this.wqA[0]==0){this.wqA[0]=parseInt( form_group.find(".PPP_wq_basic").attr("rowspan") )-1}
        if(this.wqA[1]==0){this.wqA[1]=parseInt( form_group.find(".PPP_wq_extro").attr("rowspan") )-1}
        if(i<(this.wqA[0])){
          var a=this.wqV[0];
          this.wqV[0]=accAdd(a,v);
          if(i==(this.wqA[0]-1)){form_group.find(".PPP_countBox").eq(0).text(this.wqV[0])}
        }else if(i<(this.wqA[0]+this.wqA[1])){
          var a=this.wqV[1];
          this.wqV[1]=accAdd(a,v);
          if(i==(this.wqA[0]+this.wqA[1]-1)){form_group.find(".PPP_countBox").eq(1).text(this.wqV[1])}
        }
        var t=accAdd(this.wqV[0],this.wqV[1]);
        form_group.find(".PPP_countBox").eq(2).text(t)
        if(t==100){//此处会以最后一次循环判断为准
          return true;
        }else{
          return false;
        }
      },
      //模板 复制第一个tr内容并替换 name 最后[]
      tpl:function(form_group,c){
        var del='<td><div class="PPP_tableDel btn btn-xs btn-red">删除</div></td>';
        var trs=form_group.find('tbody').children('tr');
        var mods=trs.eq(0).find('li');
        var n=trs.length-1;
        var title=trs.eq(0).find("th").html();title=title.replace("[]","["+n+"]")
        var r='<tr><th>'+title+'</th><td><ul class="yearUL">';
        mods.each(function(i){
          var innerHtml=$(this).html();
          innerHtml=innerHtml.replace("[]","["+n+"]")
          r=r+'<li>'+innerHtml+'</li>';
        })
        r=r+'</ul><a class="btn btn-xs PPP_yearUlToggle">显示更多</a></td>'+del+'</tr>';
        return r;
      },
      //年份展示隐藏
      show:function(yearUl){
        yearUl.children("li").show();
      },
      hide:function(yearUl){
        yearUl.children("li").hide();
        yearUl.children("li").filter(function(index) {  return index<5;}).show();
      },
      //name编号重排序 用于删除后保证name连续
      rename:function(form_group){
        var trs=form_group.find('tbody').children('tr');
        trs.each(function(i){
          var inputs=$(this).find("input")
          if(i>0){
            inputs.each(function(){
              var name=$(this).attr("name");
              name=name.replace(/\[\d\d?\]/,"["+i+"]")
              $(this).attr("name",name);
            })
          }
        })
      },
      //项目财务信息 添加子项目 编号
      rename2:function(){
        var trs=$(".PPP_subItemBox");
        trs.each(function(i){
          //标题编号
          var label=$(this).find('label').eq(0)
          var title=label.text();
          title=title.replace(/\d+/,i+1);
          label.text(title)
          //input name编号
          var inputs=$(this).find("input")
          if(i>0){
            inputs.each(function(j){
              var name=$(this).attr("name");
              name=name.replace(/\[\d?\]/,"["+i+"]")
              $(this).attr("name",name);
              if(j==0){
                var ph= $(this).attr("placeholder")
                ph=ph.replace(/\d+/,i+1);
                $(this).attr("placeholder",ph);
              }
            })
          }
        })
      },
      //从hidden获取默认值
      addValue:function(form_group,v){
        var a=v.split(this.spliter);
        var inputs=form_group.find(".PPP_tableInput")
        for(var i in a ){inputs.eq(i).val(a[i]);}
        this.mainFunc(inputs.eq(0));
      },
      mainFunc:function(t,type){
        var _this=this;_this.frV=0;_this.wqV=[0,0];//重置指标
        var form_group=t.closest(".form-group");
        var hidden=form_group.find('.ppp_hidden_input');
        var name=hidden.attr("name");
        if(type=="del"){var tr=t.closest("tr");tr.remove();_this.rename(form_group)}
        if(type=="add"){
          var tr=t.closest("tr");
          tr.before(_this.tpl(form_group))
          var yearUl=tr.prev("tr").find(".yearUL")
          ppp_form.hide(yearUl);
        }
        var inputs=form_group.find('.PPP_tableInput');
        var infoOk=true,hiddenStr="";
        //验证加拼接
        inputs.each(function(i){
          var v=$(this).val();
          if(v==""&&!$(this).hasClass("yz-noreq")){
            $(this).addClass("z-error");infoOk=false;
          }else if($(this).hasClass("yz-floor2")&&!msRegular.float2.test(v)){
            $(this).addClass("z-error");infoOk=false;
          }else if($(this).hasClass("yz-int")&&!msRegular.Int.test(v)){
            $(this).addClass("z-error");infoOk=false;
          }else if( $(this).hasClass("yz-score") && ( !msRegular.float2.test(v) || parseFloat(v)>100 ) ){//分数最大值不能超过100
              $(this).addClass("z-error");infoOk=false;
          }else{
            $(this).removeClass("z-error");
            hiddenStr=hiddenStr+v+_this.spliter;
          }
          if(name=="budget_performance"){_this.bpCount(form_group,i,v)}//近五年预算负债计算
          if(name=="financing_ratio"){infoOk=_this.frCheck(form_group,i,v)}//投融资比例验证
          if(name=="worth_quota"){infoOk=_this.wqCheck(form_group,i,v)}//物有所值指标比例验证
        })
        //添加信息
        if(infoOk){
          hidden.val(hiddenStr)
        }else{
          hidden.val("")
        }
        hidden.blur();
      }
    }
    $(".form-group").on("blur",".PPP_tableInput",function(){
      ppp_form.mainFunc($(this))
    })
    $(".form-group").on("click",".PPP_tableDel",function(){
      ppp_form.mainFunc($(this),"del")
    })
    $(".form-group").on("click",".PPP_tableAdd",function(){
      ppp_form.mainFunc($(this),"add")
    })
    //载入默认判断
    $(".ppp_hidden_input").each(function(){
        var form_group=$(this).closest(".form-group")
        var t=form_group.find(".PPP_tableInput").eq(0)
        ppp_form.mainFunc(t)
    })
    //其他
    $('.ppp_other_chk').on("click",function(){
      var chk=$(this).find("input")
      var checked=chk[0].checked;      
      var box=$(this).closest('.form-group').next(".form_other");
      var input=box.find("input");
      var id=chk.attr("name")+"_other"
      if(checked){
        box.show()
        input.val('')
      }else{
        box.hide()
        input.val('none')
      }
    })
    //项目财务信息 添加子项目
    $('.PPP_tableAdd2').click(function(){
      var innerHtml=$(".PPP_subItemBox").eq(0).html();
      $(this).closest('.form-group').before('<div class="PPP_subItemBox">'+innerHtml+'<div class="form-group row"><div class="col-sm-offset-3 col-sm-9"><div class="PPP_tableDel2 btn btn-xs btn-red">删除</div></div></div></div>')
      ppp_form.rename2()
    })
    $('.validate').on("click",".PPP_tableDel2",function(){
      $(this).closest('.PPP_subItemBox').remove();
      ppp_form.rename2()
    })
    //年份收起展开
    $(".validate").on("click",".PPP_yearUlToggle",function(){
      var i=$(this).text()
      var ul=$(this).prev(".yearUL")
      if(i=="显示更多"){
        ppp_form.show(ul);
        $(this).text("收起")
      }else{
        ppp_form.hide(ul);
        $(this).text("显示更多")
      }
    })
    //年份默认收起
    $(".validate .yearUL").each(function(){
        ppp_form.hide($(this));
    })
});

/*==== 头部 ===*/
$().ready(function() {
  //表单
	$(".phoneList .a03").click(function(){
			if($(this).hasClass("active")){
					$(this).removeClass("active");
					$(".pNavs01").animate({right:"-80%"});
				}else{
					$(this).addClass("active");
					$(".pNavs01").animate({right:0});
					$(".pNavs02").animate({right:"-80%"});
					$(".phoneList .a01").removeClass("active");
					$(".phoneList .a02").removeClass("active");
					$(".psearch").hide();
					}
		})	
  //用户
  $(".later-login").click(function(){
			$(this).find("i").toggle();
			$(this).find(".later-list").toggle();
		})
})

/* ===== 星星 ===== */
$().ready(function() {
  $(".exp_score").each(function(){
    var hidden=$(this).find(".score");
    var spans=$(this).find('.PPP-star').children("span")
    var v=hidden.val();
    PPP_star_show(spans,v)
    spans.each(function(i){
      $(this).click(function(){
        hidden.val(i+1)
        PPP_star_show(spans,i+1)
      })
    })
  })
  function PPP_star_show(spans,v){
    spans.each(function(i){
      if(i<v){
        $(this).addClass("b");
      }else{
        $(this).removeClass("b");
      }
    })  
  }
})

/* ===== 图片高度设置 ===== */
var ppp_imgFix={
  iniset:function(){
    $('.PPP-item-box').each(function(){
      var src=$(this).find("img").attr('src')
      $(this).prepend('<div class="PPP-item-pic" style="background-image:url('+src+');"></div>')
    })
    $('.PPP-vedio-box').each(function(){
      var src=$(this).find("img").attr('src')
      $(this).prepend('<div class="PPP-vedio-pic" style="background-image:url('+src+');"></div>').wrap('<div class="PPP-vedio-out"></div>')
    })
  }
}
$().ready(function() {
  ppp_imgFix.iniset();
})

/* ===== 定性评价计算 ===== */
var ppp_score=function(){
  var zdf=$(".ppp_worth .ppp_score_zdf");
  var st=0;
  $(".ppp_worth .ppp_score_qz").each(function(){
    var tr=$(this).closest("tr");
    var qz=parseFloat( $(this).text() );
    var scores=tr.find(".ppp_score")
    var pj=tr.find(".ppp_score_pj")
    var jqpj=tr.find(".ppp_score_jqpj")
    var s=0,i=100,x=0,n=0,a=0,aj=0;
    scores.each(function(){
      var si=parseFloat( $(this).text() )
      if(si>0){
        if(si<i){i=si}//刷新最小值
        if(si>x){x=si}//刷新最大值
        s=accAdd(s,si);
        n+=1;
      }
    })
    //去掉最大最小值球平均乘以权重
    if(n>2){
      s=accSub(s, i);s=accSub(s, x);
      a=s/(n-2)
      aj=a*qz/100
    }else{
      a=s/n
      aj=qz/100
    }
    pj.text( a.toFixed(2) )
    jqpj.text( aj.toFixed(2) )
    st=accAdd(st,aj);
  })
  zdf.text( st.toFixed(2) )
}
$().ready(function() {
  ppp_score()
})

/* ===== h3标题设置 ===== */
$().ready(function() {
  $("#index h3").each(function(){
    var t=$(this).text();
    var ico="";
    var addIco=true;
    switch(t){
      case "项目库":{ico="i1";break;}
      case "专家库":{ico="i2";break;}
      case "教程试看":{ico="i3";break;}
      default:{addIco=false;}
    }
    if(addIco){
      $(this).text('').wrap('<div class="indexH3"></div>').parent(".indexH3").addClass(ico)
    }
  })
})


/* ===== Mathfix ===== */

//两浮点数相减
function accSub(arg1, arg2) {
  var r1, r2, m, n;
  try { r1 = arg1.toString().split(".")[1].length;  }catch (e) { r1 = 0; }
  try { r2 = arg2.toString().split(".")[1].length;  }catch (e) {r2 = 0;}
  m = Math.pow(10, Math.max(r1, r2)); //last modify by deeka //动态控制精度长度
  n = (r1 >= r2) ? r1 : r2;
  return ((arg1 * m - arg2 * m) / m).toFixed(n);
}
function accAdd(arg1,arg2){
  var r1,r2,m; 
  try{r1=arg1.toStri.sng().split(".")[1].length}catch(e){r1=0}
  try{r2=arg2.toString().split(".")[1].length}catch(e){r2=0}
  m=Math.pow(10,Math.max(r1,r2))
  return (arg1*m+arg2*m)/m 
}

/* ===== IE7、8 ===== */
$().ready(function() {
  if(navigator.appMinorVersion){
  version=navigator.appVersion
  vIE=version.charAt(22);
    if(vIE=="7"||vIE=="8"||vIE=="9"){
      /* 登录提示 */
      $(".input-group").each(function(){
        var tip=$(this).find(".form-control").attr("placeholder")
        $(this).before(tip)
      })
    }
  }
})