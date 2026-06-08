<?php

/*
| 全站共用內容區塊（footer / 聯絡資訊）。
| 結構：block key => ['type','label','group','default']
*/

return [
    'company.name'      => ['type' => 'text',     'label' => '公司名稱',  'group' => '公司資訊', 'default' => '楷懿國際投資'],
    'company.tagline'   => ['type' => 'textarea', 'label' => '公司標語（可多行，換行自動斷行）', 'group' => '公司資訊', 'default' => "專業不動產投資顧問\n提供全方位服務"],
    'contact.phone_tw'  => ['type' => 'text',     'label' => '台灣電話',  'group' => '聯絡資訊', 'default' => '+886 987-773-519'],
    'contact.phone_vn'  => ['type' => 'text',     'label' => '越南電話',  'group' => '聯絡資訊', 'default' => '+84 768-168-989'],
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
