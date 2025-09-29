<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration // Creamos una clase anónima, de un sólo uso
{
    public function up(): void
    {
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', length: 50);
            $table->string('descripcion', length: 250);
            $table->enum('tipo', ['Perro','Gato','Pájaro','Dragón','Conejo','Hamster','Tortuga','Pez','Serpiente']);
            $table->enum('publica', ['Si','No']);
            $table->integer('megusta')->default(0);
            // Cada mascota pertenece a un usuario, si se borra el usuario o se actualiza su id, se actualiza en cascada
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
                ->on('users')->cascadeOnDelete()->cascadeOnUpdate();
    
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};

