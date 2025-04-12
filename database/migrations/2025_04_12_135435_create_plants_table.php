<?php

use App\Enums\PlantWaterAmount;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            // Use enum with values from the enum class
            $table->enum('preferred_water_amount', PlantWaterAmount::values());

            $table->string('location'); // e.g. 'Greenhouse A'
            $table->date('last_watering')->nullable();

            // Foreign key to plant_categories
            $table->foreignId('plant_category_id')->constrained()->onDelete('cascade');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plants');
    }
};
