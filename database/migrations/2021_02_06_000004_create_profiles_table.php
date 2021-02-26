<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('last_name');

            //if is writer.
            $table->string('cel_phone')->nullable()->default(null);
            $table->string('phone')->nullable()->default(null);
            $table->string('profile_photo')->nullable()->default(null);
            $table->string('facebook_url')->nullable()->default(null);
            $table->string('instagram_url')->nullable()->default(null);
            $table->string('twitter_url')->nullable()->default(null);
            $table->string('blog_personal_url')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('province')->nullable()->default(null);
            $table->string('country')->nullable()->default(null);
            $table->string('postal_code')->nullable()->default(null);
            $table->boolean('accepted')->default(false);
            $table->unsignedBigInteger('accepted_by')->nullable()->default(null);
            $table->timestamp('accepted_at')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();
            //relationship
            $table->foreign('user_id')->references('id')->on('users');

            $table->foreign('accepted_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
