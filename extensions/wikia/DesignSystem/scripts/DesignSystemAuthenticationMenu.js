$(function ($) {
	'use strict';

	function onAuthSuccess() {
		var redirect = this.url.replace(/.*?redirect=([^&]+).*/, '$1');
		window.location.href = decodeURIComponent(redirect);
	}

	$('#global-navigation-anon-sign-in, #global-navigation-anon-register').click(function (event) {
		var url = event.currentTarget.href;

		// Prevent opening modal with shift / alt / ctrl / let only left mouse click
		if (event.which !== 1 || event.shiftKey || event.altKey || event.metaKey || event.ctrlKey) {
			return;
		}

		event.preventDefault();
		$(event.currentTarget).closest('.wds-dropdown').removeClass('wds-is-active');

		window.wikiaAuthModal.load({
			url: url,
			origin: 'global-nav',
			onAuthSuccess: onAuthSuccess.bind({url: url})
		});
	});
});
