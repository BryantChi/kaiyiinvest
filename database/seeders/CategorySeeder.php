<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * 文章分類（貼合楷懿國際投資業務：越南不動產 / 工業地產 / 公司動態）。
     *
     * 以 slug 為唯一鍵 firstOrCreate：分類已存在則保留既有內容，不覆寫；僅補建缺少的分類。
     */
    public function run(): void
    {
        // ── 頂層：市場洞察 ──
        $market = Category::firstOrCreate(['slug' => 'market-insights'], [
            'name' => '市場洞察',
            'description' => '越南不動產與工業地產市場分析、趨勢與政策',
            'status' => 'active',
            'order' => 1,
            'color' => '#3b82f6',
            'icon' => 'cil-chart-line',
        ]);

        Category::firstOrCreate(['slug' => 'vietnam-market'], [
            'parent_id' => $market->id,
            'name' => '越南市場',
            'description' => '越南房地產市場趨勢、區域與數據',
            'status' => 'active',
            'order' => 1,
            'color' => '#06b6d4',
            'icon' => 'cil-globe-alt',
        ]);

        Category::firstOrCreate(['slug' => 'investment-trends'], [
            'parent_id' => $market->id,
            'name' => '投資趨勢',
            'description' => '跨國不動產投資趨勢與機會',
            'status' => 'active',
            'order' => 2,
            'color' => '#6366f1',
            'icon' => 'cil-graph',
        ]);

        Category::firstOrCreate(['slug' => 'policy-regulation'], [
            'parent_id' => $market->id,
            'name' => '法規政策',
            'description' => '越南投資法規、土地與稅務政策',
            'status' => 'active',
            'order' => 3,
            'color' => '#8b5cf6',
            'icon' => 'cil-institution',
        ]);

        // ── 頂層：工業地產 ──
        $industrial = Category::firstOrCreate(['slug' => 'industrial'], [
            'name' => '工業地產',
            'description' => '工業區開發、廠房與招商相關',
            'status' => 'active',
            'order' => 2,
            'color' => '#10b981',
            'icon' => 'cil-industry',
        ]);

        Category::firstOrCreate(['slug' => 'industrial-zones'], [
            'parent_id' => $industrial->id,
            'name' => '工業區開發',
            'description' => '園區開發、招商與落地營運',
            'status' => 'active',
            'order' => 1,
            'color' => '#22c55e',
            'icon' => 'cil-building',
        ]);

        Category::firstOrCreate(['slug' => 'factory-leasing'], [
            'parent_id' => $industrial->id,
            'name' => '廠房租售',
            'description' => '廠房、倉儲租賃與買賣',
            'status' => 'active',
            'order' => 2,
            'color' => '#14b8a6',
            'icon' => 'cil-storage',
        ]);

        // ── 頂層：公司動態 ──
        $company = Category::firstOrCreate(['slug' => 'company-news'], [
            'name' => '公司動態',
            'description' => '公司公告、活動與品牌消息',
            'status' => 'active',
            'order' => 3,
            'color' => '#f59e0b',
            'icon' => 'cil-newspaper',
        ]);

        Category::firstOrCreate(['slug' => 'announcements'], [
            'parent_id' => $company->id,
            'name' => '公司公告',
            'description' => '重要公告與聲明',
            'status' => 'active',
            'order' => 1,
            'color' => '#f97316',
            'icon' => 'cil-bullhorn',
        ]);

        Category::firstOrCreate(['slug' => 'events'], [
            'parent_id' => $company->id,
            'name' => '活動報導',
            'description' => '活動、展會與參訪紀錄',
            'status' => 'active',
            'order' => 2,
            'color' => '#ec4899',
            'icon' => 'cil-calendar',
        ]);

        $this->command->info('文章分類已建立完成（市場洞察 / 工業地產 / 公司動態）');
        $this->command->info('總共建立: ' . Category::count() . ' 個分類');
    }
}
