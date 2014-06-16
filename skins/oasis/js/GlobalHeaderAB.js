window.removedFromHoverMenu = false;

$(function(){
	var $accountNavigation = $( '#AccountNavigation' ),
		$avatar = $accountNavigation.find( 'li:first .avatar' ),
		avatarSize = 36,
		$loginDropdown = $accountNavigation.find( '#UserLoginDropdown' );
		$accountNavsubnav = $accountNavigation.find('.subnav'),
		$wallNotifications = $( '#WallNotifications'),
		$notifications = $('<li class="notificationsEntry"><a href="#"><span id="bubbles_count"></span>Notifications</a></li>');

	$('.WikiaHeader').addClass('v3');
	$( '#AccountNavigation > li:first > a' ).contents().filter(function() { return this.nodeType === 3; }).wrap( '<span class="login-text">' );
	$accountNavigation.find( '.login-text' ).hide();

	if ( $avatar.length > 0 ) {
		$avatar.attr( 'src', $avatar.attr( 'src' ).replace( '/20px-', '/' + avatarSize + 'px-' ) )
			.attr( 'height', avatarSize)
			.attr( 'width', avatarSize );
	}

	$accountNavigation.on('mouseover', '.notificationsEntry', function(){
		$('.subnav', $wallNotifications).addClass('show');
	});

	$accountNavigation.on('mouseover', function(){
		if( !window.removedFromHoverMenu ) {
			removeWallNotificationsFromHoverMenu();
			window.removedFromHoverMenu = true;
		}
		$('>li >.subnav', $accountNavigation).addClass('show');
	});

	$accountNavigation.on('mouseleave', '.notificationsEntry', function(){
		$('.subnav', $wallNotifications).removeClass('show');
	});

	$accountNavigation.on('mouseleave', function(){
		$('>li >.subnav', $accountNavigation).removeClass('show');
	});

	$accountNavsubnav.find( '.new' ).removeClass( 'new' );
	$('.bubbles #bubbles_count').remove();
	$notifications.append($wallNotifications);
	$accountNavsubnav.prepend($notifications);
	$accountNavigation.find( '.ajaxRegister' ).wrap( '<div class="ajaxRegisterContainer"></div>' ).parent().prependTo( '#UserLoginDropdown' );

	if ( $loginDropdown.length > 0 || $avatar.attr( 'src' ).indexOf( '/Avatar.jpg' ) > -1 ) {
		$avatar.remove();
		$accountNavigation.find( 'a:first' ).prepend(
			'<svg class="avatar" width="' + avatarSize + '" height="' + avatarSize + '" xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="0 0 36 36" enable-background="new 0 0 36 36" xml:space="preserve"><rect x="0" y="0" width="36" height="36"/><path fill="#FFFFFF" d="m 30.2 27.7 c -2.7 -1.5 -6.3 -3.1 -8.5 -4.3 4.3 -5.4 3.6 -17.3 -3.6 -17.6 -0 0 -0 -0 -0 -0 -0 0 -0 0 -0 0 -0 0 -0 -0 -0 -0 -0 0 -0 0 -0 0 -9 1.6 -7 13.3 -3.6 17.6 -2.2 1.2 -5.8 2.8 -8.5 4.3 6.5 7.9 18.4 7.7 24.4 0 z"/></svg>'
		);
	}

	$loginDropdown.find( 'input[type="text"], input[type="password"]' ).each(function() {
		var $input = $( this );
		$input.attr( 'placeholder', $input.prev().hide().text() );
	});
	function removeWallNotificationsFromHoverMenu() {
		for(var menu in window.HoverMenuGlobal.menus) {
			if(window.HoverMenuGlobal.menus[menu].selector === '#AccountNavigation') {
				window.HoverMenuGlobal.menus[menu].menu.off('focus', '.subnav a');
			}
			if(window.HoverMenuGlobal.menus[menu].selector === '#WallNotifications') {
				window.HoverMenuGlobal.menus[menu].menu.off('focus', '.subnav a');
				window.HoverMenuGlobal.menus[menu].menu.off('mouseenter','> li', window.HoverMenuGlobal.menus[menu].mouseover);
				window.HoverMenuGlobal.menus[menu].menu.off('mouseleave','> li', window.HoverMenuGlobal.menus[menu].mouseout);
			}
		}
	}
});
