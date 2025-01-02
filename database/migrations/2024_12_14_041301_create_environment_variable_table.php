<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvironmentVariableTable extends Migration
{
    public function up()
    {
        Schema::create('environment_variables', function (Blueprint $table) {
            $table->id(); // Auto-incrementing ID
            $table->string('name'); // Name of the environment variable
            $table->string('value'); // Value (0 for off, 1 for on)
            $table->string('note')->nullable(); // Optional note about the variable
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('environment_variables');
    }
}
