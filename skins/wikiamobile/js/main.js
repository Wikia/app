var WikiaMobile = {
	hideURLBar: function() {
		if ( $.os.android || $.os.ios || $.os.webos ) {
				//slide up the addressbar on webkit mobile browsers for maximum reading area
				//setTimeout is necessary to make it work on ios...
				setTimeout( function() { window.scrollTo( 0, 1 ) }, 100 );
		}
	},
	
	wrapArticles: function() {
		var content = $( '#WikiaMainContent' ).contents(),
		mainContent = '',
		firstH2 = true;
		for( var i = 0; i < content.length; i++ ) {
			var element = content[i];
			if ( element.nodeName === 'H2' ) {
				if( firstH2 ) {
					mainContent += element.outerHTML + '<section class=\"articleSection\">';
				} else {
					mainContent += '</section>' + element.outerHTML + '<section class=\"articleSection\">';
				}
				firstH2 = false;
			} else {
				mainContent += (!element.outerHTML)?element.textContent:element.outerHTML;
			}
		};
		mainContent += '</section>';
		document.getElementById('WikiaMainContent').innerHTML = mainContent;

	},

	init: function() {
		$( '#openToggle' ).bind( "tap, click", function() {
			$( '#navigation').toggleClass( 'open' );
		});

		$( '#navigationMenu > li' ).bind( "tap, click", function() {
			if ( !( $( this ).hasClass( 'openMenu' ) ) ) {
				
				$( '#navigationMenu > li' ).removeClass( 'openMenu' );
				$( this ).addClass( 'openMenu' );
				
				tab = "#" + $( this ).text().toLowerCase() + "Tab";
				$( '#openNavigationContent > div.navigationTab' ).removeClass( 'openTab' );
				$( tab ).addClass( 'openTab' );
			}
		});
		
		$( '#toctitle' ).append( '<span class=\"arrow\"></span>' );
		$( '#WikiaMainContent > h2' ).append( '<span class=\"arrow\"></span>' );
		
		$( '#toctitle' ).bind( 'tap, click', function() {
			$( 'table#toc ul' ).toggleClass( 'visible' );
			$( '#toctitle' ).toggleClass( 'open' );
		});
		
		$( '#WikiaMainContent > h2' ).bind( "tap, click", function() {
			$(this).toggleClass('open').next().toggleClass('open');
			
		});
		
		$( '#showAll' ).bind( "tap, click", function() {
			$( '.articleSection' ).toggleClass('open');
		});
	}
}

$( document ).ready( function() {
	WikiaMobile.hideURLBar();
	WikiaMobile.wrapArticles();
	WikiaMobile.init();
});