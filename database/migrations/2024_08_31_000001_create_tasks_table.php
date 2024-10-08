<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');// Relación con usuarios
            $table->string('title');
            $table->text('description');
            $table->boolean('completed')->default(false); // Estado de la tarea (completada o no)
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
