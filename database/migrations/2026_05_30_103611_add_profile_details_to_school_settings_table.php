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
        Schema::table('school_settings', function (Blueprint $table) {
            $table->string('site_name')->nullable()->after('school_name');
            $table->string('establishment_decree')->nullable()->after('established_year');
            $table->string('operational_permit')->nullable()->after('establishment_decree');
            $table->string('school_schedule')->nullable()->after('operational_permit');
            $table->string('coordinates')->nullable()->after('school_schedule');
            $table->longText('employee_data')->nullable()->after('mission');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('school_settings', function (Blueprint $table) {
            $table->dropColumn([
                'site_name',
                'establishment_decree',
                'operational_permit',
                'school_schedule',
                'coordinates',
                'employee_data',
            ]);
        });
    }
};
