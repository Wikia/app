require(['jquery'], function ($) {
	'use strict';

	var $isOnBehalfCheckbox = $('input[name=wpIsOnBehalf]'),
		$relationshipInputWrapper = $('.wp-relationship-input-wrapper'),
		$relationshipInput = $relationshipInputWrapper.find('input');

	$isOnBehalfCheckbox.on('change', function () {
		if (this.checked) {
			$relationshipInput.prop('disabled', true);
			$relationshipInputWrapper.css('display', 'none');
		} else {
			$relationshipInput.prop('disabled', false);
			$relationshipInputWrapper.css('display', 'block');
		}
	});
});
