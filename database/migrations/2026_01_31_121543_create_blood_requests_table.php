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
    Schema::create('blood_requests', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('hospital_id'); 
        $table->string('patient_name');
        $table->string('blood_group');
        $table->integer('bags_needed');
        $table->string('phone');
        $table->string('location');
        $table->text('reason')->nullable();
        $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
        $table->timestamps();

        $table->foreign('hospital_id')->references('id')->on('users')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_requests');
    }
};
