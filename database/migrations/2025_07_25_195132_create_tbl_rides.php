<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void{
        if(! Schema::hasTable('tbl_rides')){
            Schema::create('tbl_rides', function (Blueprint $table) {
                $table->bigIncrements('ride_id');
                $table->bigInteger('passenger_id')->nullable();
                $table->bigInteger('driver_id')->nullable();// BIGINT NOT NULL REFERENCES drivers(driver_id),
                $table->geography('pickup_location', 'point', 4326)->nullable();
                $table->geography('driver_initial_location', 'point', 4326)->nullable();
                $table->text('pickup_address')->nullable();
                $table->double('proposed_price', 10, 2)->nullable();
                $table->double('initial_price', 10, 2)->nullable();
                $table->double('min_price', 10, 2)->nullable();
                $table->double('max_price', 10, 2)->nullable();
                $table->double('distance_km', 6, 2)->nullable();
                $table->integer('estimated_duration_min')->nullable();
                $table->integer('passenger_count')->default(1)->nullable();
                $table->tinyInteger('vehicle_category_id')->nullable();
                $table->string('status', 20)->default('pending')->nullable(); //('pending', 'accepted', 'driver_assigned', 'arrived', 'in_progress', 'completed', 'cancelled'),
                $table->timestamp('bidding_end_time')->nullable();
                $table->tinyInteger('is_auto_accept')->default(0)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void{
        Schema::dropIfExists('tbl_rides');
    }
};

?>