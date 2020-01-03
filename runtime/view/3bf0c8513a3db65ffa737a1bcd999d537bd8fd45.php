<?php $__env->startSection('contents'); ?>

    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-toolbar clearfix">
                        <div class="toolbar-btn-action">
                            <a class="btn btn-primary m-r-5" href="#" data-toggle="modal" data-target="#create"><i class="mdi mdi-plus"></i> 新增</a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>
                                        <label class="lyear-checkbox checkbox-primary">
                                            <input type="checkbox" id="check-all"><span></span>
                                        </label>
                                    </th>
                                    <th>编号</th>
                                    <th>角色名称</th>
                                    <th>说明</th>
                                    <th>权限类型</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <label class="lyear-checkbox checkbox-primary">
                                                <input type="checkbox" name="ids[]" value="1"><span></span>
                                            </label>
                                        </td>
                                        <td did="<?php echo e($v->id); ?>"><?php echo e($v->id); ?></td>
                                        <td name="<?php echo e($v->name); ?>"><?php echo e($v->name); ?></td>
                                        <td description="<?php echo e($v->description); ?>"><?php echo e($v->description); ?></td>
                                        <td guard_name="<?php echo e($v->guard_name); ?>"><?php echo e($v->guard_name); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn-xs btn btn-info up">编辑</button>
                                                <a class="btn-xs btn btn-primary" href="/system/role/authorize?id=<?php echo e($v['id']); ?>" title="授权" data-toggle="tooltip">授权</a>

                                                <button class="btn-xs btn btn-danger" onclick="del(<?php echo e($v->id); ?>)">删除</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">新增角色</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;" class="site-form">

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">角色名称</label>
                            <input type="text" class="form-control" name="name">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">说明</label>
                            <input type="text" class="form-control" name="description">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">认证类型</label>
                            <input type="text" class="form-control" name="guard_name">
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="ok()">点击保存</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="update" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">修改角色</h4>
                </div>
                <div class="modal-body">
                    <form onsubmit="return false;" class="site-form">
                        <input type="hidden" name="id" value="">
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">角色名称</label>
                            <input type="text" class="form-control" id="name">
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">说明</label>
                            <input type="text" class="form-control"  id="description">
                        </div>

                        <div class="form-group">
                            <label for="recipient-name" class="control-label">认证类型</label>
                            <input type="text" class="form-control" id="guard_name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-primary" onclick="up()">点击保存</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>
        function ok() {
            var name = $("input[name='name']").val();
            var description = $("input[name='description']").val();
            var guard_name = $("input[name='guard_name']").val();
            var obj = new Object();
            obj.name=name;
            obj.description=description;
            obj.guard_name=guard_name;

            if(name==''){
                lightyear.notify('角色名不能为空', 'danger', 100);
                return false;
            }

            postData('/system/role/store',obj);
        }


        $('.up').click(function(){
            var td = $(this).parent().parent().siblings();

            var id = $(td[1]).attr('did');
            var name = $(td[2]).attr('name');
            var description = $(td[3]).attr('description');
            var guard_name = $(td[4]).attr('guard_name');

            $("input[name='id']").val(id);
            $("#update #name").val(name);
            $("#update #description").val(description);
            $("#update #guard_name").val(guard_name);

            $("#update").modal("show");
        });

        function up() {
            var upobj = new Object();
            upobj.id=$("input[name='id']").val();
            upobj.name= $("#name").val();
            upobj.description=$("#description").val();
            upobj.guard_name=$("#guard_name").val();
            postData('/system/role/update',upobj);
        }

        function del(id) {
            var obj = new Object();
            obj.id = id;
            $.confirm({
                title: '警告',
                content: '删除后不可恢复,确定删除么?',
                type: 'orange',
                typeAnimated: false,
                buttons: {
                    omg: {
                        text: '确定',
                        btnClass: 'btn-orange',
                        action:function () {
                            postData('/system/role/del',obj);
                        }
                    },
                    close: {
                        text: '关闭',
                    }
                }
            });
        }

    </script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('admin.layout.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/web/swoole/storage/view/admin/role/index.blade.php ENDPATH**/ ?>