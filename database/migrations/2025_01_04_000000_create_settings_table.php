<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->text('value')->nullable();
        });

        // Start with the fee that was in config/shop.php
        DB::table('settings')->insert([
            'name'  => 'delivery_fee',
            'value' => (string) config('shop.delivery_fee', 50),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
