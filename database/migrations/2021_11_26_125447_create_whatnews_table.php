<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWhatnewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('whatnews', function (Blueprint $table) {
            $table->id();
            $table->string("wn_title");
            $table->text("wn_body");
            $table->boolean("is_public");
            $table->timestamps();
        });


        Schema::create('whatnew_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id");
            $table->foreignId("whatnew_id");
            $table->timestamps();

            $table->foreign("user_id")
                    ->references("id")
                    ->on("users")
                    ->onDelete("cascade");

            $table->foreign("whatnew_id")
                    ->references("id")
                    ->on("whatnews")
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
        Schema::dropIfExists('whatnews');
        Schema::dropIfExists('whatnew_user');
    }
}
