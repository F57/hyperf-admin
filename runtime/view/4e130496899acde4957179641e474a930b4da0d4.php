
<?php $__env->startSection('css'); ?>
    <link href="/css/materialdesignicons.min.css" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('contents'); ?>

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header"><h4>设置权限</h4></div>
                    <div class="card-body">

                        <form action="#!" method="post">
                            <div class="form-group">
                                <label for="example-text-input">角色名称</label>
                                <input class="form-control" value="<?php echo e($roleInfo['name']); ?>" type="text" name="role-input" placeholder="角色名称" disabled="disabled">
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>
                                            <label class="lyear-checkbox checkbox-primary">
                                                <input name="checkbox" type="checkbox" id="check-all">
                                                <span> 全选</span>
                                            </label>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $menuList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <label class="lyear-checkbox checkbox-primary">
                                                    <input name="rules[]" type="checkbox" class="checkbox-parent" dataid="id-<?php echo e($v['id']); ?>" value="<?php echo e($v['id']); ?>" <?php if(in_array($v['id'],$permissions)): ?> checked="checked"<?php endif; ?>>
                                                    <span> <?php echo e($v['display_name']); ?></span>
                                                </label>
                                            </td>
                                        </tr>
                                        <?php if(count($v['child']) != 0): ?>
                                            <?php $__currentLoopData = $v['child']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="p-l-20">
                                                        <label class="lyear-checkbox checkbox-primary">
                                                            <input name="rules[]" type="checkbox" class="checkbox-parent checkbox-child" dataid="id-<?php echo e($v['id']); ?>-<?php echo e($vv['id']); ?>" value="<?php echo e($vv['id']); ?>" <?php if(in_array($vv['id'],$permissions)): ?> checked="checked"<?php endif; ?>>
                                                            <span> <?php echo e($vv['display_name']); ?></span>
                                                        </label>
                                                    </td>
                                                </tr>
                                                <?php if(count($vv['child']) != 0): ?>
                                                    <tr>
                                                        <td class="p-l-40">
                                                            <?php $__currentLoopData = $vv['child']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vvv): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <label class="lyear-checkbox checkbox-primary checkbox-inline">
                                                                    <input name="rules[]" type="checkbox" class="checkbox-child" dataid="id-<?php echo e($v['id']); ?>-<?php echo e($vv['id']); ?>-<?php echo e($vvv['id']); ?>" value="<?php echo e($vvv['id']); ?>" <?php if(in_array($vvv['id'],$permissions)): ?> checked="checked"<?php endif; ?>>
                                                                    <span> <?php echo e($vvv['display_name']); ?></span>
                                                                </label>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="form-group col-md-12">
                                    <button type="button" class="btn btn-primary ajax-post" onclick="ok()">确 定</button>
                                    <button type="button" class="btn btn-default" onclick="javascript:history.back(-1);return false;">返 回</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script type="text/javascript" src="/js/chosen.jquery.min.js"></script>
    <script type="text/javascript">
        $(function(){
            //动态选择框，上下级选中状态变化
            $('input.checkbox-parent').on('change', function(){
                var dataid = $(this).attr("dataid");
                $('input[dataid^=' + dataid + '-]').prop('checked', $(this).is(':checked'));
            });
            $('input.checkbox-child').on('change', function(){
                var dataid = $(this).attr("dataid");
                dataid = dataid.substring(0, dataid.lastIndexOf("-"));
                var parent = $('input[dataid=' + dataid + ']');
                if($(this).is(':checked')){
                    parent.prop('checked', true);
                    //循环到顶级
                    while(dataid.lastIndexOf("-") != 2){
                        dataid = dataid.substring(0, dataid.lastIndexOf("-"));
                        parent = $('input[dataid=' + dataid + ']');
                        parent.prop('checked', true);
                    }
                }else{
                    //父级
                    if($('input[dataid^=' + dataid + '-]:checked').length == 0){
                        parent.prop('checked', false);
                        //循环到顶级
                        while(dataid.lastIndexOf("-") != 2){
                            dataid = dataid.substring(0, dataid.lastIndexOf("-"));
                            parent = $('input[dataid=' + dataid + ']');
                            if($('input[dataid^=' + dataid + '-]:checked').length == 0){
                                parent.prop('checked', false);
                            }
                        }
                    }
                }
            });
        });
        function ok() {
            var obj =$("input[name='rules[]']");
            var check_arr = [];
            for (var i = 0; i < obj.length; i++) {
                if (obj[i].checked)
                    check_arr.push(obj[i].value);
            }
            if(check_arr.length==0){
                lightyear.notify('权限不能为空~', 'danger', 100);
                return false;
            }
            lightyear.loading('show');
            $.ajax({
                url : '/system/role/auth/<?php echo e($id); ?>',
                type : "POST",
                data : {'ids':check_arr},
                dataType : "json",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success : function(result) {
                    lightyear.loading('hide');
                    if(result.code==200){
                        lightyear.notify('添加成功，页面即将自动刷新~', 'success', 5000);
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/web/swoole/storage/view/admin/role/authorize.blade.php ENDPATH**/ ?>