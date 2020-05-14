<?php

use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->char('name', 60)->default('');
            $table->char('email', 60);
            $table->char('passwd', 60);
            $table->char('photo', 255)->default('');
            $table->unsignedTinyInteger('role')->comment('角色');
            $table->enum('access', ['0', '1'])->default('1')->comment('是否允许登录');
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
        Schema::dropIfExists('admins');
    }
}
