<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUserOperateLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_operate_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('uid');
            $table->ipAddress('ip')->default('');
            $table->text('param');
            $table->softDeletes();
            $table->timestamps();
            $table->index('uid');
            $table->engine = 'InnoDB';
            $table->charset = 'utf8';
            $table->collation = 'utf8_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_operate_log');
    }
}
