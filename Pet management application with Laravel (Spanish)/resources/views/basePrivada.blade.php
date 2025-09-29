<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=100%, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('titulo') - Mascotas y Más Cosas</title>
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}" />
</head>

<body>
    <header id="headerPrivado">
        <h1 class="contorno">¡Mascotas y más cosas!</h1>
        <h2>ZONA PRIVADA</h2>
        <h3>Luis Ginés Casanova de Utrilla</h3>
    </header>
    <hr>
    <main>

        @yield('contenido')
    </main>

    <footer id="footerPrivado">
        
        Luis Ginés Casanova de Utrilla - Desarrollo Web en Entorno Servidor (2024-2025)
    </footer>

</body>

</html>