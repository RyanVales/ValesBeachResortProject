<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('country_code', 5)->default('+63'); // Philippines default
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['male', 'female', 'other', 'prefer_not_to_say'])->nullable();
            $table->string('nationality')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('id_type')->nullable(); // Driver's License, Passport, etc.
            $table->string('id_number')->nullable();
            
            // Address Information
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state_province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('Philippines');
            
            // Contact Preferences
            $table->json('contact_preferences')->nullable(); // email, sms, phone
            $table->json('dietary_restrictions')->nullable();
            $table->json('special_requests')->nullable();
            
            // System fields
            $table->text('notes')->nullable(); // Staff notes
            $table->boolean('is_vip')->default(false);
            $table->boolean('is_blacklisted')->default(false);
            $table->string('preferred_language')->default('English');
            $table->enum('status', ['active', 'inactive', 'blacklisted'])->default('active');
            
            // Timestamps
            $table->timestamp('last_stay_date')->nullable();
            $table->integer('total_stays')->default(0);
            $table->decimal('total_spent', 12, 2)->default(0);
            $table->timestamps();
            
            // Indexes
            $table->index(['email']);
            $table->index(['phone']);
            $table->index(['last_name', 'first_name']);
            $table->index(['status']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('guests');
    }
};