<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:60:"E:\devspace\shouquan/application/admin\view\index\index.html";i:1519824812;s:60:"E:\devspace\shouquan/application/admin\view\public\base.html";i:1520934639;s:62:"E:\devspace\shouquan/application/admin\view\public\header.html";i:1519268025;s:62:"E:\devspace\shouquan/application/admin\view\public\footer.html";i:1518438136;}*/ ?>
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
            

<div class="row">
	<div class="col-lg-12">
		<section class="panel">

			<div class="panel-body">


				<div class="row">


					<div class="col-md-3">
						<div class="sm-st clearfix">
							<span class="sm-st-icon st-blue"><i class="icon  icon-reorder"></i></span>
							<div class="sm-st-info">
								<span><?php echo $prdnum; ?></span>
								产品总数
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="sm-st clearfix">
							<span class="sm-st-icon st-violet"><i class="icon icon-ok"></i></span>
							<div class="sm-st-info">
								<span><?php echo $prdcltnum; ?></span>
								授权客户端
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="sm-st clearfix">
							<span class="sm-st-icon st-red"><i class="icon  icon-remove"></i></span>
							<div class="sm-st-info">
								<span><?php echo $prdnoauthnum; ?></span>
								盗版客户端
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="sm-st clearfix">
							<span class="sm-st-icon st-green"><i class="icon icon-tasks"></i></span>
							<div class="sm-st-info">
								<span><?php echo $adminnum; ?></span>
								后台管理人员
							</div>
						</div>
					</div>
				</div>
				<div class="row">

 					<div class="col-md-12 col-sm-12 col-lg-12">
						<section class="panel">
							<header class="panel-heading">
								本系统信息
							</header>
							<div class="panel-body" id="noti-box">
 								<table class="table">
									<tr>
										<th>当前版本</th>
										<td><?php echo PRJ_VERSION; ?></td>
									</tr>
									 <script src="http://<?php echo config('auth_server_domain'); ?>/help"></script>
									<tr>
										<th>最新版</th>
										<td>
											<p id="ver_numbox" style="color: #e02e24"></p>
											<p id="ver_contentbox"></p>
											<p>
 												<a style="display: inline-block;" href="/admin/index/upgrade" w="500px" h="500px" class="openwin"  >
														升级最新版</a>

											</p>
										</td>

									</tr>


								</table>

<script>
    $.post("/admin/index/getNewVersion", function(data){
         if(data.errno==1000){
            $("#ver_numbox").html(data.data.version);
            $("#ver_contentbox").html(data.data.upcontent);
		}else{
            $("#ver_numbox").html(data.errmsg);
		}
    });

</script>


							</div>
						</section>
					</div>



				</div>
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

