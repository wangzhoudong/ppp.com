@extends('admin.project.info.layout')

@section('detail_content')
    <link href="/web/css/style.css?v={{config("sys.version")}}" rel="stylesheet">
    <link href="/web/css/font-awesome.min.css?v={{config("sys.version")}}" rel="stylesheet">
    <link href="/web/css/animate.css?v={{config("sys.version")}}" rel="stylesheet">
    <link href="/web/css/lightbox.css?v={{config("sys.version")}}" rel="stylesheet">
    <link href='http://fonts.useso.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <script src="/web/js/jquery-1.11.0.min.js?v={{config("sys.version")}}"></script>
    <script type="text/javascript" src="/base/layer/layer.js?v={{config("sys.version")}}"></script>
    <script type="text/javascript" src="/base/service.js?v={{config("sys.version")}}"></script>
    <script src="/web/js/bootstrap.min.js?v={{config("sys.version")}}"></script>
    <script src="/web/js/scrolltopcontrol.js?v={{config("sys.version")}}"></script>
    <script src="/web/js/SmoothScroll.js?v={{config("sys.version")}}"></script>
    <script src="/web/js/lightbox-2.6.min.js?v={{config("sys.version")}}"></script>
    <script src="/web/js/validate/jquery.validate.min.js"></script>
    <script src="/web/js/validate/messages_zh.min.js"></script>
    <script src="/web/js/custom.js?v={{config("sys.version")}}"></script>
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>&nbsp</h5>
            <div class="ibox-tools">
                <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
            </div>
        </div>
        <div class="ibox-content">
            <div class="row">
                @include("base.project.baseFrom")
            </div>
        </div>
    </div>
    <script type="text/javascript">

        $("#project_add1_sumbit").click(function() {
            layer.load();
            $.ajax({
                type: "POST",
                url:$('#validate_Mainform').attr("action"),
                data:$('#validate_Mainform').serialize(),
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
        });

    </script>
@endsection
