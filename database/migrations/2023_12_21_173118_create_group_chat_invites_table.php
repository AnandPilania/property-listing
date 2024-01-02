<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Musonza\Chat\ConfigurationManager;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_chat_invites', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('conversation_id')->unsigned();
            $table->bigInteger('invitee_id')->unsigned()->nullable();
            $table->bigInteger('inviter_id')->unsigned()->nullable();
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending');
            $table->timestamps();

            // $table->foreign('invitee_id')
            //     ->references('messageable_id')
            //     ->on(ConfigurationManager::PARTICIPATION_TABLE)
            //     ->onDelete('set null');

            // $table->foreign('inviter_id')
            //     ->references('messageable_id')
            //     ->on(ConfigurationManager::PARTICIPATION_TABLE)
            //     ->onDelete('set null');

            $table->foreign('conversation_id')
                ->references('id')
                ->on(ConfigurationManager::CONVERSATIONS_TABLE)
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_chat_invites');
    }
};
