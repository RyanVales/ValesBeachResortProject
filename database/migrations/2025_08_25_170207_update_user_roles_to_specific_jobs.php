<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Update existing 'staff' roles to more specific roles
        DB::table('users')->where('role', 'staff')->update(['role' => 'housekeeper']);
        
        // You can add more specific updates here if needed
        // DB::table('users')->where('email', 'specific@email.com')->update(['role' => 'concierge']);
    }

    public function down()
    {
        // Reverse the changes
        DB::table('users')->where('role', 'housekeeper')->update(['role' => 'staff']);
    }
};