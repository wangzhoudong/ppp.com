<form class="validate" id="validate_Mainform" method="post" role="form">
    @include('base.project.add1_input')
    @include('base.project.add2_input')
    @include('base.project.add3_input')
    @include('base.project.add4_input')
    @include('base.project.add5_input')
    <div class="form-group row">
        <label for="" class="col-sm-3 control-label"></label>
        <div class="col-sm-4">
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>

            <input type="button" id="project_add1_sumbit" class="btn-animate btn-style btn-d btn-primary" value="保存"/>
        </div>
    </div>
</form>