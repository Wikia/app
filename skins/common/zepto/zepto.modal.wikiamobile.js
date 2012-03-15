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
	track = function(ev, what){
		WikiaTracker.track('/1_mobile/'+(what?(what+'/'):'')+'modal/' + ev, 'main.sampled');
	},
	sharePopOver,
	d = document;

	createModal =  function() {
		var resolution = WikiaMobile.getDeviceResolution();

		d.body.insertAdjacentHTML('beforeend', '<div id=wkMdlWrp><div id=wkMdlTB><div class=wkShr id=wkShrImg></div><div id=wkMdlClo class=clsIco></div></div><div id=wkMdlCnt></div><div id=wkMdlFtr></div>\
			</div><style>#wkMdlWrp{min-height:' + resolution[1] + 'px;}@media only screen and (orientation:landscape) and (min-width: 321px){#wkMdlWrp{min-height:' + resolution[0] + 'px;}}</style>');

		images = WikiaMobile.getImages();
		clickEvent = WikiaMobile.getClickEvent();

		modal = $(d.getElementById('wkMdlWrp'));
		modalClose = $(d.getElementById('wkMdlClo'));
		modalTopBar = $(d.getElementById('wkMdlTB'));
		modalContent = $(d.getElementById('wkMdlCnt'));
		modalFooter = $(d.getElementById('wkMdlFtr'));
		allToHide = modalTopBar.add(modalFooter);
		thePage = $('#wkAdPlc, #wkTopNav, #wkPage, #wkFtr');

		//hide adress bar on orientation change
		window.onorientationchange = function() {
				if(window.pageYOffset == 0) setTimeout(function() {window.scrollTo( 0, 1 )},1);
		}

		//close modal on back button
		if ("onhashchange" in window) {
			window.addEventListener("hashchange", function() {
				if(window.location.hash == "" && $.isModalShown()){
					$.closeModal();
				}
			}, false);
		}

		modalClose.bind(clickEvent, function(event) {
			$.closeModal();
			window.history.back();
		});

		modal.bind(WikiaMobile.getTouchEvent(), function() {
			if(this.className.indexOf('imgMdl') > -1) {
				window.scrollTo( 0, 1 );
			}
			$.resetTimeout();
		});

		//handling next/previous image in lightbox
		$(d.body).delegate('#nxtImg', 'swipeLeft ' + clickEvent, function(event) {
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
		
		sharePopOver = WikiaMobile.popOver({
			on: d.getElementById('wkShrImg'),
			style: 'left:3px;',
			create: function(cnt){
				$(cnt).delegate('li', clickEvent, function(){
					track(this.className.replace('Shr',''),'share');
				});
			},
			open: function(event){
				event.stopPropagation();
				$.preventHide();
				sharePopOver.changeContent(WikiaMobile.loadShare);
				track('open', 'share');
			},
			close: function(){
				track('close', 'share');
				$.resumeHide();
			}
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

		WikiaMobile.loader.show(fullScreen[0], {center: true});

		img.src = image[0];
		fullScreen.css('background-image','url()');
		img.onload =  function() {
			fullScreen.css('background-image','url("' + img.src + '")').data('num', current);
			WikiaMobile.loader.hide(fullScreen[0]);
			img.onload = img = null;
		};

		showCaption(image[2], image[3], image[4]);
		
		sharePopOver.close();
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
	};
	
	$.getCurrentImg = function(){
		return current;
	}
	
	$.preventHide = function(){
		$.noTimeout = true;
		clearTimeout(timer);
	};
	
	$.resumeHide = function(){
		$.noTimeout = false;
		$.resetTimeout();
	};

	$.resetTimeout = function() {
		if(!$.noTimeout){
			allToHide.removeClass('hdn');
			if(hide) hide.removeClass('hdn');
	
			clearTimeout(timer);
			timer = setTimeout(function() {
				allToHide.addClass('hdn');
				if(hide) hide.addClass('hdn');
			}, hideBarsAfter);
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
		$.resetTimeout();
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