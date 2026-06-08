<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 加入 locale：每個 model 每語系一筆 SEO Meta
        Schema::table('seo_meta', function (Blueprint $table) {
            $table->string('locale', 20)->default('zh-TW')->after('model_id');
        });

        // 唯一鍵由 (model_type, model_id) 改為 (model_type, model_id, locale)
        Schema::table('seo_meta', function (Blueprint $table) {
            $table->dropUnique('seo_meta_model_type_model_id_unique');
            $table->unique(['model_type', 'model_id', 'locale'], 'seo_meta_model_locale_unique');
        });
    }

    public function down(): void
    {
        Schema::table('seo_meta', function (Blueprint $table) {
            $table->dropUnique('seo_meta_model_locale_unique');
            $table->unique(['model_type', 'model_id'], 'seo_meta_model_type_model_id_unique');
            $table->dropColumn('locale');
        });
    }
};
