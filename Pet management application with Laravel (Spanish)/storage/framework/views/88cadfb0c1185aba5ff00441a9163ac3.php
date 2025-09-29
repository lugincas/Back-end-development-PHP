

<?php $__env->startSection('titulo', '¡Mascota añadida!'); ?>

<?php $__env->startSection('contenido'); ?>

<?php if($mascotaActualizadaLCU->user->name !== auth()->user()->name): ?> <!-- Si la mascota valorada no pertenece al usuario autenticado, se informa de la operación -->
    <h2>¡<span class="exito"><?php echo e($mascotaActualizadaLCU->nombre); ?></span> ha recibido un like!</h2>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Tipo</th>
                <th>#Me Gustas</th>
                <th>Propietario</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo e($mascotaActualizadaLCU->id); ?></td>
                <td><?php echo e($mascotaActualizadaLCU->nombre); ?></td>
                <td><?php echo e($mascotaActualizadaLCU->descripcion); ?></td>
                <td><?php echo e($mascotaActualizadaLCU->tipo); ?></td>
                <td class="exito"><?php echo e($mascotaActualizadaLCU->megusta); ?></td>
                <td><?php echo e($mascotaActualizadaLCU->user->name); ?></td>
            </tr> 
        </tbody>
    </table>
    <BR>
<?php else: ?> <!-- Si la mascota valorada pertenece al usuario autenticado, se le informa -->
<h2><span class="error"><?php echo e($mascotaActualizadaLCU->nombre); ?></span> no puede recibir el like porque es una de tus mascotas... <br>
¡Por favor, valora la mascota de otro/a usuario/a!</h2>
<?php endif; ?>
<A class="enlaceBoton" href="<?php echo e(route('zonapublica')); ?>">Volver a la zona pública</A>
    
<?php $__env->stopSection(); ?>
<?php echo $__env->make('basePublica', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dwes05\dwes05\resources\views/mascotaActualizada.blade.php ENDPATH**/ ?>