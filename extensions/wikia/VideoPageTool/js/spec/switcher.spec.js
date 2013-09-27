/*global describe, it, runs, waitsFor, expect, require, document*/
describe('Form box switcher', function () {
	'use strict';

	var box = '<div class="form-box"><button class="nav-up"></button><button class="nav-down"></button></div>',
		count = 3,
		$elem,
		switcher,
		i,
		callbackInt = 0;

	// Build and reset DOM elements to test
	function buildDOM() {
		$elem = $( '<div></div>' );
		callbackInt = 0;

		for( i = 1; i <= count; i++ ) {
			$elem.append( $( box ).attr( 'id', 'box' + i ) );
		}

		$elem.switcher({
			onChange: function(){
				callbackInt = 1;
			}
		});

		switcher = $elem.data( 'switcher' );
	}

	buildDOM();

	it( 'is set', function() {
		expect( typeof switcher ).toBe( 'object' );
	});

	it( 'can set boxes', function() {
		switcher.setBoxes();

		expect( switcher.$boxes.length ).toBe( count );
	});

	it( 'disables the top most arrow', function() {
		var $topMostArrow = $elem.find( '.form-box' ).first().find( '.nav-up' );

		expect( $topMostArrow.attr( 'disabled' ) ).toBe( 'disabled' );
	});

	it( 'Disables the bottom most arrow', function() {
		var $bottomMostArrow = $elem.find( '.form-box' ).last().find( '.nav-down' );

		expect( $bottomMostArrow.attr( 'disabled' ) ).toBe( 'disabled' );
	});

	it( 'disables only two arrows', function() {
		expect( $elem.find( ':disabled' ).length ).toBe( 2 );
	});


	it( 'switches down', function() {
		buildDOM();

		$elem.find( '.form-box' ).first().find( '.nav-down' ).click();

		expect( $elem.find( '#box1' ).index() ).toBe( 1 );
		expect( $elem.find( '#box2' ).index() ).toBe( 0 );
		expect( $elem.find( '#box3' ).index() ).toBe( 2 );
		expect( callbackInt ).toBe( 1 );

	});

	it( 'switches up', function() {
		buildDOM();

		$elem.find( '.form-box' ).last().find( '.nav-up' ).click();

		expect( $elem.find( '#box1' ).index() ).toBe( 0 );
		expect( $elem.find( '#box2' ).index() ).toBe( 2 );
		expect( $elem.find( '#box3' ).index() ).toBe( 1 );
		expect( callbackInt ).toBe( 1 );

	});

});