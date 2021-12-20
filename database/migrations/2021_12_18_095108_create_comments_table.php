<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->string("c_title");
            $table->text("c_body");
            $table->timestamps();
        });


        Schema::create('comment_reply', function (Blueprint $table) {

            $table->id();
            $table->foreignId("reply_id");
            $table->foreignId("comment_id")->constrained()->cascadeOnDelete();

            $table->foreign("reply_id")
                    ->references("id")
                    ->on("replies")
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
        Schema::dropIfExists('comments');
        Schema::dropIfExists('comment_reply');
    }
}
