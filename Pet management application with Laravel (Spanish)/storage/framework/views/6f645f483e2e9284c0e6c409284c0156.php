

<?php $__env->startSection('titulo', 'Formulario para añadir mascotas'); ?>

<?php $__env->startSection('contenido'); ?>
<BR>
<A class="enlaceBotonPrivado" href="<?php echo e(route('zonaprivada')); ?>">Volver a la zona privada</A><BR>

    <h2>¡Añade una nueva mascota!</h2>
    <?php if($errors->any()): ?>
    <H3>Se han producido errores en el formulario:</H3>
    <UL>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <LI><?php echo e($error); ?></LI>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </UL>
    <?php endif; ?>
    <div>
        <fieldset class="estiloFormulario">
            <form method='post' action='<?php echo e(route("nuevamascotaLCU")); ?>'>
                <?php echo csrf_field(); ?>
                <label class="tituloFormulario" for="nombre">Nombre de la mascota</label><br />
                <input type='text' name='nombre' required='required'><br />
                <hr>
                <label for="descripcion">Descripción</label>
                <br />
                <textarea name='descripcion' rows="5" cols="40"
                    placeholder="Escribe aquí la descripción de tu mascota..." required='required'></textarea><br />
                <hr>
                <label for="tipo">Tipo de mascota</label><br />
                <input type="radio" name="tipo" value="perro" />Perro
                <input type="radio" name="tipo" value="gato" />Gato
                <input type="radio" name="tipo" value="pajaro" />Pájaro<br>
                <input type="radio" name="tipo" value="dragon" />Dragón
                <input type="radio" name="tipo" value="conejo" />Conejo
                <input type="radio" name="tipo" value="hamster" />Hámster<br>
                <input type="radio" name="tipo" value="tortuga" />Tortuga
                <input type="radio" name="tipo" value="pez" />Pez
                <input type="radio" name="tipo" value="serpiente" />Serpiente
                <br />
                <hr>
                <label for="publica">¿Pública?</label><br />
                <input type="radio" name="publica" value="Si" />Sí
                <input type="radio" name="publica" value="No" />No
                <br />
                <br />
                <input class="enlaceBoton" type='submit' value='¡Añadir!'>
            </form>

        </fieldset>
    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('basePrivada', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\dwes05\dwes05\resources\views/privada/formmascotaLCU.blade.php ENDPATH**/ ?>