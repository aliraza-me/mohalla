var mrbara = mrbara || {},
	mrbaraShortCode = mrbaraShortCode || {},
	wc_add_to_cart_variation_params = wc_add_to_cart_variation_params || {},
	FlipClock = FlipClock || {};
(function ($) {
	'use strict';

	$(function () {

		$('.mrbara-banner').each(function () {
			var fwidth = $(this).find('.text').width(),
				fleft = ( ( fwidth / 2 ) - 10 ) * -1;

			if ($(this).hasClass('text-position-left')) {
				$(this).find('.text').css('left', fleft);
			} else {
				$(this).find('.text').css('right', fleft);
			}

		});

		// SHORTCODE JS

		productsCarousel();
		productsCarousel2();
		productsTabsCarousel2();
		productsTabsCarousel();
		productsPicks();
		slidersCarousel();
		imagesCarousel();
		imagesCarouselVertical();
		productsimagesCarousel();
		testimonialCarousel();
		mrbaraMaps();
		instagramCarousel();
		productsHotDealCarousel();
		productCatsImagesCarousel();
		leftSideMenuIcon();
		postsCarousel();

		$(window).on('resize', function () {
			infoBanner();

			// Section title ver
			$('.section-title-ver ').each(function () {

				var sWidth = $('.site-content').width(),
					wParent = $(this).parent().width(),
					left = ( sWidth - wParent ) / 2,
					fwidth = $(this).find('.title').width();

				if ($(this).hasClass('align-right')) {
					fwidth = 0;
				}

				$(this).css({
					width: sWidth,
					left : (left * -1 ) + 15,
					top  : fwidth
				});
			});

		}).trigger('resize');

		// Info Banner
		function infoBanner() {
			var bHieght = 'auto',
				wWidth = $(window).width();
			if ($('body').hasClass('boxed')) {
				wWidth = $('.site').width();
			}
			if (wWidth > 767) {
				bHieght = $('.info-banners-content').find('.info-banner-normal').height();
			}

			$('.info-banners-content').find('.banner-item .no-image').css({
				'min-height': bHieght
			});

		}


		//Section Parallax
		var $parallaxsRow = $('.vc_row.parallax');
		for (var i = 0; i < $parallaxsRow.length; i++) {
			$($parallaxsRow[i]).parallax('50%', 0.6);
		}

		var $parallaxs = $('.mrbara-banner-large.parallax');
		for (var j = 0; j < $parallaxs.length; j++) {
			$($parallaxs[j]).parallax('50%', 0.6);
		}

		/**
		 * Filter product category
		 */
		$(window).load(function () {
			$('.mrbara-grid-cats').find('ul.products').isotope({
				itemSelector: 'li.product',
				layoutMode  : 'fitRows'
			});
		});

		$('.mrbara-grid-cats').find('.filters-dropdown').on('click', 'a', function (e) {
			e.preventDefault();

			var selector = $(this).attr('data-option-value');
			$(this).parents('.mrbara-grid-cats').find('ul.products').isotope({
				filter    : selector,
				layoutMode: 'fitRows'
			});

			$(this).parents('ul').find('a').removeClass('selected');
			$(this).addClass('selected');
		});

		//Init countdown js
		$('.mrbara-countdown').each(function () {
			var diff = $(this).find('.sale-price-date').html();

			$(this).find('.sale-price-date').FlipClock(diff, {
				clockFace: 'DailyCounter',
				countdown: true,
				labels   : [mrbaraShortCode.days, mrbaraShortCode.hours, mrbaraShortCode.minutes, mrbaraShortCode.seconds]
			});
		});

		/*
		 * Toggle video banner play button
		 */
		$('.video-banner').on('click', '.status', function (e) {
			e.preventDefault();
			var $el = $(this),
				$banner = $el.closest('.video-banner'),
				video = $el.closest('.video-banner').find('video')[0];
			if (video.paused) {
				$banner.addClass('playing');
				video.play();
			} else {
				$banner.removeClass('playing');
				video.pause();
			}
		});

		/**
		 * Init portfolio carousel
		 */
		function productsCarousel() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.productsCarousel === 'undefined') {
				return;
			}

			$.each(mrbaraShortCode.productsCarousel, function (id, productsData) {

				var number = 4,
					singleItem = false;
				if (productsData.number < 4) {
					number = productsData.number;
				}

				if (productsData.number == 1) {
					singleItem = true;
				}

				$(document.getElementById(id)).find('ul.products').owlCarousel({
					direction        : mrbaraShortCode.direction,
					singleItem       : singleItem,
					items            : productsData.number,
					navigation       : productsData.navigation,
					autoPlay         : productsData.autoplay,
					pagination       : productsData.pagination,
					slideSpeed       : 1000,
					paginationSpeed  : 1000,
					itemsDesktop     : [1550, number],
					itemsDesktopSmall: [1200, 3],
					itemsTablet      : [979, 3],
					itemsMobile      : [480, 1],
					navigationText   : ['<i class="ion-ios-arrow-thin-left"></i>', '<i class="ion-ios-arrow-thin-right"></i>'],
					afterInit        : function (event) {
						var current = this.currentItem;
						event.find('.owl-item').eq(current).addClass('active');
						event.find('.owl-item').eq(current + productsData.number - 1).addClass('active');
					},
					afterMove        : function (event) {
						var current = this.currentItem;
						event.find('.owl-item').removeClass('active');
						event.find('.owl-item').eq(current).addClass('active');
						event.find('.owl-item').eq(current + productsData.number - 1).addClass('active');
					}
				});
			});
		}

		/**
		 * Init portfolio carousel 2
		 */
		function productsCarousel2() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.productsCarousel2 === 'undefined') {
				return;
			}

			$.each(mrbaraShortCode.productsCarousel2, function (id, productsData) {

				var $productsID = $(document.getElementById(id));

				var rtl = false;
				if( mrbaraShortCode.direction == 'rtl' ) {
					rtl = true;
				}

				$productsID.find('ul.products').slick({
					slidesToShow  : productsData.number,
					slidesToScroll: 1,
					prevArrow     : productsData.prev,
					nextArrow     : productsData.next,
					autoplay      : productsData.autoplay,
					autoplaySpeed : productsData.speed,
					arrows        : productsData.navigation,
					dots          : true,
					rtl: rtl,
					responsive    : [{
						breakpoint: 1030,
						settings  : {
							slidesToShow: 3
						}
					}, {
						breakpoint: 768,
						settings  : {
							slidesToShow: 3
						}
					}, {
						breakpoint: 500,
						settings  : {
							slidesToShow: 1
						}
					}]
				});

				$productsID.find('.filters-dropdown').on('click', 'a', function (e) {
					e.preventDefault();
					$productsID.find('.filters-dropdown a').removeClass('selected');
					$(this).addClass('selected');
					var value = $(this).data('option-value');
					$productsID.find('ul.products').slick('slickUnfilter');


					if (value != '*') {
						$productsID.find('ul.products').slick('slickFilter', value);
					}
				});
			});
		}

		/**
		 * Init portfolio carousel
		 */
		function productsTabsCarousel2() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.productsTabsCarousel2 === 'undefined') {
				return;
			}

			$.each(mrbaraShortCode.productsTabsCarousel2, function (id, productsData) {

				var items = productsData.columns;

				if (items > 3) {
					items = items - 1;
				}
				$(document.getElementById(id)).find('ul.products').owlCarousel({
					direction        : mrbaraShortCode.direction,
					items            : productsData.columns,
					navigation       : false,
					autoPlay         : productsData.autoplay,
					pagination       : productsData.pagination,
					slideSpeed       : 1000,
					paginationSpeed  : 1000,
					itemsDesktopSmall: [1200, items],
					itemsTablet      : [979, 2],
					itemsMobile      : [480, 1]
				});
			});
		}

		/**
		 * Init portfolio carousel
		 */
		function productsTabsCarousel() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.productsTabsCarousel1 === 'undefined') {
				return;
			}

			$.each(mrbaraShortCode.productsTabsCarousel1, function (id, productsData) {
				if (productsData.is_carousel === 1) {
					$(document.getElementById(id)).find('ul.products').owlCarousel({
						direction        : mrbaraShortCode.direction,
						items            : productsData.items,
						pagination       : true,
						autoPlay         : productsData.autoplay,
						navigation       : productsData.navigation,
						slideSpeed       : 1000,
						paginationSpeed  : 1000,
						itemsDesktopSmall: [1200, 3],
						itemsTablet      : [979, 3],
						itemsMobile      : [480, 1],
						navigationText   : ['<i class="ion-ios-arrow-thin-left"></i>', '<i class="ion-ios-arrow-thin-right"></i>']
					});
				}

			});
		}

		/**
		 * Init portfolio carousel
		 */
		function productsPicks() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.productsPicks === 'undefined') {
				return;
			}
			$.each(mrbaraShortCode.productsPicks, function (id, productsData) {
				$(document.getElementById(id)).find('ul.products').owlCarousel({
					direction        : mrbaraShortCode.direction,
					items            : productsData.number,
					navigation       : productsData.navigation,
					autoPlay         : productsData.autoplay,
					pagination       : productsData.pagination,
					slideSpeed       : 1000,
					paginationSpeed  : 1000,
					itemsDesktopSmall: [1200, 3],
					itemsTablet      : [979, 3],
					itemsMobile      : [480, 1],
					navigationText   : [productsData.prev, productsData.next]
				});
			});
		}

		progressCircle();
		/**
		 * Init portfolio carousel
		 */
		function progressCircle() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.progressbar === 'undefined') {
				return;
			}

			$.each(mrbaraShortCode.progressbar, function (id, productsData) {
				$(document.getElementById(id)).circleProgress({
					value     : productsData.value,
					size      : productsData.size,
					lineCap   : 'square',
					fill      : {color: productsData.color},
					thickness : productsData.width,
					startAngle: -Math.PI / 2
				});
			});
		}

		/**
		 * Init sliders carousel
		 */
		function slidersCarousel() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.slidersCarousel === 'undefined') {
				return;
			}

			$.each(mrbaraShortCode.slidersCarousel, function (id, slidersData) {
				var $wrap = $(document.getElementById(id)),
					$frame = $wrap.find('.sliders-frame');
				var options = {
					horizontal    : 1,
					activateOn    : 'click',
					activateMiddle: 1,
					itemNav       : 'forceCentered',
					startAt       : slidersData.active_slide,
					scrollBar     : $wrap.find('.scrollbar'),
					pagesBar      : $wrap.find('.pages'),
					activatePageOn: 'click',
					speed         : 1000,
					easing        : 'easeInOutCubic',
					clickBar      : 1,
					dragHandle    : 1,
					dynamicHandle : 1,
					touchDragging : 1,
					smart         : 1,
					cycleBy       : 'items',
					cycleInterval : slidersData.speed,
					pauseOnHover  : 1,
					startPaused   : slidersData.autoplay,

					// Buttons
					prev: $wrap.find('.btn-prev'),
					next: $wrap.find('.btn-next')
				};

				var $sliders = new Sly($frame, options);

				$sliders.on('load move', function () {
					$wrap.addClass('loaded');
				});

				$sliders.init();

				$(window).resize(function () {
					var wWidth = $(window).width(),
						sWidth = wWidth - 60;

					if ($('body').hasClass('boxed')) {
						wWidth = $('.site').width();
					}

					if (wWidth < 1024) {
						sWidth = wWidth - 30;
					}

					if ($('body').hasClass('header-top-style-2')) {
						if (wWidth > 1024) {
							sWidth = sWidth - 300;
						}
						if (wWidth < 1500) {
							$('.mr-sliders').find('.mr-slider').width(sWidth);
						} else {
							$('.mr-sliders').find('.mr-slider').removeAttr('style');
						}
					} else {
						if (wWidth < 1200) {
							$('.mr-sliders').find('.mr-slider').width(sWidth);
						} else {
							$('.mr-sliders').find('.mr-slider').removeAttr('style');
						}
					}

					$sliders.reload();
				});
			});

		}


		/**
		 * Instagram Carousel
		 */

		function instagramCarousel() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.instagramCarousel === 'undefined') {
				return;
			}
			$.each(mrbaraShortCode.instagramCarousel, function (id, instagramData) {
				$(document.getElementById(id)).find('.ins-list').owlCarousel({
					direction        : mrbaraShortCode.direction,
					items            : instagramData.number,
					navigation       : false,
					autoPlay         : instagramData.autoplay,
					pagination       : instagramData.pagination,
					slideSpeed       : 800,
					paginationSpeed  : 1000,
					itemsDesktopSmall: [991, instagramData.number - 1],
					itemsTablet      : [768, 3],
					itemsMobile      : [480, 1]
				});
			});
		}


		/**
		 * Image Carousel
		 */

		function imagesCarousel() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.imagesCarousel === 'undefined') {
				return;
			}
			$.each(mrbaraShortCode.imagesCarousel, function (id, imageData) {
				$(document.getElementById(id)).owlCarousel({
					direction      : mrbaraShortCode.direction,
					items          : imageData.number,
					navigation     : false,
					autoPlay       : imageData.autoplay,
					pagination     : true,
					slideSpeed     : 800,
					paginationSpeed: 1000,
					itemsTablet    : [768, 3],
					itemsMobile    : [320, 1]
				});
			});
		}

		/**
		 * Image Carousel
		 */

		function imagesCarouselVertical() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.imagesCarouselVertical === 'undefined') {
				return;
			}
			$.each(mrbaraShortCode.imagesCarouselVertical, function (id, imageData) {
				$(document.getElementById(id)).bxSlider({
					mode     : 'vertical',
					controls : true,
					pager    : false,
					auto     : imageData.autoplay,
					pause    : imageData.pause,
					autoHover: true,
					nextText : '<i class="ion-ios-arrow-down"></i>',
					prevText : '<i class="ion-ios-arrow-up"></i>'
				});
			});
		}


		/**
		 * Image Carousel 2
		 */

		function productsimagesCarousel() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.productsimagesCarousel === 'undefined') {
				return;
			}
			$.each(mrbaraShortCode.productsimagesCarousel, function (id, imageData) {
				$(document.getElementById(id)).find('.products').owlCarousel({
					direction        : mrbaraShortCode.direction,
					items            : 8,
					navigation       : imageData.navigation,
					autoPlay         : imageData.autoplay,
					pagination       : false,
					slideSpeed       : 800,
					paginationSpeed  : 1000,
					navigationText   : ['<i class="ion-ios-arrow-left"></i>', '<i class="ion-ios-arrow-right"></i>'],
					itemsDesktop     : [1199, 6],
					itemsDesktopSmall: [979, 5],
					itemsTablet      : [768, 3],
					itemsMobile      : [320, 1]
				});
			});
		}

		/**
		 * Init testimonials carousel
		 */
		function testimonialCarousel() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.testimonial === 'undefined') {
				return;
			}
			$.each(mrbaraShortCode.testimonial, function (id, testimonialData) {
				$(document.getElementById(id)).owlCarousel({
					direction      : mrbaraShortCode.direction,
					singleItem     : true,
					navigation     : testimonialData.navigation,
					autoPlay       : testimonialData.autoplay,
					pagination     : true,
					slideSpeed     : 800,
					paginationSpeed: 1000,
					navigationText : ['<span class="ion-ios-arrow-left"></span>', '<span class="ion-ios-arrow-right"></span>']
				});
			});
		}

		/**
		 * Init product cats images carousel
		 */
		function productCatsImagesCarousel() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.productCatsImages === 'undefined') {
				return;
			}
			$.each(mrbaraShortCode.productCatsImages, function (id, productCatsImagesData) {
				$(document.getElementById(id)).owlCarousel({
					direction      : mrbaraShortCode.direction,
					singleItem     : true,
					navigation     : false,
					autoPlay       : productCatsImagesData.autoplay,
					pagination     : productCatsImagesData.pagination,
					slideSpeed     : 800,
					paginationSpeed: 1000
				});
			});
		}


		/**
		 * Init hot deal carousel
		 */
		function productsHotDealCarousel() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.productsHotDeal === 'undefined') {
				return;
			}
			$.each(mrbaraShortCode.productsHotDeal, function (id, productsHotDealData) {
				$(document.getElementById(id)).owlCarousel({
					direction      : mrbaraShortCode.direction,
					singleItem     : true,
					navigation     : productsHotDealData.navigation,
					autoPlay       : productsHotDealData.autoplay,
					pagination     : false,
					slideSpeed     : 800,
					paginationSpeed: 1000,
					navigationText : ['<span class="ion-ios-arrow-left"></span>', '<span class="ion-ios-arrow-right"></span>']
				});

				$(document.getElementById(id)).find('.sale-price-date').each(function () {
					var diff = $(this).html();

					$(this).FlipClock(diff, {
						clockFace: 'HourlyCounter',
						countdown: true,
						labels   : [mrbaraShortCode.hours, mrbaraShortCode.minutes, mrbaraShortCode.seconds]
					});
				});


			});
		}

		/**
		 * Init Google maps
		 */
		function mrbaraMaps() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.map === 'undefined') {
				return;
			}

			var styles = [{
					'featureType': 'administrative',
					'elementType': 'all',
					'stylers'    : [{'visibility': 'simplified'}]
				}, {
					'featureType': 'landscape',
					'elementType': 'geometry',
					'stylers'    : [{'visibility': 'simplified'}, {'color': '#fcfcfc'}]
				}, {
					'featureType': 'poi',
					'elementType': 'geometry',
					'stylers'    : [{'visibility': 'simplified'}, {'color': '#fcfcfc'}]
				}, {
					'featureType': 'road.highway',
					'elementType': 'geometry',
					'stylers'    : [{'visibility': 'simplified'}, {'color': '#dddddd'}]
				}, {
					'featureType': 'road.arterial',
					'elementType': 'geometry',
					'stylers'    : [{'visibility': 'simplified'}, {'color': '#dddddd'}]
				}, {
					'featureType': 'road.local',
					'elementType': 'geometry',
					'stylers'    : [{'visibility': 'simplified'}, {'color': '#eeeeee'}]
				}, {
					'featureType': 'water',
					'elementType': 'geometry',
					'stylers'    : [{'visibility': 'simplified'}, {'color': '#dddddd'}]
				}],
				customMap = new google.maps.StyledMapType(styles,
					{name: 'Styled Map'});

			var mapOptions = {
				scrollwheel       : false,
				draggable         : true,
				zoom              : 13,
				mapTypeId         : google.maps.MapTypeId.ROADMAP,
				panControl        : false,
				zoomControl       : true,
				zoomControlOptions: {
					style: google.maps.ZoomControlStyle.SMALL
				},
				scaleControl      : false,
				streetViewControl : false

			};

			$.each(mrbaraShortCode.map, function (id, mapData) {
				var map,
					marker,
					location = new google.maps.LatLng(mapData.lat, mapData.lng);


				// Update map options
				mapOptions.zoom = parseInt(mapData.zoom, 10);
				mapOptions.center = location;
				mapOptions.mapTypeControlOptions = {
					mapTypeIds: [google.maps.MapTypeId.ROADMAP]
				};

				// Init map
				map = new google.maps.Map(document.getElementById(id), mapOptions);

				// Create marker options
				var markerOptions = {
					map     : map,
					position: location
				};
				if (mapData.marker) {
					markerOptions.icon = {
						url: mapData.marker
					};
				}

				map.mapTypes.set('map_style', customMap);
				map.setMapTypeId('map_style');

				// Init marker
				marker = new google.maps.Marker(markerOptions);

				if (mapData.info) {
					var infoWindow = new google.maps.InfoWindow({
						content : '<div class="infobox mrbara-map">' + mapData.info + '</div>',
						maxWidth: 600
					});

					google.maps.event.addListener(marker, 'click', function () {
						infoWindow.open(map, marker);
					});
				}

			});
		}


		// Section title 5
		$('.mrbara-section-title-5').each(function () {
			var $this = $(this),
				offset = $this.offset();

			if ($this.hasClass('align-left') && offset.left > 175) {
				$this.find('.line').css({
					left : -offset.left,
					width: offset.left - 175
				});
			} else if ($this.hasClass('align-right')) {
				var wWidth = $(window).width();
				if ($('body').hasClass('boxed')) {
					wWidth = $('.site').width();
				}

				offset.right = wWidth - offset.left - $this.outerWidth();

				if (offset.right > 175) {
					$this.find('.line').css({
						right: -offset.right,
						width: offset.right - 175
					});
				}
			}

			if ($.fn.waypoint) {
				$this.waypoint(function () {
					$this.addClass('start-animation');
				}, {
					offset: '75%'
				});
			}
		});

		/**
		 * Counter
		 */
		function count($this, step) {
			var current = parseInt($this.html(), 10);
			current = current + step;
			$this.html(++current);

			if (current > $this.data('count')) {
				$this.html($this.data('count'));
			} else {
				setTimeout(function () {
					count($this, step);
				}, 10);
			}
		}


		$('.mrbara-counter').each(function () {
			var $el = $(this).find('.counter-number'),
				step = $(this).data('step');
			$el.data('count', parseInt($el.html(), 10));
			$el.html('0');
			count($el, step);
		});

		$('.mrbara-facts-box .number').each(function () {
			$(this).data('count', parseInt($(this).html(), 10));
			$(this).html('0');
			count($(this, 5));
		});

		// Portfolio Slider
		portfolioSlider();

		function portfolioSlider() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.portfolio === 'undefined') {
				return;
			}
			$.each(mrbaraShortCode.portfolio, function (id, portfolioData) {
				$(document.getElementById(id)).bxSlider({
					mode      : 'vertical',
					controls  : false,
					pager     : portfolioData.pager,
					auto      : portfolioData.autoplay,
					autoHover : true,
					speed     : 1800,
					pause     : portfolioData.pause,
					buildPager: function (slideIndex) {
						slideIndex++;
						if (slideIndex < 10) {
							return '0' + slideIndex;
						}

						return slideIndex;
					}
				});
			});
		}

		/**
		 * Init portfolio carousel
		 */
		function postsCarousel() {
			if (mrbaraShortCode.length === 0 || typeof mrbaraShortCode.postsCarousel === 'undefined') {
				return;
			}

			$.each(mrbaraShortCode.postsCarousel, function (id, postsData) {

				var singleItem = false;

				if (postsData.number == 1) {
					singleItem = true;
				}

				$(document.getElementById(id)).find('.posts-list').owlCarousel({
					direction        : mrbaraShortCode.direction,
					singleItem       : singleItem,
					items            : postsData.number,
					navigation       : true,
					autoPlay         : postsData.autoplay,
					pagination       : false,
					slideSpeed       : 1000,
					paginationSpeed  : 1000,
					itemsDesktop     : [1550, 4],
					itemsDesktopSmall: [1200, 3],
					itemsTablet      : [979, 2],
					itemsMobile      : [480, 1],
					navigationText   : ['<i class="ion-ios-arrow-thin-left"></i>', '<i class="ion-ios-arrow-thin-right"></i>']
				});
			});
		}

		// Info Banners
		$(window).on('load', function () {
			$('.mr-info-banners').find('.info-banners-content').isotope({
				itemSelector: '.banner-item',
				masonry     : {
					columnWidth: '.banner-sizer'
				}
			});
		});

		// Left side menu icon
		function leftSideMenuIcon() {
			var $catsIcon = '',
				$leftSide = $('#left-side-menu-icon');

			if ($leftSide.find('ul').length === 0) {
				return;
			}

			$('.product-category-box').each(function () {
				if ($(this).find('.right-cat-icon').length > 0) {
					$catsIcon += $(this).find('.right-cat-icon').html();
				}
			});

			if ($catsIcon) {
				$leftSide.find('ul').html($catsIcon);
			}

			var adminBar = 0;
			if ($('body').hasClass('admin-bar')) {
				adminBar = 32;
			}
			$leftSide.on('click', 'a', function (e) {
				e.preventDefault();
				var target = $(this).attr('href');

				if (target != null && target) {
					target = '#' + target;
					var $section = $(target);
					if ($section.length > 0) {
						var topSection = $section.offset().top - 30;
						if ($('body').hasClass('admin-bar')) {
							topSection -= adminBar;
						}
						if ($('body').hasClass('header-sticky')) {
							var hHeader = 64;
							if ($('.site-header').hasClass('minimized')) {
								hHeader = $('.site-header.minimized').outerHeight(true);
							}
							topSection -= hHeader;
						}
						$('html, body').stop().animate({
								scrollTop: topSection
							}, 1000
						);
					}
				}

			});

			var offSet = 100,
				hMinimized = 0;

			$(window).on('scroll', function () {

				if ($('body').hasClass('header-sticky')) {
					if ($('.site-header').hasClass('minimized') && hMinimized === 0) {
						hMinimized = $('.site-header').outerHeight(true);
						offSet = offSet + hMinimized;
						$leftSide.css({
							top: adminBar + hMinimized + 30
						});
					}
				}

				var found = false,
					foundView = false;

				$('.product-category-box').each(function () {
					var $viewPort = $(this);
					if ($(this).closest('.vc_row').length > 0) {
						$viewPort = $(this).closest('.vc_row');
					}

					if ($viewPort.is(':in-viewport(' + offSet + ')')) {
						foundView = true;
					}

					if ($(this).is(':in-viewport(' + offSet + ')') && !found) {
						var id = $(this).attr('id');
						$leftSide.find('a').removeClass('active');
						$leftSide.find('.' + id).addClass('active');
						found = true;
					}

				});
				if (foundView) {
					$leftSide.show();
				} else {
					$leftSide.hide();
				}
			}).trigger('scroll');
		}


		topPromotion();
		function topPromotion() {

			if ($('#top-promotion').length === 0) {
				return;
			}

			if ($('#top-promotion').find('.promotion-content-2').hasClass('expired-date')) {
				$('#top-promotion').hide();
				return;
			}

			var diff = $('#top-promotion').find('.promotion-date').html();

			$('#top-promotion').find('.promotion-date').FlipClock(diff, {
				clockFace: 'DailyCounter',
				countdown: true,
				labels   : [mrbaraShortCode.days, mrbaraShortCode.hours, mrbaraShortCode.minutes, mrbaraShortCode.seconds]
			});
		}

	});
})(jQuery);
