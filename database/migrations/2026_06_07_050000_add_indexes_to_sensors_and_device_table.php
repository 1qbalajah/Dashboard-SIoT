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
        if (Schema::hasTable('sensors') && Schema::hasColumn('sensors', 'nama_sensor') && Schema::hasColumn('sensors', 'created_at')) {
            try {
                Schema::table('sensors', function (Blueprint $table) {
                    $table->index(['nama_sensor', 'created_at'], 'sensors_nama_sensor_created_at_index');
                });
            } catch (\Exception $e) {
                // Ignore if index already exists
            }
        }

        if (Schema::hasTable('device') && Schema::hasColumn('device', 'serial_number')) {
            try {
                Schema::table('device', function (Blueprint $table) {
                    $table->index('serial_number', 'device_serial_number_index');
                });
            } catch (\Exception $e) {
                // Ignore if index already exists
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sensors')) {
            try {
                Schema::table('sensors', function (Blueprint $table) {
                    $table->dropIndex('sensors_nama_sensor_created_at_index');
                });
            } catch (\Exception $e) {
                // Ignore if index doesn't exist
            }
        }

        if (Schema::hasTable('device')) {
            try {
                Schema::table('device', function (Blueprint $table) {
                    $table->dropIndex('device_serial_number_index');
                });
            } catch (\Exception $e) {
                // Ignore if index doesn't exist
            }
        }
    }
};
