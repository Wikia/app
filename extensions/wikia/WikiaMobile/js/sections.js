/*
 * @define sections
 * module used to handle sections on wikiamobile
 *
 * @author Jakub Olek
 */

define( 'sections', ['jquery', 'wikia.window'], function ( $, window ) {
	'use strict';

	var d = window.document,
		$wkPage = $( '#wkPage' ),
		h2s = $( 'h2[id]', $wkPage ).toArray(),
		sections = [],
		lastSection,
		escapeRegExp = /[()\.\+]/g,
		offset = 5;

	/**
	 * @desc grab all headers (with non-empty id's) on the page
	 * @return Array
	 */
	function getHeaders(){
		//we switch nodeList to Array to use filter / forEach type methods
		return Array.prototype.slice.apply( d.querySelectorAll(
			'h2[id]:not( [id=""] ), h3[id]:not( [id=""] ), h4[id]:not( [id=""] )' ) );
	}

	sections = getHeaders();

	/**
	 * @desc Function that lets you scroll viewport to a given section
	 * @param {String} header
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
	 * @returns {Object} - a current section
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
	 * @param {Number} section - number of section or header element to measure
	 * @param {Number} minHeight - height of intro to compare against
	 * @returns {Boolean}
	 */
	function isSectionLongerThan ( section, minHeight ) {
		var currentSection,
			nextSection,
			topOffset,
			referenceOffset = null;

		if ( typeof section === 'number' ) {
			currentSection = h2s[section - 1];
			nextSection = h2s[section];
		} else {
			currentSection = section;
			nextSection = h2s[ getId( section ) + 1 ];
		}

		if ( !nextSection ) {
			if ( currentSection ){
				referenceOffset = $wkPage.offset().top + $wkPage.height();
				topOffset = $( currentSection ).offset().top;
			} else {
				return false;
			}
		} else {
			topOffset = section ? $( currentSection ).offset().top : $( '#mw-content-text' ).offset().top;
			referenceOffset = $( nextSection ).offset().top;
		}

		return ( referenceOffset - topOffset > minHeight );
	}

	/**
	 * @desc If possible, get section at given distance from top
	 * @param {Number} distFromTop - an int value representing given height in document
	 * @returns {Object|null}
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
	 * @desc Function that fires at most every 200ms while scrolling
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

	/**
	 * @desc Gets an index of the given H2 headline
	 * @param {Object} section
	 * @returns {Number}
	 */
	function getId ( section ) {
		return h2s.indexOf( section );
	}

	/**
	 * @desc Gets next H2 in an article
	 * @param {Object|Number} section - headline or number representing it's index
	 * @returns {Object}
	 */
	function getNext ( section ) {
		section = typeof section === 'number' ? section : getId( section );

		return h2s[section + 1];
	}

	/**
	 * @desc Checks if the given article Section (only H2-leveled sections) exists
	 * @param {Number} number of the article's section getting checked
	 * @returns {Boolean}
	 */
	function isDefined ( section ) {
		//first h2 has index 0 in the nodeList
		var headline = h2s[section-1];
		return !!headline && headline.parentElement === d.getElementById( 'mw-content-text' );
	}

	window.addEventListener( 'scroll', onScroll );

	return {
		list: function () {
			//make sure we're grabbing the latest version
			sections = getHeaders();
			return sections;
		},
		isSectionLongerThan: isSectionLongerThan,
		getElementAt: getElementAt,
		getId: getId,
		getNext: getNext,
		isDefined: isDefined,
		scrollTo: scrollTo,
		current: current
	};
} );
