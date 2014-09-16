(function (window, $) {
	'use strict';
	var
		$mwContent = $('#mw-content-text'),
		$mainContentContainer = $('#WikiaMainContentContainer'),
		$mainContent = $('#WikiaMainContent'),
		$momHeader = $('#MomHeader'),
		$editButton = $('#MomHeader .layout-edit-btn'),
		$saveButton = $('#MomHeader .layout-save-btn'),
		$discardButton = $('#MomHeader .layout-cancel-btn'),
		$deleteButton = $('.mom-delete-btn'),
		$editMode = $('.layout-mode'),
		$nonEditMode = $('.no-layout-mode'),
		$momOverlays = $('.mom-module .mom-overlay'),
		$momBar = $('.mom-module .mom-bar'),
		$momBarContent = $('.mom-bar .mom-bar-content'),
		$moms = $('.mom-module'),
		$leftColumn = $('.lcs-container'),
		$rightColumn = $('.rcs-container'),
		onEdit = function () {
			addEmpty();
			$moms.addClass('mom-hidden');
			$editMode.show();
			$nonEditMode.hide();
			$momBar.show();
			$momOverlays.show();
			var options = {
				cancel: '.mom-bar-content',
				handle: '.mom-bar',
				helper: 'clone',
				items: '.mom-module-left, .mom-module-right',
				placeholder: 'mom-add-module',
				tolerance: 'pointer',
				over: function(e, ui) {
					var $child = $($(this).children('.mom-module')[0]);
					if (ui.item[0] === $child[0]) {
						//check second child if first (and only) child was grabbed
						$child = $($(this).children('.mom-module')[1]);
					}
					if ($child.hasClass('mom-add-module')) {
						ui.placeholder.insertBefore($child);
					}
				}
			};
			options['connectWith'] = '.rcs-container';
			$leftColumn.sortable(options);
			options['connectWith'] = '.lcs-container';
			$rightColumn.sortable(options);
			$leftColumn.sortable('enable');
			$rightColumn.sortable('enable');
			$momBarContent.each(function () {
				$(this).attr('contenteditable', true);
			});
		}, onSave = function () {
			removeEmpty();
			$editMode.hide();
			$nonEditMode.show();
			$mainContentContainer.startThrobbing();
			$moms.removeClass('mom-hidden');
			$momBar.hide();
			$momOverlays.hide();
			$leftColumn.sortable('disable');
			$rightColumn.sortable('disable');
			$momBarContent.each(function () {
				$(this).removeAttr('contenteditable');
			});
			var left = [],
				right = [];
			$('.lcs-container .mom-module').each(function () {
				var data = $(this).data();
				if (data.title) {
					left.push(JSON.stringify({
						'title': data.title,
						'text': $(this).find('.mom-bar .mom-bar-content').text()
					}));
				}
			});
			$('.rcs-container .mom-module').each(function () {
				var data = $(this).data();
				if (data.title) {
					right.push(JSON.stringify({
						'title': data.title,
						'text': $(this).find('.mom-bar-content').text()
					}));
				}
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
				}
			});
		}, onDataSaved = function () {
			$mainContentContainer.stopThrobbing();
			console.info('saved');
		}, onScroll = function () {
			if ($(window).scrollTop() >= $mainContent.offset().top) {
				$momHeader.addClass('mom-fixed');
			} else {
				$momHeader.removeClass('mom-fixed');
			}
		}, onDiscard = function () {
			removeEmpty();
			$editMode.hide();
			$nonEditMode.show();
			$moms.removeClass('mom-hidden');
			$momBar.hide();
			$momOverlays.hide();
			$leftColumn.sortable('disable');
			$rightColumn.sortable('disable');
			$momBarContent.each(function () {
				$(this).removeAttr('contenteditable');
			});
			//TODO: restore default on changed
		}, addEmpty = function () {
			var $new = $(document.createElement('div')),
				$button = $(document.createElement('div'));
			$button.text('ADD');
			$button.addClass('new-btn');
			$new.append($button);
			$new.addClass('mom-module mom-add-module');

			$rightColumn.append($new);
			$leftColumn.append($new.clone());
		}, removeEmpty = function () {
			$('.mom-add-module').remove();
		};

	$editButton.on('click', onEdit);
	$saveButton.on('click', onSave);
	$discardButton.on('click', onDiscard);
	$deleteButton.on('click', function(){ $(this).parents('.mom-module').remove(); });
	$(window).on('scroll', onScroll);

})(window, jQuery);