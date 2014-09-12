(function (window, $) {
	'use strict';
	var
		$mwContent = $('#mw-content-text'),
		$editButton = $('#MainPageHero .edit-btn'),
		$saveButton = $('#MainPageHero .save-btn'),
		$momOverlays = $('.mom-module .mom-overlay'),
		onEdit = function () {
			$momOverlays.show();
			$mwContent.sortable({
				items: '.mom-module-left, .mom-module-right',
				tolerance: 'pointer',
				helper: 'clone',
				connectWith: '.mom-module'
			});
			$('#mw-content-text').sortable('enable').disableSelection();
		}, onSave = function () {
			$momOverlays.hide();
			$('#mw-content-text').sortable('disable').enableSelection();
			var left = [],
				right = [];
			$('.lcs-container .mom-module').each(function () {
				left.push($(this).data().title);
			});
			$('.rcs-container .mom-module').each(function () {
				right.push($(this).data().title);
			});
			$.nirvana.sendRequest({
				controller: 'NjordController',
				method: 'reorder',
				type: 'POST',
				data: {
					'page': wgTitle,
					'left': left,
					'right': right
				},
				callback: onDataSaved,
				onErrorCallback: function () {
					// TODO: handle failure
//					$heroModule.stopThrobbing();
				}
			});
		}, onDataSaved = function () {
			console.info('saved');
		}

	$editButton.on('click', onEdit);
	$saveButton.on('click', onSave);

})(window, jQuery);