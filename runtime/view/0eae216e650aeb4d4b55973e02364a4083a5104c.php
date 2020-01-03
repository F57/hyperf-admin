<?php $__env->startSection('contents'); ?>
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <ul class="nav nav-tabs page-tabs">
                        <li class="active"> <a href="javascript:void(0);">上传</a> </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active">

                            <form onsubmit="return false;" class="edit-form">
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($v['key']=='img_upload_size'): ?>
                                        <div class="form-group">
                                            <label for="upload_image_size">图片上传大小限制</label>
                                            <input class="form-control" type="text" id="upload_image_size" name="upload_image_size" value="<?php echo e($list[$k]['value']); ?>" placeholder="请输入图片上传大小限制" >
                                            <small class="help-block">0为不限制大小.</small>
                                        </div>
                                    <?php elseif($v['key']=='img_upload_type'): ?>
                                        <div class="form-group">
                                            <label for="upload_file_size">图片上传类型限制</label>
                                            <input class="form-control" type="text" id="upload_image_type" name="upload_image_type" value="<?php echo e($list[$k]['value']); ?>" placeholder="请输入图片上传类型限制" >
                                            <small class="help-block">多个用,分割</small>
                                        </div>
                                    <?php else: ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-group">
                                    <button type="button" class="btn btn-primary m-r-5" onclick="up()">确 定</button>
                                </div>
                            </form>


                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>
    <script>
        function up() {
            var upobj = new Object();
            upobj.img_upload_size=$("input[name='upload_image_size']").val();
            upobj.img_upload_type=$("input[name='upload_image_type']").val();
            postData('/system/set/update',upobj);
        }
    </script>
<?php $__env->stopSection(); ?>




<?php echo $__env->make('admin.layout.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /data/web/swoole/storage/view/admin/set/upload.blade.php ENDPATH**/ ?>