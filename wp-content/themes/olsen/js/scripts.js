(function () {
	'use strict'
	/* -----------------------------------------
	Responsive Menus
	----------------------------------------- */
	var body = document.querySelector('body');
	var mobileWPMenu = document.querySelectorAll('#masthead .mobile-navigation');
	var mainNav = mobileWPMenu.length > 0 ? mobileWPMenu : document.querySelectorAll('#masthead .navigation');
	var mobileNav = document.querySelector('.navigation-mobile-wrap');
	var mobileNavTrigger = document.querySelector('.mobile-nav-trigger');
	var mobileNavDismiss = document.querySelector('.navigation-mobile-dismiss');
	var navWrap = document.querySelector('#menu-main');
	var navSubmenus = navWrap ? navWrap.querySelectorAll( 'ul' ) : null;

	mainNav.forEach(function (el, i) {
		var itemClass = el.classList.contains('mobile-navigation') ? '.mobile-navigation' : '.navigation';
		var listItems = el.cloneNode(true).querySelectorAll( itemClass + ' > li');
		listItems.forEach(function (el, i) {
			el.removeAttribute('id');
			mobileNav.querySelector('.navigation-mobile').append(el);
		});
	});

	mobileNav.querySelectorAll('li').forEach(function (item, i) {
		item.removeAttribute('id');

		if (item.querySelector('.sub-menu')) {
			var btn = document.createElement('button');
			btn.classList.add('menu-item-sub-menu-toggle');
			item.appendChild(btn);
		}
	});

	var mobileToggle = mobileNav.querySelectorAll('.menu-item-sub-menu-toggle');
	mobileToggle.forEach(function (item, i) {
		item.onclick = function (event) {
			event.preventDefault();
			item.parentNode.classList.toggle('menu-item-expanded');
		}
	});

	mobileNavTrigger.onclick = function (event) {
		event.preventDefault();
		body.classList.add('mobile-nav-open');
		mobileNavDismiss.focus();
	}

	mobileNavDismiss.onclick = function (event) {
		event.preventDefault();
		body.classList.remove('mobile-nav-open');
		mobileNavTrigger.focus();
	}

	function setMenuClasses() {
		if ( navSubmenus === null || navWrap.offsetParent === null) {
			return;
		}

		var windowWidth = window.innerWidth;

		Array.prototype.forEach.call(navSubmenus, function (el, i) {

			var parent = el.parentNode;
			parent.classList.remove('nav-open-left');

			var rect = el.getBoundingClientRect();

			var leftOffset = rect.left + document.body.scrollLeft + el.offsetWidth;

			if (leftOffset > windowWidth) {
				parent.classList.add('nav-open-left');
			}
		});
	}

	setMenuClasses();

	var resizeTimer;

	window.addEventListener('resize', function () {
		clearTimeout(resizeTimer);
		resizeTimer = setTimeout(function () {
			setMenuClasses();
		}, 350);

		ciResize();
	});

	/* -----------------------------------------
	Image Lightbox
	----------------------------------------- */
	var lightbox = new SimpleLightbox('.ci-lightbox, a[data-lightbox^="gal"]', {
		captionSelector: function (element) {
			return element.parentNode.querySelector('figcaption');
		},
		captionType: 'text',
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		fadeSpeed: 300,
		history: false,
	});

	lightbox.on('show.simplelightbox', function () {
		lightbox.domNodes.overlay.dataset.opacityTarget = '0.9';
	});

	/* -----------------------------------------
	Zoom single product thumbnails
	----------------------------------------- */
	var productGallery = document.querySelector('.woocommerce-product-gallery--with-images');

	if (!!productGallery) {
		var zoomBox = document.createElement('a');
		zoomBox.classList.add('woocommerce-product-gallery__trigger');
		zoomBox.innerHTML = '<i class="fa fa-search-plus"></i>';
		productGallery.insertBefore(zoomBox, productGallery.firstChild);

		function index(el) {
			if (!el) return - 1;
			var i = 0;
			do {
				i ++;
			} while (el = el.previousElementSibling);
			return i;
		}

		var imageLinks = document.querySelectorAll('.woocommerce-product-gallery__image a');
		var lightBoxes = Array.from(imageLinks).map(function (imageLink) {
			return new SimpleLightbox(imageLink, {
				navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
				fadeSpeed: 500,
				history: false,
			});
		})

		zoomBox.onclick = function productLightbox(e) {
			var images = document.querySelectorAll('.woocommerce-product-gallery__image');
			var allImages = new SimpleLightbox(imageLinks);
			var currentImageIndex = 0;

			var sources = Array.from(images).map(function (item) {
				return {
					src: item.querySelector('a').getAttribute('href')
				};
			});

			if (1 === sources.length) {
				currentImageIndex = index(document.querySelector('.woocommerce-product-gallery__image'));
			} else {
				currentImageIndex = index(document.querySelector('.flex-active-slide'));
			}

			var previous = allImages.elements.slice(0, currentImageIndex - 1);
			var nextInc = allImages.elements.slice(currentImageIndex - 1, allImages.elements.length);
			var reordered = nextInc.concat(previous);

			lightBoxes[currentImageIndex - 1].elements = reordered;
			lightBoxes[currentImageIndex - 1].on('show.simplelightbox', function () {
				lightBoxes[currentImageIndex - 1].domNodes.overlay.dataset.opacityTarget = '0.9';
			});

			lightBoxes[currentImageIndex - 1].open();

			e.preventDefault();
		}
	}

	/* -----------------------------------------
	Media Query Check
	----------------------------------------- */
	function ciResize() {
		var entriesList = document.querySelector('.entries-list');

		if (!!entriesList) {
			if (window.matchMedia('only screen and (max-width: 768px)').matches) {
				var entries = entriesList.querySelectorAll('.entry');
				entries.forEach(function (entry) {
					entry.classList.remove('entry-list');
				});
			} else {
				var entries = entriesList.querySelectorAll('.entry');
				entries.forEach(function (entry, i) {
					if (i !== 0) {
						entry.classList.add('entry-list');
					}
				});
				var related = entriesList.querySelectorAll('.entry-blog-related .entry');
				related.forEach(function (entry) {
					entry.classList.remove('entry-list');
				});
			}
		}
	}

	ciResize();

	/* -----------------------------------------
	Main Carousel
	----------------------------------------- */
	var homeSlider = document.querySelector('.home-slider');
	var carouselSlider = document.querySelector('.slider-carousel');

	if (!!homeSlider) {
		var sliderMode = !! carouselSlider ? 'carousel' : homeSlider.dataset.fade == 1 ? 'gallery' : 'carousel';
		var slider = tns({
			container: '.home-slider',
			autoplay: homeSlider.dataset.autoplay == 1,
			nav: false,
			arrowKeys: true,
			autoplayButtonOutput: false,
			controlsPosition: 'bottom',
			speed: 500,
			items: 1,
			center: false,
			fixedWidth: false,
			autoplayTimeout: homeSlider.dataset.autoplayspeed,
			mode: sliderMode,
			onInit: function (event) {
				event.container.classList.add('tns-initialized');
				event.slideItems[event.index].classList.add('show');
			},
			responsive: {
				992: {
					items: !!carouselSlider ? 2 : 1,
					center: !!carouselSlider,
					fixedWidth: !!carouselSlider ? 1040 : false,
				},
			}
		});

		if (!!carouselSlider) {
			slider.events.on('indexChanged', function (event) {
				var active = event.slideItems[event.index];

				Array.from(event.slideItems).forEach(function (item) {
					item.classList.remove('show');
					item.classList.add('hide');
				});

				active.classList.remove('hide');
				active.classList.add('show');
			});
		}
	}

	var featureSlider = document.querySelectorAll('.feature-slider');

	if (featureSlider.length > 0) {
		Array.from(featureSlider).map(function (slider) {
			tns({
				container: slider,
				autoplay: false,
				nav: false,
				arrowKeys: true,
				autoplayButtonOutput: false,
				controlsPosition: 'bottom',
				speed: 500,
				items: 1,
				center: false,
				fixedWidth: false,
				mode: 'gallery',
				onInit: function (event) {
					event.container.classList.add('tns-initialized');
				},
			});
		});
	}

	/* -----------------------------------------
	Menu stickiness
	----------------------------------------- */
	var getNodeInnerDimensions = function (node) {
		var computedStyle = getComputedStyle(node);

		var width = node.clientWidth;
		var height = node.clientHeight;

		height -= parseFloat(computedStyle.paddingTop) + parseFloat(computedStyle.paddingBottom);
		width -= parseFloat(computedStyle.paddingLeft) + parseFloat(computedStyle.paddingRight);

		return {
			height: height,
			width: width
		};
	}

	var siteBar = document.querySelector('.sticky-head');
	if (!!siteBar) {
		var refOffset = 0;
		var menuHeight = siteBar.offsetHeight;
		var initPos = siteBar.getBoundingClientRect().top;
		var initParentPos = siteBar.parentNode.getBoundingClientRect().top;
		var loadOffset = window.scrollY || window.pageYOffset;

		var handler = function () {
			var newOffset = window.scrollY || window.pageYOffset;
			siteBar.style.width = getNodeInnerDimensions(siteBar.parentNode).width + 'px';

			if (newOffset > initPos) {
				if (newOffset > refOffset) {
					siteBar.classList.add('is_stuck');
					siteBar.parentNode.style.height = menuHeight + 'px';
				}
				refOffset = newOffset;

				if (initPos < 0) {
					if (newOffset < loadOffset - Math.abs(initParentPos)) {
						siteBar.classList.remove('is_stuck');
					}
				}
			} else {
				siteBar.classList.remove('is_stuck');
				siteBar.parentNode.style.height = 'auto';
			}
		};

		var ticking = false;
		['scroll','resize'].forEach( function(e) {
			window.addEventListener(e, function(event) {
				if (!ticking) {
				  window.requestAnimationFrame(function() {
					handler();
					ticking = false;
				  });

				  ticking = true;
				}
			}, false);
		});
	}

	/* -----------------------------------------
	Instagram Widget
	----------------------------------------- */
	var instagramWrap = document.querySelector('.footer-widget-area');
	var instagramWidget = instagramWrap ? instagramWrap.querySelectorAll('.zoom-instagram-widget__items') : null;

	if ( instagramWidget && instagramWidget.length > 0 ) {
		var auto = instagramWrap.dataset.auto;
		var speed = instagramWrap.dataset.speed;

		var instaSlider = tns({
			container: '.footer-widget-area .zoom-instagram-widget__items',
			autoplay: auto == 1,
			nav: false,
			items: 4,
			arrowKeys: false,
			autoplayButtonOutput: false,
			controls: false,
			speed: speed,
			autoplayTimeout: Math.max(3000, parseInt(speed, 10) + 501),
			mouseDrag: true,
			mode: 'carousel',
			autowidth: true,
			responsive: {
				768: {
					items: 8
				},
			},
			onInit: function (event) {
				event.container.classList.add('tns-initialized');
			},
		});
	}

	/* -----------------------------------------
	Justified Galleries
	----------------------------------------- */
	var galleries = document.querySelectorAll('.entry-justified');

	if (galleries.length > 0) {
		Array.from(galleries).map(function (gallery) {
			var items = gallery.querySelectorAll('.entry-justified .jg-entry');

			imagesLoaded(gallery, function () {
				Array.from(items).map(function (item) {
					var image = item.querySelector('img');
					var ratio = image.width / image.height;
					item.style.width = gallery.dataset.height * ratio + 'px';
					item.style.flexGrow = ratio;
				});

				gallery.style.opacity = 1;
			});
		})
	}
})();

window.onload = function () {
	/* -----------------------------------------
	Masonry Layout
	----------------------------------------- */
	var masonry = document.querySelector('.entries-masonry');

	if (!!masonry) {
		var grid = new Isotope(masonry, {
			itemSelector: '.entry-masonry',
			layoutMode: 'masonry'
		});
	}
}
