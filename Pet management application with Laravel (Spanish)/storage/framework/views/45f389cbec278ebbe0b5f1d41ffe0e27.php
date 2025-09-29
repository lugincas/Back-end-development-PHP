

<?php $__env->startSection('titulo', 'Inicio de sesión'); ?>

<?php $__env->startSection('contenido'); ?>
    <?php if(auth()->guard()->check()): ?>

    <h1 class="exito">¡Ya has iniciado sesión!</h1>
    <a class="enlaceBoton" href="<?php echo e(route('zonaprivada')); ?>">Ir a zona privada</a>

    <?php endif; ?>

    <?php if(auth()->guard()->guest()): ?>
    <h2>Iniciar sesión</h2>
    <?php if($errors->any()): ?>
    <div style="color: red;">
        <H2>ERRORES:</H2>
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
    <?php endif; ?>

    <!-- Formulario de inicio de sesión -->
    <fieldset class="estiloLogin">
        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>
            <label for="email">Correo Electrónico</label>
            <br>
            <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>">
            <hr>
            <label for="password">Contraseña</label>
            <br>
            <input type="password" id="password" name="password"><hr>
            <input class="enlaceBoton" type="submit" value="Login">
        </form>
    </fieldset>
    <?php endif; ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('basePublica', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dwes05\dwes05\resources\views/auth/login.blade.php ENDPATH**/ ?>