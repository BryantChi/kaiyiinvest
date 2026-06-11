// Kaiyi International - Main JavaScript

// Page Loader：DOM 準備好即淡出，不等 hero 影片等重資產（避免遮罩卡住整頁）
function hidePageLoader() {
    const loader = document.querySelector('.page-loader');
    if (!loader) return;
    // 最少顯示 500ms 確保載入動畫被看到
    setTimeout(() => {
        loader.classList.add('fade-out');
        // 動畫結束後移除元素
        setTimeout(() => {
            loader.style.display = 'none';
        }, 500);
    }, 500);
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', hidePageLoader);
} else {
    hidePageLoader();
}

// 動態同步固定導覽列實際高度到 --nav-h（CSS 寫死 78/88px 會因語系、字體載入、視窗寬度對不上而產生縫隙）
function syncNavHeight() {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;
    document.documentElement.style.setProperty('--nav-h', navbar.offsetHeight + 'px');
}

syncNavHeight();
window.addEventListener('load', syncNavHeight); // 字體載入後高度可能改變
window.addEventListener('resize', syncNavHeight);
if (document.fonts && document.fonts.ready) {
    document.fonts.ready.then(syncNavHeight);
}

// Mobile Menu Toggle
// 漢堡選單斷點：須與 enhancements.css 的 max-width:1024px 保持一致
// （長字語系如越南文／英文在平板寬度會撐破橫向選單，故 ≤1024 一律用抽屜）
const MOBILE_NAV_MAX = 1024;
const mobileToggle = document.getElementById('mobileToggle');
const navMenu = document.getElementById('navMenu');

if (mobileToggle) {
    mobileToggle.addEventListener('click', () => {
        navMenu.classList.toggle('active');
    });
}

// Mobile Dropdown Toggle
const navLinks = document.querySelectorAll('.nav-menu > li');
navLinks.forEach(li => {
    const link = li.querySelector('.nav-link');
    const dropdown = li.querySelector('.dropdown-menu');

    if (dropdown && link) {
        link.addEventListener('click', (e) => {
            // 只在手機／平板（抽屜模式）時阻止預設行為
            if (window.innerWidth <= MOBILE_NAV_MAX) {
                e.preventDefault();
                li.classList.toggle('dropdown-active');

                // 關閉其他下拉選單
                navLinks.forEach(otherLi => {
                    if (otherLi !== li) {
                        otherLi.classList.remove('dropdown-active');
                    }
                });
            }
        });
    }
});

// 點擊下拉選單項目後關閉手機選單
document.querySelectorAll('.dropdown-item').forEach(item => {
    item.addEventListener('click', () => {
        if (window.innerWidth <= MOBILE_NAV_MAX) {
            navMenu.classList.remove('active');
            navLinks.forEach(li => li.classList.remove('dropdown-active'));
        }
    });
});

// Back to Top Button
const backToTop = document.getElementById('backToTop');

window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
        backToTop.classList.add('show');
    } else {
        backToTop.classList.remove('show');
    }
});

backToTop.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Video Modal（關係企業頁 - 楷懿數位行銷）
const videoTrigger = document.getElementById('digitalMarketingTrigger');
const videoModal = document.getElementById('videoModal');

if (videoTrigger && videoModal) {
    const modalVideo = document.getElementById('modalVideo');
    const modalClose = document.getElementById('videoModalClose');
    const modalOverlay = videoModal.querySelector('.video-modal-overlay');

    const openModal = () => {
        // 點擊後才設定 src，頁面載入時不會下載 30MB 影片
        if (!modalVideo.src) {
            modalVideo.src = videoTrigger.dataset.video;
        }
        videoModal.classList.add('active');
        document.body.style.overflow = 'hidden';
        modalVideo.play().catch(() => { /* 自動播放被瀏覽器阻擋時忽略，使用者可手動播放 */ });
    };

    const closeModal = () => {
        videoModal.classList.remove('active');
        document.body.style.overflow = '';
        modalVideo.pause();
    };

    videoTrigger.addEventListener('click', (e) => {
        e.preventDefault();
        openModal();
    });
    // 鍵盤可及性：Enter / 空白鍵開啟
    videoTrigger.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            openModal();
        }
    });

    modalClose.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', closeModal);
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && videoModal.classList.contains('active')) {
            closeModal();
        }
    });
}

// Smooth Scroll for all anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#') {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});
