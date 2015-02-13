require([
	'jquery',
	'GlobalNavigationiOSScrollFix',
	'wikia.window',
	'wikia.browserDetect',
	'wikia.delayedhover'
], function ($, scrollFix, win, browserDetect, delayedHover) {
	'use strict';
	var $globalNavigation = $('#globalNavigation'),
		$entryPoint = $('#AccountNavigation'),
		loginAjaxForm = false;

	function openDropdown() {
		//If anon and login form not initiated - initiate
		if (!win.wgUserName && !loginAjaxForm) {
			initLoginForm();
		}

		$entryPoint.addClass('active');
		win.transparentOut.show();
		$globalNavigation.trigger('user-login-menu-opened');
	}

	function initLoginForm () {
		loginAjaxForm = new win.UserLoginAjaxForm($entryPoint, {
			skipFocus: true
		});
		win.FacebookLogin.init(win.FacebookLogin.origins.DROPDOWN);
	}

	/**
	 * Handle click on entry point when it already has active class.
	 * For logged in user behavior is different than for anon.
	 * Second click on entry point for logged in users is redirecting to user profile page.
	 * For anons second click is closing the dropdown.
	 * This method should be removed after we unify the approaches.
	 * @param event
	 */
	function handleCloseDropdownClick(event) {
		var $this = $(event.target);
		//for logged in users we need to handle double click on entry point...
		if (!!win.wgUserName) {
			event.preventDefault();
			event.stopImmediatePropagation();
			win.location = $this.attr('href') || $this.children('a').attr('href');
		} else {
			closeDropdown();
		}
	}

	function closeDropdown() {
		var activeElementId;
		if (!win.wgUserName) {
			activeElementId = document.activeElement.id;
			if (activeElementId === 'usernameInput' || activeElementId === 'passwordInput') {
				//don't close menu if one of inputs is focused
				return;
			}
		}
		$entryPoint.removeClass('active');
		win.transparentOut.hide();
	}

	$(function () {
		var $userLoginDropdown = $('#UserLoginDropdown');

		win.transparentOut.bindClick(closeDropdown);

		$entryPoint.on('click', function(event) {
			if ($entryPoint.hasClass('active')) {
				handleCloseDropdownClick(event);
			} else {
				openDropdown();
			}
		});

		delayedHover.attach(
			$entryPoint.get(0),
			{
				checkInterval: 100,
				maxActivationDistance: 20,
				onActivate: openDropdown,
				onDeactivate: closeDropdown,
				activateOnClick: false
			}
		);

		if (browserDetect.isIOS7orLower()) {
			$userLoginDropdown
				.on('focus', '#usernameInput, #passwordInput', function () {
					scrollFix.scrollToTop($globalNavigation);
				})
				.on('blur', '#usernameInput, #passwordInput', function () {
					scrollFix.restoreScrollY($globalNavigation);
				});
		}
	});
});
