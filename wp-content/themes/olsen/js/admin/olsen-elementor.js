(function ($) {
	$(window).on('elementor/frontend/init', function () {
		elementorFrontend.hooks.addAction('frontend/element_ready/widget', function ($scope) {
			var gallery = document.querySelector('.entry-justified');
			gallery.style.opacity = 0;
			var items = gallery.querySelectorAll('.entry-justified .jg-entry');

			imagesLoaded(gallery, function (instance) {
				Array.prototype.forEach.call(items, function (item) {
					var image = item.querySelector('img');
					var ratio = image.width / image.height;
					item.style.width = gallery.dataset.height * ratio + 'px';
					item.style.flexGrow = ratio;
				});

				gallery.style.transition = 'opacity .5s ease-in';
				gallery.style.opacity = 1;
			});
		});
	});
})(jQuery);

