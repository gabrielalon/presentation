<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('warehouse', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->string('name')->unique();
            $table->softDeletes();
        });

        Schema::create('warehouse_item', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->char('ean', 13)->unique();
            $table->softDeletes();
        });

        Schema::create('warehouse_state', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('warehouse_uuid');
            $table->uuid('item_uuid');
            $table->unsignedInteger('quantity');

            $table->unique(['warehouse_uuid', 'item_uuid'], 'warehouse_item');
            $table->foreign('warehouse_uuid')->references('uuid')->on('warehouse');
            $table->foreign('item_uuid')->references('uuid')->on('warehouse_item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_state');
        Schema::dropIfExists('warehouse_item');
        Schema::dropIfExists('warehouse');
    }
}
