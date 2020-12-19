<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:60:"E:\devspace\shouquan/application/admin\view\public\edit.html";i:1511859798;s:60:"E:\devspace\shouquan/application/admin\view\public\base.html";i:1520934639;s:62:"E:\devspace\shouquan/application/admin\view\public\header.html";i:1519268025;s:63:"E:\devspace\shouquan/application/admin\view\public\editcss.html";i:1512009968;s:62:"E:\devspace\shouquan/application/admin\view\public\footer.html";i:1518438136;}*/ ?>
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




<style>
    .topactive{
        color:#fff;
        /*background-color: #333333;*/
    }

</style>

<header class="header">
    <a href="index.html" class="logo">
        智云授权与更新后台
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </a>
        <ul class="nav navbar-nav">
            <?php if(is_array($top_menu) || $top_menu instanceof \think\Collection || $top_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $top_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
            <li menu-id="<?php echo $item['id']; ?>" class="topnav-item <?php if($item['select']==1): ?>topactive<?php endif; ?>">
                <a href="<?php echo url($item['url']); ?>">
                    <i class="icon icon-<?php echo (isset($item['icon']) && ($item['icon'] !== '')?$item['icon']:'circle-blank'); ?>"></i>
                    <span><?php echo $item['title']; ?></span>
                </a>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>

        <div class="navbar-right">
            <ul class="nav navbar-nav">

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon icon-user"></i>
                        <span> <?php echo session('user_auth.username'); ?><i class="caret"></i></span>
                    </a>
                    <ul class="dropdown-menu dropdown-custom dropdown-menu-right">
                        <li class="dropdown-header text-center">账户</li>
                        <li class="divider"></li>
                        <li>
                            <a href="<?php echo url('admin/user/editpwd'); ?>">
                                <i class="icon  icon-user icon-fw pull-right"></i>
                                修改密码
                            </a>
                            <a href="<?php echo url('admin/index/logout'); ?>">
                                <i class="icon icon-ban-circle  pull-right"></i>
                                退出后台
                            </a>
                        </li>

                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>



<div class="wrapper row-offcanvas row-offcanvas-left">
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="left-side sidebar-offcanvas">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">

                    <img src="__PUBLIC__/admin/img/avatar2.png" onerror="this.src='__PUBLIC__/mobile/image/logo_default.png'" class="img-circle" alt="头像" />

                </div>
                <div class="pull-left info">
                    <p><a href="javascript:;"> <?php echo session('user_auth.username'); ?></a></p>
                </div>
            </div>


            <ul class="sidebar-menu" >
                <?php if(is_array($sub_menu) || $sub_menu instanceof \think\Collection || $sub_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sitem): $mod = ($i % 2 );++$i;?>
                <li  class="nav-header" style=" color: #76829e;
		 margin-left: 5px;">
                    <?php echo $key; ?>
                </li>
                <?php if(is_array($sitem) || $sitem instanceof \think\Collection || $sitem instanceof \think\Paginator): $i = 0; $__LIST__ = $sitem;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$mitem): $mod = ($i % 2 );++$i;?>
                <li class="sub-item <?php if($mitem['select']==1): ?>active<?php endif; ?>">
                    <a href="<?php echo url($mitem['url']); ?>">
                        <i class="icon icon-<?php echo (isset($mitem['icon']) && ($mitem['icon'] !== '')?$mitem['icon']:'file'); ?>"></i>
                        <span><?php echo $mitem['title']; ?></span>
                    </a>
                </li>
                <?php endforeach; endif; else: echo "" ;endif; endforeach; endif; else: echo "" ;endif; ?>

            </ul>



        </section>
        <!-- /.sidebar -->
    </aside>

    <aside class="right-side">

        <!-- Main content -->
        <section class="content">
             <div class="row">
                <div class="col-md-12 col-lg-12">

                    <ul class="breadcrumb">
                        <li><a href="/admin/index/index"><i class="icon icon-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><?php echo $meta_title; ?></a></li>
                    </ul>

                </div>
            </div>
            
 
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
		 <div class="panel">
			 <header class="panel-heading">
				 <?php echo $meta_title; ?>
			 </header>
			 <div class="panel-body">


				 <form method="post" class="form form-horizontal">
					 <?php if(!isset($info)): $info = ''; endif; if(!empty($fieldGroup)): ?>
					 <div class="panel-heading tab-bg-dark-navy-blue">
						 <ul class="nav nav-tabs">
							 <?php if(is_array($fieldGroup) || $fieldGroup instanceof \think\Collection || $fieldGroup instanceof \think\Paginator): $i = 0; $__LIST__ = $fieldGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vGroup): $mod = ($i % 2 );++$i;?>
							 <li <?php if($i == 1): ?>class="active"<?php endif; ?>><a href="#tab<?php echo $key; ?>" data-toggle="tab"><?php echo $key; ?></a></li>
 							 <?php endforeach; endif; else: echo "" ;endif; ?>
						 </ul>
					 </div>
					 <div class="panel-body">
 						 <div class="tab-content ">
 						 <?php if(is_array($fieldGroup) || $fieldGroup instanceof \think\Collection || $fieldGroup instanceof \think\Paginator): $i = 0; $__LIST__ = $fieldGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vGroup): $mod = ($i % 2 );++$i;?>
							<div class="tab-pane fade <?php if($i == 1): ?> in active<?php endif; ?>" id="tab<?php echo $key; ?>" >
							 	 <?php if(is_array($vGroup) || $vGroup instanceof \think\Collection || $vGroup instanceof \think\Paginator): $i = 0; $__LIST__ = $vGroup;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;if($field['type'] == 'hidden'): ?>
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
						   	 </div>

						 <?php endforeach; endif; else: echo "" ;endif; ?>
					     </div>
		              </div>
			 <?php elseif(isset($keyList)): if(is_array($keyList) || $keyList instanceof \think\Collection || $keyList instanceof \think\Paginator): $i = 0; $__LIST__ = $keyList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;if($field['type'] == 'hidden'): ?>
			 <input type="hidden" name="<?php echo $field['name']; ?>" value="<?php echo (isset($info[$field['name']]) && ($info[$field['name']] !== '')?$info[$field['name']]:''); ?>"/>
			 <?php else: ?>
			 <div class="form-group">
				 <label class="col-lg-2 col-sm-2 control-label"><?php echo htmlspecialchars($field['title']); ?></label>
				 <div class="col-lg-10 col-sm-10">
					 <?php echo widget('common/Form/show',array($field,$info)); ?>
					 <div class="help-block"><?php echo (isset($field['help']) && ($field['help'] !== '')?$field['help']:''); ?></div>
				 </div>
			 </div>
			 <?php endif; endforeach; endif; else: echo "" ;endif; endif; ?>
			 <div class="form-group">
				 <div class="col-lg-offset-2 col-sm-offset-4 col-lg-10 col-sm-8">
					 <input type="hidden" name="id" value="<?php echo (isset($info['id']) && ($info['id'] !== '')?$info['id']:''); ?>">
					 <button class="btn btn-success submit-btn ajax-post" type="submit" target-form="form-horizontal">确 定</button>
					 <button class="btn btn-danger btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
				 </div>
			 </div>
			 </form>
			 </div>
		 </section>
	 </div>
 </div>



        </section><!-- /.content -->
        <!--<div class="footer-main" style="position: absolute;bottom: 0;width: 100%">-->
            <!--Copyright &copy 智云科技 <a href="http://www.zhiyunzhushou.com/" target="_blank" title="智云科技">智云科技</a>-->
        <!--</div>-->
    </aside><!-- /.right-side -->

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

