<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('appointments', function (Blueprint $table) {
        $table->id();
        // এই লাইনটি যোগ করুন: এটি ইউজারের সাথে অ্যাপয়েন্টমেন্টের রিলেশন তৈরি করবে
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); 
        
        $table->string('donor_name'); // ইউজারের নাম এখানে রাখতে পারেন
        $table->string('blood_group');
        $table->date('date');
        $table->time('time');
        $table->enum('status', ['pending', 'approved', 'completed'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
