/*global describe, it, runs, waitsFor, expect, require, document*/
describe( "toc module", function () {
	'use strict';

	var sections = {
			current: function(){
				return [];
			},
			list: function(){
				return [];
			}
		},
		window = {
			document: {
				body: getBody( "<div id=wkTOC class=side-menu><header>TOCHEADER</header><img id=wkTOCHandle src=''></div>" ),
				getElementById: function(id){
					return window.document.body.querySelector( '#' + id );
				}
			},
			Features: {
				positionfixed: true,
				overflow: true
			}
		},
		mustache = {
			render: function(){
				return '<ol class="toc-list level"><li class="has-children first-children"><a href="#Biography">Biography<span class="chevron right"></span></a><ol class="toc-list level1"><li class="has-children"><a href="#Season_One">Season One</a><ol class="toc-list level2"><li><a href="#Pilot">Pilot</a></li></ol></ol></ol>';
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

	it( 'should init itself', function () {

		spyOn( jQuery.fn, 'on' ).andCallThrough();

		modules['require,sections,wikia.window,jquery,wikia.mustache,wikia.toc,track']( sections, window, jQuery, mustache, wikiaToc, track );

		expect( jQuery.fn.on.calls.length ).toEqual( 2 );
		expect( jQuery.fn.on.calls[0].args[0] ).toEqual( 'curtain:hidden' );
		expect( jQuery.fn.on.calls[0].args[1] ).toEqual( jasmine.any( Function ) );

		expect( jQuery.fn.on.calls[1].args[0] ).toEqual( 'click' );
		expect( jQuery.fn.on.calls[1].args[1] ).toEqual( jasmine.any( Function ) );
	} );

	it( 'should add itself to DOM and add active class on open', function () {
		var tocHandle = window.document.getElementById( 'wkTOCHandle' );

		expect(window.document.body.innerHTML.indexOf('<ol class="toc-list level">') ).toEqual(-1);

		$( tocHandle ).trigger( 'click' );

		expect( window.document.getElementById( 'wkTOC' ).className ).toContain('active');
		expect( window.document.body.innerHTML.indexOf('<ol class="toc-list level">') ).not.toEqual(-1);
	} );

	it( 'should remove active class on close', function(){
		var tocHandle = window.document.getElementById( 'wkTOCHandle' ),
			toc = window.document.getElementById( 'wkTOC' );

		expect( toc.className ).toContain( 'active' );

		$( tocHandle ).trigger( 'click' );

		expect( toc.className ).not.toContain( 'active' );
	} );

	it( 'should track events', function(){
		var tocHandle = window.document.getElementById( 'wkTOCHandle' ),
			toc = window.document.getElementById( 'wkTOC' );

		spyOn( track, 'event' );

		$( tocHandle ).trigger( 'click' );
		$( tocHandle ).trigger( 'click' );

		expect( track.event ).toHaveBeenCalledWith( 'newtoc', undefined, { label : 'open' }  );
		expect( track.event ).toHaveBeenCalledWith(  'newtoc', undefined, { label : 'close' } );
	} );

	it( 'should mark current active section', function(){
		var tocHandle = window.document.getElementById( 'wkTOCHandle' ),
			$toc = $( window.document.getElementById( 'wkTOC' ) ),
			$current;

		$( tocHandle ).trigger( 'click' );

		$current = $toc.find('.current' );
		expect( $current.length ).toEqual( 0 );

		$( window.document ).trigger( 'section:changed', {
			id: 'Biography'
		} );

		$current = $toc.find('.current' );
		expect( $current.length ).toEqual( 1 );
		expect( $current.eq( 0 ).html()  ).toContain( 'Biography' );

		$( window.document ).trigger( 'section:changed', {
			id: 'Season_One'
		} );

		$current = $toc.find('.current' );
		expect( $current.length ).toEqual( 2 );
		expect( $current.eq( 0 ).html()  ).toContain( 'Biography' );
		expect( $current.eq( 1 ).html()  ).toEqual( 'Season One' );

		$( window.document ).trigger( 'section:changed', {
			id: 'Pilot'
		} );

		$current = $toc.find('.current' );
		expect( $current.length ).toEqual( 2 );
		expect( $current.eq( 0 ).html()  ).toContain( 'Biography' );
		expect( $current.eq( 1 ).html()  ).toEqual( 'Pilot' );

		$( window.document ).trigger( 'section:changed', {
			id: 'Biography'
		} );

		$current = $toc.find('.current' );
		expect( $current.length ).toEqual( 1 );
		expect( $current.eq( 0 ).html()  ).toContain( 'Biography' );
	} );
} );
