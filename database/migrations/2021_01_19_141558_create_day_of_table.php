<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayOfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_ofs', function (Blueprint $table) {
            $table->id();
            $table->date('start');
            $table->date('end');
            $table->string('type');
            $table->integer('number_day');
            $table->integer('number_hour');
            $table->string('details')->nullable();
            $table->string('state2')->default('En cours');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('day_ofs');
    }
}
