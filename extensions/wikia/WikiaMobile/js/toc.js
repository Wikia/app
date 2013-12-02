/* globals Features:true */
//init toc
require( [ 'sections', 'wikia.window', 'jquery', 'wikia.mustache', 'wikia.toc' ],
function ( sections, window, $, mustache, toc ) {
	'use strict';

	//private
	var open = 'open',
		active = 'active',
		$document = $( window.document ),
		$anchors,
		sideMenuCapable = ( Features.positionfixed && Features.overflow ),
		$ol,
		inited,
		$toc = $( '#wkTOC' ),
		tocScroll,
		inPageToc;

	if ( sideMenuCapable ) {
		$toc.addClass( 'side-menu-capable' );
	}

	/**
	 * @desc Renders toc for a given page
	 * @returns HTML String
	 */
	function renderToc () {
		var ol = '<ol class="toc-list level{{level}}">{{#sections}}{{> lis}}{{/sections}}</ol>',
			lis = '{{#.}}<li{{#sections.length}} class="has-children{{#firstLevel}}' +
				' first-children{{/firstLevel}}"{{/sections.length}}>' +
				'<a href="#{{id}}">{{name}}{{#firstLevel}}{{#sections.length}}<span class="chevron right"></span>' +
				'{{/sections.length}}{{/firstLevel}}</a>' +
				'{{#sections.length}}{{> ol}}{{/sections.length}}</li>{{/.}}',
			wrap = '<div id="tocWrapper"><div id="scroller">{{> ol}}</div></div>',
			tocData = toc.getData(
				sections.list,
				function ( header, level ) {
					return {
						id: header.id,
						name: header.textContent.trim(),
						level: level,
						firstLevel: level === 2,
						sections: []
					};
				}
			);

		return mustache.render( wrap, tocData, {
			ol: ol,
			lis: lis
		} );
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
	 */
	function onSectionChange ( event, data, scrollTo ) {
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
				tocScroll.scrollToElement( $current[0] );
			}
		}
	}

	/**
	 * @desc Handles appending the toc to a side menu
	 */
	function init () {
		if ( !inited ) {
			$toc.on( 'click', 'header', function () {
				onClose();
				window.scrollTo( 0, 0 );
			} )
			.on( 'click', 'li', function ( event ) {
				var $li = $( this ),
					$a = $li.find( 'a' ).first();

				event.stopPropagation();
				event.preventDefault();

				if ( !toggleLi( $li ) ) {
					onClose();
				}

				sections.scrollTo( $a.attr( 'href' ) );
			} );

			$ol = $toc
				.append( renderToc() )
				.find( '.level' );

			$anchors = $ol.find( 'li > a' );

			tocScroll = new window.IScroll('#tocWrapper', {
				click: true,
				scrollY: true,
				scrollX: false
			});

			inited = true;
		}
	}

	/**
	 * @desc Used in fallback mode
	 */
	function onTap (){
		inPageToc.scrollIntoView();
	}

	/**
	 * @desc Fires on opening of a Side menu toc
	 */
	function onOpen () {
		$document.on( 'section:changed', onSectionChange );

		init();

		onSectionChange( null, sections.current()[0], true );
		$.event.trigger( 'curtain:show' );
	}

	/**
	 * @desc Fires on closing of a Side menu toc
	 */
	function onClose () {
		$document.off( 'section:changed', onSectionChange );
		$.event.trigger( 'curtain:hide' );
	}

	$document.on( 'curtain:hidden', function () {
		$toc.removeClass( active );
		onClose();
	} );

	if ( !sideMenuCapable ) {
		$ol = $document.find('#mw-content-text')
			.append( '<div class="in-page-toc"><h2>' + $toc.find( 'header' ).text() + '</h2>' + renderToc() + '</div>' )
			.find('.level');

		inPageToc = document.getElementsByClassName('in-page-toc')[0];
	}

	$( '#wkTOCHandle' ).on( 'click', function ( event ) {
		event.stopPropagation();

		if ( sideMenuCapable ) {
			if ( $toc.toggleClass( active ).hasClass( active ) ) {
				onOpen();
			} else {
				onClose();
			}
		} else {
			onTap();
		}
	} );
} );
