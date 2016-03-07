define('AuthModal', ['jquery', 'wikia.window'], function ($, window) {
	'use strict';

	var modal,
		$blackout,
		isOpen,
		track;

	function open (onAuthSuccess) {
		if (isOpen) {
			close();
		}
		$('.WikiaSiteWrapper').append(
			'<div class="auth-blackout visible"><div class="auth-modal loading">' +
				'<a class="close" href="#"></div></div>'
		);
		isOpen = true;
		$blackout = $('.auth-blackout');
		modal = $blackout.find('.auth-modal')[0];
		$('.auth-blackout, .auth-modal .close').click(close);

		track = getTrackingFunction();
		track({
			action: Wikia.Tracker.ACTIONS.OPEN,
			label: 'username-login-modal'
		});

		$(window).on({
			'keyup.authModal' : onKeyUp,
			'message.authModal': function (event) {
				var e = event.originalEvent;

				if (typeof e.data !== 'undefined' && e.data.isUserAuthorized) {
					close();
					if (typeof onAuthSuccess === 'function') {
						onAuthSuccess();
					}
				}
			}
		});
	}

	function getTrackingFunction () {
		if (track) {
			return track;
		}
		track = Wikia.Tracker.buildTrackingFunction({
			category: 'user-login-desktop-modal',
			trackingMethod: 'analytics'
		});

		return track;
	}

	function onKeyUp (event) {
		if (event.keyCode === 27) {
			close();
		}
	}

	function close (event) {
		if (event) {
			event.preventDefault();
		}

		if (modal) {
			track({
				action: Wikia.Tracker.ACTIONS.CLOSE,
				label: 'username-login-modal'
			});
			$blackout.remove();
			isOpen = false;
		}

		$(window).off('.authModal');
	}

	function onPageLoaded () {
		if (modal) {
			$(modal).removeClass('loading');
		}
	}
	function authSuccess(event) {
		console.log('Paent event', event);
	}

	function loadPage (url, onPageLoaded) {


		var modalParam = 'modal=1',
			src = url + (url.indexOf('?') === -1 ? '?' : '&') + modalParam,
			PopUpWidth= 768,
			PopUpHeight= 670,
			left = (window.screen.width /2) - PopUpWidth/2,
			top = (window.screen.height/2) - PopUpHeight/2,
			authPopUp = window.open(src, 'Wikia Authentication','width='+PopUpWidth+',height='+PopUpHeight+'top='+top+',left='+left);

		authPopUp.addEventListener('message', function (event) {
			alert('Event has been send');
			console.log(event);
		}, false);

		console.log('src', src);
		console.log('url', url);

		authPopUp.onload = function () {
			authPopUp.postMessage('asdasd');
		};

		//for the selenium tests:
		/*		authIframe.id = 'auth-modal-iframe';
		 authIframe.onload = function () {
		 if (typeof onPageLoaded === 'function') {
		 onPageLoaded();
		 }
		 };*/
		//modal.appendChild(authIframe);
		window.addEventListener('message', authSuccess, false);
	}

	return {
		/**
		 * @desc launches the new auth modal if wgEnableNewAuthModal is set to true. If not, then the old UserLoginModal
		 * is loaded.
		 * @param {object} params:
		 * @param {string} url - url for the page we want to load in the modal
		 * @param {string} origin - used for tracking the source of force login modal
		 * @param {function} onAuthSuccess - callback function to be called after login
		 */
		load: function (params) {
			if (typeof params.onAuthSuccess !== 'function') {
				params.onAuthSuccess = function () {
					window.location.reload();
				};
			}

			if (!params.origin) {
				params.origin = 'no-origin-provided';
			}

			if (window.wgEnableNewAuthModal) {
				open(params.onAuthSuccess);

				track({
					action: Wikia.Tracker.ACTIONS.OPEN,
					label: 'from-' + params.origin
				});

				loadPage(params.url, onPageLoaded);

			} else {
				window.UserLoginModal.show({
					origin: params.origin,
					callback: params.onAuthSuccess
				});
			}
		},
		close: close
	};
});
