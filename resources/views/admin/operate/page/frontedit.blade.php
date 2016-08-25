@extends('admin.layout')

@section('content')

	<div class="row">
		<div class="col-sm-12">
			<div class="ibox float-e-margins">
				<div class="ibox-content">
		            <div class="row">
                        <div class="col-lg-10">
                            <form name="form_product" id="form-validation" action="" class="form-horizontal form-validation" accept-charset="UTF-8" method="post">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <textarea name="data[content]" id="editorContent" required="" aria-required="true" class="form-control" rows="9"><?php if(isset($data['content'])){echo $data['content'];} ?></textarea>
                                        <?php 
                                            echo editor('editorContent', ['position' => 'ali', 'folder' => 'upload/page'], ['themeType' => 'simple', 'height' => '380px']);
                                        ?>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="hidden" name="id" value="{{ $data['id'] or ''}}"/>
                                        <input type="hidden" name="data[key]" value="{{ $data['key'] or ''}}">
                                        <input type="hidden" name="data[page]" value="{{ $data['page'] or ''}}">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
                                        <input type="submit" value="保存" id="submit_from_button" class="btn btn-success">
                                    </div>
                                </div>
        
                            </form>
                        </div>
                        <!-- /.col-lg-10 -->
                    </div>
                    <!-- /.row -->
				</div>
			</div>
		</div>
	</div>
    <script type="text/javascript">
        $("#form-validation").submit(function() {
            $("#editorContent").val(editor_editorContent.html());
            layer.load();
            $.ajax({
                type: "POST",
                url:$('#form-validation').attr("action"),
                data:$('#form-validation').serialize(),
                dataType:"json",
                success:function(data){
                    if(data.status==200) {
                        layer.msg("操作成功");
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

    </script>

@endsection