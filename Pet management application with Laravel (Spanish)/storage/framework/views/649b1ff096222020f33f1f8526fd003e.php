

<?php $__env->startSection('titulo', 'Página principal (Privada)'); ?>

<?php $__env->startSection('contenido'); ?>

<?php if(auth()->guard()->check()): ?>
<br>
<div>
    <A class="enlaceBoton" href="<?php echo e(route('zonapublica')); ?>">Ir a la zona pública</A>
    <A class="enlaceBotonLogout" href="<?php echo e(route('logout')); ?>">Cerrar sesión</A>
</div>
<br>
<H2>¡Hola<span class="exito"> <?php echo e(Auth::user()->name); ?> </span>! Bienvenido/a a la página principal de la zona PRIVADA.</H2>
<?php if(count($mascotasLCU) !== 0): ?> <!-- Si hay mascotas, desplegamos el listado -->
<H2>¡Tus mascotas!</H2>
<table>
    <thead>
        <tr>
            <th class="celdaHeadPrivada">Id</th>
            <th class="celdaHeadPrivada">Nombre</th>
            <th class="celdaHeadPrivada">Descripcion</th>
            <th class="celdaHeadPrivada">Tipo</th>
            <th class="celdaHeadPrivada">#Me Gustas</th>
            <th class="celdaHeadPrivada">Propietario</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $mascotasLCU; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mascota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td class="celdaPrivada"><?php echo e($mascota->id); ?></td>
            <td class="celdaPrivada"><?php echo e($mascota->nombre); ?></td>
            <td class="celdaPrivada"><?php echo e($mascota->descripcion); ?></td>
            <td class="celdaPrivada"><?php echo e($mascota->tipo); ?></td>
            <td class="celdaPrivada"><?php echo e($mascota->megusta); ?></td>
            <td class="celdaPrivada"><?php echo e($mascota->user->name); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<br>
<?php else: ?> <!-- Si no hay mascotas, avisamos de ello -->
<H2>¡No tienes mascotas! Añade tu primera mascota pulsando en el botón de abajo:</H2>
<?php endif; ?>
<A class="enlaceBotonPrivado" href="<?php echo e(route('formmascotaLCU')); ?>">¡Añade una nueva mascota!</A>

<?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('basePrivada', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dwes05\dwes05\resources\views/privada/principal.blade.php ENDPATH**/ ?>