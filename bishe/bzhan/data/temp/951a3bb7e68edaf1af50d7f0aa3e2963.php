<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:63:"E:\devspace\shouquan/application/admin\view\public\popedit.html";i:1511854394;s:62:"E:\devspace\shouquan/application/admin\view\public\header.html";i:1519268025;s:63:"E:\devspace\shouquan/application/admin\view\public\editcss.html";i:1512009968;s:62:"E:\devspace\shouquan/application/admin\view\public\footer.html";i:1518438136;}*/ ?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title><?php echo config('web_site_title'); ?>-总后台</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="">
    <meta name="keywords" content="Admin, Bootstrap 3, Template, Theme, Responsive">
    <!-- bootstrap 3.0.2 -->
    <link href="__PUBLIC__/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="__PUBLIC__/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="__PUBLIC__/admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />

    <!-- iCheck for checkboxes and radio inputs -->
    <link href="__PUBLIC__/admin/css/iCheck/all.css" rel="stylesheet" type="text/css" />

    <!-- Theme style -->
    <link href="__PUBLIC__/admin/css/style.css" rel="stylesheet" type="text/css" />

     <!--[if lt IE 9]>
    <script src="__PUBLIC__/js/html5shiv.js"></script>
    <script src="__PUBLIC__/js/respond.min.js"></script>

    <![endif]-->
    <script src="__PUBLIC__/js/jquery.js"></script>
    <script src="__PUBLIC__/plugs/layer/layer.js"></script>
    <script type="text/javascript">
        var BASE_URL = "<?php echo config('base_url'); ?>"; //根目录地址
        var UPLOAD_URL="/admin/upload/";
    </script>
<body class="skin-black">





<link rel="stylesheet" type="text/css" href="__PUBLIC__/plugs/webuploader/webuploader.css">
<script type="text/javascript" src="__PUBLIC__/plugs/webuploader/webuploader.min.js"></script>
<script type="text/javascript" src="__PUBLIC__/plugs/webuploader/webuploader.custom.js"></script>
<!-- 配置文件 -->


<!-- 编辑器源码文件 -->
<script type="text/javascript" src="__PUBLIC__/plugs/ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="__PUBLIC__/plugs/ueditor/ueditor.all.min.js"></script>
<!-- datepicker statr -->
<link href="__PUBLIC__/plugs/datepicker/css/foundation-datepicker.min.css" rel="stylesheet" type="text/css">
<script src="__PUBLIC__/plugs/datepicker/js/foundation-datepicker.js"></script>
<script src="__PUBLIC__/plugs/datepicker/js/foundation-datepicker.zh-CN.js"></script>

<!-- datepicker end -->

<!--taginput-->
<link rel="stylesheet" href="__PUBLIC__/admin/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="__PUBLIC__/plugs/tagsinput/bootstrap-tagsinput.css">
<link rel="stylesheet" href="__PUBLIC__/plugs/tagsinput/app.css">
<script src="__PUBLIC__/plugs/tagsinput/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="__PUBLIC__/plugs/typeahead.js/dist/typeahead.bundle.js"></script>

<!--taginput end-->

<!-- autocomplete statr -->
<link rel="stylesheet" href="__PUBLIC__/plugs/autocomplete/css/jquery-ui.css">
<link rel="stylesheet" href="__PUBLIC__/plugs/autocomplete/css/style.css">
<script src="__PUBLIC__/plugs/autocomplete/js/jquery.ui.datepicker-zh-CN.min.js"></script>
<script src="__PUBLIC__/plugs/autocomplete/js/jquery-ui.js"></script>
<!-- autocomplete end -->

<div class="row">
	<div class="col-lg-12">
		<section class="panel">
			<!--<header class="panel-heading">-->
			<!--<?php echo $meta_title; ?>-->
			<!--</header>-->
			<div class="panel-body">
				<form method="post" class="form form-horizontal">
					<?php if(!isset($info)): $info = ''; endif; if(is_array($keyList) || $keyList instanceof \think\Collection || $keyList instanceof \think\Paginator): $i = 0; $__LIST__ = $keyList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;if($field['type'] == 'hidden'): ?>
					<input type="hidden" name="<?php echo $field['name']; ?>" value="<?php echo (isset($info[$field['name']]) && ($info[$field['name']] !== '')?$info[$field['name']]:''); ?>"/>
					<?php else: ?>
					<div class="form-group">
						<label class="col-lg-2 col-sm-2 control-label"><?php echo htmlspecialchars($field['title']); ?></label>
						<div class="col-lg-10 col-sm-10">
							<?php echo widget('common/Form/show',array($field,$info)); ?>
							<div class="help-block"><?php echo (isset($field['help']) && ($field['help'] !== '')?$field['help']:''); ?></div>
						</div>
					</div>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?>

					<div class="form-group">
						<div class="col-lg-offset-4 col-lg-8 col-sm-offset-4 col-sm-8">
							<input type="hidden" name="id" value="<?php echo (isset($info['id']) && ($info['id'] !== '')?$info['id']:''); ?>">
							<button class="btn btn-success submit-btn ajax-post" type="submit" target-form="form-horizontal">确 定</button>

						</div>
					</div>
				</form>

			</div>
		</section>
	</div>
</div>





<!-- Bootstrap -->
<script src="__PUBLIC__/admin/js/bootstrap.min.js" type="text/javascript"></script>

<!-- iCheck -->
<script src="__PUBLIC__/admin/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

<!-- Director App -->
<script src="__PUBLIC__/admin/js/Director/app.js" type="text/javascript"></script>

<script src="__PUBLIC__/js/messager.js"></script>


<script src="__PUBLIC__/js/core.js"></script>


</body>
</html>

