<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('youtube_id')->index();
            $table->string('content_owner_id');
            $table->string('user_id')->nullable();
            $table->string('type');
            $table->string('status')->nullable();
            $table->json('alias_ids')->nullable();
            $table->json('metadata')->nullable();
            $table->json('ownership')->nullable();
            $table->json('ownership_conflicts')->nullable();
            $table->timestamps();

            $table->foreign('content_owner_id')
                ->references('id')
                ->on('content_owners')
                ->onDelete('CASCADE');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('assets');
    }
}
