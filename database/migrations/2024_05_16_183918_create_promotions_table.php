<?php

use App\Models\Promotion;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', Promotion::ALL_TYPES);
            $table->unsignedInteger('discount_value');
            $table->string('discount_code');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->morphs('promotional');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
