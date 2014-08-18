require([
	'ext.wikia.adEngine.adEngine',
	'ext.wikia.adEngine.adConfigMobile'
], function(adEngine, adConfigMobile){
	"use strict";

	adEngine.run( adConfigMobile, Wikia.ads.slots, 'queue.mobile' );
});
