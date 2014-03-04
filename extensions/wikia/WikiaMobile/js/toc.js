/* globals Features:true */
//init toc
require( [ 'sections', 'wikia.window', 'jquery', 'wikia.mustache', 'wikia.toc', 'track' ],
function ( sections, window, $, mustache, toc, track ) {
	'use strict';

	//private
	var open = 'open',
		active = 'active',
		doc = window.document,
		$document = $( doc ),
		$anchors,
		sideMenuCapable = ( window.Features.positionfixed && window.Features.overflow ),
		inited,
		$toc = $( doc.getElementById( 'wkTOC' ) ),
		$tocHandle = $( doc.getElementById( 'wkTOCHandle' ) ),
		tocScroll,
		inPageToc,
		tocMarkup,
		headers = sections.list(),
		show = headers.length > 0;

	/**
	 * @desc Creates object representing a section
	 *
	 * @param {Object} header - Processed element object for single article header
	 * @param {Integer} level - The actual level on which the element will be rendered
	 *
	 * @returns {Object} - returns TOC section object
	 */
	function createSection ( header, level ) {
		return {
			id: header.id,
			name: header.innerText.trim(),
			level: level,
			firstLevel: level === 1,
			sections: []
		};
	}

	/**
	 * @desc Filters headers with nothing to show
	 *
	 * @param {Object} header - DOM element of header
	 *
	 * @returns {Object} or {Boolean} false if filtered
	 */
	function filter ( header ) {
		return !header.innerText.trim() ? false : header;
	}

	/**
	 * @desc Renders toc for a given page
	 * @returns HTML String
	 */
	function createTocMarkup () {
		var ol = '<ol class="toc-list level{{level}}">{{#sections}}{{> lis}}{{/sections}}</ol>',
			lis = '{{#.}}<li{{#sections.length}} class="has-children{{#firstLevel}}' +
				' first-children{{/firstLevel}}"{{/sections.length}}>' +
				'<a href="#{{id}}">{{name}}{{#firstLevel}}{{#sections.length}}<span class="chevron right"></span>' +
				'{{/sections.length}}{{/firstLevel}}</a>' +
				'{{#sections.length}}{{> ol}}{{/sections.length}}</li>{{/.}}',
			wrap = '<div id="tocWrapper"><div id="scroller">{{> ol}}</div></div>',
			tocData = toc.getData(
				headers,
				createSection,
				filter
			);
		if ( tocData.sections.length ) {
			return mustache.render( wrap, tocData, {
				ol: ol,
				lis: lis
			} );
		} else {
			return '';
		}
	}

	/**
	 * @desc Handles opening and closing sections
	 *
	 * @param $li jQuery object for a sections
	 * @param force whether to force a toggle
	 */
	function toggleLi ( $li, force ) {
		var isTogglable = $li.is( '.first-children' );

		if ( isTogglable ) {
			$li.toggleClass( open, force ).siblings().removeClass( open );

			tocScroll.refresh();
			tocScroll.scrollToElement( $li[0] );
		}

		return isTogglable;
	}

	/**
	 *
	 * @desc Function that is fired on every section changed so we can highlight it in TOC
	 *
	 * @param event Event
	 * @param data Data passed from sections evetn
	 * @param scrollTo weather to scroll to the element used to force it on TOC open
	 * @param time time in which to scroll to an element
	 */
	function onSectionChange ( event, data, scrollTo, time ) {
		$anchors.removeClass( 'current' );

		if ( data && data.id ) {
			var $current = $anchors
					.filter( 'a[href="#' + data.id + '"]' )
					.addClass( 'current' ),
				$currentLi = $current
					.parents( 'li' )
					.last();

			$currentLi
				.find( 'a' )
				.first()
				.addClass( 'current' );

			if ( scrollTo ) {
				toggleLi( $currentLi, true );
				tocScroll.scrollToElement( $current[0], time );
			}
		}
	}

	function renderToc () {
		$toc.find( '#tocWrapper' ).remove();

		$anchors = $toc
			.append( createTocMarkup() )
			.find( 'li > a' );

		var wrapper = doc.getElementById( 'tocWrapper' );

		if ( wrapper ) {
			tocScroll = new window.IScroll( wrapper, {
				click: true,
				scrollY: true,
				scrollX: false
			});
		}
	}

	/**
	 * @desc Handles appending the toc to a side menu
	 */
	function init () {
		if ( !inited ) {
			$toc.on( 'click', 'header', function () {
				onClose( 'header' );
				window.scrollTo( 0, 0 );
			} )
			.on( 'click', 'li', function ( event ) {
				var $li = $( this ),
					$a = $li.find( 'a' ).first();

				event.stopPropagation();
				event.preventDefault();

				if ( !toggleLi( $li ) ) {
					onClose( 'element' );
				}

				sections.scrollTo( $a.attr( 'href' ) );
			} );

			renderToc();

			inited = true;
		}
	}

	/**
	 * @desc Used in fallback mode
	 */
	function onTap (){
		inPageToc.scrollIntoView();

		track.event( 'newtoc', track.CLICK, {
			label: 'scroll'
		} );
	}

	/**
	 * @desc Fires on opening of a Side menu toc
	 */
	function onOpen () {
		$toc.addClass( active );
		$document.on( 'section:changed', onSectionChange );
		$.event.trigger( 'curtain:show' );

		init();

		onSectionChange( null, sections.current()[0], true );

		track.event( 'newtoc', track.CLICK, {
			label: 'open'
		} );
	}

	/**
	 * @desc Fires on closing of a Side menu toc
	 */
	function onClose ( event ) {
		if ( $toc.hasClass( active ) ) {
			$toc.removeClass( active );
			$document.off( 'section:changed', onSectionChange );

			track.event( 'newtoc', track.CLICK, {
				label: (typeof event === 'string' ? event : 'close')
			} );
		}

		$.event.trigger( 'curtain:hide' );
	}

	$document.on( 'curtain:hidden', onClose );

	if ( !sideMenuCapable ) {
		tocMarkup = createTocMarkup();

		if ( tocMarkup ) {
			$document.find( '#mw-content-text' )
				.append(
					'<div class="in-page-toc"><h2>' + $toc.find( 'header' ).text() + '</h2>' + tocMarkup + '</div>'
				).find('.level');

			inPageToc = doc.getElementsByClassName('in-page-toc')[0];
		} else {
			$tocHandle.hide();
		}
	}

	$tocHandle.on( 'click', function ( event ) {
		event.stopPropagation();

		if ( sideMenuCapable ) {
			if ( $toc.hasClass( active ) ) {
				onClose();
			} else {
				onOpen();
			}
		} else {
			onTap();
		}

		return {
			show: show
		}
	} );
} );
