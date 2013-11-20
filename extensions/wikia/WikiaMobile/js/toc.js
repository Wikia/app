/* globals Features:true */
//init toc
require( ['sections', 'wikia.window', 'jquery', 'wikia.mustache', 'wikia.toc', 'JSMessages'],
function ( sections, window, $, mustache, toc, msg ) {
	'use strict';

	//private
	var bottom = 'bottom',
		fixed = 'fixed',
		disabled = 'disabled',
		open = 'open',
		active = 'active',
		$document = $( window.document ),
		$anchors,
		$openOl,
		timeout,
		state,
		$parent,
		sideMenuCapable = (Features.positionfixed && Features.overflow),
		$ol,
		inited,
		lineHeight = 45,
		$toc = $( '#wkTOC' ),
		tocScroll;

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

		return '<div id="tocWrapper"><div id="scroller">' + mustache.render( ol, tocData, {
			ol: ol,
			lis: lis
		} ) + '</div></div>';
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
			$li.siblings().removeClass( fixed + ' ' + bottom + ' ' + open );

			if ( $li.toggleClass( open, force ).hasClass( open ) ) {
				$openOl = $li.find( 'ol' ).first();
				$parent = $openOl.parent();

				//handleFixingLiElement();
			} else {
				state = null;
				$li.removeClass( fixed + ' ' + bottom );

				$openOl = null;
			}

			tocScroll.refresh();
			tocScroll.scrollToElement( $li[0] );
		}

		return isTogglable;
	}

	/**
	 * @desc Handles fixing and unfixing a section header in TOC
	 * Fires on every scroll of a main ol of TOC
	 */
	function handleFixingLiElement () {
		if ( !timeout && $openOl ) {
			timeout = setTimeout( function () {
				var scrollTop = $ol.scrollTop() + ( lineHeight * 2 ),
					//when at the bottom I need to compensate for the fact it is getting position absolute
					offsetTop = $openOl[0].offsetTop + (state === bottom ? lineHeight : 0);

				//scroll is above current open section
				if ( state !== disabled && scrollTop < offsetTop ) {
					state = disabled;
					$parent.removeClass( fixed );
				} else if ( scrollTop >= offsetTop ) {
					//scroll is on current open section
					if ( offsetTop + $openOl.height() - scrollTop >= 0 ) {
						if ( state !== fixed ) {
							state = fixed;
							$parent.removeClass( bottom ).addClass( fixed );
						}
					//scroll is under current open section
					} else if ( state !== bottom ) {
						state = bottom;
						$parent.addClass( bottom );
					}
				}

				timeout = null;
			}, 75 );
		}
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

			window.lol = tocScroll;

			inited = true;
		}
	}

	/**
	 * @desc Used in fallback mode
	 */
	function onTap(){
		$ol[0].scrollIntoView();
	}

	/**
	 * @desc Fires on opening of a Side menu toc
	 */
	function onOpen () {
		$document.on( 'section:changed', onSectionChange );

		init();

		onSectionChange( null, sections.current()[0], true );
		$.event.trigger( 'curtain:show' );
		$.event.trigger( 'ads:unfix' );
	}

	/**
	 * @desc Fires on closing of a Side menu toc
	 */
	function onClose () {
		$document.off( 'section:changed', onSectionChange );
		$.event.trigger( 'curtain:hide' );
		$.event.trigger( 'ads:fix' );
	}


	$document.on( 'curtain:hidden', function () {
		$toc.removeClass( active );
		onClose();
	} );

	if ( !sideMenuCapable ) {
		$ol = $document.find('#mw-content-text')
			.append( '<div class="in-page-toc"><h2>' + msg('wikiamobile-toc-header') + '</h2>' + renderToc() + '</div>' )
			.find('.level');

	}

	$( '#wkTOCHandle' ).on( 'click', function () {
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
