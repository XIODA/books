<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('avatar')->nullable()->after('email'); // 新增大頭貼欄位
            $table->date('birthday')->nullable()->after('avatar'); // 新增生日欄位
            $table->text('bio')->nullable()->after('birthday'); // 新增個人介紹欄位

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn(['avatar', 'birthday', 'bio']);
        });
    }
};
