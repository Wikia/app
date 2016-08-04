(function (window, $) {
	'use strict';

	$(function () {
		console.info('test');

		$('.like').bind('click', function (e) {
			e.preventDefault();
			$.post(
				'/wikia.php?controller=ContributionAppreciation&method=appreciate',
				$.extend($(this).data(), {token: mw.user.tokens.get('editToken')})
			).done(function () {
				console.info('done');
			});
		});
	});
})(window, jQuery);
