<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <title>后台</title>
    <link rel="icon" href="favicon.ico" type="image/ico">
    <meta name="csrf-token" content="<?php echo e($csrf); ?>" />
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="/css/style.min.css" rel="stylesheet">
    <link href="/css/animate.css" rel="stylesheet">
    <link href="/css/bootstrapValidator.css" rel="stylesheet">
    <style>
        .lyear-wrapper {
            position: relative;
        }
        .lyear-login {
            display: flex !important;
            min-height: 100vh;
            align-items: center !important;
            justify-content: center !important;
        }
        .login-center {
            background: #fff;
            min-width: 38.25rem;
            padding: 2.14286em 3.57143em;
            border-radius: 5px;
            margin: 2.85714em 0;
        }
        .login-header {
            margin-bottom: 1.5rem !important;
        }
        .login-center .has-feedback.feedback-left .form-control {
            padding-left: 38px;
            padding-right: 12px;
        }
        .login-center .has-feedback.feedback-left .form-control-feedback {
            left: 0;
            right: auto;
            width: 38px;
            height: 38px;
            line-height: 38px;
            z-index: 4;
            color: #dcdcdc;
        }
        .login-center .has-feedback.feedback-left.row .form-control-feedback {
            left: 15px;
        }
    </style>
</head>

<body>
<div class="row lyear-wrapper">
    <div class="lyear-login">
        <div class="login-center">
            <div class="login-header text-center">
                <a href="javascript:void(0);"> <img alt="light year admin" src="/images/logo-sidebar.png"> </a>
            </div>
            <form class="form" onsubmit="return false;">
                <div class="form-group has-feedback feedback-left">
                    <input type="text" placeholder="请输入您的用户名" class="form-control" name="email" id="email" />
                    <span class="mdi mdi-account form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-feedback feedback-left">
                    <input type="password" placeholder="请输入密码" class="form-control" id="passwd" name="passwd" />
                    <span class="mdi mdi-lock form-control-feedback" aria-hidden="true"></span>
                </div>
                <div class="form-group has-feedback feedback-left row">
                    <div class="col-xs-7">
                        <input type="text" name="captcha" class="form-control" placeholder="验证码">
                        <span class="mdi mdi-check-all form-control-feedback" aria-hidden="true"></span>
                    </div>
                    <div class="col-xs-5">
                        <img src="/system/captchas?t=111" class="pull-right" id="captcha" style="cursor: pointer;" onclick="this.src='/system/captchas?t'+'='+Math.random();" title="点击刷新" alt="captcha">
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-block btn-primary" type="submit" name="submit" onclick="sub()">立即登录</button>
                </div>
            </form>
            <hr>
            <footer class="col-sm-12 text-center">
                <p class="m-b-0">Copyright © 2019 <a href="https://www.yuhelove.com">博客</a>. All right reserved</p>
            </footer>
        </div>
    </div>
</div>
<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script src="/js/bootstrap-notify.min.js"></script>
<script type="text/javascript" src="/js/lightyear.js"></script>
<script type="text/javascript" src="/js/main.min.js"></script>
<script src="/js/bootstrapValidator.min.js"></script>

<script type="text/javascript">

    $(function () {
        $('form').bootstrapValidator({
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                passwd: {
                    validators: {
                        notEmpty: {
                            message: '密码不能为空'
                        }
                    }
                },
                email: {
                    validators: {
                        notEmpty: {
                            message: '邮箱地址不能为空'
                        },
                        emailAddress: {
                            message: '邮箱地址格式有误'
                        }
                    }
                },
                captcha: {
                    validators: {
                        notEmpty: {
                            message: '验证码不能为空'
                        }
                    }
                }
            },
        });
    });

    function sub() {
        var passwd = $("input[name='passwd']").val();
        var email = $("input[name='email']").val();
        var captcha = $("input[name='captcha']").val();
        $.ajax({
            url: '/system/login',
            type: 'POST',
            dataType:"json",
            async:true,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            data: {
                'email': email,
                'passwd':passwd,
                'captcha':captcha,
            },
            success: function (info) {
                if(info['code']==200){
                    lightyear.notify('修改成功，页面即将自动跳转~', 'success', 3000);
                    window.location.href='/system/index';
                }else{
                    lightyear.notify(info['message']+'~', 'danger', 100);
                    $('form').bootstrapValidator('disableSubmitButtons', false);
                    return false;
                }

            }
        })
    }
</script>
</body>
</html><?php /**PATH /data/web/swoole/storage/view/admin/login/index.blade.php ENDPATH**/ ?>