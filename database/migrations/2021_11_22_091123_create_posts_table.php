<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->string("p_title");
            $table->string("slug");
            $table->text("p_excerpt");
            $table->text("p_body");
            $table->boolean("p_is_public");
            $table->timestamps();

            $table->foreign("user_id")
                    ->references("id")
                    ->on("users")
                    ->onDelete("cascade");
        });

        // tag relationship
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId("post_id");
            $table->foreignId("tag_id");

            $table->foreign("post_id")
                    ->references("id")
                    ->on("posts")
                    ->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
        Schema::dropIfExists('post_tag');
    }
}
