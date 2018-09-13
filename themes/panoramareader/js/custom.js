(function() {
    "use strict";
    var $ = jQuery.noConflict();

    $(document).ready(function() {
        initSelect();
        initMenu();
        newsletterFix();

        $(window).on('resize', function(){
            var win = $(this); //this = window
            if (win.width() >= 960 && win.width() <= 480 ) {
            }
            if (win.width() < 960 ) {
            }
            if (win.width() >= 960 ) {
            }
        });

    });

    $( window ).load(function() {
    });

    $( document ).ajaxComplete(function() {
        initSelect();
        initInstaCarousel();
        newsletterFix();
    });
    function newsletterFix() {
        if ( $( ".widget_daze_img_widget a").length ) {
            $( ".widget_daze_img_widget a").removeAttr('target');
            $( ".widget_daze_img_widget").addClass( $( ".widget_daze_img_widget").find('a').attr('href').replace('#','') );
        }
    }
    function initSelect() {
        var blocks = $(".widget_categories").closest('.masonry-item');
        blocks.each(function(e) {
            $(this).attr("style","overflow: visible !important; transform: none !important;");
        });

        [].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
            if ( (" " + el.className + " ").replace(/[\n\t]/g, " ").indexOf(" hidden ") == -1 ) {
                new SelectFx(el);
                el.classList.add("hidden");
            }
        } );
        
        $( ".cs-options li" ).click(function(e) {
            e.stopPropagation();
            var value = $(this).attr('data-value');
            var action = $(this).closest('form').attr('action');
            var url = action + '?cat=' + value;
            window.location = url;
        });
    }

    function initMenu() {
        [].slice.call(document.querySelectorAll('.menu')).forEach(function(menu) {
            var menuItems = menu.querySelectorAll('.menu__link'),
                setCurrent = function(ev) {
                    // ev.preventDefault();

                    var item = ev.target.parentNode; // li

                    // return if already current
                    if (classie.has(item, 'menu__item--current')) {
                        return false;
                    }
                    // remove current
                    classie.remove(menu.querySelector('.menu__item--current'), 'menu__item--current');
                    // set current
                    classie.add(item, 'menu__item--current');
                };

            [].slice.call(menuItems).forEach(function(el) {
                el.addEventListener('click', setCurrent);
            });
        });

        [].slice.call(document.querySelectorAll('.link-copy')).forEach(function(link) {
            link.setAttribute('data-clipboard-text', location.protocol + '//' + location.host + location.pathname + '#' + link.parentNode.id);
            new Clipboard(link);
            link.addEventListener('click', function() {
                classie.add(link, 'link-copy--animate');
                setTimeout(function() {
                    classie.remove(link, 'link-copy--animate');
                }, 300);
            });
        });
    }

    function initInstaCarousel() {
        
        $( '.insta-car .carousel.mini' ).each( function(){
            if ( !$(this).hasClass('slick-initialized') ) {
                $(this).slick({
                    lazyLoad: 'ondemand',
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    dots: false,
                    arrows: false,
                    mobileFirst: true
                });
            }
        });

        $( '.insta-car .carousel.spread' ).each( function(){
            if ( !$(this).hasClass('slick-initialized') ) {
                $(this).slick({
                    lazyLoad: 'ondemand',
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: false,
                    arrows: false,
                    mobileFirst: true,
                    responsive: [{
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4
                        }			
                    },
                    {	
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 6,
                            slidesToScroll: 6
                        }	
                    }]
                });
            }
        });
    }

}());

