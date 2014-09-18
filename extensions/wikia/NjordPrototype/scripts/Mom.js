(function (window, $) {
	'use strict';

	$.fn.refresh = function() {
		var elems = $(this.selector);
		this.splice(0, this.length);
		this.push.apply( this, elems );
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
			$deleteButton.on('click', function(){ $(this).parents('.mom-module').remove(); });
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
			$momBar.show();
			$momOverlays.show();
			var options = {
				cancel: '.mom-bar-content, .btn-group-right',
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
			$mainContent.startThrobbing();
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
			$deleteButton.on('click', function(){ $(this).parents('.mom-module').remove(); });
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
			$('#MomNewPlaceHolder').replaceWith(d);
			refresh();
			$moms.addClass('mom-hidden');
			$momBar.show();
			$momOverlays.show();
			$momBarContent.each(function () {
				$(this).attr('contenteditable', true);
			});
			$deleteButton.on('click', function(){ $(this).parents('.mom-module').remove(); });
			$mainContentContainer.stopThrobbing();
		}, refresh = function () {
			$deleteButton.refresh();
			$momOverlays.refresh();
			$momBar.refresh();
			$momBarContent.refresh();
			$moms.refresh();
		};

	if (window.wgUserName) {
		initMom();
	}
    $moduleEditButton.on('click', function(){
        var moduleContainer = $(this).parents('.mom-module');

        $.nirvana.sendRequest({
            controller: 'NjordController',
            method: 'getWikiMarkup',
            type: 'GET',
            data: {
                articleTitle: moduleContainer.attr('data-title')
            },
            callback: function(resp){
                $('.mom-save-btn', moduleContainer).show();
                $('.mom-discard-btn', moduleContainer).show();

                $('.mom-edit-btn', moduleContainer).hide();
                $('.mom-content', moduleContainer).hide();
                $('.mom-overlay', moduleContainer).hide();

                $('.wiki-markup', moduleContainer).val(resp['wikiMarkup']);
                $('.wiki-markup', moduleContainer).show();
            },
            onErrorCallback: function () {
                // TODO: handle failure
            }
        });
    });

    $moduleDiscardButton.on('click', function(){
        var moduleContainer = $(this).parents('.mom-module');

        $('.mom-save-btn', moduleContainer).hide();
        $('.mom-discard-btn', moduleContainer).hide();

        $('.mom-edit-btn', moduleContainer).show();
        $('.mom-overlay', moduleContainer).show();
        $('.mom-content', moduleContainer).show();

        $('.wiki-markup', moduleContainer).hide();
    });

    $moduleSaveButton.on('click', function(){
        var moduleContainer = $(this).parents('.mom-module');

        $.nirvana.sendRequest({
            controller: 'NjordController',
            method: 'MainPageModuleSave',
            type: 'POST',
            data: {
                pageTitle: moduleContainer.attr('data-title'),
                wikiMarkup: $('.wiki-markup', moduleContainer).val()
            },
            callback: function(resp){
                $('.mom-save-btn', moduleContainer).hide();
                $('.mom-discard-btn', moduleContainer).hide();

                $('.mom-edit-btn', moduleContainer).show();
                $('.mom-overlay', moduleContainer).show();
                $('.mom-content', moduleContainer).html(resp['html']);
                $('.mom-content', moduleContainer).show();

                $('.wiki-markup', moduleContainer).hide();
            },
            onErrorCallback: function () {
                // TODO: handle failure
            }
        });
    });

	$(window).on('scroll', onScroll);

})(window, jQuery);