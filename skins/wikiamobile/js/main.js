var WikiaMobile = {

	allImages: [],

	hideURLBar: function() {
		if ( $.os.android || $.os.ios || $.os.webos ) {
		//slide up the addressbar on webkit mobile browsers for maximum reading area
		//setTimeout is necessary to make it work on ios...
		setTimeout( function() {
		  	if (!pageYOffset) window.scrollTo( 0, 1 );
		}, 10 );
		}
	},

	getAllImages: function() {
		console.time('getAllImages');
		var allImages = WikiaMobile.allImages,
			number = 0;
		$('.thumb').each(function() {
			var image = [], self = $(this);
			image[0] = self.find('.image').attr('href');
			image[1] = self.find('.thumbcaption').html();
			image[2] = number;
			self.find('.image').data('number', number++)
			allImages.push(image);
		});
		console.timeEnd('getAllImages');
		console.log(WikiaMobile.allImages);
	},

	moveAd: function() {
		$( '#adWrapper' ).addClass( 'hidden' );
		setTimeout( function() {
			$( '#adWrapper' ).removeClass( 'hidden up' );
		}, 600);
	},

	handleAds: function() {
		var hideOnTimeout = setTimeout( function() {
			$( window ).unbind( 'touchstart' );
			WikiaMobile.moveAd();
		}, 15000 );

		$( document.body ).one( 'touchstart', function() {
			if ( hideOnTimeout ) clearTimeout( hideOnTimeout );
			WikiaMobile.moveAd();
		});
	},

	wrapArticles: function() {
		var wikiaMainContent = $( '#WikiaMainContent' ),
			content = wikiaMainContent.contents(),
			mainContent = '',
			firstH2 = true,
			video = 1;

		//Im using here plain javascript as Zepto.js does not provide me with real contents method
		//I end up creating simple contents method that returns JS Object instead of Zepto ones
		for( var i = 0, l = content.length; i < l; i++ ) {
			var element = content[i];
			if ( element.nodeName === 'H2' ) {
				if ( !firstH2 ) {
					mainContent += '</section>';
				}
				mainContent += element.outerHTML + '<section class="articleSection">';
				firstH2 = false;
			} else if ( element.nodeName === 'OBJECT' ) {
				mainContent += '<a href="'+ element.data +'">Video #'+ video++ +'</a>';
			} else {
				mainContent += (!element.outerHTML)?element.textContent:element.outerHTML;
			}
		};
		mainContent += '</section>';
		wikiaMainContent.html(mainContent);

	},

	init: function() {
		var position;

		//I'm using delegate on document.body as it's been proved to be the fastest option
		//$( document.body ).delegate( '#openToggle', 'click', function() {
		//	$( '#navigation').toggleClass( 'open' );
		//});

		$( document.body ).delegate( '#article-comments-counter-header', 'click', function() {
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

		$( document.body ).delegate( '#WikiaMainContent > h2', 'click', function() {
			$(this).toggleClass('open').next().toggleClass('open');

		});

		$( document.body ).delegate( '#WikiaPage', 'swipeLeft', function() {
			position = pageYOffset;
			$( '#wikiaFooter, #navigation, #WikiaPage' ).css( 'display', 'none' );
			$( '#leftPane' ).css( { 'display': 'block', 'opacity': '1' } );
		});

		$( document.body ).delegate( '#leftPane', 'swipeRight', function() {
			$( '#wikiaFooter, #navigation, #WikiaPage' ).css( 'display', 'block'  );
			window.scrollTo( 0, position );
			position = 1;
			$( '#leftPane' ).css( { 'display': 'none', 'opacity': '0' } );
		});

		$( document.body ).delegate( '.thumb', 'click', function(event) {
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

		$(document.body).delegate('#searchToggle', 'click', function(event) {
			$('#navigationWordMark').hide();
			$('#navigationSearch').show().addClass('open');
			$(this).addClass('open');
		});
	}
}

$(function() {
	WikiaMobile.hideURLBar();
	WikiaMobile.wrapArticles();
	WikiaMobile.getAllImages();
	//WikiaMobile.handleAds();
	WikiaMobile.init();
});