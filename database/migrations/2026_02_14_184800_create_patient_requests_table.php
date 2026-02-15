<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('patient_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(); // যে ইউজার রিকোয়েস্ট করছে
            $table->foreignId('hospital_id')->constrained('users'); // যে হাসপাতালের কাছে রিকোয়েস্ট যাচ্ছে
            $table->string('blood_group');
            $table->integer('bags')->default(1);
            $table->string('patient_name');
            $table->string('contact_number');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_requests');
    }
};
