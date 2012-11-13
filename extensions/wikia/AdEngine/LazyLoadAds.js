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
	var ad, funcName,
		fold = $window.height() + $window.scrollTop() + this.settings.onScroll.threshold,
		i = 0;

	for ( ; i < this.adsLength; i++ ) {
		ad = this.ads[ i ];

		if ( $( ad ).offset().top <= fold ) {
			funcName = ad.nodeName == 'IFRAME'
				? 'fillIframe_' + ad.id.replace( '_iframe', '' ) : 'fillElem_' + ad.id;

			if ( typeof window[ funcName ] != 'undefined' ) {
				window[ funcName ]();
			}

			// Remove this item
			this.ads.splice( i, 1 );
			this.adsLength--;
		}
	}

	// Unbind scroll when there are no items left to load
	if ( !this.adsLength ) {
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
