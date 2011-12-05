(function( $ ){

	$._modalCreated = false;
	$._position = 1;
	$._timer =  null;
	$._caption = false;
	$._hideBarsAfter = 2500;

	$._createModal =  function() {
		var resolution = WikiaMobile.getDeviceResolution(),
		modal = '<div id="modalWrapper">\
				<div id="modalTopBar"></div>\
				<div id="modalClose">&times;</div>\
				<div id="modalContent"></div>\
				<div id="modalFooter"></div>\
			</div><style>#modalWrapper{min-height:'+resolution[1]+'px;}@media only screen and (orientation:landscape) and (min-width: 321px){#modalWrapper{min-height:'+resolution[0]+'px;}}</style>',
		that = this;

		$('body').append(modal);

		that._modal = $('#modalWrapper');
		that._modalClose = $('#modalClose');
		that._modalTopBar = $('#modalTopBar');
		that._modalContent = $('#modalContent');
		that._modalFooter = $('#modalFooter');
		that._wikiaAdPlace = $('#WikiaAdPlace');
		that._allToHide = this._modalTopBar.add(this._modalClose).add(this._modalFooter);
		that._thePage = $('body').children().not('#modalWrapper,style,script');

		//hide adress bar on orientation change
		window.onorientationchange = function() {
				if(pageYOffset == 0) window.scrollTo( 0, 1 );
		}

		$('#modalClose').bind(WikiaMobile._clickevent , function() {
			that.closeModal();
		});

		$('#modalWrapper').bind(WikiaMobile._clickevent, function() {
			that._resetTimeout();
		});

		//handling next/previous image in lightbox
		$(document.body).delegate('#nextImage', WikiaMobile._clickevent, function() {
			$._nextImage($(this).prev());
		});

		$(document.body).delegate('#previousImage', WikiaMobile._clickevent, function() {
			that._previousImage($(this).next());
		});

		$(document.body).delegate('#nextImage', 'swipeLeft', function() {
			$._nextImage($(this).prev());
		});

		$(document.body).delegate('#previousImage', 'swipeRight', function() {
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
		var image = WikiaMobile.getImages()[imageNumber],
		img = new Image();

		img.src = image[0];
		fullScreen.css('background-image','url()');
		img.onload =  function() {
			fullScreen.css('background-image','url("' + img.src + '")');
			fullScreen.data('number', imageNumber);
			$.hideLoader(fullScreen);
		};
		$.showLoader(fullScreen,{center: true});

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

		if(options.addClass) {
			this._modal.addClass(options.addClass);
		} else {
			this._modal.attr('class', '');
		}

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
		this._wikiaAdPlace.css('pointer-events','none');
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
			this._modal.attr('class', '');
		}
	};

	$.hideModal = function() {
		if(this._modalCreated) {
			var modal = this._modal,
			wikiaAdPlace = this._wikiaAdPlace;

			modal.removeClass('modalShown');
			this._allToHide.removeClass('hidden');
			this._thePage.show();
			clearTimeout(this._timer);
			window.scrollTo(0, this._position);
			this._position = 1;
			setTimeout(function() {
				wikiaAdPlace.css('pointer-events','auto');
			},100);
		}
	};

	$.isModalShown = function(){
		return this._modal.hasClass('modalShown');
	};
})(Zepto);