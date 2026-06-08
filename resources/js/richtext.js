// TinyMCE 自託管打包（不使用 CDN）。由 Vite 打包，於需要的後台頁以 @vite 載入。
// 兩種 flavor：.js-richtext（區塊式，含清單）/ .js-richtext-inline（行內式，不產生區塊標籤）。

import tinymce from 'tinymce/tinymce';

// 必要模組（核心先載入，後續外掛 IIFE 才能註冊到 tinymce）
import 'tinymce/models/dom/model.js';
import 'tinymce/themes/silver/theme.js';
import 'tinymce/icons/default/icons.js';
import 'tinymce/plugins/lists/plugin.js';
import 'tinymce/plugins/link/plugin.js';
import 'tinymce/plugins/code/plugin.js';
import 'tinymce/plugins/autoresize/plugin.js';

// UI skin（注入頁面）；content CSS 以字串注入 iframe（content_style）
import 'tinymce/skins/ui/oxide/skin.min.css';
import contentUiCss from 'tinymce/skins/ui/oxide/content.min.css?inline';
import contentCss from 'tinymce/skins/content/default/content.min.css?inline';

const common = {
    skin: false,
    content_css: false,
    content_style: [
        contentCss,
        contentUiCss,
        'body{font-family:"Noto Sans TC",Arial,sans-serif;font-size:15px;line-height:1.7;}',
    ].join('\n'),
    menubar: false,
    min_height: 200,
    branding: false,
    promotion: false,
    extended_valid_elements: 'span[class|style],br',
    valid_classes: { span: 'text-gold' },
};

function refreshEditors() {
    tinymce.editors.forEach(function (ed) {
        try { ed.execCommand('mceAutoResize'); } catch (e) {}
    });
}

function initRichtext() {
    if (typeof tinymce === 'undefined') return;

    if (document.querySelector('textarea.js-richtext')) {
        tinymce.init(Object.assign({}, common, {
            selector: 'textarea.js-richtext',
            plugins: 'lists link code autoresize',
            toolbar: 'bold italic | bullist numlist | link | removeformat | code',
        }));
    }

    if (document.querySelector('textarea.js-richtext-inline')) {
        tinymce.init(Object.assign({}, common, {
            selector: 'textarea.js-richtext-inline',
            forced_root_block: false,
            plugins: 'link code autoresize',
            toolbar: 'bold italic | link | removeformat | code',
        }));
    }

    // CoreUI/Bootstrap 分頁：切換時刷新，避免隱藏分頁高度為 0
    document.querySelectorAll('[data-coreui-toggle="pill"],[data-bs-toggle="pill"]').forEach(function (tab) {
        tab.addEventListener('shown.coreui.tab', refreshEditors);
        tab.addEventListener('shown.bs.tab', refreshEditors);
    });
}

if (document.readyState !== 'loading') {
    initRichtext();
} else {
    document.addEventListener('DOMContentLoaded', initRichtext);
}
