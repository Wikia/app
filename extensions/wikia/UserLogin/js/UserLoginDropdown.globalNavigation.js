/* global UserLoginFacebook:true, UserLoginAjaxForm:true */
require(['jquery'], function($){
	'use strict';
	var $entryPoint, $userLoginDropdown, $transparentOut, loginAjaxForm = false;

	function openMenu() {
		$entryPoint.addClass('active');
		$transparentOut.addClass('visible');

		if (!loginAjaxForm) {
			loginAjaxForm = new UserLoginAjaxForm($entryPoint);
			UserLoginFacebook.init(UserLoginFacebook.origins.DROPDOWN);
		}
	}

	function closeMenu() {
		$entryPoint.removeClass('active');
		$transparentOut.removeClass('visible');
	}

	$(function(){
		$transparentOut = $('<div class="transparent-out transparent-out-user-login-and-account-navigation"/>').appendTo('body');
		$transparentOut.click(closeMenu);

		$entryPoint = $('#AccountNavigation');
		$entryPoint.on('click touchstart', '.ajaxLogin', function(ev) {
			ev.preventDefault();
			ev.stopPropagation(); // BugId:16984

			if (wgUserName && $entryPoint.hasClass('active')) {
				window.location = $(this).attr('href');
			} else {
				openMenu();
			}
		});

		$userLoginDropdown = $('#UserLoginDropdown');

		if (!window.touchstart) {
			window.delayedHover(
				$entryPoint.get(0),
				{
					checkInterval: 100,
					maxActivationDistance: 20,
					onActivate: openMenu,
					onDeactivate: ($userLoginDropdown.length ? Function.prototype : closeMenu)
				}
			);
		}
	});
});
