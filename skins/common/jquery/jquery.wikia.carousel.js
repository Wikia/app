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

(function($, window) {
	$.fn.carousel = function(options) {
		// All available options for this plugin
		var defaults = {
			transitionSpeed: 500,
			itemsShown: 3,
			activeIndex: 0, // set this item to active on load
			nextClass: "next",
			prevClass: "previous",
			attachBlindImages: false,
			itemClick: false,
			trackProgress: false, // pass in function for inserting progress data into dom. 
			preScroll: false, // execute before moving the caoursel
			postScroll: false // execute after moving the carousel
		};

		options = $.extend(defaults, options);

		// Any dom elements that will be reused
		var dom = {
			wrapper: $(this),
			carousel: $(this).find('.carousel'),
			items: $(this).find('.carousel li'),
			container: $(this).children('div:first'),
			next: $(this).siblings('.' + options.nextClass),
			previous: $(this).siblings('.' + options.prevClass)
		};

		var constants = {
			viewPortWidth: $(this).outerWidth(),
			itemWidth: dom.items.first().outerWidth(true), // item width including margin
			carouselWidth: 0, // updated on init
			minLeft: 0 // updated on init
		};

		var states = {
			browsing: false,
			enable_next: false,
			enable_previous: false,
			currIndex: 0, // index of first li shown in viewport
			left: 0
		};

		function nextImage() {
			if (states.browsing == false && states.enable_next == true) {
				states.browsing = true;

				// calculate a full cycle of new items
				var left = states.left - constants.viewPortWidth;

				// don't go farther left than last image
				if(left < constants.minLeft) {
					var remainder = constants.minLeft - left,
						itemDiff = options.itemsShown - (remainder / constants.itemWidth);

					states.currIndex = states.currIndex + itemDiff;

					left = constants.minLeft;

				} else {
					// update current index
					states.currIndex = states.currIndex + options.itemsShown;
				}

				states.left = left;

				if(typeof options.preScroll == 'function') {
					options.preScroll();
				}
				
				dom.carousel.animate({
					left: left
				}, options.transitionSpeed, function() {
					states.browsing = false;
					afterMove();
				});
			}
			return false;

		}

		function previousImage() {
			if (states.browsing == false && states.enable_previous == true) {
				states.browsing = true;

				var left = states.left + constants.viewPortWidth;

				// Don't go farther right than the first image
				if(left > 0) {
					left = 0;
					states.currIndex = 0;
				} else {
					states.currIndex = states.currIndex - options.itemsShown;
				}

				states.left = left;

				if(typeof options.preScroll == 'function') {
					options.preScroll();
				}
				
				dom.carousel.animate({
					left:  left
				}, options.transitionSpeed, function() {
					states.browsing = false;
					afterMove();
				});
			}
			return false;
		}

		function moveToIndex(idx) {
			// check if index is visible
			if(!isVisible(idx)) {
				// if idx is too close to the end, set idx the last possible index.
				if(idx > (dom.items.length - options.itemsShown)) {
					idx = dom.items.length - options.itemsShown;
				}

				states.currIndex = idx;

				var left = constants.itemWidth * idx * -1;

				// Move carouself to currIndex
				dom.carousel.animate({'left': left});
			}
			// Activate/deactivate left/right arrows
			afterMove();
		}

		function isVisible(idx) {
			// returns true if item at given index is inside viewport
			return idx >= states.currIndex && idx < (states.currIndex + options.itemsShown);
		}

		function getVisible() {
			// returns jQuery object of visible items inside viewport
			return dom.items.slice(states.currIndex, states.currIndex + options.itemsShown);
		}

		function setAsActive(idx) {
			// add an active class to the item that is selected (i.e. to show a larger view of it)
			dom.items.removeClass('active');
			dom.items.eq(idx).addClass('active');

			moveToIndex(idx);
		}

		function afterMove() {
			updateArrows();
			if(typeof options.trackProgress == 'function') {
				trackProgress(options.trackProgress);
			}
			if(typeof options.postScroll == 'function') {
				options.postScroll();
			}
			
		}
		
		function trackProgress(callback) {
			// get values needed
			var total = dom.items.length,
				idx1 = states.currIndex + 1, // make index base 1
				idx2 = states.currIndex + options.itemsShown;
			
			// callback will handle inserting values into the dom
			callback(idx1, idx2, total);
		}
		
		function updateArrows() {

			// If we don't have enough items to fill the viewport, disable both arrows
			if(dom.items.length <= options.itemsShown) {
				disableNext();
				disablePrevious();
				return;
			}

			// get css 'left' property without 'px'
			var left = parseInt(dom.carousel.css('left'));

			// if css 'left' is undefined, set it to 0
			if(isNaN(left)) {
				left = 0;
			}

			if(left == constants.minLeft) {
				// disable right arrow
				disableNext();
				enablePrevious();
			} else if(left == 0) {
				// disable left arrow
				disablePrevious();
				enableNext();
			} else {
				// enable both arrows
				enablePrevious();
				enableNext();
			}
		}

		// on hover, load any images that are invisible and that haven't bee loaded yet
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

		// run this once on init
		function setCarouselWidth() {
			var width = constants.itemWidth * dom.items.length;

			// expand carousel width so all li's are in one line
			dom.carousel.css('width', width);

			// get minimum possible css left value of carousel
			var minLeft = (width - constants.viewPortWidth) * -1;

			// Set constants
			constants.carouselWidth = width;
			constants.minLeft = minLeft;
		}

		// This is mainly used on LatestPhotos
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

		function disableNext() {
			states.enable_next = false;
			dom.next.addClass('disabled');
		}

		function enableNext() {
			states.enable_next = true;
			dom.next.removeClass('disabled');
		}

		function disablePrevious() {
			states.enable_previous = false;
			dom.previous.addClass('disabled');
		}
		function enablePrevious() {
			states.enable_previous = true;
			dom.previous.removeClass('disabled');
		}

		return this.each(function() {

			// if there's an awkward number of thumbnails, add empty <li>'s to fill the space
			if(typeof options.attachBlindImages == 'function') {
				attachBlindImages();
			}

			setCarouselWidth();

			setAsActive(options.activeIndex);

			// Set up click events
			dom.next.click(nextImage);
			dom.previous.click(previousImage);

			if(options.itemClick) {
				dom.carousel.on('click', 'li', function(e) {
					setAsActive($(this).index());
					options.itemClick.call(this, e);
				});
			}

			// on mouseover load the rest of images
			dom.wrapper.parent().one('mouseover', function() {
				lazyLoadImages('rest');
			});

		});
	}
})(jQuery, this);