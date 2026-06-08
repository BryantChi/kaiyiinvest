<?php

/*
| 首頁可編輯內容區塊。原靜態首頁僅顯示 hero 區（其餘區塊原為註解，依約束不顯示）。
*/

return [
    'hero.title'          => ['type' => 'text', 'label' => 'Hero 主標題', 'group' => 'Hero 區', 'default' => '專業不動產投資'],
    'hero.title_highlight' => ['type' => 'text', 'label' => 'Hero 主標題（金色強調，顯示於下一行）', 'group' => 'Hero 區', 'default' => '引領您的財富增值'],
    'hero.subtitle'     => ['type' => 'text', 'label' => 'Hero 副標題', 'group' => 'Hero 區', 'default' => '工業地產 · 不動產代理 · 專業諮詢'],
    'hero.btn_primary'  => ['type' => 'text', 'label' => '主要按鈕文字', 'group' => 'Hero 區', 'default' => '探索服務'],
    'hero.btn_outline'  => ['type' => 'text', 'label' => '次要按鈕文字', 'group' => 'Hero 區', 'default' => '立即諮詢'],
];
