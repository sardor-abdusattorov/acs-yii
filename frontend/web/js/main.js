$(document).ready(function(e){

    $('.hero_content .hero_content_header').on('click', function () {
        const bar   = $(this).closest('.menu_bar');
        const hero  = $('.hero');
        if (window.innerWidth < 992) {
            if (bar.hasClass('opened')) {
                bar.removeClass('opened');
                hero.addClass('opened');
                return;
            }
            $('.hero .main_content .main_section_hero').slideToggle(300);
        }
    });

    if (localStorage.getItem('theme') === 'night') {
        $('body').addClass('night');
        $('.toggle').addClass('active');
    }

// При клике на переключатель
    $('.toggle').click(function () {
        $('.toggle').toggleClass('active');
        $('body').toggleClass('night');

        // Сохраняем состояние в localStorage
        if ($('body').hasClass('night')) {
            localStorage.setItem('theme', 'night');
        } else {
            localStorage.setItem('theme', 'day');
        }
    });

    $('.accordion_open').on('click', function () {
        const button = $(this);
        const block = button.closest('.accordion_item');
        const content = block.find('.accordion_content');

        const textOpen = button.data('text-open');
        const textClosed = button.data('text-closed');

        $('.accordion_item').not(block).each(function () {
            $(this).removeClass('open')
                .find('.accordion_content').slideUp();

            $(this).find('.accordion_open').text(function () {
                return $(this).data('text-closed');
            });
        });

        const isOpen = block.hasClass('open');

        if (isOpen) {
            content.slideUp();
            block.removeClass('open');
            button.text(textClosed);
        } else {
            content.slideDown();
            block.addClass('open');
            button.text(textOpen);
        }
    });

    // Swiper init
    new Swiper(".swiper.gallery", {
        slidesPerView: 1,
        spaceBetween: 24,
        grabCursor: true,
        navigation: {
            nextEl: ".gallery .slide_next",
            prevEl: ".gallery .slide_prev"
        },
    });

    $('.section_header').on('click', function () {
        const bar   = $(this).closest('.menu_bar');
        const hero  = $('.hero');

        if (bar.hasClass('opened')) {
            bar.removeClass('opened');
            hero.addClass('opened');
            return;
        }

        $('.menu_bar').removeClass('opened');
        bar.addClass('opened');
        hero.removeClass('opened');
    });

})

