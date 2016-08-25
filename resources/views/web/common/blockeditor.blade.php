@if(isset($_editable) && $_editable)
    <script type="text/javascript" src="/base/BlockEditor/BlockEditor.js?v={{config("sys.version")}}" ></script>
    <script type="text/javascript">
    $BloEditor.initialization(null,"http://<?php echo config('sys.sys_admin_domain'); ?>/Operate/Page/update", '<?php echo urlencode(request()->getRequestUri()); ?>');
    </script>
@endif