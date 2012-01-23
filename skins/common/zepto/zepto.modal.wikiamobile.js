(function( $ ){

	$._modalCreated = false;
	$._position = 1;
	$._timer =  null;
	$._caption = false;
	$._hideBarsAfter = 2500;

	$._createModal =  function() {
		var resolution = WikiaMobile.getDeviceResolution(),
		modal = '<div id=wkMdlWrp><div id=wkMdlTB><div id=wkMdlClo>&times;</div></div><div id=wkMdlCnt></div><div id=wkMdlFtr></div>\
			</div><style>#wkMdlWrp{min-height:' + resolution[1] + 'px;}@media only screen and (orientation:landscape) and (min-width: 321px){#wkMdlWrp{min-height:' + resolution[0] + 'px;}}</style>',
		that = this,
		body = $(document.body);

		body.append(modal);

		this._modal = $('#wkMdlWrp');
		this._modalClose = $('#wkMdlClo');
		this._modalTopBar = $('#wkMdlTB');
		this._modalContent = $('#wkMdlCnt');
		this._modalFooter = $('#wkMdlFtr');
		this._allToHide = this._modalTopBar.add(this._modalFooter);
		this._thePage = $('#wkAdPlc, #wkTopNav, #wkPage, #wkFtr');

		//hide adress bar on orientation change
		window.onorientationchange = function() {
				if(window.pageYOffset == 0) setTimeout(function() {window.scrollTo( 0, 1 )},10);
		}

		//close modal on back button
		if ("onhashchange" in window) {
			window.addEventListener("hashchange", function() {
				if(window.location.hash == "" && that.isModalShown()) {
					that.closeModal();
				}
			}, false);
		}

		this._modalClose.bind(WikiaMobile.getClickEvent(), function(event) {
			that.closeModal();
			window.history.back();
		});

		this._modal.bind(WikiaMobile.getTouchEvent(), function() {
			if($(this).hasClass('imgMdl')) {
				window.scrollTo( 0, 1 );
			}
			that._resetTimeout();
		});

		//handling next/previous image in lightbox
		body.delegate('#nxtImg', 'swipeLeft ' + WikiaMobile.getClickEvent(), function() {
			that._nextImage($(this).prev());
		})
		.delegate('#prvImg', 'swipeRight ' + WikiaMobile.getClickEvent(), function() {
			that._previousImage($(this).next());
		})
		.delegate('.fllScrImg', 'swipeLeft', function() {
			that._nextImage($(this));
		})
		.delegate('.fllScrImg', 'swipeRight', function() {
			that._previousImage($(this));
		});

		this._modalCreated = true;
	};

	$._nextImage = function(imagePlace) {
		var nextImageNumber = parseInt(imagePlace.data('num'),10) + 1;

		if(WikiaMobile.getImages().length <= nextImageNumber) {
			nextImageNumber = 0;
		}
		this._changeImage(nextImageNumber, imagePlace);
	};

	$._previousImage = function(imagePlace) {
		var previousImageNamber = parseInt(imagePlace.data('num'),10) - 1;

		if(previousImageNamber < 0) {
			previousImageNamber = WikiaMobile.getImages().length-1;
		}
		this._changeImage(previousImageNamber, imagePlace);
	};

	$._changeImage = function(imageNumber, fullScreen) {
		var image = WikiaMobile.getImages()[imageNumber],
		img = new Image();

		$.showLoader(fullScreen,{center: true});

		img.src = image[0];
		fullScreen.css('background-image','url()');
		img.onload =  function() {
			fullScreen.css('background-image','url("' + img.src + '")').data('num', imageNumber);
			$.hideLoader(fullScreen);
			img.onload = img = null;
		};

		this._showCaption(image[1], image[2], image[3]);
	};

	$._showCaption = function(caption, number, length) {
		caption = caption || '';

		if(number !== undefined) {
			caption += '<div class=wkStkFtr> ' + (number+1) + ' / ' + length + ' </div>';
		}

		if(caption) {
			this._modalFooter.show()[0].innerHTML = caption;
			this._caption = true;
		} else {
			this._caption = false;
			this._modalFooter.hide();
		}
	};

	$.openModal =  function(options) {
		options = options || {};

		var html = options.html,
			imageNumber = options.imageNumber,
			addClass = options.addClass,
			toHide = options.toHide,
			onOpen = options.onOpen,
			modal;

		//needed for closing modal on back button
		window.location.hash = "modal";

		if(!(html || imageNumber)) throw "No content provided for modal";

		if(!this._modalCreated) this._createModal();

		modal = this._modal;
		modal.css('top', '0');
		if(addClass){
			modal.addClass(addClass);
		}else{
			modal.removeClass();
		}

		if(html){
			this._modalContent.html(html);
			this._showCaption(options.caption);
		}else if(imageNumber){
			this._modalContent.html('<div class=chnImgBtn id=prvImg><div class=chnImgChv></div></div><div class=fllScrImg></div><div class=chnImgBtn id=nxtImg><div class=chnImgChv></div></div>');
			$._changeImage(imageNumber, $('.fllScrImg'));
		}

		if(toHide){
			if(typeof toHide == 'string'){
				this._toHide = $(toHide);
			}else if(toHide instanceof Array){
				for(var i = 0, l = toHide.length; i < l; i++) {
					this._toHide.add(toHide[i]);
				}
			}else{
				this._toHide = null;
			}
		}else{
			this._toHide = null;
		}

		if(typeof onOpen == 'function'){
			onOpen();
		}

		this._position = window.pageYOffset;
		this._thePage.hide();
		modal.addClass('mdlShw');
		this._resetTimeout();
	};

	$._resetTimeout = function() {
		var allToHide = this._allToHide,
		toHide = this._toHide || false;

		allToHide.removeClass('hdn');
		if(toHide) toHide.removeClass('hdn');

		clearTimeout(this._timer);
		this._timer = setTimeout(function() {
			allToHide.addClass('hdn');
			if(toHide) toHide.addClass('hdn');
		}, this._hideBarsAfter);
	};

	$.closeModal =  function() {
		if(this._modalCreated) {
			this.hideModal();
			this._modalContent.html('');
			this._modalFooter.html('');
			this._modal.removeClass();
		}
	};

	$.hideModal = function() {
		if(this._modalCreated) {
			var modal = this._modal,
			position = this._position;

			modal.removeClass('mdlShw').css('top', position);
			this._allToHide.removeClass('hdn');
			this._thePage.show();
			clearTimeout(this._timer);
			window.scrollTo(0, position);
			this._position = 1;
		}
	};

	$.isModalShown = function(){
		return this._modal.hasClass('mdlShw');
	};
})(Zepto);