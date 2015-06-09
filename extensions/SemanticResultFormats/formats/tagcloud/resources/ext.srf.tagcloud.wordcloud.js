/**
 * JavaScript for SRF wordcloud widget based on d3 and d3.layout.cloud.js
 * @see http://www.semantic-mediawiki.org/wiki/Help:Tagcloud format
 *
 * @since 1.8
 * @release 0.3
 *
 * @file
 * @ingroup SemanticResultFormats
 *
 * @licence GNU GPL v2 or later
 * @author mwjames
 */
( function( $, mw, srf ) {
	'use strict';

	/*global d3:true*/
	////////////////////////// PRIVATE METHODS ////////////////////////

	var util = new srf.util();

	var wordcloud = {
		init: function () {
			$(document).ready(function() {
				if( $.isFunction( $.fn.eachAsync ) ){
						$( '.srf-tagcloud-wordcloud' ).eachAsync( {
						delay: 100,
						bulk: 0,
						loop: function(){
							wordcloud.output( $( this ) );
						}
					} );
				} else {
					$( '.srf-tagcloud-wordcloud' ).each( function() {
						wordcloud.output( $( this ) );
					} );
				}
			} );
		},
		output: function ( $this ) {
			var container = $this.find( ".container" ),
				containerID = container.attr( "id" ),
				width       = container.data( "width" ),
				height      = container.data( "height" ),
				target      = container.data( "target" ),
				textFont    = container.data( "font" ).split(',');

			// Hide and re-assign elements
			util.spinner.hide( { context: $this } );
			$this.css( { 'width': width, 'height': height } );

			// Build array of tags, fetch size, and href property
			var arr = [];
			container.find( 'li' ).each( function(){
				arr.push( [ $(this).text(), $(this).css( 'font-size' ), $(this).find( 'a' ).attr( "href" ) ] );
			} );

			// Init colour array
			var fill = d3.scale.category20b();

			// Build word cloud
			// ~~ (bitwise not) is used instead of Math.floor because it is twice as fast as floor
			// "end", fired when all words have been placed
			var cloud = d3.layout.cloud().size( [ width - 5, height - 5 ] )
				.words( arr.map( function( d ) {
				return { text: d[0], size: parseInt( d[1], 10 ), href: d[2] };
				} ) )
				.rotate( function() { return ~~( Math.random() * 2 ) * 90; } )
				.fontSize( function(d) { return d.size; } )
				.font( textFont[ ~~( Math.random() * textFont.length ) ] )
				.on( "end", draw );

			// Init cloud
			cloud.start();

			// Set properties
			function draw( words ) {
				d3.select( "#" + containerID ).append( "svg" )
				.attr( "width", width - 5 )
				.attr( "height", height - 5 )
				.append( "g" )
				.attr( "transform", "translate(" + width / 2 + "," + height / 2 + ")" )
				.selectAll( "text"  )
				.data( words )
				.enter().append( "text" )
				.style( "fill", function( d ) { return fill(d.text.toLowerCase() ); } )
				.style( "font-size", function(d) { return d.size + "px"; } )
				.attr( "text-anchor", "middle" )
				.attr( "transform", function( d ) {
					return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
				} )
				.append( "svg:a" )
				.style( "text-decoration", function( d ) { return typeof d.href === 'undefined' ? 'none' : 'inherent'; } )
				.attr( "font-family",  function(d) { return d.font; } )
				.attr( "target", target === 'blank' ? "_blank" : '' )
				.attr( 'xlink:href', function( d ) { return d.href !== '' ? d.href : ''; } )
				.text( function(d) { return d.text; } );
			}
		}
	};

	wordcloud.init();
} )( jQuery, mediaWiki, semanticFormats );