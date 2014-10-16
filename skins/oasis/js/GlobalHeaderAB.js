window.removedFromHoverMenu = false;

$(function(){
	'use strict';

	var $ = jQuery,
		$accountNavigation = $( '#AccountNavigation' ),
		$arrow = $( '<svg width="21" height="17" class="light search-arrow" xmlns="http://www.w3.org/2000/svg"><polygon points="0,5.66 9.0,5.66 9,0 20.5,8.5 9,17 9,11.33 0,11.33" /></svg>' ),
		$avatar = $accountNavigation.find( 'li:first .avatar' ),
		$avatarLink = $( '#AccountNavigation > li:first > a' ),
		avatarSize = 36,
		$loginDropdown = $accountNavigation.find( '#UserLoginDropdown'),
		$accountNavsubnav = $accountNavigation.find('.subnav'),
		$bubblesNotifications,
		$bubblesNavigation,
		$wallNotifications,
		$notifications,
		searchLocalText = 'This wikia',
		searchGlobalText = 'All of Wikia',
		$searchPageInput = $( '#search-v2-input' ),

		// building search
		$globalSearch = $( '<li>' ).addClass( 'global-search' ),
		localSearchUrl = window.location.origin + "/wiki/Special:Search",
		$form = $( '<form>' )
			.addClass( 'search-form' )
			.attr( 'method', 'get' )
			.attr( 'action', localSearchUrl )
			.submit( function() {
				var formAction = {
						'local': localSearchUrl,
						'global': window.wgGlobalSearchUrl
					},
				searchType = $( this ).find( 'select' ).val();
				$( this ).attr( 'action', formAction[ searchType ] );

				// Optimizely event tracking
				if ( searchType === 'global' ) {
					window.optimizely.push( [ 'trackEvent', 'global_search_submits' ] );
				} else {
					window.optimizely.push( [ 'trackEvent', 'local_search_submits' ] );
				}
			} ),
		$selectWrapper = $( '<div>' )
			.addClass( 'search-select-wrapper' ),
		$selectChevron = $( '<svg width="10" height="5" class="light search-chevron" xmlns="http://www.w3.org/2000/svg"><polygon points="10,0 5,5 0,0" /></svg>' )
			.appendTo( $selectWrapper ),
		$select = $( '<select>' )
			.attr( 'id', 'search-select' )
			.addClass( 'cursor-pointer' ),
		$selectSpan = $( '<span>' )
			.text( searchLocalText ),
		$searchInput = $( '<input>' )
			.addClass( 'search-box' )
			.attr( 'type', 'text' )
			.attr( 'accesskey', 'f' )
			.attr( 'autocomplete', 'off' )
			.attr( 'name', 'search' )
			//TODO i18n
			.attr( 'placeholder', 'Characters, history, quests...' );

	$( '<option>' )
		.val( 'local' )
		.text( searchLocalText )
		.attr( 'selected', 'selected' )
		.appendTo( $select );

	$( '<option>' )
		.val( 'global' )
		.text( searchGlobalText )
		.appendTo( $select );

	$select.appendTo( $selectWrapper );

	$( '<svg width="19" height="19" class="dark" xmlns="http://www.w3.org/2000/svg"><path transform="scale(1.2) translate(0.5,0.5)" stroke-linejoin="null" stroke-linecap="null" d="m14.8613,12.88892l-3.984008,-3.983988c0.536782,-0.885019 0.851497,-1.920426 0.852106,-3.030754c0,-3.238203 -2.622357,-5.861736 -5.860845,-5.862835c-3.237258,0.0011 -5.860767,2.624632 -5.860767,5.8625c0,3.236496 2.623743,5.859635 5.861367,5.859635c1.110886,0 2.146293,-0.314714 3.031312,-0.851395l3.985085,3.984516l1.97575,-1.97768l0,0zm-12.617637,-7.015077c0.003362,-2.00262 1.623002,-3.621701 3.625063,-3.626171c2.000933,0.00447 3.621701,1.623551 3.625053,3.626171c-0.003911,2.001492 -1.62412,3.620584 -3.625053,3.625053c-2.002386,-0.004735 -3.622219,-1.623337 -3.625063,-3.625053z" /></svg>' )
		.appendTo( $selectWrapper );

	$selectSpan.appendTo( $selectWrapper );

	$selectWrapper.appendTo( $form );

	$searchInput.appendTo( $form );

	$( '<input>' )
		.attr( 'type', 'hidden' )
		.attr( 'name', 'resultsLang')
		.val( window.wgUserLanguage )
		.appendTo( $form );

	$( '<input>' )
		.attr( 'type', 'hidden' )
		.attr( 'name', 'fulltext')
		.val( 'Search' )
		.appendTo( $form );

	// setting the searched phrase as the global header search input value
	if ( $searchPageInput.length > 0 && $searchPageInput.val() !== '' ) {
		$searchInput.val( $searchPageInput.val() );
		$arrow.attr( 'class', 'dark search-arrow' );
	}

	// removing in-page search boxes
	$( '#HeaderWikiaSearch' ).remove();
	$( '#WikiaSearch' ).remove();
	$('.wikinav2.oasis-one-column .WikiaMainContentContainer .WikiaPageHeader .tally').css('right', 0);

	// adding behaviour
	$( '<button type="submit">' )
		.focus( function() {
			$arrow.attr( 'class', 'dark search-arrow' );
		} )
		.blur( function() {
			if ( $searchInput.val() === '' ) {
				$arrow.attr( 'class', 'light search-arrow' );
			}
		} )
		.append( $arrow )
		.appendTo( $form );

	$select
		.on('change keyup', function() {
			$selectSpan.text( $( '#search-select' ).find( 'option:selected' ).text() );
		})
		.focus( function() {
			$selectChevron.attr( 'class', 'dark search-chevron' );
		} )
		.blur( function() {
			$selectChevron.attr( 'class', 'light search-chevron' );
		} )
		.change( function() {
			$searchInput.focus();
		} );

	$searchInput
		.focus( function() {
			$arrow.attr( 'class', 'dark search-arrow' );
		} )
		.blur( function() {
			if ( $searchInput.val() === '' ) {
				$arrow.attr( 'class', 'light search-arrow' );
			}
		} );

	$globalSearch.append( $form );

	$( '#WikiaHeader' ).find( '.WikiaLogo' ).after( $globalSearch );

	$('.WikiaHeader').addClass('v3');
	$avatarLink.contents().filter(function() { return this.nodeType === 3; }).wrap( '<span class="login-text">' );
	$accountNavigation.find( '.login-text' ).hide();

	if ( $avatar.length > 0 ) {
		$avatar.attr( 'src', $avatar.attr( 'src' ).replace( '/20px-', '/' + avatarSize + 'px-' ) )
			.attr( 'height', avatarSize)
			.attr( 'width', avatarSize );
	}

	if (window.wgUserName !== null) {
		$wallNotifications = $( '#WallNotifications');
		if(!$wallNotifications.hasClass('prehide')) {
			$notifications = $('<li class="notificationsEntry"><a href="#"><span id="bubbles_count"></span>Notifications</a></li>');

			$accountNavigation.on('mouseover', '.notificationsEntry', function(){
				$('.subnav', $wallNotifications).addClass('show');
			});

			$accountNavigation.on('mouseover', function(){
				if( !window.removedFromHoverMenu ) {
					$bubblesNotifications = $('.notificationsEntry #bubbles_count');
					$bubblesNavigation = $('.bubbles #bubbles_count');
					removeWallNotificationsFromHoverMenu();
					window.removedFromHoverMenu = true;
				}
				$bubblesNotifications.text($bubblesNavigation.text());
			});

			$accountNavigation.on('mouseleave', '.notificationsEntry', function(){
				$('.subnav', $wallNotifications).removeClass('show');
			});



			$avatarLink.append($('.bubbles'));
			$notifications.append($wallNotifications);
			$accountNavsubnav.prepend($notifications);
		} else {
			$wallNotifications.hide();
			$accountNavigation.on('mouseover', function(){
				if( !window.removedFromHoverMenu ) {
					removeWallNotificationsFromHoverMenu();
					window.removedFromHoverMenu = true;
				}
			});
		}

		$accountNavigation.on('mouseleave', function(){
			$('>li >.subnav', $accountNavigation).removeClass('show');
		});
	}

	$accountNavsubnav.find( '.new' ).removeClass( 'new' );
	$accountNavigation.find( '.ajaxRegister' ).wrap( '<div class="ajaxRegisterContainer"></div>' ).parent().prependTo( '#UserLoginDropdown' );

	if ( $loginDropdown.length > 0 || $avatar.attr( 'src' ).indexOf( '/Avatar.jpg' ) > -1 ) {
		$avatar.remove();
		$accountNavigation.find( 'a:first' ).prepend(
			'<div class="avatarContainer"><svg class="avatar" width="' + avatarSize + '" height="' + avatarSize + '" xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve"><rect x="0" y="0" width="36" height="36"/><path fill="#FFFFFF" d="m 30.2 27.7 c -2.7 -1.5 -6.3 -3.1 -8.5 -4.3 4.3 -5.4 3.6 -17.3 -3.6 -17.6 -0 0 -0 -0 -0 -0 -0 0 -0 0 -0 0 -0 0 -0 -0 -0 -0 -0 0 -0 0 -0 0 -9 1.6 -7 13.3 -3.6 17.6 -2.2 1.2 -5.8 2.8 -8.5 4.3 6.5 7.9 18.4 7.7 24.4 0 z"/></svg></div>'
		);
	}

	$loginDropdown.find( 'input[type="text"], input[type="password"]' ).each(function() {
		var $input = $( this );
		$input.attr( 'placeholder', $input.prev().hide().text() );
	});


	function removeWallNotificationsFromHoverMenu() {
		var hoverMenus = window.HoverMenuGlobal.menus,
			menu;
		for(menu in hoverMenus) {
			if (hoverMenus.hasOwnProperty(menu)) {
				if(hoverMenus[menu].selector === '#AccountNavigation') {
					hoverMenus[menu].menu.off('focus', '.subnav a');
					hoverMenus.splice(menu,1);
				}
				if(hoverMenus[menu].selector === '#WallNotifications') {
					hoverMenus[menu].menu.off('focus', '.subnav a');
					hoverMenus[menu].menu.off('mouseenter','> li', hoverMenus[menu].mouseover);
					hoverMenus[menu].menu.off('mouseleave','> li', hoverMenus[menu].mouseout);
					hoverMenus.splice(menu,1);
				}
			}
		}
	}


 // global nav cleanup/replace
	(function(){
		var $startAWiki = $('.start-a-wiki a');

		$('.WikiaLogo a').html('<svg version="1.1" class="svglogo" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 217.8 60" enable-background="new 0 0 217.8 60" xml:space="preserve"><path d="M100.6,58.8V0h13.2v33l3.5-4.4l7.4-8.8h18.9L128,35.2l16.5,23.7h-17.2l-9-14.9l-4.6,4.3v10.5H100.6z M51.8,20.1l-5,26.4l-6.4-26.4h-6h-0.3h-2.7h-0.3h-6l-6.4,26.4l-5-26.4H0l10.1,38.8h17.7l5-20.4l5,20.4h17.7l10.1-38.8H51.8z M217.1,47.5l0.7,11.3h-12.1l-0.9-4.2c-2.8,2.9-6.2,5.4-12.3,5.4c-11,0-17-7.1-17-20.6c0-13.5,6-20.6,17-20.6c6.1,0,9.5,2.4,12.3,5.4l0.9-4.2h12.1l-0.7,11.3V47.5z M203.9,34.4c-1.7-2.2-4.3-3.7-7.8-3.7c-4,0-7.1,2.6-7.1,8.7c0,6.1,3.2,8.7,7.1,8.7c3.5,0,6.1-1.5,7.8-3.7V34.4zM79.8,0.2c-4.2,0-7.6,3.4-7.6,7.6c0,4.2,3.4,7.6,7.6,7.6c4.2,0,7.6-3.4,7.6-7.6C87.4,3.6,84,0.2,79.8,0.2 M91.2,27.8v-8.3h-5.7H72.2v13.4v12.5v13.1v0.3h19v-8.2h-5.9V27.8H91.2z M153.7,7.8c0,4.2,3.4,7.6,7.6,7.6c4.2,0,7.6-3.4,7.6-7.6c0-4.2-3.4-7.6-7.6-7.6C157.1,0.2,153.7,3.6,153.7,7.8 M155.8,27.8v22.8h-5.9v8.2h19v-0.3V45.4V32.9V19.5h-13.2h-5.7v8.3H155.8z"/></svg>');
		$startAWiki.removeClass('wikia-button').html(
			'<svg version="1.1" id="saw-icon" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 14 14" enable-background="new 0 0 14 14" xml:space="preserve"><polygon points="14,6 8,6 8,0 6,0 6,6 0,6 0,8 6,8 6,14 8,14 8,8 14,8 "/></svg>' +
			'<span>' + $startAWiki.text() + '</span>'
		);
	})();
	// Special:Search cleanup for wwww.wikia.com
	if (window.location.host.indexOf('www.') === 0) {
		$('.SearchInput').remove();
	}
});
