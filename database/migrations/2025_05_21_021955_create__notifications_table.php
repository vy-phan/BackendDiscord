<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id('notification_id'); // Primary key, auto increment
            $table->unsignedBigInteger('user_id'); // Foreign key
            $table->string('type', 50);
            $table->text('content');
            $table->timestamp('created_at')->useCurrent(); // Default current timestamp
            $table->boolean('is_read')->default(false);

            // Foreign key constraint
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}

