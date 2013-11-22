describe( 'Modal module', function() {
	'use strict';

	var browserDetect = {},
		modal = modules[ 'wikia.ui.modal' ]( jQuery, window, browserDetect );

	it( 'registers AMD module', function() {
		expect( modal ).toBeDefined();
		expect( typeof modal ).toBe( 'object' );
	});

});

describe( 'Modal events', function() {
	'use strict';

	var browserDetect = {},
		modal = null;

	beforeEach( function() {
		modal = modules[ 'wikia.ui.modal' ]( jQuery, window, browserDetect );
	});

});
