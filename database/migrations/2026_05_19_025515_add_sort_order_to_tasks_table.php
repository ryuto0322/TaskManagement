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
    Schema::table('tasks', function (blueprint $table) {
        // 💡 ここが正しく書かれているか確認してください！
        $table->integer('sort_order')->default(0)->after('due_date'); 
    });
}

public function down(): void
{
    Schema::table('tasks', function (blueprint $table) {
        // 💡 ここでカラムを消す処理が入っているか確認
        $table->dropColumn('sort_order');
    });
}
};
