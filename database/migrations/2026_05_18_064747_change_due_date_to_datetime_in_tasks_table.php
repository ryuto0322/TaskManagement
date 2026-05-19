<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // 👇 date型から datetime型（日付＋時間）にパワーアップさせる指示
            $table->datetime('due_date')->change();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // 元に戻すときはdate型に戻す指示
            $table->date('due_date')->change();
        });
    }
};