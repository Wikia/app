require(['jquery'], function ($) {
	'use strict';

	$(function () {
		var $isOnBehalfCheckbox = $('input[name=wpIsForThemselves]'),
			$relationshipInputWrapper = $('.wp-relationship-input-wrapper'),
			$relationshipInput = $relationshipInputWrapper.find('input');

		$isOnBehalfCheckbox.on('change', function () {
			if (this.value === 'Yes') {
				$relationshipInput.prop('disabled', true);
				$relationshipInputWrapper.css('display', 'none');
			} else {
				$relationshipInput.prop('disabled', false);
				$relationshipInputWrapper.css('display', 'block');
			}
		});
	});
});
