require([
	'ext.wikia.adEngine.adEngine',
	'ext.wikia.adEngine.adConfigMobile'
], function(adEngine, adConfigMobile){
	'use strict';

	//I need a copy of Wikia.ads.slots as .run destroys it
	adEngine.run( adConfigMobile, $.extend([], Wikia.ads.slots), 'queue.mobile' );
});
