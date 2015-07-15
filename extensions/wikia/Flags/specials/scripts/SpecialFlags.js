require(
	['jquery'],
	function ($)
	{
		'use strict';

		function init() {
			bindEvents();
		}

		function bindEvents() {
			$('.flags-special-create-button').on('click', displayCreateFlagForm);
		}

		function displayCreateFlagForm(event) {
			event.preventDefault();

//			FlagEditForm.init();
		}

		// Run initialization method on DOM ready
		$(init);
	});
