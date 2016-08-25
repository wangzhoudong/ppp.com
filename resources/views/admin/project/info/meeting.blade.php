@extends('admin.project.info.layout')

@section('detail_content')
<style>

    /* qa */
    .PPP-qa-box{ margin-bottom:30px; }
    .PPP-qa-q{ }
    .PPP-qa-a{ }
    .PPP-qa-a li{ background:#fafafa; min-height:72px; padding:6px 6px 6px 72px; border:1px solid #eee; position:relative; list-style:none; margin-bottom:10px; border-radius:2px; }
    .PPP-qa-a img{ position:absolute; top:6px; left:6px; width:60px; height:60px; border-radius:2px; }
    .PPP-qa-name{ font-size:14px; color:#333; }
    .PPP-qa-time{ color:#666; position:absolute; right:6px; top:6px; font-size:12px; }
    .PPP-qa-cont{ margin-top:10px; font-size:12px; line-height:24px; }

</style>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>专家会</h5>
            <div class="ibox-tools">
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="ibox-content">
            <form name="form_product" id="form-validation" action="" class="form-horizontal form-validation" accept-charset="UTF-8" method="post">

            <div class="row">
                <div class="form-group">
                    <label class="control-label col-sm-3">开会时间</label>
                    <div class="col-sm-9">
                        <input class="form-control layer-date" placeholder="YYYY-MM-DD hh:mm:ss" onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss', min: laydate.now(),festival: true})" value="@if(isset($data['counseling_times']) && $data['counseling_times']){{ date("Y-m-d H:i:s",$data['counseling_times']) }}@endif" name="counseling_times"  required="" aria-required="true"/>
                    </div>
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-sm-3">&nbsp;</label>
                <div class="col-sm-9">
                    <input type="hidden" name="project_id" value="{{request('project_id')}}"/>
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                    <input type="submit" id="project_add1_sumbit" value="保存" class="btn btn-success" style="margin-right:20px;">
                    <input type="reset" class="btn btn-default" >
                </div>
            </div>
            </form>

        </div>

    </div>
    <script type="text/javascript">
        $(function(){
            $("#project_add1_sumbit").click(function() {
             //   layer.load();
                $.ajax({
                    type: "POST",
                    url:$('#form-validation').attr("action"),
                    data:$('#form-validation').serialize(),
                    dataType:"json",
                    success:function(data){
                        if(data.status==200) {
                            layer.msg("已保存");
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
                return false;
            });
        });


    </script>
@endsection
