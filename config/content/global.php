<?php

/*
| 全站共用內容區塊（footer / 聯絡資訊）。
| 結構：block key => ['type','label','group','default']
*/

return [
    // 導覽列 / footer 共用的選單文字。繁中為 default；其他語系於後台或 NavContentSeeder 填入。
    'nav.home'             => ['type' => 'text', 'label' => '首頁',          'group' => '導覽與選單', 'default' => '首頁'],
    'nav.about'            => ['type' => 'text', 'label' => '關於我們',      'group' => '導覽與選單', 'default' => '關於我們'],
    'nav.services'         => ['type' => 'text', 'label' => '服務項目',      'group' => '導覽與選單', 'default' => '服務項目'],
    'nav.svc_real_estate'  => ['type' => 'text', 'label' => '服務下拉：不動產代理項目', 'group' => '導覽與選單', 'default' => '不動產代理項目'],
    'nav.svc_industrial'   => ['type' => 'text', 'label' => '服務下拉：工業地產',       'group' => '導覽與選單', 'default' => '工業地產'],
    'nav.svc_consulting'   => ['type' => 'text', 'label' => '服務下拉：專業諮詢',       'group' => '導覽與選單', 'default' => '專業諮詢'],
    'nav.svc_other'        => ['type' => 'text', 'label' => '服務下拉：其他服務',       'group' => '導覽與選單', 'default' => '其他服務'],
    'nav.partners'         => ['type' => 'text', 'label' => '關係企業',      'group' => '導覽與選單', 'default' => '關係企業'],
    'nav.contact'          => ['type' => 'text', 'label' => '聯絡我們',      'group' => '導覽與選單', 'default' => '聯絡我們'],
    'footer.quick_links'   => ['type' => 'text', 'label' => '頁尾：快速連結標題', 'group' => '導覽與選單', 'default' => '快速連結'],
    'footer.contact_info'  => ['type' => 'text', 'label' => '頁尾：聯絡資訊標題', 'group' => '導覽與選單', 'default' => '聯絡資訊'],

    'company.name'      => ['type' => 'text',     'label' => '公司名稱',  'group' => '公司資訊', 'default' => '楷懿國際投資'],
    'company.tagline'   => ['type' => 'textarea', 'label' => '公司標語（可多行，換行自動斷行）', 'group' => '公司資訊', 'default' => "專業不動產投資顧問\n提供全方位服務"],
    'contact.phone_tw'  => ['type' => 'text',     'label' => '台灣電話',  'group' => '聯絡資訊', 'default' => '+886 987-773-519'],
    'contact.phone_vn'  => ['type' => 'text',     'label' => '越南電話',  'group' => '聯絡資訊', 'default' => '+84 768-168-989'],
    'contact.label_tw'  => ['type' => 'text',     'label' => '電話國別標籤:台灣', 'group' => '聯絡資訊', 'default' => '台灣'],
    'contact.label_vn'  => ['type' => 'text',     'label' => '電話國別標籤:越南', 'group' => '聯絡資訊', 'default' => '越南'],
    'contact.email'     => ['type' => 'text',     'label' => '電子郵件',  'group' => '聯絡資訊', 'default' => 'kaiyiinvest@gmail.com'],
    'contact.addr_hanoi' => ['type' => 'textarea', 'label' => '河內地址', 'group' => '聯絡資訊', 'default' => '河內：SB01-SP.02-18, Sao Bien Subdivision, Vinhomes Ocean Park Urban Area, Gia Lam Commune, Hanoi City, Vietnam'],
    'contact.addr_haiphong' => ['type' => 'textarea', 'label' => '海防地址', 'group' => '聯絡資訊', 'default' => '海防：So 449, Vo Nguyen Giap, Phuong Kenh Duong, Quan Le Chan, Thanh Pho Hai Phong, Vietnam'],
    'footer.copyright'  => ['type' => 'text',     'label' => '版權文字',  'group' => '頁尾',     'default' => '楷懿國際投資 Kaiyi International Investment. All rights reserved.'],

    // 社群連結（留空則前台隱藏該圖示）
    'social.facebook'   => ['type' => 'url', 'label' => 'Facebook 連結',  'group' => '社群連結', 'default' => ''],
    'social.instagram'  => ['type' => 'url', 'label' => 'Instagram 連結', 'group' => '社群連結', 'default' => ''],
    'social.linkedin'   => ['type' => 'url', 'label' => 'LinkedIn 連結',  'group' => '社群連結', 'default' => ''],
    'social.youtube'    => ['type' => 'url', 'label' => 'YouTube 連結',   'group' => '社群連結', 'default' => ''],
];
