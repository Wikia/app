/*
 * @define sections
 * module used to handle sections on wikiamobile
 *
 * @author Jakub Olek
 */

define( 'sections', ['jquery', 'wikia.window'], function ( $, window ) {
	'use strict';

	var d = window.document,
		h2s = $( 'h2[id]', d.getElementById( 'wkPage' ) ).toArray(),
		sections = getHeaders(),
		l = sections.length,
		lastSection,
		escapeRegExp = /[()\.\+]/g,
		offset = 5;

	/**
	 * @desc grab all headers on the page
	 * @return Array
	 */
	function getHeaders(){
		//querySelectorAll returns NodeList but this one is not live
		return Array.prototype.slice.apply( d.querySelectorAll( 'h2[id],h3[id],h4[id]' ) )
	}

	/**
	 * @desc Function that lets you scroll viewport to a given section
	 * @param header - a string representation of a header
	 * @returns {undefined|true} - status code if scroll actually happened
	 */
	function scrollTo ( header ) {
		//() . and + have to be escaped before passed to querySelector
		var h = document.querySelector( header.replace( escapeRegExp, '\\$&' ) ),
			ret;

		if ( h ) {
			window.scrollTo( 0, $(h).offset().top - offset + 1);
			ret = true;
		}

		return ret;
	}

	/**
	 * @desc Finds and returns a current section
	 * @returns jQuery object - a current section
	 */
	function current () {
		var top = window.scrollY,
			i = 0,
			l = sections.length;

		for ( ; i < l; i++ ) {
			if ( sections[i].offsetTop - offset > top ) {
				break;
			}
		}

		return $( sections[i - 1] );
	}

	lastSection = current();

	/**
	 * @desc Check if intro is longer than 700px
	 * @param sectionNumber - number of section to measure
	 * @param minHeight - height of intro to compare against
	 * @returns boolean
	 */
	function isSectionLongerThan ( sectionNumber, minHeight ) {
		var currentSection,
			nextSection,
			topOffset,
			referenceOffset = null;

		currentSection = h2s[sectionNumber - 1];
		nextSection = h2s[sectionNumber];

		if ( !nextSection ) {
			if ( currentSection ){
				var $wkPage = $( '#wkPage' );
				referenceOffset = $wkPage.offset().top + $wkPage.height();
				topOffset = $( currentSection ).offset().top;
			} else {
				return false;
			}
		} else {
			topOffset = ( sectionNumber ) ? $( currentSection ).offset().top : $( '#mw-content-text' ).offset().top;
			referenceOffset = $( nextSection ).offset().top;
		}

		return ( referenceOffset - topOffset > minHeight );
	}

	/**
	 * @desc If possible, get section under which the ad can be placed (700px down)
	 * @param distFromTop - an int value representing given height in document
	 * @returns jQuery object or null
	 */
	function getElementAt ( distFromTop ) {
		var currentElement = $( '#mw-content-text' ).children().first(),
			currentOffset = currentElement.outerHeight();

		while ( currentElement.next().length !== 0 && currentOffset < distFromTop ) {
			currentElement = currentElement.next();
			currentOffset += currentElement.outerHeight();
		}

		return currentElement;
	}

		/**
	 * @desc Function that fires at most every 200ms while scrolling\
	 * @triggers section:changed with a current section refernece and its id
	 */
	function onScroll () {
		var currentSection = current();
		// this is not needed to be fired on every scroll event
		window.removeEventListener( 'scroll', onScroll );

		if ( currentSection && !currentSection.is( lastSection ) ) {
			$( d ).trigger( 'section:changed', {
				section: currentSection,
				id: currentSection.length ? currentSection[0].id : undefined
			} );

			lastSection = currentSection;
		}

		window.setTimeout( function () {
			window.addEventListener( 'scroll', onScroll );
		}, 200 );
	}

	window.addEventListener( 'scroll', onScroll );

	return {
		list: function(){
			//make sure we're grabbing the latest version
			return sections = getHeaders();
		},
		isSectionLongerThan: isSectionLongerThan,
		getElementAt: getElementAt,
		scrollTo: scrollTo,
		current: current
	};
} );
