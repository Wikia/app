/**
 * Javascript handler for the checkboxes input type
 *
 * @author Stephan Gambke
 */

( function ( $, mw ) {

	'use strict';

	// jQuery plugin that will attach a select all/select none switch to all checkboxes in "this" element
	$.fn.appendSelectionSwitches = function () {

		function insertSwitch( switchesWrapper, label, checked  ) {

			// create a link element that will trigger the selection of all checkboxes
			var link = $( '<a href="#">' + label + '</a>' );

			// will be initialized only when the event is triggered to avoid lag during page loading
			var $checkboxes;

			// attach an event handler
			link.click( function ( event ) {

				event.preventDefault();

				// store checkboxes during first method call so the DOM is not searched on every click on the link
				$checkboxes = $checkboxes || switchesWrapper.siblings().find( 'input[type="checkbox"]' );

				$checkboxes.prop( 'checked', checked );
			} );

			// wrap the link into a span to simplify styling
			var switchWrapper = $('<span class="checkboxSwitch">' ).append( link );

			// insert the complete switch into the DOM
			switchesWrapper.append( switchWrapper );

		}

		this.each( function ( index, element ) {

			var switchesWrapper = $( '<span class="checkboxSwitches">' ).prependTo( element );

			insertSwitch( switchesWrapper, mw.message( 'sf_forminputs_checkboxes_select_all' ), true );
			insertSwitch( switchesWrapper, mw.message( 'sf_forminputs_checkboxes_select_none' ), false );

		} );

		return this;
	};

	$().ready( function ( $ ) {
		$( '.checkboxesSpan.select-all' ).appendSelectionSwitches();
	} );

}( jQuery, mediaWiki ) );
