<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:60:"E:\devspace\shouquan/application/index\view\index\index.html";i:1519823472;s:62:"E:\devspace\shouquan/application/index\view\public\header.html";i:1519723734;s:62:"E:\devspace\shouquan/application/index\view\public\footer.html";i:1519725880;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>智云网站授权与更新系统</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="description" content="php网站授权系统是一套有智云科技开发的集授权与更新为一体的产品授权与更新系统">
    <meta name="keywords" content="智云产品授权系统，php网站授权系统，php网站更新系统">
    <!-- bootstrap 3.0.2 -->
    <link href="__PUBLIC__/admin/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- font Awesome -->
    <link href="__PUBLIC__/admin/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="__PUBLIC__/admin/css/ionicons.min.css" rel="stylesheet" type="text/css" />

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
     </script>
<body class="skin-black">
<section class="content">

    <div class="row">

        <div class="panel-body" style="margin: 0 auto;width: 500px;margin-top: 10%">
            <section class="panel">
                <header class="panel-heading  text-center">
                    智云产品授权查询
                </header>
                <div class="panel-body">
                    <form class="form-horizontal"  action="/index/index/clientcheck">
                        <div class="form-group">
                            <label   class="col-lg-4 col-sm-4 control-label">域名</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="domain"   placeholder="例如www.zhiyunzhushou.com"  style="width: 80%" >
                                <p class="help-block"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-lg-4 col-sm-4 control-label">手机号</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control"  name="mobile"  placeholder="请输入预留手机号"  style="width: 80%"  >
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-lg-4 col-sm-4 control-label" >授权码</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control"  name="auth_code"  placeholder="请输入授权码"  style="width: 80%">
                            </div>
                        </div>
                          <div class="form-group">
                            <div class="col-lg-offset-4 col-lg-10 col-sm-offset-4 col-sm-10">
                                <button type="submit" class="btn btn-danger">查 询</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>

    </div>


    <!-- row end -->
</section>
<script type="text/javascript">
    $(function(){

        $("form").submit(function(){
            var self = $(this);
            $.post(self.attr("action"), self.serialize(), success, "json");
            return false;

            function success(data){
                console.log(data);
                if(data.code){
                    $.messager.show('已授权：有效期至'+data.data.enddt, {placement: 'center',type:'success'});

                } else {
                    $.messager.show(data.msg, {placement: 'center',type:'success'});

                }
            }
        });



    });
</script>



<div class="footer-main" style="position: absolute;bottom: 0px;width: 100%;">
    Copyright &copy 智云科技, wwww.zhiyunzhushou.com.  <a href="http://wwww.zhiyunzhushou.com/" target="_blank" title="智云科技">智云开源产品</a>
</div>

<!-- Bootstrap -->
<script src="__PUBLIC__/admin/js/bootstrap.min.js" type="text/javascript"></script>


 <!-- Director App -->
<script src="__PUBLIC__/admin/js/Director/app.js" type="text/javascript"></script>

<script src="__PUBLIC__/js/messager.js"></script>


<script src="__PUBLIC__/js/core.js"></script>


</body>
</html>
