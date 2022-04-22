<?php $__env->startSection('tbody'); ?>
    <?php $__currentLoopData = $setup['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($item->name); ?></td>
            <td><?php echo e($item->size); ?></td>
            <td><?php echo e($item->restoarea?$item->restoarea->name:""); ?></td>
            <td>
            <?php
                $param=[];
                $param[$setup['parameter_name']]=$item->id;
            ?>
             <?php if($setup['hasQR']): ?>
                <a href="<?php echo e(route('download.menu')."?table_id=".$item->id); ?>" class="btn btn-success btn-sm"><span class="btn-inner--icon"><i class="fas fa-qrcode"></i></span> <?php echo e(__('QR')); ?></a>
            <?php endif; ?>
            <a href="<?php echo e(route( $setup['webroute_path']."edit",$param)); ?>" class="btn btn-primary btn-sm"><span class="btn-inner--icon"><i class="ni ni-ruler-pencil"></i></span> <?php echo e(__('crud.edit')); ?></a>
            <a href="<?php echo e(route( $setup['webroute_path']."delete",$param)); ?>" class="btn btn-danger btn-sm"><span class="btn-inner--icon"><i class="ni ni-fat-remove"></i></span> <?php echo e(__('crud.delete')); ?></a>
            </td>
        </tr> 
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('general.index', $setup, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\qrmenu\resources\views/tables/index.blade.php ENDPATH**/ ?>