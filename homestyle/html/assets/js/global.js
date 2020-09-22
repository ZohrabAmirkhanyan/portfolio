/* ----------------------------------------------------------------------------------------
Author: ARM
------------------------------------------------------------------------------------------*/

(function ($) {
	"use strict";
	const version = 'v1.0.0';
	// Window Resize Mobile Menu Fix
	mobileNav();
	// Scroll animation init
	window.sr = new scrollReveal();
	// Parallax init
	if ($('.arm-parallax').length) {
		$('.arm-parallax').parallax({
			zIndex: '1',
			speed: 0.3
		});
	}
	// Background image set cover
	if ($('.imgfix').length) {
		$('.imgfix').imgfix();
	}
	// Background hover image set cover
	if ($('.imgfix-animate').length) {
		$('.imgfix-animate').imgfix({
			scale: 1.1
		});
	}
	// Slider init
	if ($('.slider-2-col').length) {
		var testimonialOne = $(".slider-2-col");
		testimonialOne.owlCarousel({
			loop: true,
			nav: false,
			dots: true,
			margin: 30,
			autoplay: false,
			autoplayTimeout: 4000,
			autoplayHoverPause: true,
			responsive: {
				0: {
					items: 1
				},
				600: {
					items: 1
				},
				1000: {
					items: 2
				}
			}
		});
	}
	// Menu Dropdown Toggle
	if ($('.menu-trigger').length) {
		$(".menu-trigger").on('click', function () {
			$(this).toggleClass('active');
			$('.menu').slideToggle(200, function(){
				if (!$(this).hasClass('active')) {
					$('.menu-item').removeClass('opened').css('height', '40px');
					$('.sub-menu-item').removeClass('opened').css('height', '40px');
				}
			});
		});
	}
	// Tooltip init
	if ($('[data-toggle="tooltip"]').length) {
		$('[data-toggle="tooltip"]').tooltip();
	}
	// Menu elevator animation
	$('a[href*=\\#]:not([href=\\#])').on('click', function () {
		if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
			if (target.length) {
				var width = $(window).width();
				$('html,body').animate({
					scrollTop: (target.offset().top) - 110
				}, 700);
				return false;
			}
		}
	});
	// Window Resize Mobile Menu Fix
	$(window).on('resize', function () {
		mobileNav();
	});
	// Window Resize Mobile Menu Fix
	function mobileNav() {
		var width = $(window).width();

		if (width < 992) {
			$('.menu-item').on('click', function (e) {
				var el = e.target;
				if ($(el).parents('.sub-menu-item').length || $(el).hasClass('sub-menu-item')) return;

				if ($(this).hasClass('open-sub-menu')) {
					if ($(this).hasClass('opened')) {
						$(this).css('height', '40px');
						$('.sub-menu-item').removeClass('opened').css('height', '40px');
						$(this).removeClass('opened');
					} else {
						$('.menu-item').removeClass('opened').css('height', '40px');
						var menuHeight = $(this).find('.sub-menu').outerHeight() + 40;
						$(this).css('height', menuHeight);
						$(this).addClass('opened');
					}
				}

			});

			$('.sub-menu-item').on('click', function (e) {
				if ($(this).hasClass('open-level-menu')) {
					if ($(this).hasClass('opened')) {
						$(this).css('height', '40px');
						$(this).removeClass('opened');
					} else {
						$('.sub-menu-item').removeClass('opened').css('height', '40px');
						var menuHeight = $(this).find('.level-menu').outerHeight() + 40;
						$(this).css('height', menuHeight);
						$(this).parent().parent().css('height', 'auto');
						$(this).addClass('opened');
					}
				}
			});
		}
	}
})(window.jQuery);