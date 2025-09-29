

<?php $__env->startSection('titulo', 'Página principal (Pública)'); ?>

<?php $__env->startSection('contenido'); ?>
<div class="centrarZona">
    <H2>Bienvenido a la página principal PÚBLICA.</H2>
    <?php if(auth()->guard()->check()): ?>
    <h3 class="exito">¡Estás autenticado!</h3>
    <div>
        <A class="enlaceBoton" href="<?php echo e(route('zonaprivada')); ?>">Ir a tu zona privada</A>
    </div>
    <?php if(count($mascotasLCU) !== 0): ?> <!-- Si hay mascotas, desplegamos el listado -->
    <br>
    <H3>Listado de mascotas públicas:</H3>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Tipo</th>
                <th>#MeGusta</th>
                <th>Propietario</th>
                <th>Votar</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $mascotasLCU; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mascota): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($mascota->id); ?></td>
                <td><?php echo e($mascota->nombre); ?></td>
                <td><?php echo e($mascota->descripcion); ?></td>
                <td><?php echo e($mascota->tipo); ?></td>
                <td><?php echo e($mascota->megusta); ?></td>
                <td><?php echo e($mascota->user->name); ?></td>   
                <td>
                    <form method="post" action="<?php echo e(route('votomascota')); ?>"> <!-- Introducimos el voto mediante un formulario y un campo tipo hidden para enviar mediante POST el id de la mascota seleccionada -->
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="mascotaId" value="<?php echo e($mascota->id); ?>">
                        <input class="botonVoto" type="submit" value="¡Me gusta!">
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
    <?php else: ?> <!-- Si no hay mascotas, informamos de ello e instamos a que se añada alguna -->
    <H3>No hay mascotas públicas en este momento...</H3>
    <H3>¡Accede a tu zona privada y añade la primera!</H3>
    <?php endif; ?>
    <?php endif; ?>
    <?php if(auth()->guard()->guest()): ?>
    No estás autenticado, por favor ...
    <BR>
    <BR>
    <div>
        <A class="enlaceBoton" href="<?php echo e(route('formlogin')); ?>">Inicia sesión</A>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('basePublica', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dwes05\dwes05\resources\views/principal.blade.php ENDPATH**/ ?>