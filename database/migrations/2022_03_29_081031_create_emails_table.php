<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('messageId', 255);
            $table->integer('mailType');
            $table->string('modelName');
            $table->string('modelId');
            $table->string('status');
            $table->string('from');
            $table->string('from_name');
            $table->string('to');
            $table->string('cc');
            $table->string('bcc');
            $table->string('replyTo');
            $table->string('body');
            $table->string('subject');
            $table->text('attachments');
            $table->integer('numberOfOpens');
            $table->dateTime('firstOpened');
            $table->string('lastOpenedFrom');
            $table->text('lastError');
            $table->integer('TotalTries');
            $table->tinyInteger('success');
            $table->text('deliveryInformation');
            $table->date('sendOn');
            $table->dateTime('deliveredAt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('emails');
    }
};
