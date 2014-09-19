(function (window, $) {
	'use strict';

	$.fn.refresh = function () {
		var elems = $(this.selector);
		this.splice(0, this.length);
		this.push.apply(this, elems);
		return this;
	};
	var
		$mwContent = $('#mw-content-text'),
		$clonedMain = null,
		$mainContentContainer = $('#WikiaMainContentContainer'),
		$mainContent = $('#WikiaMainContent'),
		$momHeader = $('#MomHeader'),
		$editButton = $('#MomHeader .layout-edit-btn'),
		$saveButton = $('#MomHeader .layout-save-btn'),
		$discardButton = $('#MomHeader .layout-cancel-btn'),
		$deleteButton = $('.mom-delete-btn'),
		$moduleEditButton = $('.mom-edit-btn'),
		$moduleSaveButton = $('.mom-save-btn'),
		$moduleDiscardButton = $('.mom-discard-btn'),
		$editMode = $('.layout-mode'),
		$nonEditMode = $('.no-layout-mode'),
		$momOverlays = $('.mom-module .mom-overlay'),
		$momBar = $('.mom-module .mom-bar'),
		$momBarContent = $('.mom-bar .mom-bar-content'),
		$moms = $('.mom-module'),
		$leftColumn = $('.lcs-container'),
		$rightColumn = $('.rcs-container'),
		initMom = function () {
			$momHeader.show();
			$editButton.on('click', onEdit);
			$saveButton.on('click', onSave);
			$discardButton.on('click', onDiscard);
			$deleteButton.on('click', function () {
				$(this).parents('.mom-module').remove();
			});
			$(window).on('scroll', onScroll);
		}, onEdit = function () {
			$clonedMain = $mwContent.clone(true, true);
			$('html, body').animate({
				scrollTop: $momHeader.offset().top - 2
			}, 600);
			addEmpty();
			$moms.addClass('mom-hidden');
			$editMode.show();
			$nonEditMode.hide();
			$momBar.css('display', 'flex');
			$momOverlays.show();
			var options = {
				cancel: '.mom-bar-content, .btn-group-right',
				handle: '.mom-bar',
				helper: 'clone',
				items: '.mom-module-left, .mom-module-right',
				placeholder: 'mom-add-module',
				tolerance: 'pointer',
				over: function (e, ui) {
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
			$mainContent.startThrobbing();
			$moms.removeClass('mom-hidden');
			$moms.removeClass('mom-edit');
			$momBar.css('display', 'none');
			$momOverlays.hide();
			$leftColumn.sortable('disable');
			$rightColumn.sortable('disable');
			$momBarContent.each(function () {
				$(this).removeAttr('contenteditable');
			});
			$('.mom-edit-btn').show();
			$('.mom-delete-btn').show();
			$('.mom-content').show();
			$('.mom-save-btn').hide();
			$('.mom-discard-btn').hide();
			$('.mom-wiki-markup').hide();
			var left = [],
				right = [];
			$('.lcs-container .mom-module').each(function () {
				var data = $(this).data();
				if (typeof data.title != 'undefined') {
					left.push(JSON.stringify({
						'title': data.title,
						'text': $(this).find('.mom-bar .mom-bar-content').text()
					}));
				}
			});
			$('.rcs-container .mom-module').each(function () {
				var data = $(this).data();
				if (typeof data.title != 'undefined') {
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
			$mainContent.stopThrobbing();
		}, onScroll = function () {
			if ($(window).scrollTop() >= $mainContent.offset().top) {
				$momHeader.addClass('mom-fixed');
			} else {
				$momHeader.removeClass('mom-fixed');
			}
		}, onDiscard = function () {
			$editMode.hide();
			$nonEditMode.show();
			$mwContent.replaceWith($clonedMain);
			$mwContent.refresh();
			$mainContent.refresh();
			$deleteButton.refresh();
			$momOverlays.refresh();
			$momBar.refresh();
			$momBarContent.refresh();
			$moms.refresh();
			$leftColumn.refresh();
			$rightColumn.refresh();
			$deleteButton.on('click', function () {
				$(this).parents('.mom-module').remove();
			});
			$('.mom-save-btn').hide();
			$('.mom-discard-btn').hide();
			$('.mom-wiki-markup').hide();
		}, addEmpty = function () {
			var $new = $(document.createElement('div')),
				$button = $(document.createElement('div'));
			$button.text('ADD');
			$button.addClass('add-btn new-btn');
			$new.addClass('mom-module mom-add-module');
			var $secButton = $button.clone(true),
				$secNew = $new.clone();
			$button.on('click', {align: 'right'}, addNewModule);
			$secButton.on('click', {align: 'left'}, addNewModule);

			$rightColumn.append($new.append($button));
			$leftColumn.append($secNew.append($secButton));
		}, removeEmpty = function () {
			$('.mom-add-module').remove();
		}, addNewModule = function (ev) {
			$mainContentContainer.startThrobbing();
			//add placeholder will be replace after loaded
			$('<div id="MomNewPlaceHolder" class="mom-no-display"></div>').insertBefore($(this).parent());
			$.nirvana.sendRequest({
				controller: 'NjordController',
				method: 'modula',
				format: 'HTML',
				type: 'GET',
				data: {
					align: ev.data.align,
					title: 'new'
				},
				callback: onAddNewBlock,
				onErrorCallback: function () {
					$mainContentContainer.stopThrobbing();
					// TODO: handle failure
				}
			});
		}, onAddNewBlock = function (d) {
			var $this = $(d);
			$('#MomNewPlaceHolder').replaceWith($this);
			refresh();
			$this.addClass('mom-hidden');
			$this.find('.mom-bar').css('display', 'flex');
			$this.find('.mom-overlay').show();
			$this.find('.mom-bar-content').attr('contenteditable', true);
			$this.find('.mom-delete-btn').on('click', function () {
				$(this).parents('.mom-module').remove();
			});
			$mainContentContainer.stopThrobbing();
		}, refresh = function () {
			$deleteButton.refresh();
			$momOverlays.refresh();
			$momBar.refresh();
			$momBarContent.refresh();
			$moms.refresh();
			$moduleEditButton.refresh();
			$moduleDiscardButton.refresh();
			$moduleSaveButton.refresh();
		};

	if (window.wgUserName) {
		initMom();
	}
	$mwContent.on('click', '.mom-edit-btn', function () {
		var $moduleContainer = $(this).parents('.mom-module');
		$moduleContainer.startThrobbing();

		$.nirvana.sendRequest({
			controller: 'NjordController',
			method: 'getWikiMarkup',
			type: 'GET',
			data: {
				articleTitle: $moduleContainer.attr('data-title')
			},
			callback: function (resp) {
				$moduleContainer.removeClass('mom-hidden');
				$moduleContainer.addClass('mom-edit');
				$('.mom-save-btn', $moduleContainer).show();
				$('.mom-discard-btn', $moduleContainer).show();

				$('.mom-edit-btn', $moduleContainer).hide();
				$('.mom-delete-btn', $moduleContainer).hide();
				$('.mom-content', $moduleContainer).hide();
				$('.mom-overlay', $moduleContainer).hide();

				$('.mom-wiki-markup .wiki-markup', $moduleContainer).val(resp['wikiMarkup']);
				$('.mom-wiki-markup', $moduleContainer).show();
				$moduleContainer.stopThrobbing();
			},
			onErrorCallback: function () {
				// TODO: handle failure
			}
		});
	});

	$mwContent.on('click', '.mom-discard-btn', function () {
		var $moduleContainer = $(this).parents('.mom-module');
		$moduleContainer.addClass('mom-hidden');
		$moduleContainer.removeClass('mom-edit');

		$('.mom-save-btn', $moduleContainer).hide();
		$('.mom-discard-btn', $moduleContainer).hide();

		$('.mom-edit-btn', $moduleContainer).show();
		$('.mom-delete-btn', $moduleContainer).show();
		$('.mom-overlay', $moduleContainer).show();
		$('.mom-content', $moduleContainer).show();

		$('.mom-wiki-markup', $moduleContainer).hide();
	});

	$mwContent.on('click', '.mom-save-btn', function () {
		var $moduleContainer = $(this).parents('.mom-module');
		$moduleContainer.startThrobbing();

		$.nirvana.sendRequest({
			controller: 'NjordController',
			method: 'MainPageModuleSave',
			type: 'POST',
			data: {
				pageTitle: $moduleContainer.attr('data-title'),
				wikiMarkup: $('.wiki-markup', $moduleContainer).val()
			},
			callback: function (resp) {
				$moduleContainer.addClass('mom-hidden');
				$moduleContainer.removeClass('mom-edit');

				$('.mom-save-btn', $moduleContainer).hide();
				$('.mom-discard-btn', $moduleContainer).hide();

				$('.mom-edit-btn', $moduleContainer).show();
				$('.mom-delete-btn', $moduleContainer).show();
				$('.mom-overlay', $moduleContainer).show();
				$('.mom-content', $moduleContainer).html(resp['html']);
				$('.mom-bar-info', $moduleContainer).html('content of this module might be outdated, refresh page for updated version');
				$('.mom-content', $moduleContainer).show();

				$('.mom-wiki-markup', $moduleContainer).hide();
				$moduleContainer.stopThrobbing();
			},
			onErrorCallback: function () {
				// TODO: handle failure
			}
		});
	});

})
	(window, jQuery);