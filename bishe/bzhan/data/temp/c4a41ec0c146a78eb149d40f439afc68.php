<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:64:"E:\devspace\shouquan/application/admin\view\product\verlist.html";i:1519472210;s:60:"E:\devspace\shouquan/application/admin\view\public\base.html";i:1519889335;s:62:"E:\devspace\shouquan/application/admin\view\public\header.html";i:1519268025;s:65:"E:\devspace\shouquan/application/admin\view\public\searchbar.html";i:1511492374;s:62:"E:\devspace\shouquan/application/admin\view\public\footer.html";i:1518438136;}*/ ?>
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

<link rel="stylesheet" type="text/css" href="__PUBLIC__/admin/css/bootstrap-editable.css">

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
                        <li><a href="/admin/index/main"><i class="icon icon-home"></i> 首页</a></li>
                        <li><a href="javascript:;"><?php echo $meta_title; ?></a></li>
                    </ul>

                </div>
            </div>
            

<div class="row">
    <div class=" col-lg-12 col-sm-12">

        <div class="pull-right"  style="margin-top: 20px;">

            <a class="btn btn-primary openwin" href="<?php echo url('admin/product/addver'); ?>"  >添加版本</a>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <div class="panel-body">
                <div class="form-inline">
    <form method="get"  role="form">

        <?php if(is_array($searchbar) || $searchbar instanceof \think\Collection || $searchbar instanceof \think\Paginator): $i = 0; $__LIST__ = $searchbar;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$field): $mod = ($i % 2 );++$i;if($field['type'] == 'hidden'): ?>
        <input type="hidden" name="<?php echo $field['name']; ?>" value="<?php echo (isset($param[$field['name']]) && ($param[$field['name']] !== '')?$param[$field['name']]:''); ?>"/>
        <?php else: ?>
        <div class="form-group">
            <!--<label class="control-label"><?php echo htmlspecialchars($field['title']); ?></label>-->
            <?php echo widget('common/Form/show',array($field,$param)); ?>
        </div>
        <?php endif; endforeach; endif; else: echo "" ;endif; ?>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">搜索</button>
        </div>

    </form>
</div>

                <table class="table table-hover">
                    <thead>

                    <tr>
                        <th>ID</th>
                        <th>产品名</th>
                        <th>版本号</th>
                        <th>更新包路径</th>
                        <th>更新内容</th>
                        <th>升级顺序</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
                    <tr>
                        <td><?php echo $item['id']; ?></td>
                        <td><?php echo $item['title']; ?></td>
                        <td> <a href="#" class="editable editable-click" data-id="<?php echo $item['id']; ?>"
                                data-name="vernum" data-type="text" data-pk="<?php echo $item['id']; ?>" data-url="<?php echo url('editvable'); ?>"><?php echo $item['vernum']; ?></a>
                        </td>
                        <td>
                             <a href="#" class="editable editable-click" data-id="<?php echo $item['id']; ?>"
                               data-name="upzipname" data-type="text" data-pk="<?php echo $item['id']; ?>" data-url="<?php echo url('editvable'); ?>"><?php echo $item['upzipname']; ?></a>
                        </td>
                        <td>
                            <a href="#" class="editable editable-click" data-id="<?php echo $item['id']; ?>"
                               data-name="upcontent" data-type="textarea" data-pk="<?php echo $item['id']; ?>" data-url="<?php echo url('editvable'); ?>"><?php echo $item['upcontent']; ?></a>
                        </td>
                        <td>
                            <a href="#" class="editable editable-click" data-id="<?php echo $item['id']; ?>"
                               data-name="up_sort" data-type="text" data-pk="<?php echo $item['id']; ?>" data-url="<?php echo url('editvable'); ?>"><?php echo $item['up_sort']; ?></a>
                        </td>
                        <td><?php if($item['status']==1): ?>
                            <span class="label label-primary">开启</span>
                            <?php else: ?>
                            <span class="label label-danger">关闭</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a title="编辑" href="<?php echo url('/admin/product/addver?id='.$item['id']); ?>" class="openwin">编辑</a>
                             <a class="confirm ajax-get" title="删除" href="<?php echo url('/admin/product/deletever',array('id'=>$item['id'])); ?>">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; else: echo "" ;endif; else: ?>
                    <td colspan="10" class="text-center"> 暂时还没有内容!</td>
                    <?php endif; ?>
                    </tbody>
                </table>
                <?php echo $page; ?>
                <div class="alert alert-info ">
                    <p>更新包路径：为了安全压缩包请用ftp上传。路径可以是本地路径,也可以是远程（假如有自己的更新包服务器 ）</p>
                    <p>升级顺序：因为不同产品版本号规则可能不一样，按后边填写从小到大更新，例如版本号1.2.1 对应1；1.2.3对应2</p>
                </div>

            </div>
        </section>
    </div>
</div>


        </section><!-- /.content -->
        <div class="footer-main">
            Copyright &copy 智云科技 <a href="http://www.zhiyunzhushou.com/" target="_blank" title="智云科技">智云科技</a>
        </div>
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

<script type="text/javascript" src="__PUBLIC__/js/bootstrap-editable.min.js"></script>
<script type="text/javascript">
    $(function () {
        $('.editable').editable();
        $('.edit_topnav').each(function (index,element) {
            $(this).editable({
                value:$(this).attr('select-val'),
                source: [
                    {value: 0, text: '否'},
                    {value: 1, text: '是'}
                ],
                validate: function (value) {
                    if(value==null){
                        return '请选择';
                    }

                }
            });
        });

    });
</script>

