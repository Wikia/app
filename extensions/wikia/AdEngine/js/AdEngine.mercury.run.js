require([
	'ext.wikia.adEngine.adEngine',
	'ext.wikia.adEngine.adContext',
	'ext.wikia.adEngine.adConfigMobile'
], function(adEngine, adContext, adConfigMobile){
	'use strict';
	if (Wikia && Wikia.article && Wikia.article.adsContext) {
		// Set the article context if available.
		adContext.setContext(Wikia.article.adsContext);
	}
	//I need a copy of Wikia.ads.slots as .run destroys it
	adEngine.run( adConfigMobile, $.extend([], Wikia.ads.slots), 'queue.mobile' );
});
