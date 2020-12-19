<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:71:"E:\devspace\shouquan/application/common\view\default\form\datetime.html";i:1512093884;}*/ ?>
<div class="input-group input-group-sm   	" style="width:160px ;" >
	<input type="text" class="form-control input-sm" id="<?php echo $field; ?>" name="<?php echo $field; ?>"
		   value="<?php echo date('Y-m-d H:i:s',(isset($value) && ($value !== '')?$value:time())); ?>" readonly size="20" >
	<span class="input-group-addon"><i class="fa fa-th icon icon-th"></i></span>
</div>
<script>
    $(document).ready(function() {
        $('#<?php echo $field; ?>').fdatepicker({
            format: 'yyyy-mm-dd hh:ii:ss',
            pickTime: true
        });
    });
</script>