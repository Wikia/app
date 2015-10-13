require(['jquery'], function ($) {
	'use strict';

	function init() {
		$('.template-classification-edit').click(function (e) {
			e.preventDefault();
			console.log('edit');
		});
	}

	$(init);
});
