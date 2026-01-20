<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('car_wash_working_hours', function (Blueprint $table) {
            $table->time('open_time')->nullable()->change();
            $table->time('close_time')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('car_wash_working_hours', function (Blueprint $table) {
            $table->time('open_time')->nullable(false)->change();
            $table->time('close_time')->nullable(false)->change();
        });
    }
};
