$(document).ready(function(e){

    $('.accordion_date').on('click', function() {
        $(this).next('.accordion_item_wrapper').slideToggle(250);
        $(this).toggleClass('active');
    });

    $('.accordion_item_wrapper').hide();


    $(document).on('click', '.navigation_link', function(e) {
        e.preventDefault();
    });

    $('.article_link').on('click', function(e) {
        e.preventDefault();

        let articleId = $(this).data('id');
        let lang = $('html').attr('lang') || 'ru';

        if (!articleId) return;

        $.ajax({
            type: 'POST',
            url: '/' + lang + '/site/get-article',
            data: {
                id: articleId,
                _csrf: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    let article = response.article;
                    let translation = article.translations.find(t => t.language === lang);

                    if (!translation) {
                        alert('Перевод на выбранном языке отсутствует.');
                        return;
                    }

                    let html = `
                <div class="article_title">${translation.title}</div>
                <div class="article_date">${article.created_at}</div>
                <div class="acticle_image">
                    <a href="${article.image}" data-fancybox="gallery" data-caption="${translation.title}">
                        <img src="${article.image}" alt="${translation.title}">
                    </a>
                    <p>${translation.description}</p>
                </div>
                <div class="article_content">
                    ${translation.content}
                </div>
            `;
                    $('.research_books, .research_articles').hide();
                    $('.menu_bar.research .header_navigation ul li').not(':has(.back_link)').hide();
                    $('.menu_bar.research .header_navigation .back_link').show();
                    $('.article_section').html(html);
                    $('html, body').animate({ scrollTop: $('.menu_bar.research').offset().top }, 'fast');
                } else {
                    alert(response.message || 'Ошибка загрузки статьи');
                }
            },
            error: function(xhr, status, error) {
                console.error('AJAX error:', status, error);
            }
        });
    });

    $('.menu_bar.research .header_navigation .back_link').on('click', function(e) {
        e.preventDefault();

        $('.menu_bar.research .header_navigation ul li').show();
        $(this).hide();
        $('.article_section').empty();
        $('.research_books, .research_articles').show();

        // Плавно прокрутить наверх
        $('html, body').animate({ scrollTop: $('.menu_bar.research').offset().top }, 'fast');
    });


    $('.event_day').on('click', function(e) {
        e.preventDefault();
        let day = $(this).data('day');
        let lang = $('html').attr('lang') || 'ru';
        if (!day) return;
        $('.event_day').removeClass('active');
        $(this).addClass('active');

        $.ajax({
            type: 'POST',
            url: '/' + lang + '/site/get-programs',
            data: {
                day: day,
                _csrf: $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            success: function(data) {

                let container = $('.events');
                container.empty();

                function formatTime(timeStr) {
                    return timeStr ? timeStr.substring(0,5) : '';
                }

                function getTranslatedTitle(translations) {
                    let lang = $('html').attr('lang') || 'ru';
                    let translation = translations.find(t => t.language === lang);
                    return translation ? translation.title : '';
                }

                if (data.success && data.programs.length) {
                    let html = '<div class="events_container">';

                    data.programs.forEach(function(program) {
                        let programTranslation = getTranslatedTitle(program.translations);
                        let locationTitle = program.location ? getTranslatedTitle(program.location.translations) : '';
                        let tagTitle = program.tag ? getTranslatedTitle(program.tag.translations) : '';

                        html += `
                        <div class="row mb-3">
                            <div class="col-12 col-lg-3 pl-0 pr-0 pr-md-2">
                                <div class="event_time_location p-2 p-md-4">
                                    <p class="event_time">${formatTime(program.start_time)} - ${formatTime(program.end_time)}</p>
                                    <p class="event_location">${locationTitle}</p>
                                </div>
                            </div>
                            <div class="col-12 col-lg-9 pr-0 pl-0 pl-md-2">
                                <div class="event_data" style="background-color: ${program.bg_color || '#f3fff4'}">
                                    <div class="event p-2 p-md-4">
                                        <div class="event_type mb-3 d-flex">
                                            <span class="event_type_title">${tagTitle}</span>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 col-lg-6 mb-2 mb-lg-0">
                                                <h3 class="event_title">${programTranslation}</h3>
                                            </div>
                                            <div class="col-12 col-lg-6">
                                                <div class="event_description">${program.translations.find(t => t.language === ($('html').attr('lang') || 'ru'))?.description || ''}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    });

                    html += '</div>';
                    container.html(html);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', status, error);

            }
        });
    });

    $('.scroll-link').on('click', function(e) {
        e.preventDefault();
        var target = $($(this).attr('href'));
        if (target.length) {
            $('html, body').animate({
                scrollTop: target.offset().top
            }, 600);
        }
    });

    $('.hero_content .hero_content_header').on('click', function () {
        const bar = $(this).closest('.menu_bar');
        const hero = $('.hero');

        if (window.innerWidth < 992) {
            if (bar.hasClass('opened')) {
                bar.removeClass('opened');
                if (hero.hasClass('mobile-opened')) {
                    hero.removeClass('mobile-opened');
                }
            } else {
                $('.menu_bar.opened').removeClass('opened');
                bar.addClass('opened');
                if (hero.hasClass('mobile-opened')) {
                    hero.removeClass('mobile-opened');
                }
            }
        }
    });

    $('.hero .wrapper_header_hero').on('click', function(e) {
        if ($(e.target).closest('.main_header').length) {
            return;
        }
        if ($('.hero').hasClass('opened')) {
            return;
        }
        let menuWidth = $('.menu_bar.hero').data('width') || 180;
        $('.menu_bar').removeClass('opened').removeAttr('style');
        $('.hero').addClass('opened').css('width', `calc(100% - ${menuWidth}px)`);
    });

    $('.section_header').on('click', function () {
        const bar = $(this).closest('.menu_bar');

        // Check if this is a redirect section
        if (bar.hasClass('redirect-section')) {
            const redirectUrl = bar.data('redirect');
            if (redirectUrl) {
                window.open(redirectUrl, '_blank');
                return;
            }
        }

        const hero = $('.hero');
        const menuWidth = bar.data('width') || 180;

        if (window.innerWidth >= 992) {
            if (bar.hasClass('opened')) {
                bar.removeClass('opened');
                bar.removeAttr('style');
                hero.addClass('opened');
                $('.hero').addClass('opened').css('width', `calc(100% - ${menuWidth}px)`);
                return;
            }

            $('.menu_bar').removeClass('opened').removeAttr('style');
            bar.addClass('opened').css('width', `calc(100% - ${menuWidth}px)`);
            hero.removeClass('opened');
        } else {
            if (bar.hasClass('opened')) {
                bar.removeClass('opened');
                bar.removeAttr('style');
                hero.removeClass('mobile-opened');
            } else {
                $('.menu_bar.opened').removeClass('opened').removeAttr('style');
                bar.addClass('opened').css('width', `calc(100% - ${menuWidth}px)`);
                hero.addClass('mobile-opened');
            }
        }
    });

    $('.section_header').on('click', function() {
        if (window.innerWidth < 992) {
            const $section = $(this).closest('section');
            setTimeout(function() {
                if ($section.hasClass('opened')) {
                    $section[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        }
    });

    $('.hero_content_header').on('click', function() {
        if (window.innerWidth < 992) {
            const $section = $(this).closest('section');
            const content = $(this).closest('.hero_content');
            setTimeout(function() {
                if ($section.hasClass('opened')) {
                    content[0].scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }, 100);
        }
    });



    if (localStorage.getItem('theme') === 'night') {
        $('body').addClass('night');
        $('.toggle').addClass('active');
    }

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
})

