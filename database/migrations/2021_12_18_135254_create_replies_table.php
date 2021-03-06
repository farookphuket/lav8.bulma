<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained()->cascadeOnDelete();
            $table->string("r_title");
            $table->text("r_body");
            $table->timestamps();
        });


        Schema::create('post_reply', function (Blueprint $table) {
            $table->id();
            $table->foreignId("post_id")->constrained()->cascadeOnDelete();
            $table->foreignId("reply_id")->constrained()->cascadeOnDelete();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
        Schema::dropIfExists('post_reply');
    }
}
