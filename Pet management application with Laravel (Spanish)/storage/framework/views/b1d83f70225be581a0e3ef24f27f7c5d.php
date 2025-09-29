

<?php $__env->startSection('titulo', '¡Mascota añadida!'); ?>

<?php $__env->startSection('contenido'); ?>

    <h2>¡La mascota <span class="exito"><?php echo e($nuevaMascotaLCU->nombre); ?></span> se ha añadido con éxito! || <span class="exito">Luis Ginés Casanova de Utrilla</span></h2>
    <br>
    <A class="enlaceBoton" href="<?php echo e(route('formmascotaLCU')); ?>">¡Añade otra mascota!</A>
    <br>
    <A class="enlaceBotonPrivado" href="<?php echo e(route('zonaprivada')); ?>">Volver a la zona privada</A>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('basePrivada', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dwes05\dwes05\resources\views/privada/mascotaniadidaLCU.blade.php ENDPATH**/ ?>