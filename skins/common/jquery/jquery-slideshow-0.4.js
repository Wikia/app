// jquery.timers.js
jQuery.fn.extend({
	everyTime: function(interval, label, fn, times, belay) {
		return this.each(function() {
			jQuery.timer.add(this, interval, label, fn, times, belay);
		});
	},
	oneTime: function(interval, label, fn) {
		return this.each(function() {
			jQuery.timer.add(this, interval, label, fn, 1);
		});
	},
	stopTime: function(label, fn) {
		return this.each(function() {
			jQuery.timer.remove(this, label, fn);
		});
	}
});

jQuery.extend({
	timer: {
		guid: 1,
		global: {},
		regex: /^([0-9]+)\s*(.*s)?$/,
		powers: {
			// Yeah this is major overkill...
			'ms': 1,
			'cs': 10,
			'ds': 100,
			's': 1000,
			'das': 10000,
			'hs': 100000,
			'ks': 1000000
		},
		timeParse: function(value) {
			if (value == undefined || value == null)
				return null;
			var result = this.regex.exec(jQuery.trim(value.toString()));
			if (result[2]) {
				var num = parseInt(result[1], 10);
				var mult = this.powers[result[2]] || 1;
				return num * mult;
			} else {
				return value;
			}
		},
		add: function(element, interval, label, fn, times, belay) {
			var counter = 0;

			if (jQuery.isFunction(label)) {
				if (!times)
					times = fn;
				fn = label;
				label = interval;
			}

			interval = jQuery.timer.timeParse(interval);

			if (typeof interval != 'number' || isNaN(interval) || interval <= 0)
				return;

			if (times && times.constructor != Number) {
				belay = !!times;
				times = 0;
			}

			times = times || 0;
			belay = belay || false;

			if (!element.$timers)
				element.$timers = {};

			if (!element.$timers[label])
				element.$timers[label] = {};

			fn.$timerID = fn.$timerID || this.guid++;

			var handler = function() {
				if (belay && this.inProgress)
					return;
				this.inProgress = true;
				if ((++counter > times && times !== 0) || fn.call(element, counter) === false)
					jQuery.timer.remove(element, label, fn);
				this.inProgress = false;
			};

			handler.$timerID = fn.$timerID;

			if (!element.$timers[label][fn.$timerID])
				element.$timers[label][fn.$timerID] = window.setInterval(handler,interval);

			if ( !this.global[label] )
				this.global[label] = [];
			this.global[label].push( element );

		},
		remove: function(element, label, fn) {
			var timers = element.$timers, ret;

			if ( timers ) {

				if (!label) {
					for ( label in timers )
						this.remove(element, label, fn);
				} else if ( timers[label] ) {
					if ( fn ) {
						if ( fn.$timerID ) {
							window.clearInterval(timers[label][fn.$timerID]);
							delete timers[label][fn.$timerID];
						}
					} else {
						for ( var fn in timers[label] ) {
							window.clearInterval(timers[label][fn]);
							delete timers[label][fn];
						}
					}

					for ( ret in timers[label] ) break;
					if ( !ret ) {
						ret = null;
						delete timers[label];
					}
				}

				for ( ret in timers ) break;
				if ( !ret )
					element.$timers = null;
			}
		}
	}
});

if (jQuery.browser.msie)
	jQuery(window).one("unload", function() {
		var global = jQuery.timer.global;
		for ( var label in global ) {
			var els = global[label], i = els.length;
			while ( --i )
				jQuery.timer.remove(els[i], label);
		}
	});



/* JQuery Slideshow 0.4
	by Aaron Lozier 2008 (lozieraj-[at]-gmail.com) (twitter: @ajlozier)
	version 0.2
		* made adjustments that allow you to activate multiple slide shows on one page
	version 0.3
		* added "CrossWipe" transition effect.  looks kind of like windshield wiper or a book page turning
		* integrated with jquery.dimensions.js which is necessary for CrossWipe and probably other effects as well
	version 0.4
		* there was confusion (with myself) about whether the slideClass and the slideButton classes refers to the list <ul>
		element or the div "containing" the <ul>.  it refers now to the <ul> element itself.  (see example below).
		* you may now include the prevClass and the nextClass in the same list (see example again)
		* fixed bug - clicking Prev or Next did not pause animation as it should have.
		* Note: Buttons must be <a> tags.  See below.

	To Do:
		* Add documentation and examples!!  Coming soon, I promise.

	Dependencies:
		* jQuery 1.2.x
		* jquery.timers.js (http://jquery.offput.ca/every/)
		* jquery.dimensions.js (http://plugins.jquery.com/project/dimensions)

	Usage:

	$('#slideshow').slideshow();

	Note: At this time it is required that all CSS/XHTML be handled outside the plugin.  Here is a code example:

	<div id="slideshow">
		<ul class="slideClass">
			<li><img src="image-1.jpg" alt="Slide 1" /></li>
			<li><img src="image-2.jpg" alt="Slide 2" /></li>
			<li><img src="image-3.jpg" alt="Slide 3" /></li>
		</ul>
		<ul class="slideButton">
			<li><a class="prevClass">Prev</a></li>
			<li><a class="selected">1</a></li>
			<li><a>2</a></li>
			<li><a>3</a></li>
			<li><a class="nextClass">Next</a></li>
		</ul>
	</div>

	<style type="text/css">
		*{
			margin:0;
			padding:0;
		}
		#slideshow{
			position:relative;
			top:0px;
			left:0px;
		}
		.slideClass,.slideButton{
			list-style:none;
		}
		.slideClass li{
			position:absolute;
			top:0px;
			left:0px;
		}
		.slideButton{
			clear: both;
		}
		.slideButton li
		{
			float:left;
			margin: 0 5px 0 0;
		}
	</style>
*/

(function(jQuery){
 jQuery.fn.slideshow = function(options) {

	var defaults = {
		slideDuration: 5000,					//in ms, time between slides
		fadeDuration: 'slow',					//in ms (or jQuery alias - e.g. slow, fast, etc) duration of fade
		slidesClass: 'slideClass', 				//class of slides UL
		buttonsClass: 'slideButton',			//class of buttons UL
		nextClass: 'nextClass',					//class of "next" button
		prevClass: 'prevClass',					//class of "prev" button
		pauseClass: 'pauseClass',				//class of "pause" button
		startClass: 'startClass',				//class of "start" button
		reverseClass: 'reverseClass',			//class of "reverse" button
		blockedClass: 'blockedClass',			//wikia: class of blocked "play" / "pause" button
		topZIndex: 100,							//z-index of top slide
		stayOn: false,							//stay on a particular slide (e.g. 1,2,3) if false, slideshow automatically animates
		stopOnSelect: true,						//stop slideshow if user presses controls
		direction: 1,							//direction: 1 forward, -1 backward
		transitionType: 'crossFade',				//crossFade, crossWipe
		slideWidth:	'575px'					//it was either this or require the dimensions plugin
	};

	var options = jQuery.extend(defaults, options);
	var pass = 0;

  return this.each(function() {

		var curslide = 0;
		var prevslide = 0;
		var num_slides = 0;
		var num_buttons = 0;
		var slide_width = '0px';

		pass++;

		var obj = jQuery(this);
		obj.data('slideshowed',true);

		var objId = obj.attr('id');

		num_slides = obj.find('.'+ options.slidesClass).eq(0).children('li').length;
		slide_width = obj.find('.'+ options.slidesClass).eq(0).children('li').eq(0).outerWidth();

		var button_selector = '.'+options.buttonsClass+' li a:not(".prevClass.nextClass")';
		num_buttons = obj.find(button_selector).length;

		obj.find(button_selector).eq(0).addClass('selected');

		obj.find('.'+ options.slidesClass).each(function(){
			var i = 0;

			jQuery(this).children('li').each(function(){
				i++;
				jQuery(this).css('z-index',(options.topZIndex-i));
				if(i>1){
					jQuery(this).css('display','none');
				}
			});
		});

		// Wikia
		fireEvent('slide');
		obj.data('currentSlide', curslide);
		obj.data('slides', num_slides);

		if(options.stayOn){
			curslide = (options.stayOn-1);
			doSlide();
		} else {
			obj.everyTime(options.slideDuration, 'animateSlides'+pass, function(){
				moveSlide(options.direction,objId);
			});

			fireEvent('onStart');
		}

		function moveSlide(direction,objId){
			jQuery('ul.debug').append('<li>moveSlide +  / ' + direction+'</li>');

			curslide = curslide + direction;
			prevslide = curslide - direction;
			switch(direction){
				case 1:
					if(curslide==num_slides){
						curslide = 0;
						prevslide = (num_slides - 1);
					}
					break;
				case -1:
					if(curslide<0){
						curslide = (num_slides - 1);
						prevslide = 0;
					}
					break;
			}

			doSlide(objId);
		}

		obj.find('.'+options.prevClass).click(function(){
			if(!$(this).hasClass('inactive')){
				obj.stopTime('animateSlides'+pass);
				moveSlide(-1,objId);

				fireEvent('onPrev');
				fireEvent('onStop');
			}
		 });
		obj.find('.'+options.nextClass).click(function(){
			if(!$(this).hasClass('inactive')){
				obj.stopTime('animateSlides'+pass);
				moveSlide(1,objId);

				fireEvent('onNext');
				fireEvent('onStop');
			}
		 });
		obj.find('.'+options.pauseClass).click(function(){
				obj.stopTime('animateSlides'+pass);

				// wikia
				$(this).addClass(options.blockedClass);
				obj.find('.'+options.startClass).removeClass(options.blockedClass);
		 });
		obj.find('.'+options.startClass).click(function(){
			obj.everyTime(options.slideDuration, 'animateSlides'+pass, function advanceSlide() {
				moveSlide(options.direction,objId);
			});

			// wikia
			$(this).addClass(options.blockedClass);
			obj.find('.'+options.pauseClass).removeClass(options.blockedClass);
		 }).addClass(options.blockedClass);

		obj.find('.'+options.reverseClass).click(function(){
			options.direction = (options.direction * (-1));
		 });


		obj.find(button_selector).click(function(){
			var thisObj = jQuery('#'+objId);
			if(options.stopOnSelect){
				obj.stopTime('animateSlides'+pass);

				fireEvent('onStop');
			}
			curslide = jQuery(thisObj.find(button_selector)).index(this);
			doSlide(objId);
		});

		function doSlide(objId){
			var thisObj = jQuery('#'+objId);

			if (!thisObj.exists()) {
				return;
			}

			thisObj.find(button_selector).removeClass('selected');
			thisObj.find(button_selector).eq(curslide).addClass('selected');

			thisObj.find('.'+ options.slidesClass).each(function(){
					switch(options.transitionType){
						case 'crossFade':
							jQuery(this).children('li').eq(curslide).animate({opacity:'show'},options.fadeDuration);
							jQuery(this).children('li').not(jQuery(this).children('li').eq(curslide)).animate({opacity:'hide'},options.fadeDuration);
							break;
						case 'crossWipe':
							if(curslide>prevslide){
								jQuery(this).children('li').eq(curslide).show();
								jQuery(this).children('li').eq(prevslide).animate({width:'0px'},options.fadeDuration,function(){
									$(this).css('display','none');
								});
							} else {

								jQuery(this).children('li').eq(curslide).animate({width:slide_width},options.fadeDuration,function(){
									//pass
								});
							}

							if(curslide==0){
								thisObj.find('.'+options.prevClass).addClass('inactive');
							} else {
								thisObj.find('.'+options.prevClass).removeClass('inactive');
							}

							if(curslide==(num_slides-1)){
								thisObj.find('.'+options.nextClass).addClass('inactive');
							} else {
								thisObj.find('.'+options.nextClass).removeClass('inactive');
							}
							break;
					}
			});

			// Wikia
			fireEvent('slide');
			thisObj.data('currentSlide', curslide);
		}

		/**
		 * Wikia tweaks below
		 */

		// fire custom event so we can handle slideshow animation
		function fireEvent(eventType) {
			var slideshow = jQuery('#'+objId);

			slideshow.trigger(eventType, {
				currentSlideId: curslide,
				totalSlides: num_slides
			});
		}

		// add method to select slide by ID
		// usage: $('#foo').trigger('selectSlide', {slideId: 2});
		obj.bind('selectSlide', function(ev, data) {
			curslide = parseInt(data.slideId);
			doSlide(objId);
		});

		// add method to (re)start slideshow animation
		// usage: $('#foo').trigger('start');
		obj.bind('start', function(ev) {
			obj.everyTime(options.slideDuration, 'animateSlides'+pass, function(){
				moveSlide(options.direction,objId);
			});

			fireEvent('onStart');
		});

		// add method to stop slideshow animation
		// usage: $('#foo').trigger('stop');
		obj.bind('stop', function(ev) {
			obj.stopTime('animateSlides'+pass);

			fireEvent('onStop');
		});
  });
 };
})(jQuery);
