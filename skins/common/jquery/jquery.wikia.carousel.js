/* 
 * Wikia Carousel jQuery plugin
 * Author Liz Lee, Hyun Lim
 * 
 * Sample HTML:
 * 
 * <span class="next"></span>
 * <span class="previous"></span>
 * <div id="myCarousel">
 * 	  <div>
 * 		  <ul class="carousel"> 
 * 			<li><img></li>
 * 			<li><img></li>
 * 			<li><img></li>
 * 		  </ul>
 * 	  </div>
 * </div>
 * 
 * $('#myCarousel').carousel();
 * 
 */

;(function($, window) {
	$.fn.carousel = function(options) {
		var defaults = {
			transition_speed: 500,
			itemCount: 3,
			nextClass: "next",
			prevClass: "previous"
		}

		options = $.extend(defaults, options);
		
		var dom = {
			wrapper: $(this),
			carousel: $(this).find('.carousel'),
			container: $(this).children('div:first'),
			next: $(this).siblings('.' + options.nextClass),
			previous: $(this).siblings('.' + options.prevClass)
		}

		var states = {
			browsing: false,
			enable_next: true,
			enable_previous: false,
			carousel: false
		}		

		function nextImage() {
			var width = setCarouselWidth();
	
			enableBrowsing();
	
			if (states.browsing == false && states.enable_next == true) {
				states.browsing = true;
				dom.container.animate({
					left: '-' + width
				}, options.transition_speed, function() {
					removeFirstPhotos();
					states.browsing = false;
				});
			}
			return false;
	
		}
	
		function previousImage() {
			var width = setCarouselWidth();
	
			enableBrowsing();
	
			if (states.browsing == false && states.enable_previous == true) {
				states.browsing = true;
				var images = $('.carousel li').length;
				for (var i=0; i < 3; i++) {
					dom.carousel.prepend( dom.carousel.find('li').eq(images -1) ) ;
				}
				dom.container.css('left', - width + 'px');
	
				dom.container.animate({
					left:  '0px'
				}, options.transition_speed, function() {
					states.browsing = false;
				});
			}
			return false;
		}
	
		function enableBrowsing() {
			var current = dom.carousel.find('li').slice(0, 3).each(function (i) {
				if ($(this).is('.last-image')) {
					states.enable_next = false;
					return false;
				}
				else {
					states.enable_next = true;
				}
	
				if ($(this).is('.first-image')) {
					states.enable_previous = false;
					return false;
				}
				else {
					states.enable_previous = true;
				}
			});
		}
		
		function lazyLoadImages(limit) {
			var images = dom.carousel.find('img').filter('[data-src]');
			$().log('lazy loading rest of images', 'LatestPhotos');
	
			var count = 0;
			images.each(function() {
				count ++;
				if (count > limit) { // exit the loop for init image loading.
					return false;
				}
				var image = $(this);
				image.
					attr('src', image.attr('data-src')).
					removeAttr('data-src');
			});
		}
	
		function setCarouselWidth() {
			var width = dom.carousel.find('li').outerWidth() * options.itemCount + 6;
			dom.carousel.css('width', width * dom.carousel.find('li').length + 'px'); // all li's in one line
			return width;
		}
	
		function removeFirstPhotos() {
			var old = dom.carousel.find('li').slice(0,3);
			dom.container.css('left', '0px');
			dom.carousel.find('li').slice(0,3).remove();
			dom.carousel.append(old);
	
		}
	
		function attachBlindImages() {
			if (dom.carousel.find('li').length == 5) {
				dom.carousel.append("<li class='blind'></li>");
			}
			else if (dom.carousel.find('li').length == 4) {
				dom.carousel.append("<li class='blind'></li>");
				dom.carousel.append("<li class='blind'></li>");
			}
	
			dom.carousel.find('li').first().addClass("first-image");
			dom.carousel.find('li').last().addClass("last-image");
		}
		
		return this.each(function() {
			
			// if there's an awkward number of thumbnails, add empty <li>'s to fill the space
			attachBlindImages();
			
			// Set up click events
			dom.next.click(nextImage);
			dom.previous.click(previousImage);
	
			// on mouseover load the rest of images
			dom.wrapper.one('mouseover', function() {
				lazyLoadImages('rest');
			});
			
		});
	}
})(jQuery, this);