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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->date('consultation_date');
            
            // Prescription fields
            $table->string('right_eye_sph')->nullable();
            $table->string('right_eye_cyl')->nullable();
            $table->string('right_eye_axis')->nullable();
            $table->string('right_eye_add')->nullable();
            
            $table->string('left_eye_sph')->nullable();
            $table->string('left_eye_cyl')->nullable();
            $table->string('left_eye_axis')->nullable();
            $table->string('left_eye_add')->nullable();
            
            // Financial fields
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            
            $table->text('internal_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
