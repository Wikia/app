describe( 'Modal module', function() {
	'use strict';

	var browserDetect = {},
		modal = modules[ 'wikia.ui.modal' ]( jQuery, window, browserDetect );

	it( 'registers AMD module', function() {
		expect( modal ).toBeDefined();
		expect( typeof modal ).toBe( 'object' );
	} );

});

describe( 'Modal events', function() {
	'use strict';

	var browserDetect = {},
		module = modules[ 'wikia.ui.modal' ]( jQuery, window, browserDetect),
		modal = null;

	beforeEach( function() {
		modal = module.init( 'test' );
	} );

	it( 'triggers the event listener exactly once', function() {
		var listeners = {
			onFoo : function () { }
		};
		spyOn( listeners, 'onFoo' );

		modal.bind( 'foo', listeners.onFoo );
		modal.trigger( 'foo' );

		expect( listeners.onFoo ).toHaveBeenCalled();
		expect( listeners.onFoo.calls.length ).toEqual( 1 );
	} );

	it( 'triggers the proper event listener', function() {
		var listeners = {
			onFoo : function () { },
			onBar : function () { },
		};
		spyOn( listeners, 'onFoo' );
		spyOn( listeners, 'onBar' );

		modal.bind( 'foo', listeners.onFoo );
		modal.bind( 'bar', listeners.onBar );
		modal.trigger( 'foo' );
		modal.trigger( 'foo' );

		expect( listeners.onFoo ).toHaveBeenCalled();
		expect( listeners.onFoo.calls.length ).toEqual( 2 );
		expect( listeners.onBar ).not.toHaveBeenCalled();
	} );

});
