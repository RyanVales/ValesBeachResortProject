<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->string('room_number')->unique()->after('id');
            $table->foreignId('room_type_id')->constrained('room_types')->onDelete('cascade')->after('room_number');
            $table->string('floor')->nullable()->after('room_type_id');
            $table->enum('status', ['available', 'occupied', 'maintenance', 'out_of_order'])->default('available')->after('floor');
            $table->text('notes')->nullable()->after('status');
            $table->boolean('is_active')->default(true)->after('notes');
            $table->json('features')->nullable()->after('is_active');
        });
    }

    public function down()
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropForeign(['room_type_id']);
            $table->dropColumn([
                'room_number',
                'room_type_id', 
                'floor',
                'status',
                'notes',
                'is_active',
                'features'
            ]);
        });
    }
};