(function($) {
	'use strict';
	$(function() {
		var $inputResultLang, $formElement, $selectElement, $searchInput, $searchLabel, $chevron;


		function setFormOptions() {
			var $selectedOption;

			$selectedOption = $selectElement.find( 'option:selected' );
			$searchLabel.text( $selectedOption.text() );
			$formElement.attr( 'action' , $selectedOption.attr( 'data-search-url' ) );
			if ($selectedOption.val() === 'global') {
				$inputResultLang.prop( 'disabled', false );
				if ($searchInput.data('autocomplete')) {
					$searchInput.data('autocomplete').disable();
				}
			} else {
				$inputResultLang.prop( 'disabled', true );
				if ($searchInput.data('autocomplete')) {
					$searchInput.data('autocomplete').enable();
				}
			}
		}

		$inputResultLang = $('#searchInputResultLang');
		$chevron = $('#searchFormChevron');
		$formElement = $('#searchForm');
		$selectElement = $('#searchSelect');
		$searchLabel = $('#searchLabelInline');
		$searchInput = $('#searchInput');

		setFormOptions();

		$selectElement.on('change keyup keydown', function() {
			setFormOptions();
		});
		$selectElement.on('focus', function() {
			$chevron.addClass('dark');
		});
		$selectElement.on('blur', function() {
			$chevron.removeClass('dark');
		});
	});
}(jQuery));
