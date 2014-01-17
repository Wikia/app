(function(){
	'use strict';
	var group = window.Wikia.AbTest ? Wikia.AbTest.getGroup( 'OPTIMIZELY' ) : null;
	if (group === 'ENABLED') {
		document.write('<script src="//cdn.optimizely.com/js/554924358.js"></script>');
	}
})();
