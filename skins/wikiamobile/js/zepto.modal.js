(function( $ ){

	$._modalCreated = false;
	$._position = 1;
	$._timer =  null;
	$._caption = false;
	$._hideBarsAfter = 5500;

	$._createModal =  function() {
		var modal = '<div id="modalWrapper">\
				<div id="modalTopBar"></div>\
				<div id="modalClose">&times;</div>\
				<div id="modalContent"></div>\
				<div id="modalFooter"></div>\
			</div>',
		that = this;

		$('body').append(modal);

		this._modal = $('#modalWrapper');
		this._modalClose = $('#modalClose');
		this._modalTopBar = $('#modalTopBar');
		this._modalContent = $('#modalContent');
		this._modalFooter = $('#modalFooter');
		this._allToHide = this._modalTopBar.add(this._modalClose).add(this._modalFooter);
		this._thePage = $('#navigation, #WikiaPage, #wikiaFooter');


		$(document.body).delegate('#modalClose', WikiaMobile._clickevent , function() {
			that.closeModal();
		});

		$(document.body).delegate('#modalWrapper', WikiaMobile._clickevent, function() {
			that._resetTimeout();
		});

		//handling next/previous image in lightbox
		$(document.body).delegate('#nextImage', WikiaMobile._clickevent, function() {
			$._nextImage($(this).prev());
		});

		$(document.body).delegate('#previousImage', WikiaMobile._clickevent, function() {
			that._previousImage($(this).next());
		});

		$(document.body).delegate('.fullScreenImage', 'swipeLeft', function() {
			$._nextImage($(this));
		});

		$(document.body).delegate('.fullScreenImage', 'swipeRight', function() {
			that._previousImage($(this));
		});

		this._modalCreated = true;
	};

	$._nextImage = function(imagePlace) {
		var nextImageNumber = parseInt(imagePlace.data('number')) + 1;

		if(WikiaMobile.getImages().length <= nextImageNumber) {
			nextImageNumber = 0;
		}
		this.changeImage(nextImageNumber, imagePlace);
	};

	$._previousImage = function(imagePlace) {
		var previousImageNamber = parseInt(imagePlace.data('number')) - 1;

		if(previousImageNamber < 0) {
			previousImageNamber = WikiaMobile.getImages().length-1;
		}
		this.changeImage(previousImageNamber, imagePlace);
	};

	$.changeImage = function(imageNumber, fullScreen) {
		var image = WikiaMobile.getImages()[imageNumber];

		fullScreen.css('background-image','url("' + image[0] + '")');
		fullScreen.data('number', imageNumber);

		this._showCaption(image[1]);
	};

	$._showCaption = function(caption) {
		if(caption) {
			this._modalFooter.show();
			this._modalFooter.html(caption);
			this._caption = true;
		} else {
			this._caption = false;
			this._modalFooter.hide();
		}
	};

	$.openModal =  function(options) {
		if(!this._modalCreated) this._createModal();
		options = options || {};

		if(options.html) {
			this._modalContent.html(options.html);
		} else {
			this._modalContent.html('No Content provided');
		}

		this._showCaption(options.caption);

		if(options.toHide) {
			var toHide = options.toHide;
			if(typeof toHide == 'string') {
				this._toHide = $(toHide);
			} else if(toHide instanceof Array) {
				for(var i = 0, l = toHide.length; i < l; i++) {
					this._toHide.add(toHide[i]);
				}
			}  else {
				this._toHide = null;
			}
		} else {
			this._toHide = null;
		}

		this._position = pageYOffset;

		this._thePage.hide();
		this._modal.addClass('modalShown');
		this._resetTimeout();
	};

	$._resetTimeout = function() {
		var allToHide = this._allToHide,
		toHide = this._toHide || false;

		allToHide.removeClass('hidden');
		if(toHide) toHide.removeClass('hidden');

		clearTimeout(this._timer);
		this._timer = setTimeout(function() {
			allToHide.addClass('hidden');
			if(toHide) toHide.addClass('hidden');
		}, this._hideBarsAfter);
	};

	$.closeModal =  function() {
		if(this._modalCreated) {
			this.hideModal();
			this._modalContent.html('');
			this._modalFooter.html('');
		}
	};

	$.hideModal = function() {
		if(this._modalCreated) {
			var modal = this._modal;
			modal.removeClass('modalShown');
			this._allToHide.removeClass('hidden');
			this._thePage.show();
			window.scrollTo(0, this._position);
			this._position = 1;
			clearTimeout(this._timer);
		}
	};

	$.isModalShown = function(){
		return this._modal.hasClass('modalShown');
	};
})(Zepto);