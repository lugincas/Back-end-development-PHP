<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=100%, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $__env->yieldContent('titulo'); ?> - Mascotas y Más Cosas</title>
    <link rel="stylesheet" href="<?php echo e(asset('css/estilo.css')); ?>" />
</head>

<body>
    <header>
        <h1 class="contorno">¡Mascotas y más cosas!</h1>
        <h2>ZONA PÚBLICA</h2>
        <h3>Luis Ginés Casanova de Utrilla</h3>
    </header>
    <hr>
    <main>

        <?php echo $__env->yieldContent('contenido'); ?>
    </main>

    <footer>
        
        Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor (2024-2025)
    </footer>

</body>

</html><?php /**PATH C:\xampp\htdocs\dwes05\dwes05\resources\views/basePublica.blade.php ENDPATH**/ ?>