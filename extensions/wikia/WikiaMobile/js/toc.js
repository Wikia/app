//init toc
require( ['sections', 'wikia.window', 'jquery', 'wikia.mustache', 'wikia.toc'],
function ( sections, window, $, mustache, toc ) {
	'use strict';

	//private
	var bottom = 'bottom',
		fixed = 'fixed',
		disabled = 'disabled',
		open = 'open',
		$document = $( window.document ),
		$anchors,
		$openOl,
		timeout,
		state,
		$parent,
		sideMenuCapable = true,
		$toc,
		$ol,
		inited,
		lineHeight = 45;

	function toggleLi ( $li, force ) {
		if ( $li.is( '.first-children' ) ) {
			$li.siblings().removeClass( fixed + ' ' + bottom + ' ' + open );

			if ( $li.toggleClass( open, force ).hasClass( open ) ) {
				$openOl = $li.find( 'ol' ).first();
				$parent = $openOl.parent();

				handleFixingLiElement();
			} else {
				state = null;
				$li.removeClass( fixed + ' ' + bottom );

				$openOl = null;
			}

			$ol.scrollTop( $li.position().top - lineHeight );
		}
	}

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

	$toc = $( '#wkTOC' )
		.on( 'click', 'header', function () {
			window.scrollTo( 0, 0 );
		} )
		.on( 'click', 'li', function ( event ) {
			var $li = $( this ),
				$a = $li.find( 'a' ).first();

			event.stopPropagation();
			event.preventDefault();

			sections.scrollTo( $a.attr( 'href' ).slice( 1 ) );

			toggleLi( $li );
		} );

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
				$ol.scrollTop( $current.parent().position().top - lineHeight * 2 );
			}
		}
	}

	$document.on( 'curtain:hidden', function () {
		$toc.removeClass();
		onClose();
	} );

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

		return mustache.render( ol, tocData, {
			ol: ol,
			lis: lis
		} );
	}

	function init () {
		if ( !inited ) {
			$ol = $toc
				.append( renderToc() )
				.find( '.level' )
				.on( 'scroll', handleFixingLiElement );

			$anchors = $ol.find( 'li > a' );

			inited = true;
		}
	}

	if ( !sideMenuCapable ) {
		$ol = $document.find('#mw-content-text')
			.append( '<div class="in-page-toc">' + renderToc() + '</div>' )
			.find('.level');
	}

	function onTap(){
		$ol[0].scrollIntoView();
	}

	function onOpen () {
		$document.on( 'section:changed', onSectionChange );

		init();

		onSectionChange( null, sections.current()[0], true );
		$.event.trigger( 'curtain:show' );
		$.event.trigger( 'ads:unfix' );
	}

	function onClose () {
		$document.off( 'section:changed', onSectionChange );
		$.event.trigger( 'curtain:hide' );
		$.event.trigger( 'ads:fix' );
	}

	$( '#wkTOCHandle' ).on( 'click', function () {
		if ( sideMenuCapable ) {
			if ( $toc.toggleClass( 'active' ).hasClass( 'active' ) ) {
				onOpen();
			} else {
				onClose();
			}
		} else {
			onTap();
		}
	} );
} );
