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
        $moduleEditButton = $('.mom-edit-btn'),
        $moduleSaveButton = $('.mom-save-btn'),
        $moduleDiscardButton = $('.mom-discard-btn'),
		$editMode = $('.layout-mode'),
		$nonEditMode = $('.no-layout-mode'),
		$momOverlays = $('.mom-module .mom-overlay'),
		$momBar = $('.mom-module .mom-bar'),
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
			$leftColumn.sortable('enable').disableSelection();
			$rightColumn.sortable('enable').disableSelection();
		}, onSave = function () {
			removeEmpty();
			$editMode.hide();
			$nonEditMode.show();
			$mainContentContainer.startThrobbing();
			$moms.removeClass('mom-hidden');
			$momBar.hide();
			$momOverlays.hide();
			$leftColumn.sortable('disable').enableSelection();
			$rightColumn.sortable('disable').enableSelection();
			var left = [],
				right = [];
			$('.lcs-container .mom-module').each(function () {
				var title = $(this).data().title;
				if (title) {
					left.push(title);
				}
			});
			$('.rcs-container .mom-module').each(function () {
				var title = $(this).data().title;
				if (title) {
					right.push(title);
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
			$leftColumn.sortable('disable').enableSelection();
			$rightColumn.sortable('disable').enableSelection();
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