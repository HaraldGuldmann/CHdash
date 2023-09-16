<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateClaimsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();

        Schema::rename('manual_claims', 'claims');

        Schema::table('claims', function (Blueprint $table) {
            $table->string('timestamp_start')->nullable()->after('video_url');
            $table->string('timestamp_end')->nullable()->after('timestamp_start');
            $table->string('status')->default(\App\Enums\ClaimStatusEnum::pending())->after('video_url');
            $table->string('match_policy')->default(\App\Enums\MatchPolicyEnum::track())->after('status');
            $table->string('content_type')->default(\App\Enums\ReferenceContentTypeEnum::audiovisual())->after('match_policy');

            $table->dropPrimary(['id']);
            $table->dropForeign('manual_claims_user_id_foreign');
            $table->dropColumn('policy');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        Schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('claims', function (Blueprint $table) {
            //
        });
    }
}
