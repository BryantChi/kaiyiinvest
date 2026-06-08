// Contact Form Handler

document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            // 前端基本驗證；通過則讓表單以原生方式 POST 至後端（Laravel）
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value.trim();
            const message = document.getElementById('message').value.trim();

            if (!name || !email || !subject || !message) {
                e.preventDefault();
                alert('請填寫所有必填欄位');
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('請輸入有效的電子郵件地址');
                return;
            }

            // 驗證通過：不攔截，讓瀏覽器送出表單；同時鎖定按鈕避免重複送出
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.textContent = '傳送中...';
                submitBtn.disabled = true;
            }
        });

        // Real-time validation for email
        const emailInput = document.getElementById('email');
        if (emailInput) {
            emailInput.addEventListener('blur', function() {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (this.value && !emailRegex.test(this.value)) {
                    this.style.borderColor = '#dc3545';
                } else if (this.value) {
                    this.style.borderColor = '#28a745';
                }
            });
        }
    }
});
