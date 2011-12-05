var WikiaMobile = (function() {

	var allImages = [],
	deviceWidth,
	deviceHeight,
	realWidth,
	//position,

	getImages = function() {
		return allImages;
	},

	//slide up the addressbar on webkit mobile browsers for maximum reading area
	//setTimeout is necessary to make it work on ios...
	hideURLBar = function() {
		setTimeout( function() {
		  	if (!pageYOffset) window.scrollTo( 0, 1 );
		}, 1 );
	},

	handleTables = function() {
		$('table').not('table table').each(function() {
			if(this.offsetWidth > realWidth) {
				$(this).addClass('tooBigTable');
			}
		});
	},

	getAllImages = function() {
		var number = 0,
		image = [];

		if(image[0] = $('.infobox .image').data('number', number).attr('href')) {
			allImages.push(image);
			number++;
		}

		$('figure').each(function() {
			var self = $(this);
			image = [];

			image[0] = self.find('.image').data('number', number++).attr('href');
			image[1] = self.find('.thumbcaption').html();
			allImages.push(image);
		});

		$('.wikia-slideshow').each(function() {
			var slideshow = $(this),
			length = slideshow.data('number', number++).data('image-count');


			for(var i = 0; i < length;i++) {
				image = [];
				image[0] = slideshow.data('slideshow-image-id-' + i);
				image[1] = "Slideshow image #" + (i+1);
				allImages.push(image);
			}
		});

		if(allImages.length <= 1) $('body').addClass('justOneImage');
	},

	getDeviceResolution = function() {
		return [deviceWidth, deviceHeight];
	},

	wrapArticles = function() {
		var wikiaMainContent = $( '#WikiaMainContent' ),
		content = wikiaMainContent.contents(),
		mainContent = '',
		firstH2 = true,
		video = 1;

		//Im using here plain javascript as Zepto.js does not provide me with real contents method
		//I end up creating simple contents method that returns JS Object instead of Zepto ones
		for( var i = 0, l = content.length; i < l; i++ ) {
			var element = content[i],
			open = false;
			if (element.nodeName == 'H2') {
				if ( !firstH2 ) {
					open = false;
					mainContent += '</section>';
				}
				mainContent += element.outerHTML + '<section class="articleSection">';
				firstH2 = false;
				open = true;
			} else if (element.nodeName == 'OBJECT') {
				mainContent += '<a href="'+ element.data +'">Video #'+ video++ +'</a>';
			} else if(element.nodeName == "NAV") {
				mainContent += '</section>' + element.outerHTML;
				open = false;
			}else if(element.nodeName != '#comment'){
				mainContent += (!element.outerHTML)?element.textContent:element.outerHTML;
			}
		};

		if(!open) mainContent += '</section>';
		wikiaMainContent.html(mainContent);

	},

	imgModal = function(number,href,caption) {
		$.openModal({
			html: '<div class="changeImageButton" id="previousImage"><div class="changeImageChevron"></div></div><div class="fullScreenImage" data-number='+
				number+
				' style=background-image:url("'+
				href+
				'")></div><div class="changeImageButton" id="nextImage"><div class="changeImageChevron"></div></div>',
			toHide: '.changeImageButton',
			caption: caption
		})
	},

	init = function() {
		WikiaMobile._clickevent = ('ontouchstart' in window)?'tap':'click';

		var body = $(document.body),
		navigationWordMark = $('#navigationWordMark'),
		navigationSearch = $('#navigationSearch'),
		searchToggle = $('#searchToggle'),
		searchInput = $('#searchInput'),
		wikiaAdPlace = $('#WikiaAdPlace');

		realWidth = screen.width

		if($.os.ios) {
			deviceWidth = 268;
			deviceHeight = 436;
			if(window.orientation != 0) {
				realWidth = screen.height;
			}
		} else if(window.orientation == 0 || window.orientation == 180) {
			deviceWidth = screen.width;
			deviceHeight = screen.height + 53;
		} else {
			deviceWidth = screen.height + 53;
			deviceHeight = screen.width;
		}

		wrapArticles();
		hideURLBar();
		handleTables();
		getAllImages();

		body.delegate( '#WikiaMainContent > h2, #WikiaPage .collapsible-section', this._clickevent, function() {
			$(this).toggleClass('open').next().toggleClass('open');
		});

		$('.infobox img').bind(this._clickevent, function(event) {
			event.preventDefault();
			var thumb = $(this),
			image = thumb.parents('.image');

			imgModal(image.data('number'), image.attr('href'));
		});

		$('figure').bind(this._clickevent, function(event) {
			event.preventDefault();
			var thumb = $(this),
			image = thumb.children('.image').first();

			imgModal(image.data('number'), image.attr('href'), thumb.children('.thumbcaption').html());
		});

		$('.wikia-slideshow').bind(this._clickevent, function(event) {
			event.preventDefault();
			var slideshow = $(this);

			imgModal(slideshow.data('number'), slideshow.find('img').attr('src'), "Slideshow image #1");
		});

		$('#searchToggle').bind(this._clickevent, function(event) {
			var self = $(this);
			if(self.hasClass('open')) {
				navigationWordMark.show();
				navigationSearch.hide().removeClass('open');
				self.removeClass('open');
				searchInput.val('');
			} else {
				navigationWordMark.hide();
				navigationSearch.show().addClass('open');
				self.addClass('open');
			}
		});

		$('#WikiaPage').bind(this._clickevent, function(event) {
			navigationWordMark.show();
			navigationSearch.hide().removeClass('open');
			searchToggle.removeClass('open');
			searchInput.val('');
		});

		$('.tooBigTable').bind(this._clickevent, function(event) {
			event.preventDefault();
			$.openModal({
				addClass: 'wideTable',
				html: this.outerHTML
			});
		});

		$('#fullSiteSwitch').bind('click', function(event){
			event.preventDefault();
			Wikia.CookieCutter.set('mobilefullsite', 'true');
			location.reload();
		});
	},
	
	getClickEvent = function(){
		return WikiaMobile._clickevent;
	};

	return {
		init: init,
		getImages: getImages,
		getDeviceResolution: getDeviceResolution,
		getClickEvent: getClickEvent
	}
})();

$(function() {
	WikiaMobile.init();
});