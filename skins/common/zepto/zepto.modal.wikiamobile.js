(function( $ ){

	var modalCreated = false,
	position = 1,
	timer =  null,
	caption = false,
	hideBarsAfter = 2500,
	images,
	modal,
	modalClose,
	modalTopBar,
	modalContent,
	modalFooter,
	allToHide,
	thePage,
	hide,
	clickEvent,
	current = 1,

	createModal =  function() {
		var resolution = WikiaMobile.getDeviceResolution(),
		body = $(document.body);

		body.append('<div id=wkMdlWrp><div id=wkMdlTB><div id=wkMdlClo>&times;</div></div><div id=wkMdlCnt></div><div id=wkMdlFtr></div>\
			</div><style>#wkMdlWrp{min-height:' + resolution[1] + 'px;}@media only screen and (orientation:landscape) and (min-width: 321px){#wkMdlWrp{min-height:' + resolution[0] + 'px;}}</style>');
		
		images = WikiaMobile.getImages();
		clickEvent = WikiaMobile.getClickEvent();

		modal = $('#wkMdlWrp');
		modalClose = $('#wkMdlClo');
		modalTopBar = $('#wkMdlTB');
		modalContent = $('#wkMdlCnt');
		modalFooter = $('#wkMdlFtr');
		allToHide = modalTopBar.add(modalFooter);
		thePage = $('#wkAdPlc, #wkTopNav, #wkPage, #wkFtr');

		//hide adress bar on orientation change
		window.onorientationchange = function() {
				if(window.pageYOffset == 0) setTimeout(function() {window.scrollTo( 0, 1 )},10);
		}

		//close modal on back button
		if ("onhashchange" in window) {
			window.addEventListener("hashchange", function() {
				if(window.location.hash == "" && $.isModalShown()) {
					$.closeModal();
				}
			}, false);
		}

		modalClose.bind(clickEvent, function(event) {
			$.closeModal();
			window.history.back();
		});

		modal.bind(WikiaMobile.getTouchEvent(), function() {
			if($(this).hasClass('imgMdl')) {
				window.scrollTo( 0, 1 );
			}
			resetTimeout();
		});

		//handling next/previous image in lightbox
		body.delegate('#nxtImg', 'swipeLeft ' + clickEvent, function() {
			nextImage($(this).prev());
		})
		.delegate('#prvImg', 'swipeRight ' + clickEvent, function() {
			previousImage($(this).next());
		})
		.delegate('.fllScrImg', 'swipeLeft', function() {
			nextImage($(this));
		})
		.delegate('.fllScrImg', 'swipeRight', function() {
			previousImage($(this));
		});

		modalCreated = true;
	};

	var nextImage = function(imagePlace) {
		current += 1;

		if(images.length <= current) {
			current = 0;
		}
		changeImage(imagePlace);
	};

	var previousImage = function(imagePlace) {
		current -= 1;

		if(current < 0) {
			current = images.length-1;
		}
		changeImage(imagePlace);
	};

	var changeImage = function(fullScreen) {
		var image = images[current],
		img = new Image();

		$.showLoader(fullScreen,{center: true});

		img.src = image[0];
		fullScreen.css('background-image','url()');
		img.onload =  function() {
			fullScreen.css('background-image','url("' + img.src + '")').data('num', current);
			$.hideLoader(fullScreen);
			img.onload = img = null;
		};

		showCaption(image[1], image[2], image[3]);
	};

	var showCaption = function(cap, number, length) {
		cap = cap || '';

		if(number !== undefined) {
			cap += '<div class=wkStkFtr> ' + (number+1) + ' / ' + length + ' </div>';
		}

		if(cap) {
			modalFooter.show()[0].innerHTML = cap;
			caption = true;
		} else {
			caption = false;
			modalFooter.hide();
		}
	};

	$.openModal =  function(options) {
		options = options || {};

		var html = options.html,
			addClass = options.addClass,
			toHide = options.toHide,
			onOpen = options.onOpen;
			
		current = parseInt(options.imageNumber, 10);
		
		//needed for closing modal on back button
		window.location.hash = "modal";

		if(!(html || current)) throw "No content provided for modal";

		if(!modalCreated) createModal();

		modal.css('top', '0');
		if(addClass){
			modal.addClass(addClass);
		}else{
			modal.removeClass();
		}

		if(html){
			modalContent.html(html);
			showCaption(options.caption);
		}else if(current){
			modalContent.html('<div class=chnImgBtn id=prvImg><div class=chnImgChv></div></div><div class=fllScrImg></div><div class=chnImgBtn id=nxtImg><div class=chnImgChv></div></div>');
			changeImage($('.fllScrImg'));
		}

		if(toHide){
			if(typeof toHide == 'string'){
				hide = $(toHide);
			}else if(toHide instanceof Array){
				for(var i = 0, l = toHide.length; i < l; i++) {
					hide.add(toHide[i]);
				}
			}else{
				hide = null;
			}
		}else{
			hide = null;
		}

		if(typeof onOpen == 'function'){
			onOpen();
		}

		position = window.pageYOffset;
		thePage.hide();
		modal.addClass('mdlShw');
		resetTimeout();
	};

	var resetTimeout = function() {

		allToHide.removeClass('hdn');
		if(hide) hide.removeClass('hdn');

		clearTimeout(timer);
		timer = setTimeout(function() {
			allToHide.addClass('hdn');
			if(hide) hide.addClass('hdn');
		}, hideBarsAfter);
	};

	$.closeModal = function() {
		if(modalCreated) {
			this.hideModal();
			modalContent.html('');
			modalFooter.html('');
			modal.removeClass();
		}
	};

	$.hideModal = function() {
		if(modalCreated) {
			modal.removeClass('mdlShw').css('top', position);
			allToHide.removeClass('hdn');
			thePage.show();
			clearTimeout(timer);
			window.scrollTo(0, position);
			position = 1;
		}
	};

	$.isModalShown = function(){
		return modal.hasClass('mdlShw');
	};
})(Zepto);