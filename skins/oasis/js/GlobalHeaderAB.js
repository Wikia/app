$(function(){
	var $accountNavigation = $( '#AccountNavigation' ),
		$avatar = $accountNavigation.find( 'li:first .avatar' ),
		avatarSize = 36,
		$loginDropdown = $accountNavigation.find( '#UserLoginDropdown' );

	$('.WikiaHeader').addClass('v3');
	$( '#AccountNavigation > li:first > a' ).contents().filter(function() { return this.nodeType === 3; }).wrap( '<span class="login-text">' );
	$accountNavigation.find( '.login-text' ).hide();
	$( '#WallNotifications' ).hide();

	if ( $avatar.length > 0 ) {
		$avatar.attr( 'src', $avatar.attr( 'src' ).replace( '/20px-', '/' + avatarSize + 'px-' ) )
			.attr( 'height', avatarSize)
			.attr( 'width', avatarSize );
	}

	$accountNavigation.find('.subnav' ).find( '.new' ).removeClass( 'new' );
	$accountNavigation.find( '.ajaxRegister' ).wrap( '<div class="ajaxRegisterContainer"></div>' ).parent().prependTo( '#UserLoginDropdown' );

	$loginDropdown.find( 'input[type="text"], input[type="password"]' ).each(function() {
		var $input = $( this );
		$input.attr( 'placeholder', $input.prev().hide().text() );
	});
});
