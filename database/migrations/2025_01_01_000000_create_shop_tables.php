<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', fn(Blueprint $t) => $t->string('role')->default('customer'));
        Schema::create('categories', function (Blueprint $t) { $t->id(); $t->string('name'); $t->string('slug')->unique(); });
        Schema::create('products', function (Blueprint $t) {
            $t->id(); $t->foreignId('category_id')->constrained(); $t->string('name'); $t->string('description')->nullable();
            $t->boolean('is_drink')->default(true); $t->decimal('price',8,2)->default(0);
            $t->decimal('price_cold',8,2)->nullable(); $t->decimal('price_hot',8,2)->nullable();
            $t->boolean('featured')->default(false); $t->boolean('active')->default(true); $t->timestamps();
        });
        Schema::create('options', function (Blueprint $t) {
            $t->id(); $t->string('grp'); $t->string('name'); $t->decimal('price_add',8,2)->default(0);
            $t->boolean('is_multi')->default(false); $t->integer('sort')->default(0); $t->boolean('active')->default(true);
        });
        Schema::create('cart_items', function (Blueprint $t) {
            $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete(); $t->foreignId('product_id')->constrained()->cascadeOnDelete();
            $t->unsignedInteger('qty')->default(1); $t->string('options_text')->default(''); $t->decimal('unit_price',8,2);
        });
        Schema::create('orders', function (Blueprint $t) {
            $t->id(); $t->foreignId('user_id')->constrained(); $t->decimal('total',9,2); $t->string('status')->default('pending');
            $t->string('contact_name'); $t->string('phone'); $t->string('pickup_time'); $t->string('note')->nullable(); $t->timestamps();
        });
        Schema::create('order_items', function (Blueprint $t) {
            $t->id(); $t->foreignId('order_id')->constrained()->cascadeOnDelete(); $t->string('product_name');
            $t->string('options_text')->default(''); $t->unsignedInteger('qty'); $t->decimal('unit_price',8,2);
        });
    }
    public function down(): void
    {
        foreach (['order_items','orders','cart_items','options','products','categories'] as $t) Schema::dropIfExists($t);
        Schema::table('users', fn(Blueprint $t) => $t->dropColumn('role'));
    }
};
