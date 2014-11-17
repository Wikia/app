/* global wgNamespaceIds, wgFormattedNamespaces, mw, wgServer, wgScript */
$(function () {
	require(['wikia.window', 'jquery', 'wikia.nirvana', 'JSMessages'], function (window, $, nirvana, msg) {
		'use strict';

		var d = document,
			item = mw.config.get('itemTemplate'),
			section = mw.config.get('sectionTemplate'),
			duplicateError = msg('wikiacuratedcontent-content-duplicate-entry'),
			requiredError = msg('wikiacuratedcontent-content-required-entry'),
			emptySectionError = msg('wikiacuratedcontent-content-empty-section'),
			itemError = msg('wikiacuratedcontent-content-item-error'),
			articleNotFoundError = msg('wikiacuratedcontent-content-articlenotfound-error'),
			emptyLabelError = msg('wikiacuratedcontent-content-emptylabel-error'),
			videoNotSupportedError = msg('wikiacuratedcontent-content-videonotsupported-error'),
			notSupportedType = msg('wikiacuratedcontent-content-notsupportedtype-error'),
			addItem = d.getElementById('addItem'),
			addSection = d.getElementById('addSection'),
			$save = $(d.getElementById('save')),
			form = d.getElementById('contentManagmentForm'),
			$form = $(form),
			ul = form.getElementsByTagName('ul')[0],
			$ul = $(ul),
		//it looks better if we display in input item name without Item:

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

				checkInputs($ul.find('.section-input'), true);
				checkInputs($ul.find('.item-input'), true, true);

				$ul.find('.section').each(function () {
					var $t = $(this),
						$items = $t.nextUntil('.section');

					if ($items.length === 0) {
						$t.find('.section-input')
							.addClass('error')
							.popover('destroy')
							.popover({
								content: emptySectionError
							});
					} else {
						checkInputs($items.find('.name'))
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
				if (ev.keyCode === 13) {
					addNew(item, $(this).parent());
				}
			})
			.on('keypress', '.item-input, .section-input', function (ev) {
				if (ev.keyCode === 13) {
					$(this).next().focus();
				}
			}).keydown(function(ev){
				setTimeout(checkForm, 0);
			});

		$(addItem).on('click', function () {
			addNew(item);
		});

		$(addSection).on('click', function () {
			addNew(section);
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
				nonames = [];

			if (checkForm()) {
				$ul.find('.item:not(.section ~ .item)').each(function () {
					nonames.push(getData(this));
				});

				$ul.find('.section').each(function () {
					var $t = $(this),
						name = $t.find('.section-input').val(),
						imageId = $t.find('.image').data('id') || 0,
						items = [];

					$t.nextUntil('.section').each(function () {
						items.push(getData(this));
					});

					if (name) {
						data.push({
							title: name,
							image_id: imageId,
							items: items
						});
					} else {
						data.push({
							title: '',
							image_id: imageId,
							items: items.concat(nonames) //append orphaned entries at the end of no name category
						});
						nonames = []; // we already added orphans so lets remove them from existence
					}
				});
				nirvana.sendRequest({
					controller: 'CuratedContentSpecial',
					method: 'save',
					data: {
						sections: data
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
								items = $form.find('.item-input');
							while (i--) {
								//I cannot use value CSS selector as I want to use current value
								var errTitle = err[i].title;
								var errReason = err[i].reason;
								var reasonMessage = getReasonMessage(errReason);
								items.each(function () {

									if (this.value === errTitle) {
										if (errReason != 'emptyLabel') {
											$(this)
												.addClass('error')
												.popover('destroy')
												.popover({
													content: reasonMessage
												});
										} else {
											$(this).next()
												.addClass('error')
												.popover('destroy')
												.popover({
													content: reasonMessage
												});
										}

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
