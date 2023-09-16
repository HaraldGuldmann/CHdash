<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('references', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('youtube_id');
            $table->string('asset_id')->nullable();
            $table->string('status');
            $table->string('statusReason')->nullable();
            $table->string('duplicateLeader')->nullable();
            $table->unsignedBigInteger('length')->nullable();
            $table->string('hash_code')->nullable();
            $table->string('video_id')->nullable();
            $table->string('claim_id')->nullable();
            $table->boolean('urgent')->default(false);
            $table->string('content_type');

            $table->foreign('asset_id')
                ->references('youtube_id')
                ->on('assets')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('references');
    }
}
