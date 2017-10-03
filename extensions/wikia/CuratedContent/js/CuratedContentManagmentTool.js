/* global mw, wgScript */
/* jshint maxlen: false */
/* jshint loopfunc: false */
/* jshint camelcase: false */
'use strict';

require(
	['wikia.window', 'jquery', 'wikia.nirvana', 'wikia.tracker', 'JSMessages'],
	function (window, $, nirvana, tracker, msg)
{
	// usefull shortcuts
	$.fn.removeError = function () {
		return this.removeClass('error').popover('destroy');
	};

	$.fn.addError = function (message) {
		return this.addClass('error')
			.popover('destroy')
			.popover({content: message});
	};
	$.fn.findSelectorFromList = function(list, reason) {
		return this.find(list[reason] || list.default);
	};

	$(function () {
		mw.loader.using(['jquery.autocomplete', 'jquery.ui.sortable', 'wikia.aim', 'wikia.yui'], function () {

			var d = document,
				item = mw.config.get('itemTemplate'),
				section = mw.config.get('sectionTemplate'),
				duplicateError = msg('wikiacuratedcontent-content-duplicate-entry'),
				requiredError = msg('wikiacuratedcontent-content-required-entry'),
				emptySectionError = msg('wikiacuratedcontent-content-empty-section'),
				orphanError = msg('wikiacuratedcontent-content-orphaned-error'),
				articleNotFoundError = msg('wikiacuratedcontent-content-articlenotfound-error'),
				emptyLabelError = msg('wikiacuratedcontent-content-emptylabel-error'),
				tooLongLabelError = msg('wikiacuratedcontent-content-toolonglabel-error'),
				videoNotSupportedError = msg('wikiacuratedcontent-content-videonotsupported-error'),
				notSupportedType = msg('wikiacuratedcontent-content-notsupportedtype-error'),
				noCategoryInTag = msg('wikiacuratedcontent-content-nocategoryintag-error'),
				imageMissingError = msg('wikiacuratedcontent-content-imagemissing-error'),
				addItem = d.getElementById('addItem'),
				addSection = d.getElementById('addSection'),
				$save = $(d.getElementById('save')),
				form = d.getElementById('contentManagmentForm'),
				$form = $(form),
				ul = form.getElementsByTagName('ul')[0],
				$ul = $(ul),
				maxAllowedLength = 48, // it's derived from MAX_LABEL_LENGTH in CuratedContentSpecialController

				setup = function (elem) {
					(elem || $ul.find('.item-input')).autocomplete({
						serviceUrl: wgScript,
						params: {
							action: 'ajax',
							rs: 'getLinkSuggest',
							format: 'json'
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
					// validate form on init
					checkForm();
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

				/**
				 * Validate input elements
				 *
				 * @param {jQuery} elements
				 * @param {array} options array consists of ['required', 'limit', 'duplicates']
				 */
				checkInputs = function (elements, options) {
					var cachedVals = [],
						optionRequired, optionLimit, optionDuplicates;

					if (Array.isArray(options)) {
						optionRequired = options.indexOf('required') !== -1;
						optionLimit = options.indexOf('limit') !== -1;
						optionDuplicates = options.indexOf('duplicates') !== -1;
					}

					elements.each(function () {
						var val = this.value,
							$this = $(this);

						// check if field value is empty and it's required
						if (optionRequired && val === '') {
							$this.addError(requiredError);
						}
						// check if field value is too long
						if (optionLimit && val.length > maxAllowedLength) {
							$this.addError(tooLongLabelError);
						}
						if (optionDuplicates && val !== '') {
							// check if value already exists (in cachedVals variable)
							if (cachedVals.indexOf(val) === -1) {
								// not exists, add it to cachedVals
								cachedVals.push(val);
							} else {
								// if it exists and it's not empty it's duplication
								$this.addError(duplicateError);
							}
						}
					});
				},

				checkImages = function () {
					// find all images for items and sections except Featured Section and...
					$ul.find('.section:not(.featured), .item')
						.find('.image:not([style*="background-image"])')
						.addError(imageMissingError);
					// ...except Optional Section
					var $lastSection = $ul.find('.section').last().find('.section-input');
					if ($lastSection.val().length === 0) {
						$lastSection.parent().find('.image').removeError();
					}
				},

				checkForm = function () {
					$save.removeClass();

					// clear errors from all possible items / sections / images
					$ul.find('.section-input.error, .item-input.error, .name.error, .image.error').removeError();

					checkInputs($ul.find('.section-input'), ['limit', 'duplicates']);
					checkInputs($ul.find('.item-input'), ['required']);

					// check images for non-featured sections and items
					checkImages();

					// validate orphans
					$ul.find('.item:not(.section ~ .item)').addError(orphanError);

					$ul.find('.section').each(function () {
						var $t = $(this),
							$items = $t.nextUntil('.section');

						if ($items.length === 0 && !$t.hasClass('featured')) {
							$t.find('.section-input').addError(emptySectionError);
						} else {
							checkInputs($items.find('.name'), ['limit']);
						}
					});

					// validate duplicates in featured items
					checkInputs($ul.find('.featured').nextUntil('.section').find('.name'), ['duplicates']);
					// check for duplicated in items
					checkInputs($ul.find('.section:not(.featured)').first().nextAll().find('.name'), ['duplicates']);

					if (d.getElementsByClassName('error').length > 0) {
						$save.attr('disabled', true);
						return false;
					} else {
						$save.attr('disabled', false);
						return true;
					}
				},

				track = tracker.buildTrackingFunction({
					action: Wikia.Tracker.ACTIONS.CLICK,
					category: 'special-curated-content',
					trackingMethod: 'analytics'
				}),

				onImageLoadFail = function ($image) {
					$image
						.addError(imageMissingError)
						.css('backgroundImage', '')
						.data('id', 0)
						.removeAttr('data-id');

					$image.stopThrobbing();
					checkForm();
				},

				loadImage = function ($image, imgTitle, catImage) {
					$image.startThrobbing();

					nirvana.getJson(
						'CuratedContent',
						'getImage',
						{
							title: imgTitle
						}
					).done(
						function (data) {
							if (data.url && data.id) {
								$image
									.removeError()
									.css('backgroundImage', 'url(' + data.url + ')')
									.data('id', data.id)
									.attr('data-id', data.id)
									.data('crop', '')
									.removeAttr('data-crop');

								if (!catImage) {
									$image.siblings().last().addClass('photo-remove');
								}

								$image.stopThrobbing();
								checkForm();
							} else {
								onImageLoadFail($image);
							}
						}
					).fail(function () {
							onImageLoadFail($image);
						});
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
					var val = $.trim(this.value),
						self = this,
						$imageForSection = $(this).parent().find('.image');

					if (this.className === 'item-input') {
						val = val.replace(/ /g, '_');
						this.value = val;
						//If element doesn't have background image - load one from category
						if (!$imageForSection[0].matches('[style*="background-image"]')) {
							// This has to happen inside setTimeout because updating value from autocomplete
							// happens after blur event so value passed to loadImage is wrong.
							// With setTimeout we are waiting for correct value to appear inside input
							setTimeout(function () {
								loadImage($imageForSection, $(self).val());
							}, 500);
						}
						checkForm();
					} else {
						this.value = val;
						checkForm();
					}
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
				}).keyup(function () {
					setTimeout(checkForm, 0);
				});

			$(addItem).on('click', function () {
				addNew(item);
			});

			$(addSection).on('click', function () {
				addNew(section);
			});

			function getItemData(li) {
				var $lia = $(li);
				return {
					title: $lia.find('.item-input').val(),
					label: $lia.find('.name').val(),
					image_id: $lia.find('.image').data('id') || 0,
					image_crop: $lia.find('.image').data('crop') || ''
				};
			}

			function getSectionData(li) {
				var $lia = $(li),
					name = $lia.find('.section-input').val() || '',
					imageId = $lia.find('.image').data('id') || 0,
					imageCrop = $lia.find('.image').data('crop') || '',
					featured = $lia.hasClass('featured') || false,
					items = [],
					result;

				$lia.nextUntil('.section').each(function () {
					items.push(getItemData(this));
				});

				result = {
					title: name,
					image_id: imageId,
					image_crop: imageCrop,
					items: items
				};

				if (featured) {
					result.featured = true;
				}

				return result;
			}

			function gerErrorMessageFromErrReason(errReason) {
				if (errReason === 'articleNotFound') {
					return articleNotFoundError;
				}
				if (errReason === 'emptyLabel') {
					return emptyLabelError;
				}
				if (errReason === 'tooLongLabel') {
					return tooLongLabelError;
				}
				if (errReason === 'videoNotSupportProvider') {
					return videoNotSupportedError;
				}
				if (errReason === 'notSupportedType') {
					return notSupportedType;
				}
				if (errReason === 'noCategoryInTag') {
					return noCategoryInTag;
				}
				if (errReason === 'imageMissing') {
					return imageMissingError;
				}
				if (errReason === 'duplicatedLabel') {
					return duplicateError;
				}
				return errReason;
			}
			function addErrorToItem($selector, reason, message) {
				$selector.findSelectorFromList({
						imageMissing: '.image',
						emptyLabel: '.name',
						duplicatedLabel: '.name',
						tooLongLabel: '.name',
						default: '.item-input'
					}, reason).addError(message);
			}
			function addErrorToSection($selector, reason, message) {
				$selector.findSelectorFromList({
					imageMissing: '.image',
					default: '.section-input'
				}, reason).addError(message);
			}
			function isFeaturedItem($node) {
				return $node.closest('li').prevUntil('.section').prev().last().hasClass('featured');
			}
			function iterateItemsForErrors($nodes, err, message) {
				var errLabel = err.target;

				if (err.type === 'item' ) {
					$nodes.each(function () {
						var $this = $(this);
						// label for items is held in .name
						if ($this.find('.name').val() === errLabel && !isFeaturedItem($this)) {
							addErrorToItem($this, err.reason, message);
						}
					});
				} else if (err.type === 'featured') {
					$nodes.each(function () {
						var $this = $(this);
						// label for items is held in .name
						if ($this.find('.name').val() === errLabel && isFeaturedItem($this)) {
							addErrorToItem($this, err.reason, message);
						}
					});
				}
			}
			function iterateSectionsForErrors($nodes, err, message) {
				var errLabel = err.target;

				if (err.type === 'section') {
					$nodes.each(function () {
						var $this = $(this);
						// label for items is held in .name
						if ($this.find('.section-input').val() === errLabel) {
							addErrorToSection($this, err.reason, message);
						}
					});
				}

			}

			window._gaq.push(['_setSampleRate', '100']);

			$save.on('click', function () {
				var data = [],
					orphans = [];

				if (checkForm()) {
					$ul.find('.item:not(.section ~ .item)').each(function () {
						orphans.push(getItemData(this));
					});

					$ul.find('.section').each(function () {
						var sectionData = getSectionData(this);
						if (orphans.length > 0) {
							// adopts the orphans to the top of topmost section
							// since that what probably orphaned them in the first place
							sectionData.items = sectionData.items.reduce(function (self, item) {
								self.push(item);
								return self;
							}, orphans);
							orphans = [];
						}
						data.push(sectionData);
					});

					nirvana.sendRequest({
						controller: 'CuratedContentSpecial',
						method: 'save',
						data: {
							sections: data
						}
					}).done(function (data) {
						var $featuredItems = $ul.find('.featured').nextUntil('.section'),
							$items = $ul.find('.section:not(.featured)').first().nextAll(),
							$sections = $ul.find('.section:not(.featured)');

						if (data.error) {
							[].forEach.call(data.error, function (err) {
								// err := { target: <label>, type: [item,section,featured], reason: <error> }
								var message = gerErrorMessageFromErrReason(err.reason);

								iterateItemsForErrors($items, err, message);
								iterateItemsForErrors($featuredItems, err, message);
								iterateSectionsForErrors($sections, err, message);
							});

							$save.addClass('err');
							$save.attr('disabled', true);
							track({label: 'save-error'});
						} else if (data.status) {
							$save.addClass('ok');
							track({label: 'save'});
						}
					}).fail(function () {
						$save.addClass('err');
						track({label: 'save-error'});
					}).then(function () {
						$form.stopThrobbing();
					});
				}
			});

			$form.
				on('click', '.photo-remove', function () {
					var $this = $(this),
						$line = $this.parent(),
						$image = $line
							.find('.image')
							.data('id', 0)
							.removeAttr('data-id')
							.data('crop', '')
							.removeAttr('data-crop');

					$this.removeClass('photo-remove');
					loadImage($image, $line.find('.item-input').val(), true);
				})
				.on('click', '.photo:not(.photo-remove), .image', function () {
					var $image = $(this).parent().find('.image');

					$(window).one('WMU_addFromSpecialPage', function (event, wmuData) {
						loadImage($image, wmuData.imageTitle);
					});

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
				items: 'li:not(.sort-disabled)',
				placeholder: 'drop',
				update: function () {
					checkForm();
				}
			});

			setup();
		});
	});
});
