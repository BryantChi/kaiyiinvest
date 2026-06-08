// Industrial Development Page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Initialize accordion functionality
    initAccordion();

    // Initialize scroll animations
    initScrollAnimations();
});

// Accordion functionality
function initAccordion() {
    const scopeItems = document.querySelectorAll('.scope-item');

    // Open first item by default
    if (scopeItems.length > 0) {
        scopeItems[0].classList.add('active');
    }

    scopeItems.forEach(item => {
        const header = item.querySelector('.scope-header');

        header.addEventListener('click', function() {
            const isActive = item.classList.contains('active');

            // Close all items
            scopeItems.forEach(otherItem => {
                otherItem.classList.remove('active');
            });

            // Toggle current item
            if (!isActive) {
                item.classList.add('active');
            }
        });
    });
}

// Scroll animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Animate cards
    const cards = document.querySelectorAll('.process-card, .feature-card, .industry-card, .stat-item');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });

    // Animate overview sections
    const overviewSections = document.querySelectorAll('.overview-content, .overview-image');
    overviewSections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = index === 0 ? 'translateX(-30px)' : 'translateX(30px)';
        section.style.transition = `opacity 0.8s ease 0.2s, transform 0.8s ease 0.2s`;
        observer.observe(section);
    });
}

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        if (href !== '#' && href.length > 1) {
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

// Add hover effects for stats
document.querySelectorAll('.stat-item').forEach(item => {
    item.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px) scale(1.05)';
    });

    item.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
});

// Parallax effect for page header
window.addEventListener('scroll', function() {
    const header = document.querySelector('.page-header-bg');
    if (header) {
        const scrolled = window.pageYOffset;
        header.style.transform = `translateY(${scrolled * 0.5}px)`;
    }
});

// Number counter animation for stats
function animateNumbers() {
    const stats = document.querySelectorAll('.stat-number');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                entry.target.classList.add('animated');
                const text = entry.target.textContent;

                // Check if it contains a number
                const hasNumber = /\d/.test(text);
                if (hasNumber) {
                    animateValue(entry.target, 0, parseInt(text.match(/\d+/)[0]), 2000);
                }
            }
        });
    }, { threshold: 0.5 });

    stats.forEach(stat => observer.observe(stat));
}

function animateValue(element, start, end, duration) {
    const text = element.textContent;
    const prefix = text.match(/^[^\d]*/)[0];
    const suffix = text.match(/[^\d]*$/)[0];

    let startTimestamp = null;
    const step = (timestamp) => {
        if (!startTimestamp) startTimestamp = timestamp;
        const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        const current = Math.floor(progress * (end - start) + start);
        element.textContent = prefix + current + suffix;
        if (progress < 1) {
            window.requestAnimationFrame(step);
        }
    };
    window.requestAnimationFrame(step);
}

// Initialize number animation
animateNumbers();

// Add loading class removal for smooth entry
window.addEventListener('load', function() {
    document.body.classList.add('loaded');
});

// Print functionality (if needed)
function printPage() {
    window.print();
}

// Share functionality
function shareOnSocialMedia(platform) {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);

    let shareUrl;
    switch(platform) {
        case 'facebook':
            shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${url}`;
            break;
        case 'line':
            shareUrl = `https://social-plugins.line.me/lineit/share?url=${url}`;
            break;
        case 'email':
            shareUrl = `mailto:?subject=${title}&body=${url}`;
            break;
    }

    if (shareUrl) {
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
}

// Export functions for use in HTML
window.printPage = printPage;
window.shareOnSocialMedia = shareOnSocialMedia;
