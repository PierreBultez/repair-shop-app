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
        Schema::create('device_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Smartphone, Tablet, etc.
            $table->timestamps();
        });

        Schema::create('device_brands', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Apple, Samsung, etc.
            $table->timestamps();
        });

        Schema::create('device_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_type_id')->constrained();
            $table->foreignId('device_brand_id')->constrained();
            $table->string('name'); // iPhone 15, Galaxy S24, etc.
            $table->string('model_number')->nullable();
            $table->json('specifications')->nullable();
            $table->timestamps();
        });

        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->foreignId('device_model_id')->constrained();
            $table->string('serial_number')->nullable();
            $table->string('imei')->nullable();
            $table->string('color')->nullable();
            $table->string('capacity')->nullable(); // 64GB, 128GB, etc.
            $table->text('condition_notes')->nullable();
            $table->boolean('has_password')->default(false);
            $table->string('password')->nullable(); // peut être stocké chiffré
            $table->json('accessories')->nullable(); // charger, box, etc.
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device');
        Schema::dropIfExists('device_models');
        Schema::dropIfExists('device_brands');
        Schema::dropIfExists('device_types');
    }
};
