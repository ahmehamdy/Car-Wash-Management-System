<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'service_id')) {
                $table->dropForeign(['service_id']);
                $table->dropColumn('service_id');
            }

            if (!Schema::hasColumn('orders', 'total_price')) {
                $table->decimal('total_price', 8, 2)->default(0)->after('car_wash_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('service_id')->nullable()->after('car_wash_id');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
            $table->dropColumn('total_price');
        });
    }
};
