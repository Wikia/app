/*
 * Lazy Loader - jQuery plugin for lazy loading images
 *
 * Christian Williams
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Based on Mike Tuupola's Lazy Load plugin:
 * Project home:
 *   http://www.appelsiini.net/projects/lazyload
 *
 */
$(function() {
	$("noscript + img.lazyload").lazyloader();
});
(function($) {
	$.fn.lazyloader = function(options) {
		var settings = {
			threshold	: 0, 
			failurelimit	: 0, 
			event		: "scroll", 
			effect		: "show", 
			container	: window, 
			onload		: true
		};
                
		if (options) { 
			$.extend(settings, options); 
		}
	
		var elements = this;

		/* When the page is fully loaded, give in and load the images. */
		if (settings.onload) {
			$(settings.container).load(function() {
				elements.each(function() {
					if (!this.loaded) {
						//$(this).attr("src", $(this).prev().attr("title"));
						$(this).trigger("appear");
					}
				});
			});
		}

		/* Fire one scroll event per scroll. Not one scroll event per image. */
		if ("scroll" == settings.event) {
			$(settings.container).bind("scroll", function(event) {
				var counter = 0;
				elements.each(function() {
					if (!$.belowthefold(this, settings) && !$.rightoffold(this, settings)) {
						$(this).trigger("appear");
					} else {
						if (counter++ > settings.failurelimit) { 
							return false; 
						} 
					}
				});
                
				/* Remove image from array so it is not looped next time. */
				var temp = $.grep(elements, function(element) { 
					return !element.loaded;
				});
				elements = $(temp); 
			});
		}
        
		return this.each(function() {
			var self = this;
            
			/* When appear is triggered load original image. */
			$(self).one("appear", function() {
				if (!this.loaded) { 
					$("<img />") 
						.bind("load", function() { 
							$(self).attr("src", $(self).prev().attr("title")) 
						})
						.attr("src", $(self).prev().attr("title")); 
				}; 
			}); 
		
			/* When wanted event is triggered load original image by triggering appear. */ 
			if ("scroll" != settings.event) { 
				$(self).bind(settings.event, function(event) { 
					if (!self.loaded) { 
						$(self).trigger("appear"); 
					}
				});
			}

			//if not below the fold or right of fold, make real image appear
			if (!$.belowthefold(this, settings) && !$.rightoffold(this, settings)) {
				$(this).trigger("appear");
			}
		});
	};

	/* Convenience methods in jQuery namespace. */
	/* Use as  $.belowthefold(element, {threshold : 100, container : window}) */

	$.belowthefold = function(element, settings) {
		if (settings.container === undefined || settings.container === window) { 
			var fold = $(window).height() + $(window).scrollTop(); 
		} else { 
			var fold = $(settings.container).offset().top + $(settings.container).height(); 
		} 
		return fold <= $(element).offset().top - settings.threshold;
	};
    
	$.rightoffold = function(element, settings) { 
		if (settings.container === undefined || settings.container === window) { 
			var fold = $(window).width() + $(window).scrollLeft(); 
		} else { 
			var fold = $(settings.container).offset().left + $(settings.container).width(); 
		} 
		return fold <= $(element).offset().left - settings.threshold; 
	};
	
	/* Custom selectors for your convenience.   */
	/* Use as $("img:below-the-fold").something() */

	$.extend($.expr[':'], { 
		"below-the-fold" : "$.belowthefold(a, {threshold : 0, container: window})", 
		"above-the-fold" : "!$.belowthefold(a, {threshold : 0, container: window})", 
		"right-of-fold"  : "$.rightoffold(a, {threshold : 0, container: window})", 
		"left-of-fold"   : "!$.rightoffold(a, {threshold : 0, container: window})" 
	});
})(jQuery);
