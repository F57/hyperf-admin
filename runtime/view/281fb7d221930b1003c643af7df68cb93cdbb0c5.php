<?php $__env->startSection('css'); ?>
    <link href="/fileinput/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
    <link href="/fileinput/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
    <style>
        .theme-fa{
            display: none;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>


    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <div class="edit-avatar">
                            <img <?php if($uinfo['photo'] != ''): ?> src="<?php echo e($uinfo['photo']); ?>" <?php else: ?> src="/images/users/avatar.jpg" <?php endif; ?> class="img-avatar">
                            <div class="avatar-divider"></div>
                            <div class="edit-avatar-content">
                                <button class="btn btn-default uplo">修改头像</button>
                                <input id="input-ke-2" name="file" type="file" style="display: none">
                                <?php if($uinfo['photo'] != ''): ?>
                                    <input type="hidden" class="img" id="img" value="<?php echo e($uinfo['photo']); ?>" name="img">
                                <?php else: ?>

                                    <input type="hidden" class="img" id="img" value="/images/users/avatar.jpg" name="img">
                                <?php endif; ?>
                            </div>
                        </div>
                        <hr>
                        <form onsubmit="return false;" class="site-form">
                            <div class="form-group">
                                <label for="nickname">昵称</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="输入您的昵称" value="<?php echo e($list['name']); ?>">
                            </div>

                            <div class="form-group">
                                <label for="email">邮箱</label>
                                <input type="text" class="form-control" name="email" id="email" value="<?php echo e($list['email']); ?>"/>
                                <small id="emailHelp" class="form-text text-muted">请保证您填写的邮箱地址是正确的。</small>
                            </div>

                            <button class="btn btn-block btn-primary" type="submit" name="submit" onclick="sub()">确定</button>
                        </form>

                    </div>
                </div>
            </div>

        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script src="/fileinput/themes/explorer-fas/theme.js" type="text/javascript"></script>
    <script src="/fileinput/js/plugins/sortable.js" type="text/javascript"></script>
    <script src="/fileinput/js/fileinput.js" type="text/javascript"></script>
    <script src="/fileinput/js/locales/zh.js" type="text/javascript"></script>
    <script src="/fileinput/themes/explorer-fa/theme.js" type="text/javascript"></script>
    <script src="/fileinput/themes/fa/theme.js"></script>
    <script>
        $(function () {
            $('form').bootstrapValidator({
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    img: {
                        validators: {
                            notEmpty: {
                                message: '头像不能为空'
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
                    name: {
                        validators: {
                            notEmpty: {
                                message: '昵称不能为空'
                            }
                        }
                    }
                },
            });
        });


        $('.uplo').click(function () {
            $("#input-ke-2").click();
        });

        $("#input-ke-2").fileinput({
            language:'zh',
            theme: 'fa',
            uploadUrl:'/common/img',
            showCaption:false,
            showPreview:false,
            showRemove:false,
            showUpload:false,
            showCancel:false,
            showClose:false,
            uploadAsync:true,
            showUploadedThumbs:false,
            uploadExtraData:{ 'x-csrf-token':$('meta[name="csrf-token"]').attr('content') },
            previewClass:'btn btn-default uplo',
            allowedFileExtensions: ['jpg', 'png','jpeg'],
        }).on("filebatchselected", function(event, files) {
            $(event.target).fileinput('upload');
        }).on("fileuploaded", function(event, data) {

            var result = data.response;
            if(result.code==200){
                lightyear.notify('头像上传成功~', 'success', 100);
                $('.img-avatar').attr('src',result.data.path);
                $('.img').val(result.data.path);
                $("meta[name='csrf-token']").attr('content',result.data.csrf);
            }else{
                var msg= result.message;
                lightyear.notify(msg, 'danger', 100);
            }
        });


        function sub() {

            var username = $("input[name='name']").val();
            var email = $("input[name='email']").val();
            var img = $("input[name='img']").val();

            lightyear.loading('show');
            $.ajax({
                url : '/system/admin/info',
                type : "POST",
                data : {'name':username,'email':email,'img':img},
                dataType : "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success : function(result) {
                    lightyear.loading('hide');
                    if(result.code==200){
                        lightyear.notify('修改成功，页面即将自动刷新~', 'success', 5000);
                        location.reload();
                    }else{
                        var msg= result.message;
                        lightyear.notify(msg, 'danger', 100);
                        $('form').bootstrapValidator('disableSubmitButtons', false);
                    }

                },
                error:function(msg){
                    lightyear.notify('连接超时,请重试~', 'danger', 100);
                    lightyear.loading('hide');
                    $('form').bootstrapValidator('disableSubmitButtons', false);
                }
            })
        }
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/web/swoole/storage/view/admin/admin/profile.blade.php ENDPATH**/ ?>