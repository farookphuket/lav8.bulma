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
            $table->boolean("p_is_public")->default(1);
            $table->integer("p_has_read_count")->default(0);
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

            $table->foreign("tag_id")
                    ->references("id")
                    ->on("tags")
                    ->onDelete("cascade");
        });


        // category link table for post 
        Schema::create('category_post', function (Blueprint $table) {

            $table->id();
            $table->foreignId("category_id");
            $table->foreignId("post_id");

            $table->foreign("category_id")
                    ->references("id")
                    ->on("categories")
                    ->onDelete("cascade");

            $table->foreign("post_id")
                  ->references("id")
                    ->on("posts")
                    ->onDelete("cascade");
        });


        // read link table for post 
        Schema::create('post_read', function (Blueprint $table) {
            $table->id();
            $table->string("ip");
            $table->foreignId("post_id");
            $table->foreignId("read_id");
            $table->timestamps();

            $table->foreign("post_id")
                  ->references("id")
                    ->on("posts")
                    ->onDelete("cascade");

            $table->foreign("read_id")
                  ->references("id")
                    ->on("reads")
                    ->onDelete("cascade");
        });


        // comment link table for post 
        Schema::create('comment_post', function (Blueprint $table) {

            $table->id();
            $table->foreignId("comment_id")->constrained()->cascadeOnDelete();
            $table->foreignId("post_id")->constrained()->cascadeOnDelete();

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
        Schema::dropIfExists('category_post');
        Schema::dropIfExists('comment_post');
        Schema::dropIfExists('post_read');
    }
}
