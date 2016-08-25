<div class="form-group row">
    <span class="col-sm-3">初步实施方案：</span>
    <div class="col-sm-8">
        <div>
            <?php
            echo widget('Tools.FileUpload')
                    ->single2('upload/project',
                            'pre_scheme_file',
                            'pre_scheme_file',
                            isset($data['pre_scheme_file']) ? $data['pre_scheme_file'] : '',
                            ['position' => 'local', 'placeholder' => '（5M以下格式支持图片，文档，ZIP、RAR等格式）']
                    );
            ?>
        </div>
        <div style="clear: both">5M以下格式支持图片，文档，ZIP、RAR等格式</div>

    </div>

</div>
<div class="form-group row">
    <span class="col-sm-3">其他资料：</span>
    <div class="col-sm-8">
        <div>
            <?php
            echo widget('Tools.FileUpload')
                    ->multi2('upload/project',
                            'other_info_file',
                            'other_info_file',
                            isset($data['other_info_fileInfo']) ? $data['other_info_fileInfo'] : '',
                            ['position' => 'local', 'placeholder' => '（5M以下格式支持图片，文档，ZIP、RAR等格式）']
                    );
            ?>
        </div>
        <div style="clear: both">允许上传多个文件，5M以下格式支持图片，文档，ZIP、RAR等格式</div>

    </div>

</div>