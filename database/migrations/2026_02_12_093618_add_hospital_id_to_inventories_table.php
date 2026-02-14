<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            // hospital_id কলামটি যোগ করা হচ্ছে
            $table->unsignedBigInteger('hospital_id')->nullable()->after('id');

            // যদি আপনি চান এটি users টেবিলের সাথে কানেক্টেড থাকুক (ঐচ্ছিক কিন্তু ভালো)
            $table->foreign('hospital_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropForeign(['hospital_id']);
            $table->dropColumn('hospital_id');
        });
    }
};
