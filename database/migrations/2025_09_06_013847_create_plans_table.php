<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id('plan_id');                      
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            $table->string('plan_name');                
            $table->string('area_shape');               
            $table->string('planting_system');          
            $table->integer('plant_spacing')->nullable();
            $table->integer('num_plants')->nullable();  // calculation result
            $table->timestamps();                        // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
