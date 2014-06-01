var WikiaMosaicSliderMasterControl = {
	init: function() {
		// cache DOM
		WikiaMosaicSliderMasterControl.sliders = [];
		var sliders = $(".WikiaMosaicSlider");
		// initialize sliders
		for(var i = 0; i < sliders.length; i++) {
			WikiaMosaicSliderMasterControl.sliders.push(new WikiaMosaicSlider(sliders[i]));
		}

		sliders.click(WikiaMosaicSliderMasterControl.clickTrackingHandler);
	},
	trackClick: function(category, action, label, value, params, event) {
		Wikia.Tracker.track({
			action: action,
			browserEvent: event,
			category: category,
			label: label,
			trackingMethod: 'internal',
			value: value
		});
	},

	clickTrackingHandler: function(e) {
		var node = $(e.target);
		var mouseButton = e.button;
		var startTime = new Date();

		if (node.closest('.wikia-mosaic-slider-region').length > 0 && node.closest('a').length > 0) {
			var url = node.closest('a').attr('href');
			WikiaMosaicSliderMasterControl.trackClick('MosaicSlider', Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'hero', null, {href:url, button: mouseButton}, e);
		} else if (node.closest('.wikia-mosaic-slide').length > 0) {
			var liNode = node.closest('.wikia-mosaic-slide');
			var allLiNode = node.closest('.wikia-mosaic-thumb-region').find('.wikia-mosaic-slide');
			var imageIndex = allLiNode.index(liNode) + 1;
			var url = node.closest('a').attr('href');
			WikiaMosaicSliderMasterControl.trackClick('MosaicSlider', Wikia.Tracker.ACTIONS.CLICK_LINK_IMAGE, 'thumbnail', imageIndex, {href:url, button: mouseButton}, e);
		}
		$().log('tracking took ' + (new Date() - startTime) + ' ms');
	}
};

var WikiaMosaicSlider = function(el) {
	this.el = $(el);
	this._imageWidth = 320;
	this.init();

	/* temp transition code until grid is fully rolled out, remove and integrate after transition */
	if( window.wgOasisGrid ) {
		this._imageWidth = 330;
	}
	/* end temp transistion code */
};

WikiaMosaicSlider.prototype.init = function() {
	// pre-cache DOM
	this.thumbRegion = this.el.find('.wikia-mosaic-thumb-region');
	this.slides = this.thumbRegion.find('.wikia-mosaic-slide');
	this.slideLinks = this.thumbRegion.find('.wikia-mosaic-link');
	this.slideDescriptions = this.slides.find('.wikia-mosaic-description');
	this.largeThumbs = this.slides.find('.wikia-mosaic-hero-image');
	this.sliderRegion = this.el.find('.wikia-mosaic-slider-region');
	this.sliderPanorama = this.sliderRegion.find('.wikia-mosaic-slider-panorama');
	this.sliderDescription = this.sliderRegion.find('.wikia-mosaic-slider-description');
	this.sliderRegionLink = this.sliderRegion.find('.wikia-mosaic-link');

	// build slider region (DOM op)
	this.sliderPanorama.append(this.largeThumbs);

	// other variables
	this.timerIndex = 0;
	this.timer = 5000;	// 3 seconds

	// attach event handler
	this.slides.hover($.proxy(this.handleSlideClick, this), function() {});
	this.timerHandle = setInterval($.proxy(this.timedSlide, this), this.timer);

	// display
	this.showSlide(0);
	this.el.show();
};

WikiaMosaicSlider.prototype.handleSlideClick = function(e) {
	e.preventDefault();
	if(this.timerHandle) {
		clearInterval(this.timerHandle);
	}
	var slide = $(e.target).closest('.wikia-mosaic-slide');
	var index = this.slides.index(slide);
	this.showSlide(index);
};

WikiaMosaicSlider.prototype.showSlide = function(index) {
	this.sliderDescription.stop(true, true);
	this.sliderPanorama.stop(true, true);

	this.slides.removeClass('selected');

	var slide = $(this.slides[index]);
	slide.addClass('selected');

	this.sliderRegionLink.attr('href', $(this.slideLinks[index]).attr('href'));

	this.sliderDescription.fadeTo(100, 0, $.proxy(function() {
		this.sliderDescription.html(
			$(this.slideDescriptions[index]).html()
		).fadeTo(100, 1);
	}, this) );

	this.sliderDescription.addClass('')
	if ( !Modernizr.csstransitions ) { //jquery animate version for browsers that do not support css transitions
		this.sliderPanorama.animate({left: -(this._imageWidth*index)}, 400);
	}
	else { //css animation for modern browsers
		this.sliderPanorama.css('left', -(this._imageWidth * index));
	}
};

WikiaMosaicSlider.prototype.timedSlide = function() {
	this.timerIndex++;
	if(this.timerIndex > 4) {
		this.timerIndex = 0;
	}
	this.showSlide(this.timerIndex);
};