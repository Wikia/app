define('AuthModal', [ 'jquery', 'AuthComponent' ], function( $, AC ) {
	'use strict';

	function open () {
		$('.WikiaSiteWrapper').append(
			'<div class="auth-blackout"><div class="auth-modal"></div></div>'
		);
		new AC($('.auth-modal')[0]).login();
	}

	return open;
} );
