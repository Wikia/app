(function(){
	'use strict';
	if ( window.Wikia.AbTest && Wikia.AbTest.getGroup( 'OPTIMIZELY' ) === 'ENABLED' ) {
		document.write('<script src="//cdn.optimizely.com/js/554924358.js" async></script>');
	}
})();
