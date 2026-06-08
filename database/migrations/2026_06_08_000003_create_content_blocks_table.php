<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('content_blocks', function (Blueprint $table) {
            $table->id();
            $table->string('page')->index();   // 頁面 key（home/about/global…），對應 manifest
            $table->string('key');             // 區塊 key（如 hero.title）
            $table->string('locale', 20);      // 語系代碼
            $table->string('type', 20)->default('text'); // text/textarea/html/image/url
            $table->longText('value')->nullable();
            $table->timestamps();

            $table->unique(['page', 'key', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_blocks');
    }
};
