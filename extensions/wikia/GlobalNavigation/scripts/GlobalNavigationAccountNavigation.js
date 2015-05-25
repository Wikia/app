require([
	'jquery',
	'GlobalNavigationiOSScrollFix',
	'wikia.window',
	'wikia.browserDetect',
	'wikia.delayedhover',
	'wikia.globalNavigationDropdowns'
], function ($, scrollFix, win, browserDetect, delayedHover, dropdowns) {
	'use strict';
	var $globalNavigation = $('#globalNavigation'),
		loginAjaxForm = false,
		$entryPoint;

	/**
	 * @desc Handle click on entry point for logged in users.
	 * Second click on entry point for logged in users is redirecting to user profile page.
	 * This method should be removed after we unify the ux for anon and logged in.
	 * @param {Event} event
	 */
	function onEntryPointClick(event) {
		var $this = $(event.currentTarget);
		event.preventDefault();
		event.stopImmediatePropagation();
		
		if ($entryPoint.hasClass('active')) {
			win.location = $this.attr('href') || $this.children('a').attr('href');
		} else {
			dropdowns.openDropdown.call($entryPoint.get(0));
		}
	}

	function onDropdownOpen(event) {
		$globalNavigation.trigger('user-login-menu-opened');
		if (event) {
			event.preventDefault();
			//Stop propagation has to be called in order to avoid opening userLoginModal
			event.stopPropagation();
		}

		if (!win.wgUserName && !loginAjaxForm) {
			loginAjaxForm = new win.UserLoginAjaxForm($entryPoint, {
				skipFocus: true
			});
			win.FacebookLogin.init(win.FacebookLogin.origins.DROPDOWN);
		}
	}

	function onDropdownClose() {
		var activeElementId = document.activeElement.id;
		
		if (!win.wgUserName) {
			if (activeElementId === 'usernameInput' || activeElementId === 'passwordInput') {
				//don't close menu if one of inputs is focused
				return false;
			}
		}
	}

	$(function () {
		var $userLoginDropdown = $('#UserLoginDropdown');
		$entryPoint = $('#AccountNavigation');

		dropdowns.attachDropdown($entryPoint, {
			onOpen: onDropdownOpen,
			onClose: onDropdownClose,
			onClick: !!win.wgUserName ? onEntryPointClick : false,
			onClickTarget: '.links-container'
		});

		delayedHover.attach(
			$entryPoint.get(0),
			{
				checkInterval: 100,
				maxActivationDistance: 20,
				onActivate: dropdowns.openDropdown,
				onDeactivate: dropdowns.closeDropdown,
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
