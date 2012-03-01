var WikiaMosaicSliderMasterControl = {
	init: function() {
		// cache DOM
		WikiaMosaicSliderMasterControl.sliders = [];
		var sliders = $(".WikiaMosaicSlider");
		// initialize sliders
		for(var i = 0; i < sliders.length; i++) {
			WikiaMosaicSliderMasterControl.sliders.push(new WikiaMosaicSlider(sliders[i]));
		}
	}
};

var WikiaMosaicSlider = function(el) {
	this.el = $(el);
	this._imageWidth = 320;
	this.init();
};

WikiaMosaicSlider.prototype.init = function() {
	// pre-cache DOM
	this.thumbRegion = this.el.find('.wikia-mosaic-thumb-region');
	this.slides = this.thumbRegion.find('.wikia-mosaic-slide');
	this.slideDescriptions = this.slides.find('.wikia-mosaic-description');
	this.largeThumbs = this.slides.find('.wikia-mosaic-hero-image');
	this.sliderRegion = this.el.find('.wikia-mosaic-slider-region');
	this.sliderPanorama = this.sliderRegion.find('.wikia-mosaic-slider-panorama');
	this.sliderDescription = this.sliderRegion.find('.wikia-mosaic-slider-description');
	
	// build slider region (DOM op)
	this.sliderPanorama.append(this.largeThumbs);
	
	// other variables
	this.timerIndex = 0;
	this.timer = 5000;	// 3 seconds
	
	// attach event handler
	this.slides.click($.proxy(this.handleSlideClick, this));
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
	this.slides.removeClass('selected');
	
	var slide = $(this.slides[index]);
	slide.addClass('selected');
	
	this.sliderDescription.fadeOut(200, $.proxy(function() {
		this.sliderDescription.html(
			'<a href="' + $(this.largeThumbs[index]).attr("href") + '">'
			+ $(this.slideDescriptions[index]).html()
			+ '</a>'
		).fadeIn(200);
	}, this) );
	if ( ($.browser.msie) || ( $.browser.mozilla && $.browser.version.slice(0,3) == "1.9" ) ) { //jquery animate version for IE and FF 3.6
		this.sliderPanorama.animate({left: -1*this._imageWidth*index}, 400);
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