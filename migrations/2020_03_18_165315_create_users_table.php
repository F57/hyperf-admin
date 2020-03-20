<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255)->default('');
            $table->string('email', 255);
            $table->string('passwd', 255);
            $table->string('photo', 255)->default('');
            $table->integer('role')->comment('角色');
            $table->unsignedTinyInteger('access')->default('1')->comment('是否允许登录 0可以 1不可以');
            $table->ipAddress('ip')->default('');
            $table->softDeletes();
            $table->timestamps();
            $table->unique('id');
            $table->unique('email');
            $table->index('deleted_at');
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
        Schema::dropIfExists('users');
    }
}
