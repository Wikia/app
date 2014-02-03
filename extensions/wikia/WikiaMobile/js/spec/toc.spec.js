/*global describe, it, runs, waitsFor, expect, require, document*/
describe( "toc module", function () {
	'use strict';

	var sections = {
			current: function(){
				return [];
			}
		},
		window = {
			document: {
				body: getBody( "<div id=wkTOC class=side-menu><header>TOC</header><img id=wkTOCHandle src=''></div>" )
			},
			Features: {
				positionfixed: true,
				overflow: true
			}
		},
		jQueryObject = {
			on: function (event, func) {
				if ( event == 'click' && typeof func == 'function' ) {
					var event = {
						stopPropagation: function(){}
					};



					func(event);
				}

				return jQueryObject;
			},
			hide: function () {

			},
			append: function( html ){
				window.document.body.innerHTML += html;

				return jQueryObject;
			},
			find: function(){
				return jQueryObject;
			},
			hasClass: function(){},
			removeClass: function(){},
			addClass: function(){}
		},
		jQuery = function ( selector ) {
			jQueryObject.selector = selector;
			return jQueryObject;
		},
		mustache = {
			render: function(){
				return 'TEMPLATE';
			}
		},
		wikiaToc = {
			getData: function () {
				return {
					sections: [ {
						firstLevel: true,
						id: "Biography",
						level: 1,
						name: "Biography",
						sections: [ {
							firstLevel: false,
							id: "Season_One",
							level: 2,
							name: "Season One",
							sections: [ {
								firstLevel: false,
								id: "Pilot",
								level: 3,
								name: "Pilot",
								sections: []
							} ]
						} ]
					} ]
				};
			}
		},
		track = {
			event: function(){}
		};

	jQuery.event = {
		trigger: function(){}
	};

	it( 'should init itself', function () {

		spyOn( jQueryObject, 'on' ).andCallThrough();

		modules['require,sections,wikia.window,jquery,wikia.mustache,wikia.toc,track']( sections, window, jQuery, mustache, wikiaToc, track );

		expect( jQueryObject.on.calls.length ).toEqual( 5 );
		expect( jQueryObject.on.calls[0].args[0] ).toEqual( 'curtain:hidden' );
		expect( jQueryObject.on.calls[0].args[1] ).toEqual( jasmine.any( Function ) );

		expect( jQueryObject.on.calls[1].args[0] ).toEqual( 'click' );
		expect( jQueryObject.on.calls[1].args[1] ).toEqual( jasmine.any( Function ) );
	} );

	it( 'should add itself to DOM on open', function () {
		var tocHandle = window.document.body.querySelector( '#wkTOCHandle' );

		expect(window.document.body.innerHTML.indexOf('TEMPLATE') ).toEqual(-1)

		fireEvent( 'click', tocHandle );

		expect(window.document.body.innerHTML.indexOf('TEMPLATE') ).not.toEqual(-1)
	} );
} );
