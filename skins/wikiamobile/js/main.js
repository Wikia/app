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
		var tables = $('table').not('table table');
		tables.each(function() {
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
			if ( element.nodeName === 'H2' ) {
				if ( !firstH2 ) {
					open = false;
					mainContent += '</section>';
				}
				mainContent += element.outerHTML + '<section class="articleSection">';
				firstH2 = false;
				open = true;
			} else if ( element.nodeName === 'OBJECT' ) {
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

	init = function() {
		WikiaMobile._clickevent = ('ontouchstart' in window)?'tap':'click';

		var body = $(document.body),
		navigationWordMark = $('#navigationWordMark'),
		navigationSearch = $('#navigationSearch'),
		searchToggle = $('#searchToggle'),
		searchInput = $('#searchInput');

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

		//Using delegate on document.body as it's been proved to be the fastest option
		//$( document.body ).delegate( '#openToggle', 'click', function() {
		//	$( '#navigation').toggleClass( 'open' );
		//});

		//$( document.body ).delegate( '#navigationMenu > li', 'click', function() {
		//	if ( !( $( this ).hasClass( 'openMenu' ) ) ) {
		//
		//		$( '#navigationMenu > li' ).removeClass( 'openMenu' );
		//		$( this ).addClass( 'openMenu' );
		//
		//		tab = "#" + $( this ).text().toLowerCase() + "Tab";
		//		$( '#openNavigationContent > div.navigationTab' ).removeClass( 'openTab' );
		//		$( tab ).addClass( 'openTab' );
		//	}
		//});

		body.delegate( '#WikiaMainContent > h2, #WikiaPage .collapsible-section', this._clickevent, function() {
			$(this).toggleClass('open').next().toggleClass('open');
		});

		//$( document.body ).delegate( '#WikiaPage', 'swipeLeft', function() {
		//	position = pageYOffset;
		//	$( '#wikiaFooter, #navigation, #WikiaPage' ).css( 'display', 'none' );
		//	$( '#leftPane' ).css( { 'display': 'block', 'opacity': '1' } );
		//});
		//
		//$( document.body ).delegate( '#leftPane', 'swipeRight', function() {
		//	$( '#wikiaFooter, #navigation, #WikiaPage' ).css( 'display', 'block'  );
		//	window.scrollTo( 0, position );
		//	position = 1;
		//	$( '#leftPane' ).css( { 'display': 'none', 'opacity': '0' } );
		//});

		$('.infobox img').bind(this._clickevent, function(event) {
			event.preventDefault();
			var thumb = $(this),
				image = thumb.parents('.image');

			$.openModal({
				html: '<div class="changeImageButton" id="previousImage"><div class="changeImageChevron"></div></div><div class="fullScreenImage" data-number='+
					image.data('number')+
					' style=background-image:url("'+
					image.attr('href')+
					'")></div><div class="changeImageButton" id="nextImage"><div class="changeImageChevron"></div></div>',
				toHide: '.changeImageButton'
			})
		});

		$('figure').bind(this._clickevent, function(event) {
			event.preventDefault();
			var thumb = $(this),
				image = thumb.children('.image').first();

			$.openModal({
				html: '<div class="changeImageButton" id="previousImage"><div class="changeImageChevron"></div></div><div class="fullScreenImage" data-number='+
					image.data('number')+
					' style=background-image:url("'+
					image.attr('href')+
					'")></div><div class="changeImageButton" id="nextImage"><div class="changeImageChevron"></div></div>',
				caption: thumb.children('.thumbcaption').html(),
				toHide: '.changeImageButton'
			});
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
			$('iframe').closest('body > div, #WikiaAdPlace > div').add('#trion_toolbar_padding').remove();
		});

		body.delegate('.tooBigTable', this._clickevent, function(event) {
			event.preventDefault();
			$.openModal({
				addClass: 'wideTable',
				html: this.outerHTML
			})
		});

		$('#fullSiteSwitch').bind('click', function(event){
			event.preventDefault();
			Wikia.CookieCutter.set('mobilefullsite', 'true');
			location.reload();
		});

		body.delegate('.wikia-slideshow',this._clickevent, function(event) {
			event.preventDefault();
			$.openModal({
				html: '<div class="changeImageButton" id="previousImage"><div class="changeImageChevron"></div></div><div class="fullScreenImage" data-number='+
					$(this).data('number')+
					' style=background-image:url("'+
					$(this).find('img').attr('src')+
					'")></div><div class="changeImageButton" id="nextImage"><div class="changeImageChevron"></div></div>',
				toHide: '.changeImageButton',
				caption: "Slideshow image #1"
			});
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