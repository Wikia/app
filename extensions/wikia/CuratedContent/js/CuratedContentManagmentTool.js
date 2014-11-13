/* global wgNamespaceIds, wgFormattedNamespaces, mw, wgServer, wgScript */
$(function () {
	require(['wikia.window', 'jquery', 'wikia.nirvana', 'JSMessages'], function (window, $, nirvana, msg) {
		'use strict';

		var d = document,
			item = mw.config.get('itemTemplate'),
			tag = mw.config.get('tagTemplate'),
			duplicateError = msg('wikiaCuratedContent-content-duplicate-entry'),
			requiredError = msg('wikiaCuratedContent-content-required-entry'),
			emptyTagError = msg('wikiaCuratedContent-content-empty-section'),
			itemError = msg('wikiaCuratedContent-content-item-error'),
			articleNotFoundError = msg('wikiaCuratedContent-content-articlenotfound-error'),
			emptyLabelError = msg('wikiaCuratedContent-content-emptylabel-error'),
			videoNotSupportedError = msg('wikiaCuratedContent-content-videonotsupported-error'),
			notSupportedType = msg('wikiaCuratedContent-content-notsupportedtype-error'),
			addItem = d.getElementById('addItem'),
			addTag = d.getElementById('addTag'),
			$save = $(d.getElementById('save')),
			form = d.getElementById('contentManagmentForm'),
			$form = $(form),
			ul = form.getElementsByTagName('ul')[0],
			$ul = $(ul),
		//it looks better if we display in input item name without Item:
			categoryId = wgNamespaceIds.category,
			categoryName = wgFormattedNamespaces[categoryId] + ':',
			setup = function (elem) {
				(elem || $ul.find('.item-input')).autocomplete({
					serviceUrl: wgServer + wgScript,
					params: {
						action: 'ajax',
						rs: 'getLinkSuggest',
						format: 'json'
						//ns: categoryId
					},
					appendTo: form,
					onSelect: function () {
						$ul.find('input:focus').next().focus();
					},
					fnPreprocessResults: function (data) {
						var suggestions = data.suggestions,
							suggestion,
							l = suggestions.length,
							i = 0;

						//for(; i < l; i++) {
						//	suggestion = suggestions[i];
						//	//get rid of non categories suggestions
						//	//and 'Category:' part of suggestion
						//	if(suggestion.indexOf(categoryName) > -1) {
						//		suggestions[i] = suggestion.replace(categoryName, '');
						//	}else{
						//		delete suggestions[i];
						//	}
						//}

						data.suggestions = suggestions;
						return data;
					},
					deferRequestBy: 50,
					minLength: 3,
					skipBadQueries: true // BugId:4625 - always send the request even if previous one returned no suggestions
				});
			},
			addNew = function (row, elem) {
				var cat;

				if (elem) {
					elem.after(row);
					cat = elem.next().find('.item-input');
				} else {
					$ul.append(row);
					cat = $ul.find('.item-input:last');
				}

				setup(cat);
				cat.focus();

				$ul.sortable('refresh');
			},
			checkInputs = function (elements, checkEmpty, required) {
				var names = [];

				elements.each(function () {
					var val = this.value,
						$this = $(this);

					if (required && val === '') {
						$this
							.addClass('error')
							.popover('destroy')
							.popover({
								content: requiredError
							});
					} else if (!~names.indexOf(val)) {
						names.push(val);

						$this
							.removeClass('error')
							.popover('destroy');

					} else if (checkEmpty || val !== '') {
						$this
							.addClass('error')
							.popover('destroy')
							.popover({
								content: duplicateError
							});
					}
				});
			},
			checkForm = function () {

				$save.removeClass();

				checkInputs($ul.find('.tag-input'), true);
				checkInputs($ul.find('.item-input'), true, true);

				$ul.find('.tag').each(function () {
					var $t = $(this),
						$categories = $t.nextUntil('.tag');

					if ($categories.length === 0) {
						$t.find('.tag-input')
							.addClass('error')
							.popover('destroy')
							.popover({
								content: emptyTagError
							});
					} else {
						checkInputs($categories.find('.name'))
					}
				});

				if (d.getElementsByClassName('error').length > 0) {
					$save.attr('disabled', true);
					return false;
				} else {
					$save.attr('disabled', false);
					return true;
				}
			};

		$form
			.on('focus', 'input', function () {
				checkForm();
			})
			.on('click', '.remove', function () {
				ul.removeChild(this.parentElement);
				checkForm();
			})
			.on('blur', 'input', function () {
				var val = $.trim(this.value);

				if (this.className == 'item-input') {
					val = val.replace(/ /g, '_');
				}

				this.value = val;

				checkForm();
			})
			.on('keypress', '.name', function (ev) {
				if (ev.keyCode === 13) addNew(item, $(this).parent());
			})
			.on('keypress', '.item-input, .tag-input', function (ev) {
				if (ev.keyCode === 13) $(this).next().focus();
			});

		$(addItem).on('click', function () {
			addNew(item);
		});

		$(addTag).on('click', function () {
			addNew(tag);
		});

		function getData(li) {
			var $lia = $(li);
			return {
				title: $lia.find('.item-input').val(),
				label: $lia.find('.name').val(),
				image_id: $lia.find('.image').data('id') || 0
			}
		}

		$save.on('click', function () {
			var data = [],
				nonames = [],
				nonameId = 0;

			if (checkForm()) {
				$ul.find('.item:not(.tag ~ .item)').each(function () {
					nonames.push(getData(this));
				});

				$ul.find('.tag').each(function () {
					var $t = $(this),
						name = $t.find('.tag-input').val(),
						imageId = $t.find('.image').data('id') || 0,
						categories = [];

					$t.nextUntil('.tag').each(function () {
						(name ? categories : nonames).push(getData(this));
					});

					if (name) {
						data.push({
							title: name,
							image_id: imageId,
							categories: categories
						});
					} else {
						nonameId = imageId;
					}
				});

				if (nonames.length > 0) {
					data.push({
						title: '',
						image_id: nonameId || 0,
						categories: nonames
					});
				}

				$save.removeClass();
				$form.startThrobbing();

				nirvana.sendRequest({
					controller: 'CuratedContentSpecial',
					method: 'save',
					data: {
						tags: data
					}
				}).done(
					function (data) {
						function getReasonMessage(errReason) {
							if (errReason === 'articleNotFound') {
								return articleNotFoundError;
							}
							if (errReason === 'emptyLabel') {
								return emptyLabelError;
							}
							if (errReason === 'videoNotSupportProvider') {
								return videoNotSupportedError;
							}
							if (errReason === 'notSupportedType') {
								return notSupportedType;
							}
							return errReason;
						}

						if (data.error) {
							var err = data.error,
								i = err.length,
								categories = $form.find('.item-input');

							while (i--) {
								//I cannot use value CSS selector as I want to use current value
								var errTitle = err[i].title;
								var errReason = err[i].reason;
								var reasonMessage = getReasonMessage(errReason);
								categories.each(function () {

									if (this.value === errTitle) {
										$(this)
											.addClass('error')
											.popover('destroy')
											.popover({
												content: reasonMessage
											});

										return false;
									}
									return true;
								});
							}

							$save.addClass('err');
							$save.attr('disabled', true);
						} else if (data.status) {
							$save.addClass('ok');
						}
					}).fail(
					function () {
						$save.addClass('err');
					}
				).then(function () {
						$form.stopThrobbing();
					});
			}
		});

		//be sure modules are ready to be used
		mw.loader.using(['jquery.autocomplete', 'jquery.ui.sortable', 'wikia.aim', 'wikia.yui'], function () {
			var $currentImage;

			function onFail() {
				$currentImage
					.css('backgroundImage', '')
					.removeAttr('data-id');

				$currentImage.stopThrobbing();
			}

			function loadImage(imgTitle, catImage) {
				$currentImage.startThrobbing();

				nirvana.getJson(
					'CuratedContentSpecial',
					'getImage',
					{
						file: imgTitle
					}
				).done(
					function (data) {
						if (data.url && data.id) {
							$currentImage.css('backgroundImage', 'url(' + data.url + ')')

							if (!catImage) {
								$currentImage.attr('data-id', data.id);
								$currentImage.siblings().last().addClass('photo-remove');
							}
							;

							$currentImage.stopThrobbing();
						} else {
							onFail();
						}
					}
				).fail(onFail);
			}

			$(window).bind('WMU_addFromSpecialPage', function (event, wmuData) {
				loadImage(wmuData.imageTitle);
			});

			$form.
				on('click', '.photo-remove', function () {
					var $this = $(this),
						$line = $this.parent();

					$currentImage = $line.find('.image');
					$currentImage.removeAttr('data-id');

					$this.removeClass('photo-remove');

					loadImage(wgFormattedNamespaces[wgNamespaceIds.category] + ':' + $line.find('.item-input').val(), true);
				})
				.on('click', '.photo:not(.photo-remove), .image', function () {
					$currentImage = $(this).parent().find('.image');

					window.WMU_skipDetails = true;
					window.WMU_show();
					window.WMU_openedInEditor = false;
				});

			$ul.sortable({
				opacity: 0.5,
				axis: 'y',
				containment: '#contentManagmentForm',
				cursor: 'move',
				handle: '.drag',
				placeholder: 'drop',
				update: function () {
					checkForm();
				}
			});

			setup();
		});
	});
});