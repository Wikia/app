require(
	['jquery', 'mw', 'wikia.nirvana', 'wikia.fluidlayout', 'wikia.window'],
	function($, mw, nirvana, fluidlayout, window) {
	'use strict';
	var ThemeDesigner = {
		slideByDefaultWidth: 760,
		slideByItems: 5,
		isSliding: false,
		// basePageOpacity used in calculating page-opacity setting
		basePageOpacity: 70,
		maxPageOpacity: 100,
		minSliderValue: 0,
		splitOption: true,
		$slider: null,

		init: function () {
			var that = this;
			// theme settings
			this.settings = window.themeSettings;
			this.standardizeSettingValues();

			// settings history
			this.history = window.themeHistory;

			// themes
			this.themes = window.themes;

			// Cashe selectors
			this.themeDesignerPicker = $('#ThemeDesignerPicker');
			this.previewFrame = $('#PreviewFrame');

			// min width for dynamic is equal to our breakpoint
			this.minWidthForDynamicBackground = fluidlayout.getBreakpointContent();
			// TODO: when using wikia.fluidlayout for minWidthForDynamicBackground, we need to add following variable to
			// wikia.fluidlayout and reference it here too.
			this.minWidthNotSplitBackground = 2000;

			this.backgroundType = 0;

			// handle navigation clicks - switching between tabs
			$('#Navigation a').click(that.navigationClick);

			// handle "Save" and "Cancel" button clicks
			$('#Toolbar').find('.save').click(that.saveClick)
				.end().find('.cancel').click(that.cancelClick);


			this.checkBgImageIsSet();

			// init tabs
			this.initSwatches();
			this.themeTabInit();
			this.customizeTabInit();
			this.wordmarkTabInit();

			// click appropriate tab based on the settings
			if (this.settings.theme === 'custom') {
				$('#Navigation [rel="CustomizeTab"]').click();
			} else {
				$('#Navigation [rel="ThemeTab"]').click();
			}

			// init Tool Bar
			this.toolBarInit();

			this.applySettings(false, false);

			// init tooltips
			this.initTooltips();

			// iframe resizing
			$(window).resize($.proxy(this.resizeIframe, this)).resize();
		},

		standardizeSettingValues: function () {
			ThemeDesigner.settings['background-dynamic'] = ThemeDesigner.settings['background-dynamic'].toString();
			ThemeDesigner.settings['background-fixed'] = ThemeDesigner.settings['background-fixed'].toString();
			ThemeDesigner.settings['background-tiled'] = ThemeDesigner.settings['background-tiled'].toString();

			if (ThemeDesigner.settings['background-image'] === false) {
				ThemeDesigner.settings['background-image'] = '';
			}
		},

		initTooltips: function () {
			var tooltipTimeout = 0;

			function setTooltipTimeout(elem) {
				tooltipTimeout = setTimeout(function () {
					elem.tooltip('hide');
				}, 300);
			}

			// This tooltip will not go away if you hover inside the tooltip
			$('.form-questionmark').tooltip({
				trigger: 'manual',
				placement: 'right'
			}).on('mouseenter', function () {
				clearTimeout(tooltipTimeout);
				$(this).tooltip('show');
			}).on('mouseleave', function () {
				var $this = $(this);
				setTooltipTimeout($this);
				$('.tooltip').mouseenter(function () {
					clearTimeout(tooltipTimeout);
				}).mouseleave(function () {
					setTooltipTimeout($this);
				});
			});

		},

		themeTabInit: function () {
			var slideBy = ThemeDesigner.slideByDefaultWidth,
				slideMax = -Math.floor($('#ThemeTab').find('.slider').find('ul').find('li').length /
					ThemeDesigner.slideByItems) * ThemeDesigner.slideByDefaultWidth;

			// click handler for next and previous arrows in theme slider
			$('#ThemeTab .previous, #ThemeTab .next').click(function (event) {
				event.preventDefault();
				if (!ThemeDesigner.isSliding) {
					var list = $('#ThemeTab .slider ul'),
						arrow = $(this),
						slideTo = null;

					// prevent disabled clicks
					if (arrow.hasClass('disabled')) {
						return;
					}

					ThemeDesigner.isSliding = true;
					// slide
					if (arrow.hasClass('previous')) {
						slideTo = parseInt(list.css('margin-left'), 10) + slideBy;
					} else {
						slideTo = parseInt(list.css('margin-left'), 10) - slideBy;
					}
					list.animate({
						marginLeft: slideTo
					}, 'slow', function () {
						ThemeDesigner.isSliding = false;
					});

					// calculate which buttons should be enabled
					if (slideTo === slideMax) {
						$('#ThemeTab .next').addClass('disabled');
						$('#ThemeTab .previous').removeClass('disabled');
					} else if (slideTo === 0) {
						$('#ThemeTab .next').removeClass('disabled');
						$('#ThemeTab .previous').addClass('disabled');
					} else {
						$('#ThemeTab .next, #ThemeTab .previous').removeClass('disabled');
					}
				}
			});

			// click handler for themes thumbnails
			$('#ThemeTab').find('.slider').find('li').click(function () {
				var targetObject = $(this);

				// highlight selected theme
				targetObject.parent().find('.selected').removeClass('selected').end().end().addClass('selected');

				ThemeDesigner.set('theme', targetObject.attr('data-theme'));
				if (ThemeDesigner.checkBgImageIsSet()) {
					ThemeDesigner.loadImage(ThemeDesigner.settings['background-image']);
				} else {
					ThemeDesigner.checkBgIsDynamic(0);
				}
				ThemeDesigner.resetPageOpacity();
			});

			// select current theme
			$('#ThemeTab').find('[data-theme=' + ThemeDesigner.settings.theme + ']').addClass('selected');
		},

		customizeTabInit: function () {
			$('#CustomizeTab').find('li').find('img[id*="color"]').click(function (event) {
				ThemeDesigner.showPicker(event, 'color');
			});
			$('#swatch-image-background').click(function (event) {
				ThemeDesigner.showPicker(event, 'image');
			});

			$('#tile-background').change(function () {
				ThemeDesigner.checkTiledBg(ThemeDesigner.splitOption);
				ThemeDesigner.set('background-tiled', $(this).attr('checked') ? 'true' : 'false');
			});
			$('#fix-background').change(function () {
				ThemeDesigner.set('background-fixed', $(this).attr('checked') ? 'true' : 'false');
			});

			$('#tile-background').attr('checked', ThemeDesigner.settings['background-tiled'] === 'true');
			$('#fix-background').attr('checked', ThemeDesigner.settings['background-fixed'] === 'true');

			// TODO: Remove IF statement after fluid layout global release
			if (window.wgOasisResponsive || window.wgOasisBreakpoints) {
				$('#not-split-background').change(function () {
					ThemeDesigner.set('background-dynamic', $(this).attr('checked') ? 'false' : 'true');
					if ($(this).attr('checked')) {
						ThemeDesigner.splitOption = false;
					} else {
						ThemeDesigner.splitOption = true;
					}
				});

				$('#not-split-background').attr('checked', ThemeDesigner.settings['background-dynamic'] === 'false');

				ThemeDesigner.middleColorSelect(ThemeDesigner.settings['background-dynamic'] === 'true');
				ThemeDesigner.checkBgIsDynamic(
					ThemeDesigner.settings['background-image-width'],
					ThemeDesigner.settings['background-dynamic'] === 'true'
				);

				ThemeDesigner.setSplitOption();
			}

			// submit handler for uploading custom background image
			$('#BackgroundImageForm').submit(function () {
				$.AIM.submit(this, ThemeDesigner.backgroundImageUploadCallback);
			});

			var currentVal = ThemeDesigner.settings['page-opacity'],
				base = ThemeDesigner.basePageOpacity,
				max = ThemeDesigner.maxPageOpacity;
			ThemeDesigner.$slider = $('#OpacitySlider').slider({
				value: max - ((base - currentVal) * (max / (base - max))),
				stop: function (e, ui) {
					ThemeDesigner.set('page-opacity', max - Math.round((ui.value / max) * (max - base)));
				}
			});
		},

		wordmarkTabInit: function () {
			// handle font family and font size menu change
			$('#wordmark-font').change(function () {
				ThemeDesigner.set('wordmark-font', $(this).val());
			});
			$('#wordmark-size').change(function () {
				ThemeDesigner.set('wordmark-font-size', $(this).val());
			});

			// handle wordmark editing
			$('#wordmark-edit').find('button').click(function (event) {
				event.preventDefault();
				var value = $('#wordmark-edit').find('input[type="text"]').val().trim();
				if (value.length > 0) {

					if (value.length > 50) {
						value = value.substr(0, 50);
					}

					ThemeDesigner.set('wordmark-text', value);
				} else {
					$.getMessages('ThemeDesigner', function () {
						window.alert($.msg('themedesigner-wordmark-preview-error'));
					});
				}

			});

			//graphic wordmark clicking
			$('#WordmarkTab').find('.graphic').find('.preview').find('.wordmark').click(function () {
				ThemeDesigner.set('wordmark-type', 'graphic');
			});

			//grapic wordmark button
			$('#WordmarkTab').find('.graphic').find('.preview').find('a').click(function (event) {
				event.preventDefault();
				ThemeDesigner.set('wordmark-type', 'text');
				ThemeDesigner.set('wordmark-image-url', window.wgBlankImgUrl);

				// Can't use js to clear file input value so reseting form
				$('#WordMarkUploadForm')[0].reset();
			});

			// submit handler for uploading custom logo image
			$('#WordMarkUploadForm').submit(function () {
				$.AIM.submit(this, ThemeDesigner.wordmarkUploadCallback);
			});

			//remove favicon link
			$('#WordmarkTab').find('.favicon').find('.preview').find('a').click(function (event) {
				event.preventDefault();
				ThemeDesigner.set('favicon-image-url', window.wgBlankImgUrl);

				// Can't use js to clear file input value so reseting form
				$('#FaviconUploadForm')[0].reset();
			});

			// submit handler for uploading favicon image
			$('#FaviconUploadForm').submit(function () {
				$.AIM.submit(this, ThemeDesigner.faviconUploadCallback);
			});
		},

		wordmarkShield: function () {
			var shield = $('#wordmark-shield'),
				parent;

			if (ThemeDesigner.settings['wordmark-type'] === 'graphic') {
				parent = shield.parent();

				shield
					.css({
						height: parent.outerHeight(true),
						width: parent.outerWidth(true)
					})
					.show();
			} else {
				shield.hide();
			}
		},

		toolBarInit: function () {
			$('#Toolbar .history')
				.click(function () {
					$(this).find('ul').show();
				})
				.find('ul').mouseleave(function () {
					$(this).hide();
				})
				.find('li').click(ThemeDesigner.revertToPreviousTheme);
		},

		showPicker: function (event, type) {
			ThemeDesigner.hidePicker();
			event.stopPropagation();
			var swatch = $(event.currentTarget),
				swatchName = event.currentTarget.className,
				swatches,
				duplicate,
				swatchNodes,
				expression,
				i;

			// check the type (color or image)
			if (type === 'color') {

				//add swatches from array
				swatchNodes = '';
				for (i = 0; i < ThemeDesigner.swatches[swatchName].length; i++) {
					swatchNodes += '<li style="background-color: #' + ThemeDesigner.swatches[swatchName][i] + ';"></li>';
				}
				this.themeDesignerPicker.children('.color').find('.swatches').append(swatchNodes);

				//add user color if different than swatches
				swatches = this.themeDesignerPicker.children('.color').find('.swatches');
				duplicate = false;

				swatches.find('li').each(function () {
					if (swatch.css('background-color') === $(this).css('background-color')) {
						duplicate = true;
						return false;
					}
				});

				if (!duplicate) {
					swatches.append('<li class="user" style="background-color: ' +
						swatch.css('background-color') + '"></li>');
				}

				// handle swatch clicking
				swatches.find('li').click(function () {
					ThemeDesigner.hidePicker();
					ThemeDesigner.set(swatchName, ThemeDesigner.rgb2hex($(this).css('background-color')));
					ThemeDesigner.set('theme', 'custom');
				});

				//handle custom colors
				$('#ColorNameForm').submit(function (event) {
					event.preventDefault();

					var color = $.trim($('#color-name').val().toLowerCase());

					// was anything submitted?
					if (color === '' || color === $('#color-name').attr('placeholder')) {
						return;
					}

					// RT:70673 trim string
					//color = $.trim(color);

					// add hash if needed
					expression = /^[0-9a-f]{3,6}/i;
					if (expression.test(color)) {
						color = '#' + color;
					}

					// test color
					$('<div id="ColorTester"></div>').appendTo(document.body);
					try {
						$('#ColorTester').css('background-color', color);
					} catch (error) {

					}
					if ($('#ColorTester').css('background-color') === 'transparent' ||
						$('#ColorTester').css('background-color') === 'rgba(0, 0, 0, 0)') {
						return;
					}
					$('#ColorTester').remove();

					ThemeDesigner.hidePicker();
					ThemeDesigner.set(swatchName, ThemeDesigner.rgb2hex(color));
					ThemeDesigner.set('theme', 'custom');
				});

			} else if (type === 'image') {

				swatches = this.themeDesignerPicker.children('.image').find('.swatches');
				// add admin background
				if (ThemeDesigner.settings['user-background-image']) {
					$('<li class="user"><img src="' + ThemeDesigner.settings['user-background-image-thumb'] +
						'" data-image="' + ThemeDesigner.settings['user-background-image'] + '"></li>')
						.insertBefore(swatches.find('.no-image'));
				}

				// click handling
				this.themeDesignerPicker.children('.image').find('.swatches').find('li').click(function () {

					//set correct image
					if ($(this).attr('class') === 'no-image') {
						ThemeDesigner.set('background-image', '');
						ThemeDesigner.changeDynamicBg(false);
					} else {
						ThemeDesigner.loadImage($(this).children('img').attr('data-image'));
					}

					ThemeDesigner.hidePicker();
				});
			}

			// show picker
			this.themeDesignerPicker
				.css({
					top: swatch.offset().top + 10,
					left: swatch.offset().left + 10
				})
				.removeClass('color image')
				.addClass(type);

			// clicking away will close picker
			$('body').bind('click.picker', $.proxy(ThemeDesigner.hidePicker, this));
			this.themeDesignerPicker.click(function (event) {
				event.stopPropagation();
			});
		},

		hidePicker: function () {
			$('body').unbind('.picker');
			$('#ColorNameForm').unbind();
			this.themeDesignerPicker
				.removeClass('color image')
				.find('.user').remove().end()
				.find('.color li').remove().end()
				.find('.image li').unbind('click');
			$('#color-name').val('').blur();
		},

		checkBgIsDynamic: function (width, value) {
			var noSplitOption = $('#CustomizeTab').find('.not-split-option');

			// TODO: Remove IF statement after fluid layout global release
			if (window.wgOasisResponsive || window.wgOasisBreakpoints) {
				if (width < ThemeDesigner.minWidthForDynamicBackground) {
					noSplitOption.css('display', 'none');
					ThemeDesigner.backgroundType = 1;
					ThemeDesigner.splitOption = false;
					ThemeDesigner.changeDynamicBg(false);
				} else if (width < ThemeDesigner.minWidthNotSplitBackground) {
					noSplitOption.css('display', 'none');
					ThemeDesigner.backgroundType = 2;
					ThemeDesigner.splitOption = true;
					ThemeDesigner.checkTiledBg(value);
				} else {
					noSplitOption.css('display', 'inline');
					ThemeDesigner.backgroundType = 3;
					ThemeDesigner.checkTiledBg(value);
					ThemeDesigner.splitOption = value;
				}
			}
		},

		checkTiledBg: function (value) {
			if (ThemeDesigner.backgroundType > 1) {
				if ($('#tile-background').attr('checked')) {
					ThemeDesigner.changeDynamicBg(false);
					$('#not-split-background').attr('disabled', true);
				} else {
					ThemeDesigner.changeDynamicBg(value);
					$('#not-split-background').attr('disabled', false);
				}
			}
		},

		changeDynamicBg: function (value) {
			var val = !! value,
				el = $('#not-split-background');

			if (el.prop('checked') === val) {
				el.prop('checked', !val);
				ThemeDesigner.set('background-dynamic', val.toString());
			}
		},

		setSplitOption: function () {
			if (ThemeDesigner.backgroundType === 1) {
				ThemeDesigner.splitOption = false;
			} else if (ThemeDesigner.backgroundType === 3) {
				ThemeDesigner.splitOption = ThemeDesigner.settings['background-dynamic'] === 'true';
			}
		},

		loadImage: function (src) {
			var img = new Image();

			img.onload = function () {
				if (img.width && img.height) {
					ThemeDesigner.set('background-image-width', img.width);
					ThemeDesigner.set('background-image-height', img.height);
					ThemeDesigner.set('background-image', src);
					ThemeDesigner.checkBgIsDynamic(img.width, true);
				}
			};
			img.src = src;
		},

		checkBgImageIsSet: function () {
			if (ThemeDesigner.settings['background-image'] === '') {
				ThemeDesigner.set('background-image-width', 0);
				ThemeDesigner.set('background-image-height', 0);
				return false;
			} else {
				return true;
			}
		},

		middleColorSelect: function (enable) {
			if (enable) {
				$('#CustomizeTab').find('.wrap-middle-color').css({
					opacity: 1
				});
				$('#CustomizeTab').find('.middle-color-mask').hide();
			} else {
				$('#CustomizeTab').find('.wrap-middle-color').css({
					opacity: 0.3
				});
				$('#CustomizeTab').find('.middle-color-mask').show();
			}
		},

		/**
		 * @author: Inez Korczynski
		 */
		set: function (setting, newValue) {
			ThemeDesigner.settings[setting] = newValue;

			if (setting === 'wordmark-image-name' || setting === 'background-image-name') {
				return;
			}

			var body = ThemeDesigner.previewFrame.contents().find('body'),
				reloadCSS = false,
				updateSkinPreview = false;

			if (setting === 'background-tiled') {
				if (newValue === 'true') {
					body.removeClass('background-not-tiled');
				} else {
					body.addClass('background-not-tiled');
				}
			}

			if (setting === 'background-fixed') {
				if (newValue === 'true') {
					body.addClass('background-fixed');
				} else {
					body.removeClass('background-fixed');
				}
			}

			if (setting === 'background-dynamic') {
				if (newValue === 'true') {
					body.addClass('background-dynamic');
					ThemeDesigner.middleColorSelect(true);
				} else {
					body.removeClass('background-dynamic');
					ThemeDesigner.middleColorSelect(false);
				}
			}

			if (setting === 'theme' && newValue !== 'custom') {
				$.extend(ThemeDesigner.settings, ThemeDesigner.themes[newValue]);
				reloadCSS = true;
			}

			if (setting === 'color-body' || setting === 'color-body-middle' || setting === 'color-page' ||
				setting === 'color-buttons' || setting === 'color-links' || setting === 'background-image' ||
				setting === 'color-header' || setting === 'wordmark-font') {
				reloadCSS = true;
			}

			if (setting === 'wordmark-font-size' || setting === 'wordmark-text' || setting === 'wordmark-type' ||
				setting === 'page-opacity') {
				updateSkinPreview = true;
			}

			ThemeDesigner.applySettings(reloadCSS, updateSkinPreview);
		},

		/**
		 * Async callback for uploading wordmark image
		 *
		 * @author: Inez Korczynski
		 */
		wordmarkUploadCallback: {
			onComplete: function (response) {
				var resp = JSON.parse(response);

				if (resp.errors && resp.errors.length > 0) {

					window.alert(resp.errors.join('\n'));

				} else {

					ThemeDesigner.set('wordmark-image-name', resp.wordmarkImageName);
					ThemeDesigner.set('wordmark-image-url', resp.wordmarkImageUrl);
					ThemeDesigner.set('wordmark-type', 'graphic');
				}
			}
		},

		/**
		 * Wordmark image upload button handler which cancel async request when image is not selected
		 *
		 * @author: Inez Korczynski
		 */
		wordmarkUpload: function () {
			return $('#WordMarkUploadFile').val() !== '';

		},

		/**
		 * Favicon upload callback
		 */
		faviconUploadCallback: {
			onComplete: function (response) {
				var resp = JSON.parse(response);

				if (resp.errors && resp.errors.length > 0) {

					window.alert(resp.errors.join('\n'));

				} else {
					ThemeDesigner.set('favicon-image-name', resp.faviconImageName);
					ThemeDesigner.set('favicon-image-url', resp.faviconImageUrl);
				}
			}
		},

		faviconUpload: function () {
			// do validation
		},

		/**
		 * Async callback for uploading background image
		 *
		 * @author: Inez Korczynski
		 */
		backgroundImageUploadCallback: {
			onComplete: function (response) {
				var resp = JSON.parse(response);
				if (resp.errors && resp.errors.length > 0) {

					window.alert(resp.errors.join('\n'));

				} else {
					$('#backgroundImageUploadFile').val('');
					ThemeDesigner.hidePicker();

					ThemeDesigner.set('user-background-image', resp.backgroundImageUrl);
					ThemeDesigner.set('user-background-image-thumb', resp.backgroundImageThumb);

					ThemeDesigner.set('theme', 'custom');
					ThemeDesigner.set('background-image-name', resp.backgroundImageName);
					ThemeDesigner.set('background-image-width', resp.backgroundImageWidth);
					ThemeDesigner.set('background-image-height', resp.backgroundImageHeight);

					// This should be last, it triggers a CSS reload
					ThemeDesigner.set('background-image', resp.backgroundImageUrl);
					ThemeDesigner.checkBgIsDynamic(resp.backgroundImageWidth, true);
				}
			}
		},

		/**
		 * Background image upload button handler which cancel async request when image is not selected
		 *
		 * @author: Inez Korczynski
		 */
		backgroundImageUpload: function () {
			return $('#BackgroundImageForm').find('input[type="file"]').val() !== '';

		},


		revertToPreviousTheme: function (event) {
			event.preventDefault();
			event.stopPropagation();
			ThemeDesigner.settings = ThemeDesigner.history[$(this).index()].settings;

			ThemeDesigner.applySettings(true, true);
		},

		cancelClick: function (event) {
			event.preventDefault();
			document.location = window.returnTo;
		},

		saveClick: function (event) {
			event.preventDefault();
			$(event.target).attr('disabled', true);
			ThemeDesigner.save();
		},

		save: function () {
			// send current settings to backend

			nirvana.sendRequest({
				controller: 'ThemeDesigner',
				method: 'SaveSettings',
				data: {
					settings: ThemeDesigner.settings,
					token: mw.user.tokens.get('editToken')
				},
				callback: function () {
					// BugId:1349
					ThemeDesigner.purgeReturnToPage(function () {
						if (window.returnTo) {
							// redirect to article from which ThemeDesigner was triggered
							document.location = window.returnTo;
						}
					});
				}
			});
		},

		navigationClick: function (event) {
			event.preventDefault();

			var clickedLink = $(this),
				command = clickedLink.attr('rel');

			//select the correct tab
			clickedLink.parent().addClass('selected').siblings().removeClass('selected');
			//show the correct panel
			$('#' + command).show().siblings('section').hide();

			//hide wordmark text side if necessary
			if (command === 'WordmarkTab') {
				ThemeDesigner.wordmarkShield();
			}
		},

		resizeIframe: function () {
			this.previewFrame.css('height', $(window).height() - $('#Designer').height());
		},

		history: false,
		settings: false,
		themes: false,

		applySettings: function (reloadCSS, updateSkinPreview) {
			var file, theme, settingsToLoad, wordmark;

			/*** Theme Tab ***/
			if (ThemeDesigner.settings.theme === 'custom') {
				$('#ThemeTab').find('.slider').find('.selected').removeClass('selected');
			}

			/*** Customize Tab ***/
			// color swatches
			$('#swatch-color-background').css('background-color', ThemeDesigner.settings['color-body']);
			$('#swatch-color-background-middle').css('background-color', ThemeDesigner.settings['color-body-middle']);
			$('#swatch-color-buttons').css('background-color', ThemeDesigner.settings['color-buttons']);
			$('#swatch-color-links').css('background-color', ThemeDesigner.settings['color-links']);
			$('#swatch-color-page').css('background-color', ThemeDesigner.settings['color-page']);
			$('#swatch-color-header').css('background-color', ThemeDesigner.settings['color-header']);

			if (ThemeDesigner.settings['background-image'] === '') {
				//no background image
				$('#swatch-image-background').attr('src', window.wgBlankImgUrl);
			} else if (ThemeDesigner.settings['background-image'].indexOf('images/themes') > 0) {
				//wikia background image
				file = ThemeDesigner.settings['background-image']
					.substring(ThemeDesigner.settings['background-image'].lastIndexOf('/') + 1);
				theme = file.substr(0, file.length - 4);
				$('#swatch-image-background').attr('src', window.wgExtensionsPath + '/wikia/ThemeDesigner/images/' +
					theme + '_swatch.jpg');
			} else {
				//admin background image
				$('#swatch-image-background').attr('src', ThemeDesigner.settings['user-background-image-thumb']);
			}

			/*** Wordmark Tab ***/
			// style wordmark preview
			$('#wordmark').removeClass().addClass(ThemeDesigner.settings['wordmark-font'])
				.addClass(ThemeDesigner.settings['wordmark-font-size']).text(ThemeDesigner.settings['wordmark-text']);

			// populate wordmark editor
			$('#wordmark-edit').find('input[type="text"]')
				.val(ThemeDesigner.settings['wordmark-text']);

			// select current font
			$('#wordmark-font').find('[value="' + ThemeDesigner.settings['wordmark-font'] + '"]')
				.attr('selected', 'selected');

			// select current size
			$('#wordmark-size').find('[value="' + ThemeDesigner.settings['wordmark-font-size'] + '"]')
				.attr('selected', 'selected');

			// wordmark image
			$('#WordmarkTab .graphic .wordmark').attr('src', ThemeDesigner.settings['wordmark-image-url']);


			if (ThemeDesigner.settings['wordmark-type'] === 'graphic') {
				$('#WordmarkTab').find('.graphic')
					.find('.preview').addClass('active')
					.find('.wordmark').addClass('selected');
				ThemeDesigner.wordmarkShield();
			} else {
				$('#WordmarkTab').find('.graphic')
					.find('.preview').removeClass('active')
					.find('.wordmark').removeClass('selected');
				ThemeDesigner.wordmarkShield();
			}

			// favicon image
			$('#WordmarkTab').find('.favicon').find('.preview').find('img')
				.attr('src', ThemeDesigner.settings['favicon-image-url']);

			if (ThemeDesigner.settings['favicon-image-url'] === window.wgBlankImgUrl) {
				$('#WordmarkTab').find('.favicon').find('.preview').removeClass('active');
			} else {
				$('#WordmarkTab').find('.favicon').find('.preview').addClass('active');
			}

			if (reloadCSS) {
				settingsToLoad = $.extend({}, ThemeDesigner.settings, window.applicationThemeSettings);

				document.getElementById('PreviewFrame').contentWindow.ThemeDesignerPreview.loadSASS(settingsToLoad);
			}

			if (updateSkinPreview) {
				wordmark = this.previewFrame.contents().find('#WikiHeader').find('.wordmark');

				if (ThemeDesigner.settings['wordmark-type'] === 'text') {
					wordmark.removeClass().addClass('wordmark').addClass(ThemeDesigner.settings['wordmark-font-size'])
						.find('a').text(ThemeDesigner.settings['wordmark-text']);
				} else if (ThemeDesigner.settings['wordmark-type'] === 'graphic') {
					wordmark.addClass('graphic')
						.find('a').html('').append('<img src="' + ThemeDesigner.settings['wordmark-image-url'] + '">');
				}

				this.previewFrame.contents().find('#WikiaPageBackground')
					.css('opacity', ThemeDesigner.settings['page-opacity'] / ThemeDesigner.maxPageOpacity);

				if (ThemeDesigner.settings['page-opacity'] < ThemeDesigner.maxPageOpacity) {
					this.previewFrame.contents().find('#WikiHeader .shadow-mask').hide();
				} else {
					this.previewFrame.contents().find('#WikiHeader .shadow-mask').show();
				}
			}
		},

		/**
		 * Purges the page from which user has triggered Theme Designer
		 */
		purgeReturnToPage: function (callback) {
			if (!window.returnTo) {
				return;
			}

			$.post(window.returnTo, {
				action: 'purge'
			}, function () {
				if (typeof callback === 'function') {
					callback();
				}
			});
		},

		/**
		 * Converts from rgb(255, 255, 255) to #fff
		 *
		 * Copied here from WikiaPhotoGallery.js
		 */
		rgb2hex: function (rgb) {
			function hex(x) {
				return ('0' + parseInt(x, 10).toString(16)).slice(-2);
			}

			var components = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/);

			if (components) {
				return '#' + hex(components[1]) + hex(components[2]) + hex(components[3]);
			} else {
				//not an rgb color, probably an hex value has been passed, return it
				return rgb;
			}
		},

		initSwatches: function () {
			this.swatches = {};

			// init color-body swatches
			this.swatches['color-body'] = [
				'f9ebc3',
				'ede5dd',
				'f7e1d3',
				'dfdbc3',
				'fbe300',
				'ffbf99',
				'ffbf99',
				'fdc355',
				'cdbd89',
				'd5a593',
				'a37719',
				'836d35',
				'776b41',
				'f14700',
				'dd3509',
				'a34111',
				'7b3b09',
				'4f4341',
				'454545',
				'611d03',
				'891100',
				'71130f',
				'ebfffb',
				'ebf1f5',
				'f5ebf5',
				'e7f3d1',
				'bde9fd',
				'dfbddd',
				'c3d167',
				'a5b5c5',
				'6599ff',
				'6b93b1',
				'978f33',
				'53835d',
				'7f6f9f',
				'd335f7',
				'337700',
				'006baf',
				'2b53b5',
				'2d2b17',
				'003715',
				'012d59',
				'6f017b',
				'790145',
				'ffffff',
				'f1f1f1',
				'ebebeb',
				'000000'
			];

			// copy color-body swatches to color-body-middle
			this.swatches['color-body-middle'] = this.swatches['color-body'];

			// initialize color-button swatches
			this.swatches['color-buttons'] = [
				'fec356',
				'6699ff',
				'6c93b1',
				'a47719',
				'846d35',
				'786c42',
				'f14800',
				'337800',
				'006cb0',
				'dd360a',
				'a34112',
				'474646',
				'7b3b0a',
				'4f4341',
				'0038d8',
				'2d2c18',
				'611e03',
				'003816',
				'891100',
				'012e59',
				'721410',
				'6f027c',
				'7a0146'
			];

			// initialize color-links swatches
			this.swatches['color-links'] = [
				'fce300',
				'fec356',
				'c4d167',
				'6699ff',
				'6c93b1',
				'a47719',
				'54845e',
				'337800',
				'006cb0',
				'0148c2',
				'6f027c',
				'ffffff'
			];

			// initialize color-page swatches
			this.swatches['color-page'] = [
				'ebf2f5',
				'e7f4d2',
				'f5ebf5',
				'f9ecc3',
				'eee5de',
				'f7e1d4',
				'd4e6f7',
				'dfdbc3',
				'dfbddd',
				'cebe8a',
				'a5b5c6',
				'474646',
				'2d2c18',
				'611e03',
				'012e59',
				'ffffff',
				'f2f2f2',
				'ebebeb',
				'000000'
			];

			// initialize color-header swatches
			this.swatches['color-header'] = [
				'D09632',
				'DD4702',
				'2B53B5',
				'3A5766',
				'285F00',
				'4A4612',
				'8F3000',
				'A301B4',
				'6D0D00',
				'002266',
				'580062',
				'808080'
			];
		},

		/**
		 * @desc Sets ThemeDesigner page-opacity option to ThemeDesigner.maxPageOpacity and jQuery UI slider value to 0
		 */
		resetPageOpacity: function () {
			var value = ThemeDesigner.maxPageOpacity;
			ThemeDesigner.set('page-opacity', value);

			if (ThemeDesigner.$slider !== null) {
				// Special:CreateNewWiki uses ThemeDesigner without slider (DAR-2532)
				ThemeDesigner.$slider.slider('value', ThemeDesigner.minSliderValue);
			}
		}

	};
	window.ThemeDesigner = ThemeDesigner;

	$(function () {
		'use strict';
		window.ThemeDesigner.init();
	});
});
