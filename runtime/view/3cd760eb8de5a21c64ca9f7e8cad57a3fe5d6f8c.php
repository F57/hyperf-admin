<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>后台管理系统</title>
    <link rel="icon" href="/favicon.ico" type="image/ico">
    <meta name="author" content="yinqi">
    <meta name="csrf-token" content="<?php echo e($csrf); ?>" />
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="/css/style.min.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/bootstrapValidator.css" rel="stylesheet">
    <link rel="stylesheet" href="/js/jconfirm/jquery-confirm.min.css">
    <?php $__env->startSection('css'); ?>
    <?php echo $__env->yieldSection(); ?>
</head>

<body>
<div class="lyear-layout-web">
    <div class="lyear-layout-container">
        <!--左侧导航-->
        <aside class="lyear-layout-sidebar">

            <!-- logo -->
            <div id="logo" class="sidebar-header">
                <a href="/system"><img src="/images/logo-sidebar.png" title="LightYear" alt="LightYear" /></a>
            </div>
            <div class="lyear-layout-sidebar-scroll">

                <nav class="sidebar-main">
                    <ul class="nav nav-drawer">
                        <li class="nav-item active"> <a href="/system"><i class="mdi mdi-home"></i> 后台首页</a> </li>
                        <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="nav-item nav-item-has-subnav">
                                <a href="javascript:void(0)"><i class="mdi <?php echo e($v['icon']); ?>"></i><?php echo e($v['display_name']); ?></a>
                                <?php if(isset($v['child'])): ?>
                                    <ul class="nav nav-subnav">
                                        <?php $__currentLoopData = $v['child']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kk=>$vv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li> <a href="<?php echo e($vv['url']); ?>"><?php echo e($vv['display_name']); ?></a> </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php endif; ?>

                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </nav>

                <div class="sidebar-footer">
                    <p class="copyright">Copyright &copy; 2019. <a target="_blank" href="https://www.yuhelove.com">博客</a> All rights reserved.</p>
                </div>
            </div>

        </aside>
        <!--End 左侧导航-->

        <!--头部信息-->
        <header class="lyear-layout-header">

            <nav class="navbar navbar-default">
                <div class="topbar">

                    <div class="topbar-left">
                        <div class="lyear-aside-toggler">
                            <span class="lyear-toggler-bar"></span>
                            <span class="lyear-toggler-bar"></span>
                            <span class="lyear-toggler-bar"></span>
                        </div>
                        <span class="navbar-page-title"> 后台首页 </span>
                    </div>

                    <ul class="topbar-right">
                        <li class="dropdown dropdown-profile">
                            <a href="javascript:void(0)" data-toggle="dropdown">
                                <?php if($uinfo['photo'] != ''): ?>
                                    <img class="img-avatar img-avatar-48 m-r-10" src="<?php echo e($uinfo['photo']); ?>"/>
                                <?php else: ?>
                                    <img class="img-avatar img-avatar-48 m-r-10" src="/images/users/avatar.jpg"/>
                                <?php endif; ?>
                                <span><?php echo e($uinfo['name']); ?><span class="caret"></span></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right">
                                <li> <a href="/system/admin/profile"><i class="mdi mdi-account"></i> 个人信息</a> </li>
                                <li> <a href="javascript:void(0)" data-toggle="modal" data-target="#pwd"><i class="mdi mdi-lock-outline"></i> 修改密码</a> </li>
                                
                                <li class="divider"></li>
                                <li> <a href="javascript:void(0)" onclick="logout()"><i class="mdi mdi-logout-variant"></i> 退出登录</a> </li>
                            </ul>
                        </li>
                    </ul>

                </div>
            </nav>

        </header>
        <div class="modal fade" id="pwd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">修改密码</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">密码</label>
                                <input type="text" class="form-control pwd">
                            </div>
                            <div class="form-group">
                                <label for="recipient-name" class="control-label">确认密码</label>
                                <input type="text" class="form-control pwd_confim">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="button" class="btn btn-primary" onclick="pwd()">点击保存</button>
                    </div>
                </div>
            </div>
        </div>
        <!--End 头部信息-->
            <main class="lyear-layout-content">
                <div class="card-body">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        这里总要写一些东西的,要不然感觉不好看.
                    </div>
                </div>
                <?php $__env->startSection('contents'); ?>

                <?php echo $__env->yieldSection(); ?>
            </main>

    </div>
</div>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="/js/main.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-notify.min.js"></script>
<script type="text/javascript" src="/js/lightyear.js"></script>
<script type="text/javascript" src="/js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="/js/jconfirm/jquery-confirm.min.js"></script>
<script>
    function pwd()
    {
        var pwd = $('.pwd').val();
        var pwd_confim = $('.pwd_confim').val();
        if(pwd=='' || pwd_confim=='')
        {
            lightyear.notify('密码不能为空', 'danger', 100);
            return false;
        }
        if(pwd != pwd_confim){
            lightyear.notify('两次密码不一致', 'danger', 100);
            return false;
        }
        lightyear.loading('show');
        $.ajax({
            url : '/system/admin/pwd',
            type : "POST",
            dataType : "json",
            data: {
                'password': pwd,
                'password_confirmation':pwd_confim
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success : function(result) {
                lightyear.loading('hide');
                if(result.code==200){
                    lightyear.notify('操作成功，页面即将自动刷新~', 'success', 5000);
                    location.reload();
                }else{
                    var msg= result.message;
                    lightyear.notify(msg, 'danger', 100);
                }
            },
            error:function(msg){
                lightyear.notify('连接超时,请重试~', 'danger', 100);
                lightyear.loading('hide');
            }
        })
    }

    function logout() {
        lightyear.loading('show');
        $.ajax({
            url : '/system/login/logout',
            type : "POST",
            dataType : "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success : function(result) {
                lightyear.loading('hide');
                if(result.code==200){
                    lightyear.notify('退出成功，页面即将自动刷新~', 'success', 5000);
                    window.location.href='/system/login';
                }else{
                    var msg= result.message;
                    lightyear.notify(msg, 'danger', 100);
                }

            },
            error:function(msg){
                lightyear.notify('连接超时,请重试~', 'danger', 100);
                lightyear.loading('hide');
            }
        })
    }
    function postData(url,data) {
        lightyear.loading('show');
        $.ajax({
            url : url,
            type : "POST",
            data : data,
            dataType : "json",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            success : function(result) {
                lightyear.loading('hide');
                if(result.code==200){
                    lightyear.notify('操作成功，页面即将自动刷新~', 'success', 5000);
                    location.reload();
                }else{
                    var msg= result.message;
                    lightyear.notify(msg, 'danger', 100);
                }

            },
            error:function(msg){
                lightyear.notify('连接超时,请重试~', 'danger', 100);
                lightyear.loading('hide');
            }
        })
    }
</script>
<?php $__env->startSection('js'); ?>
<?php echo $__env->yieldSection(); ?>
</body>
</html><?php /**PATH /data/web/swoole/storage/view/admin/layout/index.blade.php ENDPATH**/ ?>