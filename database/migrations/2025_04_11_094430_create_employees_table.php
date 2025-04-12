<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('division_id');
            $table->string('fullname');
            $table->integer('nip');
            $table->enum('gender', ['Laki-Laki', 'Perempuan']);
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('address');
            $table->timestamps();

            $table->foreign('division_id')->references('id')->on('divisions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
