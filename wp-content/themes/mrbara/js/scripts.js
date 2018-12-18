var mrbara = mrbara || {},
	mrbaraShortCode = mrbaraShortCode || {},
	wc_add_to_cart_variation_params = wc_add_to_cart_variation_params || {};
(function ($) {
	'use strict';

	$(function () {
		var $body = $('body'),
			$header = $('#masthead'),
			$mobileNav = $('#primary-mobile-nav'),
			$window = $(window);

		/*
		 HEADER
		 */

		// Reloader
		$body.imagesLoaded(function () {
			$('#loader').delay(300).fadeOut('slow');
		});


		/**
		 * Off canvas cart toggle
		 */
		if ($body.hasClass('header-cart-click')) {
			$header.on('click', '.cart-contents', function (e) {
				e.preventDefault();
				$(this).parent('li').toggleClass('selected-cart');
				$body.toggleClass('display-cart');
			});
		}


		/**
		 * Off canvas cart toggle
		 */
		$header.find('.navbar-toggle').on('click', '.m-navbar-icon', function (e) {
			e.preventDefault();
			$(this).toggleClass('selected-mobile');
			$body.toggleClass('display-mobile-menu');
		});

		$window.on('resize', function () {
			$mobileNav.find('.sub-menu, .dropdown-submenu').css({
				height: $window.height() - 32
			});

			resizeHeaderLeft();

			resizePortfolio();

			resizeProduct();

			resizeMenu();

			if ($window.width() > 1200) {
				$body.find('.shop-sidebar').removeAttr('style');
				$('.shop-filter-mobile').find('.filter-title').removeClass('show-filter');
			}

			if ($window.width() > 1660) {
				$('#shop-topbar').find('.soo-product-filter-widget').find('form').removeAttr('style');
				$('.shop-filter-mobile').find('.filter-title').removeClass('show-filter');
			}


			$header.find('.primary-nav .menu-item.is-mega-menu').each(function () {
				var wsubWidth = $(this).children('.dropdown-submenu').width(),
					wWidth = $(this).outerWidth(),
					offsetLeft = $(this).position().left + (wWidth / 2),
					offsetRight = ( wsubWidth - $(this).position().left ) + (wWidth / 2),
					left = offsetLeft - ( wsubWidth / 2 ),
					right = offsetRight - ( wsubWidth / 2 );

				if (left < 0) {
					left = 0;
				}

				if (right < 0) {
					$(this).children('.dropdown-submenu').css({
						right: 0,
						left : 'auto'
					});
				} else {
					$(this).children('.dropdown-submenu').css('left', left);
				}

			});


			var hHeader = $header.outerHeight(true),
				hTopbar = $('.topbar').outerHeight(true),
				hPromotion = $('#top-promotion').outerHeight(true),
				scrollActive = hHeader + hTopbar + hPromotion + 100,
				maxsCroll = $(document).height() - $window.height();

			if ($body.hasClass('header-sticky') && !$body.hasClass('header-transparent')) {
				$('.header-sticky-sep').height(hHeader);
			}

			if ($header.find('#toggle-product-cats').length > 0) {
				scrollActive += $header.find('#toggle-product-cats').outerHeight(true);
			}

			if ($header.hasClass('header-sticky-1')) {
				var minimizing = scrollActive + 100;

				if (maxsCroll > 400) {

					$window.scroll(function () {
						var scrollTop = $window.scrollTop();

						if (scrollTop >= scrollActive && scrollTop <= minimizing) {
							$header.addClass('opa-0');
						} else {
							$header.removeClass('opa-0');
						}

						if (scrollTop >= scrollActive) {
							$header.addClass('minimized');
							$('.header-sticky-sep').addClass('minimized');
							$('.header-top-style-11').find('.toggle-product-cats').removeClass('open');
						} else {
							$header.removeClass('minimized');
							$('.header-sticky-sep').removeClass('minimized');
							if ($body.hasClass('page-template-template-homepage')) {
								$('.header-top-style-11').find('.open-menu-items .toggle-product-cats').addClass('open');
							}
						}

						if (scrollTop > minimizing) {
							if (!$header.hasClass('minimizing')) {
								$header.addClass('minimizing');
							}
						} else {
							$header.removeClass('minimizing');
						}

					});
				}
			}

			if ($header.hasClass('header-sticky-2')) {
				var scrollOpacity = scrollActive + 100,
					lastScrollTop = 2;

				if (maxsCroll > 400) {
					$window.scroll(function () {
						var scrollTop = $window.scrollTop();
						$header.removeClass('opa-0');
						$header.removeClass('minimizing');
						if (scrollTop > scrollActive) {
							$header.addClass('minimized');
							$('.header-top-style-11').find('.toggle-product-cats').removeClass('open');
							$('.header-sticky-sep').addClass('minimized');
							if (scrollTop < scrollOpacity) {
								$header.addClass('opa-0');
							}

							if (scrollTop < lastScrollTop) {
								$header.addClass('minimizing');
							}

						} else {
							$header.removeClass('minimized');
							$('.header-sticky-sep').removeClass('minimized');
							if ($body.hasClass('page-template-template-homepage')) {
								$('.header-top-style-11').find('.toggle-product-cats').addClass('open');
							}
						}

						lastScrollTop = scrollTop;
					});
				}

			}


		}).trigger('resize');


		if ($body.hasClass('header-top-style-3') || $body.hasClass('header-top-style-11')) {
			$header.find('.menu > .menu-item').last().addClass('last-item');
			$header.find('.menu > .menu-item').last().prev().addClass('last-item');
		}


		// Back to top scroll
		$window.scroll(function () {
			if ($window.scrollTop() > $window.height()) {
				$('#scroll-top').addClass('show-scroll');
			} else {
				$('#scroll-top').removeClass('show-scroll');
			}
		});

		// Scroll effect button top
		$('#scroll-top').on('click', function (event) {
			event.preventDefault();
			$('html, body').stop().animate({
					scrollTop: 0
				},
				1200
			);
		});


		// Menu Mobile
		menuMobile();

		function menuMobile() {
			$mobileNav.find('.menu .menu-item-has-children').prepend('<span class="toggle-children "><i class="arrow_carrot-right"></i> </span>');
			$mobileNav.find('.menu .menu-item-mega').prepend('<span class="toggle-children "><i class="arrow_carrot-right"></i> </span>');
			$mobileNav.find('.menu .menu-item-has-children').each(function () {
				var title = $(this).children('a').find('.menu-title').html();
				if ($(this).hasClass('menu-item-currency') || $(this).hasClass('menu-item-language')) {
					title = $(this).find('.current').html();
				}
				if ($(this).children('a').hasClass('dropdown-toggle')) {
					title = $(this).children('.dropdown-toggle').html();
				}
				$(this).children('ul').prepend('<li class="menu-parent-items">' + title + '</li>');
				$(this).children('ul').prepend('<li class="menu-back">' + mrbara.mrbara_back + '</li>');
			});
			$mobileNav.find('.menu .menu-item-mega').each(function () {
				var title = $(this).children('.dropdown-toggle').html();
				$(this).find('ul').prepend('<li class="menu-parent-items">' + title + '</li>');
				$(this).find('ul').prepend('<li class="menu-back">' + mrbara.mrbara_back + '</li>');
			});
			$mobileNav.find('.menu .menu-item-has-children').on('click', '.toggle-children', function (e) {
				e.preventDefault();
				$(this).parent('li').addClass('over-menu');
				$(this).parents('.menu').addClass('over-submenu');
			});
			$mobileNav.find('.menu .menu-item-mega').on('click', '.toggle-children', function (e) {
				e.preventDefault();
				$mobileNav.find('.menu .menu-item-mega').addClass('active-menu-mega');
				$(this).closest('.menu-item-mega').addClass('over-menu-mega');
				$(this).closest('.menu-item-mega').children('.mega-menu-submenu').addClass('over-menu');
				$(this).parents('.menu').addClass('over-submenu');
			});
			$mobileNav.find('.menu .menu-item-has-children').on('click', '.menu-back', function (e) {
				e.preventDefault();
				$(this).closest('ul').closest('li').removeClass('over-menu');
				if (!$mobileNav.find('.menu .menu-item-has-children').hasClass('over-menu')) {
					$mobileNav.find('.menu').removeClass('over-submenu');
				}
			});
			$mobileNav.find('.menu .menu-item-mega').on('click', '.menu-back', function (e) {
				e.preventDefault();
				$mobileNav.find('.menu .menu-item-mega').removeClass('active-menu-mega');
				$(this).closest('.menu-item-mega').removeClass('over-menu-mega');
				$(this).closest('ul').closest('.mega-menu-submenu').removeClass('over-menu');
				if (!$mobileNav.find('.menu .menu-item-has-children').hasClass('over-menu')) {
					$mobileNav.find('.menu').removeClass('over-submenu');
				}
			});
			$mobileNav.on('click', '.close-canvas-mobile-panel', function (e) {
				e.preventDefault();
				$body.toggleClass('display-mobile-menu');
			});

			$('.wpb_content_element, .primary-sidebar').find('.menu > .menu-item-has-children > a').prepend('<span class="toggle-children"><i class="arrow_carrot-down"></i> </span>');

			$('.wpb_content_element, .primary-sidebar').find('.menu .menu-item-has-children').on('click', '.toggle-children', function (e) {
				e.preventDefault();

				if ($(this).hasClass('show-children')) {
					$(this).removeClass('show-children');
					$(this).closest('li').children('ul').slideUp();
				} else {
					$('.wpb_content_element, .primary-sidebar').find('.menu > .menu-item-has-children > a').find('.toggle-children').removeClass('show-children');
					$(this).toggleClass('show-children');
					$('.wpb_content_element, .primary-sidebar').find('.menu > .menu-item-has-children').children('ul').slideUp();
					$(this).closest('li').children('ul').slideToggle();
				}

			});
		}

		// Parallax
		$('.page-header.parallax').parallax('50%', 0.6);

		/**
		 * Search toggle
		 */
		$('#toggle-search').on('click', function (e) {
			e.preventDefault();

			var $line1 = $(this).find('.t-line1'),
				$line2 = $(this).find('.t-line2'),
				wLine1 = '19px',
				hLine1 = '19px',
				tLine1 = '11px',
				lLine1 = '13px',
				hLine2 = '9px',
				lLine2 = '19px',
				tLine2 = '-5px';

			if (mrbara.direction == 'rtl') {
				lLine1 = '-13px';
				lLine2 = '2px';
			}


			if ($body.hasClass('header-top-style-7')) {
				wLine1 = '16px';
				hLine1 = '16px';
				lLine1 = '13px';
				hLine2 = '8px';
				lLine2 = '16px';

				if (mrbara.direction == 'rtl') {
					lLine2 = '2px';
				}
			}

			if ($(this).closest('.menu-item-search').hasClass('active')) {
				return false;
			} else if ($(this).closest('.menu-item-search').hasClass('show-search-form')) {
				$(this).closest('.menu-item-search').removeClass('show-search-form');
				$(this).closest('.menu-item-search').addClass('active');
				$body.toggleClass('show-search-form');
				$line1.velocity('reverse', {
					duration: 250,
					easing  : 'easeOutSine',
					complete: function () {
						$line1.velocity({
							width       : wLine1,
							height      : hLine1,
							borderRadius: '50%'
						}, {
							duration: 250,
							easing  : 'easeOutSine'
						});
					}
				});
				$(this).find('.t-line2').velocity({
					rotateZ: '-45deg',
					height : hLine2,
					top    : tLine2,
					left   : lLine2
				}, {
					duration: 500,
					easing  : 'easeOutSine',
					complete: function () {
						$(this).closest('.menu-item-search').removeClass('active');
					}

				});

			} else {

				hLine1 = '22px';
				hLine2 = '22px';
				lLine2 = '13px';
				tLine2 = '-11px';

				if (mrbara.direction == 'rtl') {
					lLine2 = '-13px';
				}

				$(this).closest('.menu-item-search').addClass('active');
				$body.toggleClass('show-search-form');
				if ($body.hasClass('header-top-style-7')) {
					hLine1 = '18px';
					hLine2 = '18px';
					lLine2 = '13px';
					tLine1 = '7px';

					if (mrbara.direction == 'rtl') {
						lLine2 = '2px';
						tLine2 = '-17px';
						lLine1 = '3px';
						tLine1 = '0';
					}
				}


				$(this).closest('.menu-item-search').addClass('show-search-form');

				$line1.velocity({
					width       : '0',
					borderRadius: '0',
					rotateZ     : '-45deg',
					height      : hLine1
				}, {
					duration: 250,
					easing  : 'easeOutSine',
					complete: function () {
						$line1.velocity({
							left       : lLine1,
							borderWidth: '1px',
							top        : tLine1

						}, {
							duration: 250,
							easing  : 'easeOutSine'
						});
					}
				});

				$line2.velocity({
					rotateZ: '225deg',
					height : hLine2,
					top    : tLine2,
					left   : lLine2
				}, {
					duration: 500,
					easing  : 'easeOutSine',
					complete: function () {
						$(this).closest('.menu-item-search').removeClass('active');
					}

				});
			}
		});


		// wrap content for product-item-layout-6
		$('.product-item-layout-6 ul.products li.product ').each(function () {
			$(this).find('.star-rating, h3, .price').wrapAll('<div class="product-inner-content"></div>');
		});


		/**
		 * Search panel
		 */
		$('#toggle-search-popup, #search-panel-close').on('click', function (e) {
			e.preventDefault();
			$body.toggleClass('display-search');
		});

		/**
		 * Off canvas nav toggle
		 */
		$('#toggle-nav').on('click', function (e) {
			e.preventDefault();

			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
				$body.removeClass('modal-open display-nav');
				$('#nav-panel').removeClass('in');

			} else {
				$(this).addClass('active');
				$body.addClass('modal-open display-nav');
				$('#nav-panel').addClass('in');
			}
		});

		/**
		 * Hide cart or nav when click to off canvas layer
		 */
		$('#off-canvas-layer, .close-canvas-panel').on('click', function (e) {
			e.preventDefault();

			$body.removeClass('display-cart');
			$body.removeClass('display-mobile-menu');

			// Menu Left
			$('#left-menu-nav').find('.menu-item-cart').removeClass('selected-cart');
		});


		function resizeMenu() {


			if ($body.hasClass('header-left')) {
				if ($window.width() < 1061) {
					$body.removeClass('display-menu-left');
				} else {
					$body.removeClass('display-mobile-menu');
				}
			} else if ($body.hasClass('header-top-style-1')) {
				if ($window.width() > 1061) {
					$body.removeClass('display-mobile-menu');
				}

			} else {
				if ($window.width() < 1024) {
					if ($body.hasClass('display-nav')) {
						$body.removeClass('display-nav');
						$('#nav-panel').hide();
						$('#nav-panel').removeClass('in');
						$body.removeClass('modal-open');
						$('#toggle-nav').removeClass('active');
					}

				} else {
					$body.removeClass('display-mobile-menu');
					$('#nav-panel').show();
				}
			}
		}

		// Menu icon
		$('#nav-panel').on('click', '.menu > .menu-item-has-children > a', function (e) {
			e.preventDefault();
			$('#nav-panel').find('.menu > .menu-item-has-children').children('ul').stop(true, true).slideUp();
			$(this).parent().children('ul').stop(true, true).slideDown();
		});

		// Menu Left
		$('#left-menu-nav').on('click', '.item-menu-nav', function (e) {
			e.preventDefault();
			$(this).toggleClass('selected-nav');
			$body.toggleClass('display-menu-left');
		});

		$('.primary-left-nav').on('mouseenter', 'li', function () {
			$(this).addClass('active');
			$(this).prev('li').addClass('active');
		}).on('mouseleave', 'li', function () {
			$(this).removeClass('active');
			$(this).prev('li').removeClass('active');
		});

		// mega menu
		var heightImage = 0,
			heightCol = 0;
		$header.find('.mega-menu-style-2 .mr-col').each(function () {
			heightCol = Math.max(heightCol, $(this).height());
			heightImage = Math.max(heightImage, $(this).find('.image-bottom').height());
		});

		heightCol = Math.max(heightCol + heightImage, 440);

		$header.find('.mega-menu-style-2 .mr-col').css({
			'padding-bottom': heightImage,
			'height'        : heightCol
		}).addClass('hide-sub-menu');

		$header.find('.mega-menu-style-2 .mr-col').mouseover(function () {
			$(this).css({
				'padding-bottom': heightImage - 60
			});
		}).mouseout(function () {
			$(this).css({
				'padding-bottom': heightImage
			});
		});

		// toggle left sidebar
		$('#left-sidebar').on('click', '.menu-item-has-children > a', function (e) {
			e.preventDefault();

			if ($(this).parent('li').hasClass('mr-active')) {
				$(this).parent('li').removeClass('mr-active');
				$(this).parent('li').children('ul').slideUp(200);
			} else {
				$('#left-sidebar').find('.menu-item-has-children').children('ul').slideUp(200);
				$('#left-sidebar').find('li').removeClass('mr-active');
				$(this).parent('li').addClass('mr-active');
				$(this).parent('li').children('ul').slideToggle(200);
			}


		});


		// Header left
		function resizeHeaderLeft() {

			if (!$body.hasClass('header-left-style-2')) {
				return;
			}

			$window.on('load', function () {
				var hLeft7 = $('.page-template-template-homepage').find('.site').height(),
					wWindow = $window.width();

				if (hLeft7 < 1100 && wWindow > 1449) {
					$body.addClass('header-left-small');
				} else {
					$body.removeClass('header-left-small');
				}
			});
		}

		// SHOP JS
		productSwatches();
		function productSwatches() {
			$('body').find('.attr-swatches').on('click', '.swatch-variation-image', function () {
				$(this).siblings('.swatch-variation-image').removeClass('selected');
				$(this).addClass('selected');
				var imgSrc = $(this).data('src'),
					$mainImages = $(this).parents('li.product').find('.product-content-thumbnails > a'),
					image = $mainImages.find('img').first(),
					imgWidth = $mainImages.find('img').first().width(),
					imgHeight = $mainImages.find('img').first().height();

				$mainImages.addClass('image-loading');

				image.attr('src', imgSrc);
				image.attr('srcset', imgSrc);
				image.attr('src-orig', imgSrc);

				$mainImages.css({
					width  : imgWidth,
					height : imgHeight,
					display: 'block'
				});

				$mainImages.imagesLoaded(function () {
					$mainImages.removeClass('image-loading');
					$mainImages.removeAttr('style');
				});
			});
		}


		if ($('.site-content').find('.widget').hasClass('soo-product-filter-widget')) {
			$('.site-content').addClass('show-product-filter-mobile');
		}

		$body.find('.shop-filter-mobile .filter-title').removeClass('show-filter');

		$('#content').find('.shop-filter-mobile').on('click', '.filter-title', function (e) {
			e.preventDefault();
			var topMobile = $('.shop-filter-mobile').position().top + $('.shop-filter-mobile').outerHeight(true) + parseInt($('#content').css('padding-top'), 10);

			$('.shop-sidebar ').css({top: topMobile});
			$(this).toggleClass('show-filter');
			$(this).parents('.site-content').find('.shop-sidebar').stop().slideToggle();
		});


		$('#shop-topbar').find('.soo-product-filter-widget').prepend('<div class="shop-filter-mobile"><a href="#" class="filter-title"><i class="ion-android-menu"></i><span>' + mrbara.mrbara_filter_by + '</span></a></div>');

		$('#shop-topbar').find('.shop-filter-mobile').on('click', '.filter-title', function (e) {
			e.preventDefault();
			$(this).toggleClass('show-filter');
			$(this).parents('.soo-product-filter-widget').find('form').stop().slideToggle();
		});

		//select 2 for toolbar
		$('.shop-toolbar').find('.orderby').select2({
			minimumResultsForSearch: Infinity
		});

		// select 2 for product categories
		$('#product_cat').select2({}).on('select2:opening', function () {
			$body.addClass('show-dropdown-product-cat');
		}).on('select2:closing', function () {
			$body.removeClass('show-dropdown-product-cat');
		});

		/**
		 * Filter product category
		 */
		$window.load(function () {
			$('.product-cat-filter').find('ul.products').isotope({
				itemSelector: 'li.product',
				layoutMode  : 'fitRows'
			});
		});

		$('#filters-product-cat').on('click', 'a', function (e) {
			e.preventDefault();

			var selector = $(this).attr('data-option-value');
			$(this).parents('.site-content').find('ul.products').isotope({
				filter    : selector,
				layoutMode: 'fitRows'
			});

			$(this).parents('ul').find('a').removeClass('selected');
			$(this).addClass('selected');

			if ($('.shop-navigation-ajax .woocommerce-pagination').is(':in-viewport')) {
				$('.shop-navigation-ajax .woocommerce-pagination').find('.page-numbers.next').click();
			}
		});

		/**
		 * Shop view toggle
		 */
		$('.shop-view').on('click', 'a', function (e) {
			e.preventDefault();
			var $el = $(this),
				view = $el.data('view');

			if ($el.hasClass('current')) {
				return;
			}

			if (view == 'list') {
				$body.removeClass(mrbara.product_item_layout);
			} else if (!$body.hasClass(mrbara.product_item_layout)) {
				$body.addClass(mrbara.product_item_layout);
			}

			$el.addClass('current').siblings().removeClass('current');
			$body.removeClass('shop-view-grid shop-view-list').addClass('shop-view-' + view);

			if ($body.hasClass('product-cat-filter')) {
				$('.product-cat-filter').find('ul.products').isotope({
					itemSelector: 'li.product',
					layoutMode  : 'fitRows'
				});
			}

			document.cookie = 'shop_view=' + view + ';domain=' + window.location.host + ';path=/';


		});

		// Shop Masonry
		$('.shop-subcategories').find('ul.products').append('<li class="cat-sizer"></li>');
		var $cat = $('.shop-subcategories').find('ul.products'),
			options;

		options = {
			itemSelector: '.product-category',
			masonry     : {
				columnWidth: '.cat-sizer'
			}
		};

		$body.imagesLoaded(function () {
			$cat.isotope(options);
		});

		productQuantity($body);
		// Increase/Decrease Product Quantity
		function productQuantity($object) {
			// Increase Product Quantity
			$object.find('.quantity').on('click', '.qty-plus', function (e) {
				e.preventDefault();
				var $quantityInput = $(this).parents('.quantity').find('input.qty'),
					step = parseInt($quantityInput.attr('step'), 10),
					newValue = parseInt($quantityInput.val(), 10) + step,
					maxValue = parseInt($quantityInput.attr('max'), 10);

				if (!maxValue) {
					maxValue = 9999999999;
				}

				if (newValue <= maxValue) {
					$quantityInput.val(newValue);
				}
			});
			// Decrease
			$object.find('.quantity').on('click', '.qty-minus', function (e) {
				e.preventDefault();
				var $quantityInput = $(this).parents('.quantity').find('input.qty'),
					step = parseInt($quantityInput.attr('step'), 10),
					newValue = parseInt($quantityInput.val(), 10) - step,
					minValue = parseInt($quantityInput.attr('min'), 10);

				if (!minValue) {
					minValue = 1;
				}

				if (newValue >= minValue) {
					$quantityInput.val(newValue);
				}
			});
		}

		$window.on('scroll', function () {

			if ($('.shop-navigation-ajax .woocommerce-pagination').is(':in-viewport')) {
				$('.shop-navigation-ajax .woocommerce-pagination').find('.page-numbers.next').click();
			}

			if ($('.blog-navigation-ajax .post-pagination').is(':in-viewport')) {
				$('.blog-navigation-ajax .post-pagination').find('.page-numbers.next').click();
			}

			if ($('.portfolio-navigation-ajax .post-pagination').is(':in-viewport')) {
				$('.portfolio-navigation-ajax .post-pagination').find(' .page-numbers.next').click();
			}


		}).trigger('scroll');


		/**
		 * Load ajax on shop page.
		 */
		$('.shop-navigation-ajax').on('click', '.page-numbers.next', function (e) {
			e.preventDefault();

			if ($(this).data('requestRunning')) {
				return;
			}

			$(this).data('requestRunning', true);

			$(this).addClass('loading');

			var $products = $(this).parents('.woocommerce-pagination').prev('.products'),
				$pagination = $(this).parents('.woocommerce-pagination');

			$.get(
				$(this).attr('href'),
				function (response) {
					var content = $(response).find('ul.products').html(),
						$pagination_html = $(response).find('.woocommerce-pagination').html();
					var $content = $(content);

					$pagination.html($pagination_html);
					if ($body.hasClass('product-cat-filter')) {
						$content.imagesLoaded(function () {
							$products.isotope('insert', $content);
							$pagination.find('.page-numbers.next').removeClass('loading');
							$pagination.find('.page-numbers.next').data('requestRunning', false);
							productSwatches();

						});
					} else {
						$products.append($content);
						$pagination.find('.page-numbers.next').removeClass('loading');
						$pagination.find('.page-numbers.next').data('requestRunning', false);
						productSwatches();

					}

					if (!$pagination.find('li .page-numbers').hasClass('next')) {
						$pagination.addClass('loaded');
					}

					toolTopIcon();

					$('.product-item-layout-6 ul.products li.product ').each(function () {
						$(this).find('.star-rating, h3, .price').wrapAll('<div class="product-inner-content"></div>');
					});
				}
			);
		});


		productGallery();
		productThumbnail();

		function productThumbnail() {

			if (!$body.hasClass('product-page-thumbnail-carousel')) {
				return;
			}

			var $thumbnails = $('#product-thumbnails'),
				$mainImages = $('#product-images'),
				asNavFor = $thumbnails,
				vertical = false,
				rtl = false,
				rtl_thumb = false;

			if (mrbara.direction == 'rtl') {
				rtl = true;
				rtl_thumb = true;
			}

			if ($body.hasClass('product-page-layout-4') ||
				$body.hasClass('product-page-layout-6') ||
				$body.hasClass('product-page-layout-10')
			) {
				asNavFor = '';
			}

			if ($body.hasClass('product-page-layout-9') ||
				$body.hasClass('product-page-layout-12')) {
				vertical = true;
				rtl_thumb = false;
			}

			$mainImages.not('.slick-initialized').slick({
				slidesToShow  : 1,
				slidesToScroll: 1,
				infinite      : false,
				dots          : true,
				rtl           : rtl,
				asNavFor      : asNavFor,
				prevArrow     : '<span class="arrow_carrot-left slick-prev-arrow"></span>',
				nextArrow     : '<span class="arrow_carrot-right slick-next-arrow"></span>'
			});

			$thumbnails.not('.slick-initialized').slick({
				slidesToShow  : 4,
				slidesToScroll: 1,
				asNavFor      : $mainImages,
				focusOnSelect : true,
				vertical      : vertical,
				infinite      : false,
				rtl           : rtl_thumb,
				prevArrow     : '<span class="arrow_carrot-left slick-prev-arrow"></span>',
				nextArrow     : '<span class="arrow_carrot-right slick-next-arrow"></span>'
			});

			$mainImages.imagesLoaded(function () {
				$mainImages.addClass('loaded');
			});

			$thumbnails.imagesLoaded(function () {
				$thumbnails.addClass('loaded');
			});

			if (mrbara.product_zoom === '1') {
				$mainImages.find('.photoswipe').each(function () {
					$(this).zoom({
						url: $(this).attr('href'),
						touch: false
					});

				});
			}

			$(document).on('found_variation', 'form.variations_form', function (event) {
				event.preventDefault();
				$('#product-images').slick('slickGoTo', 0, true);

				if (mrbara.product_zoom === '1') {
					$('#product-images').find('.photoswipe').each(function () {
						$(this).zoom({
							url: $(this).attr('href'),
							touch: false
						});

					});
				}
			}).on('reset_image', function () {
				$('#product-images').slick('slickGoTo', 0, true);

				if (mrbara.product_zoom === '1') {
					$('#product-images').find('.photoswipe').each(function () {
						$(this).zoom({
							url: $(this).attr('href'),
							touch: false
						});

					});
				}
			});
		}

		function productGallery() {
			var $images = $('#product-images');

			if ('no' == mrbara.lightbox) {
				$images.on('click', 'a.photoswipe', function () {
					return false;
				});
				return;
			}

			if (!$images.length) {
				return;
			}


			$images.on('click', 'a.photoswipe', function (e) {
				e.preventDefault();

                var $links = $images.find('a.photoswipe'),
                    items = [];

                $links.each(function () {
                    var $a = $(this);

                    if ($a.hasClass('video')) {
                        items.push({
                            html: $a.data('href')
                        });

                    } else {
                        items.push({
                            src: $a.attr('href'),
                            w  : $a.find('img').first().attr('data-large_image_width'),
                            h  : $a.find('img').first().attr('data-large_image_height'),
                            title: $a.find('img').attr( 'data-caption' ) ? $a.find('img').attr( 'data-caption' ) : $a.find('img').attr( 'title' )
                        });
                    }

                });

				var index = $links.index($(this)),
					options = {
						index              : index,
						bgOpacity          : 0.85,
						showHideOpacity    : true,
						mainClass          : 'pswp--minimal-dark',
						barsSize           : {top: 0, bottom: 0},
						captionEl          : true,
						fullscreenEl       : false,
						shareEl            : false,
						tapToClose         : true,
						tapToToggleControls: false

					};

				var lightBox = new PhotoSwipe(document.getElementById('pswp'), window.PhotoSwipeUI_Default, items, options);
				lightBox.init();
			});
		}


		// Single product
		function resizeProduct() {
			var wWidth = $('#content').width(),
				wRight = 0,
				wContainer = $('#content').children('.container').width();

			if (wWidth > 767) {
				wRight = (wWidth - wContainer) / 2;
			}

			if (mrbara.direction == 'rtl') {
				$('.product-page-layout-11').find('.product-details .product-images-content').css({
					'margin-right': wRight * -1
				});

				$('.product-page-layout-7').find('.product-details .product-images-content').css({
					'margin-left': wRight * -1
				});
			} else {
				$('.product-page-layout-7, .product-page-layout-11').find('.product-details .product-images-content').css({
					'margin-left': wRight * -1
				});
			}


		}

		// soopas_variation_swatches_form
		$(document.body).on('soopas_initialized', function () {
			$body.addClass('has-soopas');
			$('.variations_form').unbind('soopas_no_matching_variations');
			$('.variations_form').on('soopas_no_matching_variations', function (event, $el) {
				event.preventDefault();
				$el.addClass('selected');

				$('.variations_form').find('.woocommerce-variation.single_variation').show();
				if (typeof wc_add_to_cart_variation_params !== 'undefined') {
					$('.variations_form').find('.single_variation').slideDown(200).html('<p>' + wc_add_to_cart_variation_params.i18n_no_matching_variations_text + '</p>');
				}
			});

		});

		$('.variations_form').find('.styled-select').each(function () {
			if (!$(this).find('.variation-selector').hasClass('hidden')) {
				$(this).addClass('show-select');
			}
		});

		quickView();

		// Show quick view of product
		function quickView() {
			/**
			 * Product quick view popup
			 */
			var $modal = $('#modal'),
				$modalBody = $modal.find('.modal-body');

			// Open product single modal
			$body.on('click', '.product-quick-view', function (e) {
				e.preventDefault();

				$modal.addClass('in');
				$body.addClass('modal-open');
				$modalBody.html('');
				$modalBody.removeClass().addClass('modal-body');

				$.get($(this).attr('data-href'), function (response) {
					if (!response) {
						return;
					}

					var $content = $(response).find('.product-details'),
						productClasses = $(response).find('.product').attr('class');
					$modalBody.html($content);

					$modal.addClass('display-content');
					$modalBody.addClass(productClasses);

					// Quantity
					productQuantity($content);

					$content.find('.variations_form .styled-select').each(function () {
						if (!$(this).find('.variation-selector').hasClass('hidden')) {
							$(this).addClass('show-select');
						}
					});

					$content.find('.woocommerce-main-image').each(function () {
						if (!$(this).hasClass('active')) {
							$(this).remove();
						}
					});

					var $thumbnails = $content.find('#product-thumbnails'),
						$mainImages = $content.find('#product-images'),
						$mainNav = $thumbnails.length > 0 ? $thumbnails : false;


					$mainImages.not('.slick-initialized').slick({
						slidesToShow  : 1,
						slidesToScroll: 1,
						infinite      : false,
						dots          : true,
						asNavFor      : $mainNav,
						prevArrow     : '<span class="arrow_carrot-left slick-prev-arrow"></span>',
						nextArrow     : '<span class="arrow_carrot-right slick-next-arrow"></span>'
					});

					$thumbnails.not('.slick-initialized').slick({
						slidesToShow  : 4,
						slidesToScroll: 1,
						asNavFor      : $mainImages,
						focusOnSelect : true,
						infinite      : false,
						prevArrow     : '<span class="arrow_carrot-left slick-prev-arrow"></span>',
						nextArrow     : '<span class="arrow_carrot-right slick-next-arrow"></span>'
					});

					$mainImages.imagesLoaded(function () {
						$mainImages.addClass('loaded');
					});

					$thumbnails.imagesLoaded(function () {
						$thumbnails.addClass('loaded');
					});

					if (typeof wc_add_to_cart_variation_params !== 'undefined') {
						$('.variations_form').wc_variation_form();
						$('.variations_form .variations select').change();
					}

					if (typeof $.fn.soopas_variation_swatches_form !== 'undefined') {
						$('.variations_form').soopas_variation_swatches_form();
					}

					$(document).on('found_variation', 'form.variations_form', function (event) {
						event.preventDefault();
						$mainImages.slick('slickGoTo', 0, true);

					}).on('reset_image', function () {
						$mainImages.slick('slickGoTo', 0, true);
					});


					$('.variations_form').unbind('soopas_no_matching_variations');
					$('.variations_form').on('soopas_no_matching_variations', function (event, $el) {
						event.preventDefault();
						$el.addClass('selected');

						$('.variations_form').find('.woocommerce-variation.single_variation').show();
						if (typeof wc_add_to_cart_variation_params !== 'undefined') {
							$('.variations_form').find('.single_variation').slideDown(200).html('<p>' + wc_add_to_cart_variation_params.i18n_no_matching_variations_text + '</p>');
						}
					});


				});
			});

			// Close portfolio modal
			$modal.on('click', '.mr-close-modal', function (e) {
				e.preventDefault();

				$body.removeClass('modal-open');
				$modal.removeClass('in');
				$modal.removeClass('display-content');
				$modalBody.html('');
				$modalBody.removeClass().addClass('modal-body');

			});

			// Prevent click event on image link
			$modal.on('click', '.images a', function (e) {
				e.preventDefault();
			});
		}

		// Instance search
		if ($().autocomplete) {
			var searchCache = {}; // Cache the search results

			$.ui.autocomplete.prototype._renderItem = function (ul, item) {
				return $('<li class="woocommerce"></li>')
					.append('<a href="' + item.value + '">' + item.thumb + '<span class="product-title">' + item.label + '</span>' + item.rate + '<span class="product-price">' + item.price + '</span></a>')
					.appendTo(ul);
			};

			$('#search-field-auto').autocomplete({
				minLength: 2,
				source   : function (request, response) {
					var term = request.term,
						cat = $(this.element).closest('.products-search').find('.product-cat').children('select').val(),
						key = term + '|' + cat;

					if (key in searchCache) {
						response(searchCache[key]);
						return;
					}

					$.ajax({
						url     : mrbara.ajax_url,
						dataType: 'json',
						method  : 'post',
						data    : {
							action : 'search_products',
							mbnonce: mrbara.nonce,
							term   : term,
							cat    : cat
						},
						success : function (data) {
							searchCache[key] = data.data;
							response(data.data);
						}
					});
				},
				select   : function (event, ui) {
					event.preventDefault();
					if (ui.item.value != '#') {
						location.href = ui.item.value;
					}
				}
			});
		}


		$('.shop-toolbar').find('.show-number').on('click', '.input-number', function () {
			$(this).parents('.shop-products-number').submit();
		});

		/* ToolTip */
		toolTopIcon();

		function toolTopIcon() {
			$('.yith-wcwl-add-to-wishlist .add_to_wishlist').attr('data-original-title', $('.yith-wcwl-add-to-wishlist .add_to_wishlist').html()).attr('rel', 'tooltip');
			$('.yith-wcwl-wishlistaddedbrowse a').attr('data-original-title', $('.yith-wcwl-wishlistaddedbrowse a').html()).attr('rel', 'tooltip');
			$('.yith-wcwl-wishlistexistsbrowse a').attr('data-original-title', $('.yith-wcwl-wishlistexistsbrowse a').html()).attr('rel', 'tooltip');
			$('.woocommerce .compare.button').attr('data-original-title', $('.woocommerce .compare.button').html()).attr('rel', 'tooltip');
			$('[rel=tooltip]').tooltip({offsetTop: -15});
		}

		$(document).on('soo_filter_request_success', function (event, response) {
			toolTopIcon();

			var products_found = 0;
			if ($(response).find('.products-found').length > 0) {
				products_found = $(response).find('.products-found span').html();
			}

			$('.shop-toolbar').find('.products-found span').html(products_found);

			$('#filters-product-cat').find('a').removeClass('selected');
			$('#filters-product-cat li').first().find('a').addClass('selected');

			productSwatches();


			$window.on('scroll', function () {
				if ($('.shop-navigation-ajax').find('.woocommerce-pagination').is(':in-viewport')) {
					$('.shop-navigation-ajax').find('.page-numbers.next').trigger('click');
				}

			}).trigger('scroll');
		});


		/*
		 SHOPPING CART
		 */

		// Calculate Shipping
		$('.woocommerce-shipping-calculator').on('click', '.shipping-calculator-button', function () {
			$(this).parents('.woocommerce-shipping-calculator').find('.shipping-calculator-form').removeAttr('style');
			$(this).parents('.woocommerce-shipping-calculator').toggleClass('hide-form');
			return false;
		});

		// Coupon
		$('#coupon-actions').on('click', '.coupon-code', function (e) {
			e.preventDefault();
			$(this).parent().toggleClass('hide-form');
		});


		/*  LOGIN & REGISTER POPUP */

		// Show login popup
		var $login = $('#login-popup');
		$header.on('click', '#menu-extra-login', function (e) {
			e.preventDefault();
			$login.addClass('display-content');
			$login.addClass('in');
			$login.addClass('modal-open');
			$login.removeClass('register-active');
			$login.addClass('login-active');
		});

		$login.on('click', function (e) {
			if (e.target.className === 'modal-dialog') {
				e.preventDefault();
				$body.removeClass('modal-open');
				$login.removeClass('in');
				$login.removeClass('display-content');
			}
		});

		$login.on('click', '.mr-close-modal', function (e) {
			e.preventDefault();

			$body.removeClass('modal-open');
			$login.removeClass('in');
			$login.removeClass('display-content');

		});

		$login.on('click', '.register-tab', function (e) {
			e.preventDefault();
			$login.removeClass('login-active');
			$login.addClass('register-active');

		});

		$login.on('click', '.login-tab', function (e) {
			e.preventDefault();
			$login.removeClass('register-active');
			$login.addClass('login-active');

		});

		$header.on('click', '#menu-extra-register', function (e) {
			e.preventDefault();
			$login.addClass('display-content');
			$login.addClass('in');
			$login.addClass('modal-open');
			$login.removeClass('login-active');
			$login.addClass('register-active');
		});

		// NEWLETTER POPUP //
		newletterPopup();
		function newletterPopup() {
			// Show newsletter popup
			if ($body.hasClass('show-newsletter-popup')) {
				var $modal = $('#newsletter-popup');
				if (getCookie('mrnewletter') !== '1') {
					setTimeout(function () {
						$modal.addClass('display-content');
						$modal.addClass('in');
						$body.addClass('modal-open');
					}, mrbara.newsletter_seconds);
				}

				$modal.on('click', '.mr-close-modal', function (e) {
					e.preventDefault();

					setCookie('mrnewletter', 1, mrbara.days);

					$body.removeClass('modal-open');
					$modal.removeClass('in');
					$modal.removeClass('display-content');

				});

				$modal.on('click', '.n-close', function (e) {
					e.preventDefault();

					setCookie('mrnewletter', 1, 30);

					$body.removeClass('modal-open');
					$modal.removeClass('in');
					$modal.removeClass('display-content');

				});

				$modal.find('.mc4wp-form').submit(function () {
					setCookie('mrnewletter', 1, mrbara.days);
				});
			}
		}


		if (!$body.hasClass('page-template-template-home-split')) {
			$('.testimonial-carousel').each(function () {
				var $carousel = $(this),
					auto = parseInt($carousel.data('autoplay'), 10),
					arrows = $carousel.data('avatar') == 'yes' ? ['<i class="ion-ios-arrow-left"></i>', '<i class="ion-ios-arrow-right"></i>'] : ['<i class="arrow_left"></i>', '<i class="arrow_right"></i>'];

				$carousel.owlCarousel({
					direction     : mrbara.direction,
					items         : 1,
					singleItem    : true,
					slideSpeed    : 1000,
					autoPlay      : auto === 0 ? false : auto,
					pagination    : false,
					navigation    : $carousel.data('nav') == 'yes',
					navigationText: arrows
				});
			});
		}


		// BLOG JS

		videoBlog();

		function videoBlog() {
			if (!$body.hasClass('blog') && !$body.hasClass('single-post')) {
				return;
			}

			if ($('.entry-format.format-video').length > 0) {
				$('.format-video').find('.video-play').magnificPopup({
					disableOn      : 0,
					type           : 'iframe',
					mainClass      : 'mfp-fade',
					removalDelay   : 160,
					preloader      : false,
					fixedContentPos: false
				});
			}

		}


		// Blog isotope
		$window.load(function () {

			var masony = 'fitRows';

			if ($body.hasClass('blog-view-masony')) {
				masony = 'masonry';
			}

			$('.content-isotope').isotope({
				itemSelector: '.blog-wapper',
				layoutMode  : masony
			});
		});

		$('#category-filter').on('click', 'a', function (e) {
			e.preventDefault();

			var selector = $(this).attr('data-option-value');
			$('.content-isotope').isotope({filter: selector});

			$(this).parents('ul').find('a').removeClass('selected');
			$(this).addClass('selected');

			if ($('.blog-navigation-ajax .post-pagination').is(':in-viewport')) {
				$('.blog-navigation-ajax .post-pagination').find('.page-numbers.next').click();
			}
		});

		/**
		 * Load ajax on blog page.
		 */

		$('.blog-navigation-ajax').find('.post-pagination').on('click', '.page-numbers.next', function (e) {
			e.preventDefault();

			if ($(this).data('requestRunning')) {
				return;
			}

			$(this).data('requestRunning', true);

			$(this).addClass('loading');

			var $posts = $(this).parents('.post-pagination').prev('.content-isotope'),
				$pagination = $(this).parents('.post-pagination');

			$.get(
				$(this).attr('href'),
				function (response) {
					var content = $(response).find('div.content-isotope').children('article'),
						$pagination_html = $(response).find('.post-pagination').html();

					$pagination.html($pagination_html);

					content.imagesLoaded(function () {
						$posts.append(content).isotope('insert', content);
						videoBlog();
						gallerySlider();
						$pagination.find('.page-numbers.next').removeClass('loading');
						$pagination.find('.page-numbers.next').data('requestRunning', false);
					});

				}
			);
		});

		gallerySlider();
		/*
		 * gallery slider
		 */
		function gallerySlider() {


			var arLeft = '<span class="arrow_carrot-left">' + mrbara.prev + '</span>',
				arNext = '<span class="arrow_carrot-right">' + mrbara.next + '</span>';

			// Flex slider for gallery
			$body.find('.format-gallery-slider .slides').owlCarousel({
				direction      : mrbara.direction,
				singleItem     : true,
				slideSpeed     : 800,
				navigation     : true,
				pagination     : false,
				autoPlay       : false,
				paginationSpeed: 1000,
				navigationText : [arLeft, arNext]
			});
		}

		// set Cookie
		function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
			var expires = 'expires=' + d.toUTCString();
			document.cookie = cname + '=' + cvalue + '; ' + expires + ';domain=' + window.location.host + ';path=/';
		}

		// Get Cookie
		function getCookie(cname) {
			var name = cname + '=';
			var ca = document.cookie.split(';');
			for (var i = 0; i < ca.length; i++) {
				var c = ca[i];
				while (c.charAt(0) == ' ') {
					c = c.substring(1);
				}
				if (c.indexOf(name) === 0) {
					return c.substring(name.length, c.length);
				}
			}
			return '';
		}

		splitScroll();
		// split scroll
		function splitScroll() {
			if ($body.hasClass('page-template-template-home-split')) {
				$('html').addClass('page-template-template-home-split');
			}

			var $splitScroll = $('#split-scroll');
			if ($splitScroll.length) {
				var leftSections = $splitScroll.children('.ms-left').children('.ms-section'),
					rightSections = $splitScroll.children('.ms-right').children('.ms-section');

				$splitScroll.multiscroll({
					easeInExpo : 'easeInCirc',
					delay      : 700,
					onLeave    : function (index) {
						$(leftSections[index - 1]).removeClass('loaded');
						$(rightSections[index - 1]).removeClass('loaded');
					},
					afterLoad  : function (anchorLink, index) {
						$(leftSections[index - 1]).addClass('loaded');
						$(rightSections[index - 1]).addClass('loaded');
					},
					afterRender: function () {
						$('.testimonial-carousel').each(function () {
							var $carousel = $(this),
								auto = parseInt($carousel.data('autoplay'), 10),
								arrows = $carousel.data('avatar') == 'yes' ? ['<i class="ion-ios-arrow-left"></i>', '<i class="ion-ios-arrow-right"></i>'] : ['<i class="arrow_left"></i>', '<i class="arrow_right"></i>'];

							$carousel.owlCarousel({
								direction     : mrbara.direction,
								singleItem    : true,
								slideSpeed    : 1000,
								autoPlay      : auto === 0 ? false : auto,
								pagination    : false,
								navigation    : $carousel.data('nav') == 'yes',
								navigationText: arrows
							});
						});
					}
				});

				$('#split-scroll-nav').on('click', 'a', function (e) {
					e.preventDefault();

					if ($(this).hasClass('scrollup')) {
						$splitScroll.multiscroll.moveSectionUp();
					} else {
						$splitScroll.multiscroll.moveSectionDown();
					}
				});
			}

			$('#split-scroll-mobile').find('.testimonial-carousel').each(function () {
				var $carousel = $(this),
					auto = parseInt($carousel.data('autoplay'), 10),
					arrows = $carousel.data('avatar') == 'yes' ? ['<i class="ion-ios-arrow-left"></i>', '<i class="ion-ios-arrow-right"></i>'] : ['<i class="arrow_left"></i>', '<i class="arrow_right"></i>'];

				$carousel.owlCarousel({
					direction     : mrbara.direction,
					singleItem    : true,
					slideSpeed    : 1000,
					autoPlay      : auto === 0 ? false : auto,
					pagination    : false,
					navigation    : $carousel.data('nav') == 'yes',
					navigationText: arrows
				});
			});

		}

		// Portfolio masonry
		var layoutMode = 'masonry';
		if ($body.hasClass('portfolio-grid')) {
			layoutMode = 'fitRows';
		}


		$body.imagesLoaded(function () {
			$('.portfolio-showcase').find('.portfolio-list').isotope({
				transitionDuration: '0.8s',
				itemSelector      : '.portfolio-wapper',
				layoutMode        : layoutMode
			});
		});

		$('#portfolio-category-filters').on('click', 'a', function (e) {
			e.preventDefault();

			var selector = $(this).attr('data-option-value');
			$('.portfolio-showcase').find('.portfolio-list').isotope({
				filter: selector
			});

			$(this).parents('ul').find('a').removeClass('selected');
			$(this).parent().find('a').addClass('selected');

			if ($('.portfolio-navigation-ajax .post-pagination').is(':in-viewport')) {
				$('.portfolio-navigation-ajax .post-pagination').find(' .page-numbers.next').click();
			}
		});

		$('.portfolio-navigation-ajax').find('.post-pagination').on('click', '.page-numbers.next', function (e) {
			e.preventDefault();

			if ($(this).data('requestRunning')) {
				return;
			}

			$(this).data('requestRunning', true);

			$(this).addClass('loading');

			var $portfolio = $(this).parents('.portfolio-showcase').find('.portfolio-list'),
				$pagination = $(this).parents('.post-pagination');

			$.get(
				$(this).attr('href'),
				function (response) {
					var content = $(response).find('.portfolio-showcase .portfolio-list .portfolio-wapper'),
						$pagination_html = $(response).find('.post-pagination').html();

					$pagination.html($pagination_html);

					content.imagesLoaded(function () {
						$portfolio.append(content).isotope('insert', content);

						$pagination.find('.page-numbers.next').removeClass('loading');
						$pagination.find('.page-numbers.next').data('requestRunning', false);
					});
				}
			);
		});

		// resize single portfolio
		function resizePortfolio() {
			if (!$body.hasClass('single-portfolio_project')) {
				return;
			}
			var wWidth = $('#content').width(),
				wRight = 0;

			if (wWidth > 1170) {
				wRight = (wWidth - 1170) / 2;
			}

			$('.single-portfolio-type-image').find('.portfolio-images').css({
				'margin-right': wRight * -1
			});


			if (!$('.gallery-main-carousel').hasClass('slick-initialized')) {
				var rtl = false;
				if (mrbara.direction == 'rtl') {
					rtl = true;
				}
				$('.gallery-main-carousel').slick({
					rtl          : rtl,
					dots         : false,
					infinite     : true,
					speed        : 1000,
					slidesToShow : 1,
					centerMode   : true,
					variableWidth: true,
					prevArrow    : '<i class="ion-ios-arrow-left slick-arrow-left"></i>',
					nextArrow    : '<i class="ion-ios-arrow-right slick-arrow-right"></i>'

				});
			}
		}

		// toggle product cat header 11
		$('.header-top-style-11').find('.products-cats-menu.on-click').on('click', '.cats-menu-title', function (e) {
			e.preventDefault();
			$(this).parent().find('.toggle-product-cats').toggleClass('open');
		});

		// update wishlist count
		$body.on('added_to_wishlist removed_from_wishlist', function () {
			$.ajax({
				url     : mrbara.ajax_url,
				dataType: 'json',
				method  : 'post',
				data    : {
					action: 'update_wishlist_count'
				},
				success : function (data) {
					$header.find('.menu-item-wishlist .mini-yith-counter').html(data);
				}
			});
		});

		$body.on('click', '.product a.compare', function (e) {
			e.preventDefault();
			var compare = false;

			if ($(this).hasClass('added')) {
				compare = true;
			} else if ($(this).closest('.footer-product-button').hasClass('compare-added')) {
				compare = true;
			}

			if (compare === false) {
				var compare_counter = $header.find('#mini-compare-counter').html();
				compare_counter = parseInt(compare_counter, 10) + 1;

				setTimeout(function () {
					$header.find('#mini-compare-counter').html(compare_counter);
				}, 2000);

			}
		});

		$(document).find('.compare-list').on('click', '.remove a', function (e) {
			e.preventDefault();
			var compare_counter = $('#mini-compare-counter', window.parent.document).html();
			compare_counter = parseInt(compare_counter, 10) - 1;
			if (compare_counter < 0) {
				compare_counter = 0;
			}

			$('#mini-compare-counter', window.parent.document).html(compare_counter);
		});

		$('.yith-woocompare-widget').on('click', 'li a.remove', function (e) {
			e.preventDefault();
			var compare_counter = $header.find('#mini-compare-counter').html();
			compare_counter = parseInt(compare_counter, 10) - 1;
			if (compare_counter < 0) {
				compare_counter = 0;
			}

			setTimeout(function () {
				$header.find('#mini-compare-counter').html(compare_counter);
			}, 2000);

		});

		$('.yith-woocompare-widget').on('click', 'a.clear-all', function (e) {
			e.preventDefault();
			setTimeout(function () {
				$header.find('#mini-compare-counter').html('0');
			}, 2000);
		});


		topPromotion();
		function topPromotion() {

			if ($('#top-promotion').length === 0) {
				return;
			}
			// Toggle promotion
			$('#top-promotion').on('click', '.close', function (e) {
				e.preventDefault();

				$(this).parents('#top-promotion').slideUp();
			});

		}

		$window.on('resize', function () {

			if ($window.width() > 1200) {
				// sticky entry sumary
				var hHeader = 32;
				if ($body.hasClass('header-sticky')) {
					hHeader += $header.outerHeight(true);
				}

				$('.product-page-layout-3, .product-page-layout-7, .product-page-layout-11').find('div.product .entry-summary-sticky').stick_in_parent({
					parent    : '#primary',
					offset_top: hHeader
				});

				$('.single-portfolio-type-image').find('.site-content .col-left').stick_in_parent({
					offset_top: hHeader
				});
			} else {
				$('.product-page-layout-3, .product-page-layout-7, .product-page-layout-11').find('div.product .entry-summary-sticky').trigger('sticky_kit:detach');
				$('.single-portfolio-type-image').find('.site-content .col-left').trigger('sticky_kit:detach');
			}

		}).trigger('resize');

		if (!$body.hasClass('product-page-layout-4') && !$body.hasClass('product-page-layout-10')) {
			relatedCarousel('mr-upsells-products');
			relatedCarousel('mr-related-products');
		}

		// function related carousel
		function relatedCarousel(id) {
			var number = $(document.getElementById(id)).data('columns');
			$(document.getElementById(id)).find('ul.products').owlCarousel({
				direction        : mrbara.direction,
				items            : number,
				navigation       : true,
				autoPlay         : false,
				pagination       : false,
				slideSpeed       : 1000,
				paginationSpeed  : 1000,
				itemsDesktopSmall: [1200, 3],
				itemsTablet      : [979, 2],
				itemsMobile      : [480, 1],
				navigationText   : ['<i class="ion-ios-arrow-left"></i>', '<i class="ion-ios-arrow-right"></i>'],
				afterInit        : function (event) {
					var current = this.currentItem;
					event.find('.owl-item').eq(current).addClass('active');
					event.find('.owl-item').eq(current + number - 1).addClass('active');
				},
				afterMove        : function (event) {
					var current = this.currentItem;
					event.find('.owl-item').removeClass('active');
					event.find('.owl-item').eq(current).addClass('active');
					event.find('.owl-item').eq(current + number - 1).addClass('active');
				}
			});
		}

		crossCarousel();
		// function cross-selss carousel
		function crossCarousel() {
			$('.woocommerce-cart .cross-sells').find('ul.products').owlCarousel({
				direction        : mrbara.direction,
				items            : mrbara.crosssells_products_columns,
				navigation       : true,
				autoPlay         : false,
				pagination       : false,
				slideSpeed       : 1000,
				paginationSpeed  : 1000,
				itemsDesktopSmall: [1200, 3],
				itemsTablet      : [979, 2],
				itemsMobile      : [480, 1],
				navigationText   : ['<i class="ion-ios-arrow-left"></i>', '<i class="ion-ios-arrow-right"></i>']
			});
		}

		$window.on('load', function () {
			if (mrbara.direction == 'rtl') {
				$('.vc_row[data-vc-full-width="true"]').each(function () {
					$(this).css('right', $(this).css('left')).css('left', 'auto');
				});
			}
		});

		var $cartPanel = $('.mr-cart-panel');

		$cartPanel.on('click', '.remove', function (e) {
			e.preventDefault();
			$cartPanel.addClass('loading');
            $( document.body ).on( 'removed_from_cart', function () {
                $cartPanel.removeClass('loading');
            } );
		});

		addToCartAjax();
		// Add to cart ajax
		function addToCartAjax() {

			if (mrbara.product_add_to_cart_ajax == '0') {
				return;
			}

			$body.on('click', '.single_add_to_cart_button', function (e) {
				e.preventDefault();

				if ($(this).hasClass('disabled')) {
					return;
				}

				var $cartForm = $(this).closest('form.cart'),
					$singleBtn = $(this).closest('.single-add-to-cart-btn');
				$singleBtn.addClass('loading');

				if (!$singleBtn.hasClass('loading')) {
					return;
				}

				var formdata = $cartForm.serializeArray(),
					currentURL = window.location.href;

				$.ajax({
					url    : window.location.href,
					method : 'post',
					data   : formdata,
					error  : function () {
						window.location = currentURL;
					},
					success: function (response) {
						if (!response) {
							window.location = currentURL;
						}


						if (typeof wc_add_to_cart_params !== 'undefined') {
							if (wc_add_to_cart_params.cart_redirect_after_add === 'yes') {
								window.location = wc_add_to_cart_params.cart_url;
								return;
							}
						}

						$(document.body).trigger('updated_wc_div');
						$(document.body).on('wc_fragments_refreshed', function () {

							$singleBtn.removeClass('loading');
						});

					}
				});

			});

		}
	});
})(jQuery);
