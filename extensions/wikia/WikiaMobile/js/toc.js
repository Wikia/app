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
			offsetTop = 0,
			$parent,
			sideMenuCapable = true,
			ol = '<ol class="toc-list level{{level}}">{{#sections}}{{> lis}}{{/sections}}</ol>',
			lis = '{{#.}}<li{{#sections.length}} class="has-children{{#firstLevel}}' +
				' first-children{{/firstLevel}}"{{/sections.length}}>' +
				'<a href="#{{id}}">{{name}}{{#firstLevel}}{{#sections.length}}<span class="chevron right"></span>' +
				'{{/sections.length}}{{/firstLevel}}</a>{{#sections.length}}{{> ol}}{{/sections.length}}</li>{{/.}}',
			$toc,
			$ol,
			inited;

		function toggleLi ( $li, force ) {
			if ( $li.is( '.first-children' ) ) {
				$li.siblings().removeClass( fixed + ' ' + bottom + ' ' + open );

				if ( $li.toggleClass( open, force ).hasClass( open ) ) {
					$openOl = $li.find( 'ol' ).first();
					offsetTop = Math.round( $openOl.position().top );
					$parent = $openOl.parent();

					handleFixingLiElement();
				} else {
					state = null;
					$li.removeClass( fixed + ' ' + bottom );

					$openOl = null;
				}

				$ol.scrollTop( $li.position().top - 45 );
			}
		}

		function handleFixingLiElement () {
			if ( !timeout && $openOl ) {
				timeout = setTimeout( function () {
					var scrollTop = $ol.scrollTop() + 90;

					if ( state !== disabled && scrollTop < offsetTop ) {
						state = disabled;
						$parent.removeClass( fixed );
					} else if ( scrollTop >= offsetTop ) {
						if ( offsetTop + $openOl.height() - scrollTop >= 0 ) {
							if ( state !== fixed ) {
								state = fixed;
								$parent.removeClass( bottom ).addClass( fixed );
							}
						} else if ( state !== bottom ) {
							state = bottom;
							$parent.addClass( bottom );
						}
					}

					timeout = null;
				}, 50 );
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
			$anchors.filter( '.current' ).removeClass( 'current' );

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
					$ol.scrollTop( $current.parent().position().top - 90 );
				}
			}
		}

		$document.on( 'curtain:hidden', function () {
			$toc.removeClass();
			onClose();
		} );

		function init () {
			if ( !inited ) {
				var tocData = toc.getData(
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

				$ol = $toc
					.append( mustache.render( ol, tocData, {
						ol: ol,
						lis: lis
					} ) )
					.find( '.level' )
					.on( 'scroll', handleFixingLiElement );

				$anchors = $ol.find( 'li > a' );

				inited = true;
			}
		}

		if ( !sideMenuCapable ) {
			var tocData = toc.getData(
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

			$ol = $document.find('#mw-content-text')
				.append( mustache.render( ol, tocData, {
					ol: ol,
					lis: lis
				} ) ).find('.level');
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
