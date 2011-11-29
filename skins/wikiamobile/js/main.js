var WikiaMobile = (function() {

	var allImages = [],
	deviceWidth,
	deviceHeight,
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
		var tables = $('table').not('.infobox');
		tables.each(function() {
			$(this).addClass('tooBigTable');
		});
	},

	getAllImages = function() {
		var number = 0,
		image = [];

		image[0] = $('.infobox .image').data('number' , number++).attr('href');
		allImages.push(image);

		$('.thumb').each(function() {
			var self = $(this);
			image = [];

			image[0] = self.find('.image').data('number', number++).attr('href');
			image[1] = self.find('.thumbcaption').html();
			allImages.push(image);
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
			}else {
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


			if($.os.ios) {
				deviceWidth = screen.width - 44;
				deviceHeight = screen.height - 44;
			} else {
				if(window.orientation == 0) {
					deviceWidth = window.innerWidth;
					deviceHeight = window.innerHeight;
				} else {
					deviceWidth = window.innerHeight + 53;
					deviceHeight = window.innerWidth;
				}

			}

		wrapArticles();
		hideURLBar();
		handleTables();
		getAllImages();

		//I'm using delegate on document.body as it's been proved to be the fastest option
		//$( document.body ).delegate( '#openToggle', 'click', function() {
		//	$( '#navigation').toggleClass( 'open' );
		//});

		body.delegate( '#article-comments-counter-header', 'tap', function() {
			$( '#article-comments').toggleClass( 'open' );
		});

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

		$( '#WikiaMainContent > h2' ).append( '<span class=\"chevron\"></span>' );

		body.delegate( '#WikiaMainContent > h2, #WikiaArticleCategories > h1', this._clickevent, function() {
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

		body.delegate( '.infobox img', this._clickevent, function(event) {
			event.preventDefault();
			var thumb = $(this),
				image = thumb.parents('.image');

			$.openModal({
				html: '<div class="changeImageButton" id="previousImage"></div><div class="fullScreenImage" data-number='+1+
					' style=background-image:url("'+
					image.attr('href')+
					'")></div><div class="changeImageButton" id="nextImage"></div>',
				toHide: '.changeImageButton'
			})
		});

		body.delegate( '.thumb', this._clickevent, function(event) {
			event.preventDefault();
			var thumb = $(this),
				image = thumb.children('.image').first();

			$.openModal({
				html: '<div class="changeImageButton" id="previousImage"></div><div class="fullScreenImage" data-number='+
					image.data('number')+
					' style=background-image:url("'+
					image.attr('href')+
					'")></div><div class="changeImageButton" id="nextImage"></div>',
				caption: thumb.children('.thumbcaption').html(),
				toHide: '.changeImageButton'
			})
		});

		body.delegate('#searchToggle', this._clickevent, function(event) {
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

		body.delegate('#WikiaPage', this._clickevent, function(event) {
			navigationWordMark.show();
			navigationSearch.hide().removeClass('open');
			searchToggle.removeClass('open');
			searchInput.val('');
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
	};

	return {
		init: init,
		getImages: getImages,
		getDeviceResolution: getDeviceResolution
	}
})();

$(function() {
	WikiaMobile.init();
});