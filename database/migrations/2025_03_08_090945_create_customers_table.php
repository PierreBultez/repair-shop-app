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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_tax_id')->nullable(); // SIRET, etc.
            $table->text('notes')->nullable();
            $table->boolean('marketing_consent')->default(false);
            $table->timestamp('last_visit_at')->nullable();
            $table->timestamps();
            $table->softDeletes(); // Pour ne pas perdre d'historique
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
