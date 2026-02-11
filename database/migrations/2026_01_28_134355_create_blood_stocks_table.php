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
    Schema::create('blood_stocks', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('user_id'); // Hospital id
        $table->string('blood_group');
        $table->integer('bags')->default(0);
        $table->timestamps();

        // Hospital delete hole stock o delete hoye jabe
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_stocks');
    }
};
