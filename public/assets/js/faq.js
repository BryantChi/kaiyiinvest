// FAQ Page Interactive Functionality

document.addEventListener('DOMContentLoaded', function() {
    // FAQ Accordion
    const faqItems = document.querySelectorAll('.faq-item');

    faqItems.forEach(item => {
        const question = item.querySelector('.faq-question');

        question.addEventListener('click', () => {
            const isActive = item.classList.contains('active');

            // Close all other items
            faqItems.forEach(otherItem => {
                if (otherItem !== item) {
                    otherItem.classList.remove('active');
                }
            });

            // Toggle current item
            if (isActive) {
                item.classList.remove('active');
            } else {
                item.classList.add('active');
            }
        });
    });

    // Category Filter
    const categoryBtns = document.querySelectorAll('.category-btn');

    categoryBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const category = btn.dataset.category;

            // Update active button
            categoryBtns.forEach(otherBtn => {
                otherBtn.classList.remove('active');
            });
            btn.classList.add('active');

            // Filter FAQ items
            faqItems.forEach(item => {
                const itemCategories = item.dataset.category.split(' ');

                if (category === 'all' || itemCategories.includes(category)) {
                    item.classList.remove('hidden');
                    // Smooth reveal animation
                    setTimeout(() => {
                        item.style.opacity = '1';
                        item.style.transform = 'translateY(0)';
                    }, 10);
                } else {
                    item.classList.add('hidden');
                    item.classList.remove('active');
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(-10px)';
                }
            });
        });
    });

    // Initialize: Set initial state for filter animation
    faqItems.forEach(item => {
        item.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        item.style.opacity = '1';
        item.style.transform = 'translateY(0)';
    });
});
