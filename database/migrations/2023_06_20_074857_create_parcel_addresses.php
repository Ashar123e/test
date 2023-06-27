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
        Schema::create('parcel_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcel_id');
            $table->string('pickup_address')->nullable();
            $table->string('dropoff_address')->nullable();
            // $table->string('name',100);
            // $table->string('email',100)->nullable();
            // $table->string('phone',50);
            // $table->string('city',100);
            // $table->text('address');
            // $table->enum('type',["pickup", "delivery"])->default("pickup");
            // $table->bigInteger('parcel_id')->unsigned()->nullable();
            // $table->index('parcel_id');
            // $table->foreign('parcel_id')->references('id')->on('parcels')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcel_addresses');
    }
};
