(function( window, $ ) {

var $window = $( window ),
	scroll = 'scroll.LazyLoadAds',
	Wikia = window.Wikia || {};

var LazyLoadAds = function( settings ) {
	settings = $.extend( {}, LazyLoadAds.settings, settings );

	this.ads = $( settings.selector ).get();
	this.adsLength = this.ads.length;
	this.settings = settings;

	if ( settings.onScroll ) {

		// TODO: throttle this better?
		$window.on( scroll, $.throttle( 100, $.proxy( this.onScroll, this ) ) ).trigger( scroll );
	}
};

LazyLoadAds.prototype.onScroll = function() {
	var ad, func, funcName,
		fold = $window.height() + $window.scrollTop() + this.settings.onScroll.threshold,
		spc = window.OpenXSPC,
		i = 0;

	// See: /extensions/AdEngine/AdProviderOpenX.php
	if ( spc && this.adsLength ) {
		for ( ; i < this.adsLength; i++ ) {
			ad = this.ads[ i ];

			if ( $( ad ).offset().top <= fold ) {
				funcName = ad.nodeName == 'IFRAME'
					? 'fillIframe_' + ad.id.replace( '_iframe', '' ) : 'fillElem_' + ad.id;

				// Call OpenXSPC callback function
				if ( $.isFunction( func = spc[ funcName ] ) ) {
					func();
				}

				// Remove this item
				this.ads.splice( i, 1 );
				this.adsLength--;
			}
		}
	}

	// Unbind scroll when there are no items left to load
	if ( !spc || !this.adsLength ) {
		$window.off( scroll );
	}
};

LazyLoadAds.settings = {
	onScroll: {
		threshold: 200
	},
	selector: '.LazyLoadAd'
};

// Exports
Wikia.LazyLoadAds = LazyLoadAds;
window.Wikia = Wikia;

})( window, jQuery );
