<?php

use App\Models\Parcel;
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
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();
            $table->decimal('weight',8,2);
            $table->decimal('amount',10,2);
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->enum('status',[Parcel::DELIVERED, Parcel::ON_THE_WAY, Parcel::PENDING, Parcel::PICKED])->default(Parcel::PENDING);
            $table->foreignId('sender_id')->nullable();
            $table->foreignId('biker_id')->nullable();
            // $table->index('biker_id');
            // $table->foreign('biker_id')->references('id')->on('users')->onDelete('cascade');
//            $table->bigInteger('delivery_biker_id')->unsigned()->nullable();
//            $table->index('delivery_biker_id');
//            $table->foreign('delivery_biker_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcels');

    }
};
