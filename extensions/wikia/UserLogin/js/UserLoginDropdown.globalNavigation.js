/* global UserLoginFacebook:true, UserLoginAjaxForm:true */
require( ['jquery'], function( $ ){
	'use strict';
	var $entryPoint, $transparentOut, loginAjaxForm = false;

	function openMenu() {
		$entryPoint.addClass( 'active' );
		$transparentOut.addClass( 'visible' );

		if (!loginAjaxForm) {
			loginAjaxForm = new UserLoginAjaxForm($entryPoint);
			UserLoginFacebook.init( UserLoginFacebook.origins.DROPDOWN );
		}
	}

	function closeMenu() {
		$entryPoint.removeClass( 'active' );
		$transparentOut.removeClass( 'visible' );
	}

	$entryPoint = $('#AccountNavigation');

	$transparentOut = $('<div class="transparent-out transparent-out-user-login"/>').appendTo('body');
	$transparentOut.click(closeMenu);

	$entryPoint.on('click', '.ajaxLogin', function(ev) {
		ev.preventDefault();
		ev.stopPropagation(); // BugId:16984
		if ($entryPoint.hasClass('active')) {
			window.location = $(this).attr('href');
		} else {
			openMenu();
		}
	});

	if ( !window.touchstart ) {
		window.delayedHover(
			$entryPoint.get( 0 ),
			{
				checkInterval: 100,
				maxActivationDistance: 20,
				onActivate: openMenu
			}
		);
	}
});
