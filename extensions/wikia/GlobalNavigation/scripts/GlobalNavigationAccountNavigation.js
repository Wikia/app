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
		loginAjaxForm = false;

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
		if (this.$entryPoint.hasClass('active')) {
			win.location = $this.attr('href') || $this.children('a').attr('href');
		} else {
			dropdowns.openDropdown.call(this.$entryPoint.get(0));
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
			loginAjaxForm = new win.UserLoginAjaxForm(this.$entryPoint, {
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

	function authModalOpen(url) {
		window.wikiaAuthModal.load({
			url: url,
			origin: 'global-nav',
			onAuthSuccess: onAuthSuccess.bind({url: url})
		});
	}

	function onAuthSuccess() {
		var redirect = this.url.replace(/.*?redirect=([^&]+).*/, '$1');
		window.location.href = decodeURIComponent(redirect);
	}

	function globalNavAuthButtonsClick(event) {
		//Prevent opening modal with shift / alt / ctrl / let only left mouse click
		if (event.which !== 1 || event.shiftKey || event.altKey || event.metaKey || event.ctrlKey) {
			return;
		}
		if (event) {
			event.preventDefault();
			event.stopPropagation();
		}

		authModalOpen(event.currentTarget.href);
	}

	function oldAccountNav ($entryPoint) {
		var $userLoginDropdown = $('#UserLoginDropdown');

		dropdowns.attachDropdown($entryPoint, {
			onOpen: onDropdownOpen.bind({$entryPoint: $entryPoint}),
			onClose: onDropdownClose,
			onClick: !!win.wgUserName ? onEntryPointClick.bind({$entryPoint: $entryPoint}) : false,
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
	}

	$(function () {
		var $entryPoint, $authEntryPoints;

		$entryPoint = $('#AccountNavigation');

		if (!win.wgUserName && win.wgEnableNewAuthModal) {
			$authEntryPoints = $entryPoint.find('.auth-link.register, .auth-link.sign-in, a.sign-in');

			$authEntryPoints.click(globalNavAuthButtonsClick);
		}
		else {
			oldAccountNav($entryPoint);
		}
	});
});
