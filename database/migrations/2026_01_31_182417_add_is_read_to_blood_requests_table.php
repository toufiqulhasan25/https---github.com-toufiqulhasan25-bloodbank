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
        Schema::table('blood_requests', function (Blueprint $table) {
            $table->boolean('is_read')->default(false); // নতুন রিকোয়েস্ট ডিফল্টভাবে 'অপঠিত' থাকবে
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('blood_requests', function (Blueprint $table) {
            //
        });
    }
};
