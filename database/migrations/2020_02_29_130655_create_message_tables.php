<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_storage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('event_uuid')->collation('utf8mb4_bin'); // case sensitive search
            $table->string('event_name', 255)->index('event_name')->collation('utf8mb4_bin');
            $table->integer('version')->default(1);
            $table->json('payload');
            $table->uuid('user_id')->nullable();
            $table->timestamps();

            $table->unique(['event_uuid', 'version'], 'event');
            $table->index('created_at');
        });

        Schema::create('snapshot_storage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('aggregate_uuid')->collation('utf8mb4_bin'); // case sensitive search
            $table->string('aggregate_type', 255)->collation('utf8mb4_bin');
            $table->mediumText('aggregate');
            $table->integer('last_version')->default(1);

            $table->unique(['aggregate_uuid', 'aggregate_type'], 'aggregate');
            $table->index('last_version');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_storage');
        Schema::dropIfExists('snapshot_storage');
    }
}
