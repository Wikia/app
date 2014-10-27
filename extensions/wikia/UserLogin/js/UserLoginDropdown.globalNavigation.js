/* global UserLoginFacebook:true, UserLoginAjaxForm:true */
require(['jquery', 'GlobalNavigationiOSScrollFix', 'wikia.window'], function ($, scrollFix, win) {
	'use strict';
	var $entryPoint, $userLoginDropdown;

	/**
	 * Open user login dropdown by adding active class
	 */
	function openMenu() {
		var loginAjaxForm = false;
		$entryPoint.addClass('active');
		window.transparentOut.show();

		if (!loginAjaxForm) {
			loginAjaxForm = new UserLoginAjaxForm($entryPoint, {
				skipFocus: true
			});
			UserLoginFacebook.init(UserLoginFacebook.origins.DROPDOWN);
		}
	}

	/**
	 * Close user login dropdown by removing active class
	 */
	function closeMenu() {
		$entryPoint.removeClass('active');
		window.transparentOut.hide();
	}

	/**
	 * Close user login dropdown if neither user input nor password input are active
	 */
	function closeMenuIfNotFocused() {
		var id = document.activeElement.id;
		if (!(id === 'usernameInput' || id === 'passwordInput')) {
			closeMenu();
		}
	}

	$(function () {
		var $globalNav = $('#globalNavigation');

		window.transparentOut.bindClick(closeMenu);

		$entryPoint = $('#AccountNavigation');
		$entryPoint.on('click', '.ajaxLogin', function (ev) {
			ev.preventDefault();
			ev.stopImmediatePropagation();

			if ($entryPoint.hasClass('active')) {
				if (!!win.wgUserName) {
					window.location = $(this).attr('href');
				} else {
					closeMenu();
				}
			} else {
				openMenu();
			}

		});

		$userLoginDropdown = $('#UserLoginDropdown');

		$userLoginDropdown
			.on('focus', '#usernameInput, #passwordInput', function () {
				scrollFix.scrollToTop($globalNav);
			})
			.on('blur', '#usernameInput, #passwordInput', function () {
				scrollFix.restoreScrollY($globalNav);
			});

		if (!window.Wikia.isTouchScreen()) {
			window.delayedHover(
				$entryPoint.get(0), {
					checkInterval: 100,
					maxActivationDistance: 20,
					onActivate: openMenu,
					onDeactivate: ($userLoginDropdown.length ? closeMenuIfNotFocused : closeMenu),
					activateOnClick: false
				}
			);
		}
	});
});
