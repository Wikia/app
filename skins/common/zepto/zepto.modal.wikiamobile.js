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
	current = 0,
	track = function(ev){
		WikiaTracker.track('/1_mobile/modal/' + ev, 'main.sampled');
	},

	createModal =  function() {
		var resolution = WikiaMobile.getDeviceResolution(),
		body = $(document.body);

		body.append('<div id=wkMdlWrp><div id=wkMdlTB><div class=wkShr id=wkShrImg></div><div id=wkMdlClo>&times;</div></div><div id=wkMdlCnt></div><div id=wkMdlFtr></div>\
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
				if(window.pageYOffset == 0) setTimeout(function() {window.scrollTo( 0, 1 )},1);
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
		body.delegate('#nxtImg', 'swipeLeft ' + clickEvent, function(event) {
			nextImage($(this).prev());
			track(((event.type == 'swipeLeft')?'swipe':'click') + '/left');
		})
		.delegate('#prvImg', 'swipeRight ' + clickEvent, function(event) {
			previousImage($(this).next());
			track(((event.type == 'swipeRight')?'swipe':'click') + '/right');
		})
		.delegate('.fllScrImg', 'swipeLeft', function() {
			nextImage($(this));
			track('swipe/left');
		})
		.delegate('.fllScrImg', 'swipeRight', function() {
			previousImage($(this));
			track('swipe/right');
		});
		//document.body.addEventListener('touchmove', function(event) {
		//	event.preventDefault();
		//}, false);
		
		WikiaMobile.popOver({
			on: document.getElementById('wkShrImg'),
			content: WikiaMobile.loadShare,
			align: 'left:0'
		});

		modalCreated = true;
	},

	nextImage = function(imagePlace) {
		current += 1;

		if(images.length <= current) {
			current = 0;
		}
		changeImage(imagePlace);
	},

	previousImage = function(imagePlace) {
		current -= 1;

		if(current < 0) {
			current = images.length-1;
		}
		changeImage(imagePlace);
	},

	changeImage = function(fullScreen) {
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
	},

	showCaption = function(cap, number, length) {
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
	},

	resetTimeout = function() {

		allToHide.removeClass('hdn');
		if(hide) hide.removeClass('hdn');

		clearTimeout(timer);
		timer = setTimeout(function() {
			allToHide.addClass('hdn');
			if(hide) hide.addClass('hdn');
		}, hideBarsAfter);
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

		if(!(html || typeof current == 'number')) throw "No content provided for modal";

		if(!modalCreated) createModal();

		if(addClass){
			modal.addClass(addClass);
		}else{
			modal.removeClass();
		}

		if(html){
			modalContent.html(html);
			showCaption(options.caption);
		}else if(current >= 0){
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
		track('open');
	};

	$.closeModal = function() {
		if(modalCreated) {
			this.hideModal();
			modalContent.html('');
			modalFooter.html('');
			modal.removeClass();
			if(!Modernizr.positionfixed) WikiaMobile.moveSlot();
			track('close');
		}
	};

	$.hideModal = function() {
		if(modalCreated) {
			modal.removeClass('mdlShw');
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