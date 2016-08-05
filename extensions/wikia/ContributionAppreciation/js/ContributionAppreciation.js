(function (window, $) {
	'use strict';

	$(function () {
		$('.appreciation-button').bind('click', function (e) {
			e.preventDefault();
			$.post(
				'/wikia.php?controller=ContributionAppreciation&method=appreciate',
				$.extend($(this).data(), {token: mw.user.tokens.get('editToken')})
			).done(function () {
				//TODO: handle sending
			}).error(function () {
				//TODO: handle errors
			});
		});
	});
})(window, jQuery);
