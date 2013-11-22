describe( 'UIModal', function() {
	'use strict';

	var browserDetect = {},
		modal = modules[ 'wikia.ui.modal' ]( jQuery, window, browserDetect );

	it( 'registers AMD module', function() {
		expect( modal ).toBeDefined();
		expect( typeof modal ).toBe( 'object' );
	});

});
