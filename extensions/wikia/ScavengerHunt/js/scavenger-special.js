var SpecialScavengerHunt = {
	inGameBox: null,
	inGameBoxIndex: 0,

	init: function() {
		var inGameBoxes = $('.scavenger-ingame');
		SpecialScavengerHunt.inGameBoxIndex = inGameBoxes.length;
		SpecialScavengerHunt.inGameBox = inGameBoxes.eq(0).clone();
		SpecialScavengerHunt.inGameBox.find('input').val('');
		$('#gameName').focus();
		$('input[name=delete]').bind('click.sumbit', SpecialScavengerHunt.onDeleteClick);
		$('#addSection').bind('click', SpecialScavengerHunt.onAddSectionClick);
		$('.scavenger-form')//.delegate('.scavenger-page-title', 'blur', SpecialScavengerHunt.onPageTitleBlur)
			.delegate('.scavenger-dialog-check', 'click', SpecialScavengerHunt.onDialogCheckClick)
			.delegate('.scavenger-progress-check', 'click', SpecialScavengerHunt.onVisualEditorClick)
			.delegate('.scavenger-image-check', 'click', SpecialScavengerHunt.onImageCheckClick)
			.delegate('input[type=text], textarea', 'change', SpecialScavengerHunt.onDataChange)
			.delegate('.removeSection', 'click', SpecialScavengerHunt.onRemoveSectionClick);
	},

	log: function(msg) {
		$().log(msg, 'SpecialScavengerHunt');
	},
/*
	onPageTitleBlur: function(e) {
		var titles = $('.scavenger-page-title');
		var count = titles.length;
		titles.each(function(i,e) {
			if ($(this).val()) {
				count--;
			}
		});

		if (!count) {
			$('.scavenger-article').last().after(SpecialScavengerHunt.inGameBox.clone())
		}
	},
*/
	onDeleteClick: function(e) {
		e.preventDefault();
		var button = $(this);
		$.confirm({
			//TODO: add i18n if this extension will be used outside staff group
			content: 'Are you sure to delete this game?',
			onOk: function() {
				button.unbind('.sumbit').click();
			}
		});
	},

	onDataChange: function(e) {
		$('.scavenger-form input[name=enable]').attr('disabled','disabled');
	},

	onDialogCheckClick: function(e) {
		e.preventDefault();

		var fieldset = $(this).closest('fieldset');
		var type = fieldset.attr('class');
		var formData = {};
		fieldset.find('input, textarea').each(function(i, el){
			formData[$(el).attr('name')] = $(el).val();
		});
		//add landing page for goodbye form
		if (type == 'scavenger-goodbye') {
			formData['landingTitle'] = fieldset.parent().find('.scavenger-general input[name=landingTitle]').val();
		}

		var data = {
			action: 'ajax',
			method: 'getPreviewForm',
			rs: 'ScavengerHuntAjax',
			formData: JSON.stringify(formData),
			type: type
		};

		var id, showCloseButton;
		switch (type) {
			case 'scavenger-entry':
				id = 'scavengerEntryFormModal';
				showCloseButton = false;
				break;
			case 'scavenger-goodbye':
				id = 'scavengerGoodbyeModal';
				showCloseButton = true;
				break;
			default:
				id = 'scavengerClueModal';
				showCloseButton = false;
		}

		$.getJSON(wgScript, data, function(json) {
			$.showModal(
				json.title,
				json.content,
				{
					id: id,
					showCloseButton: showCloseButton,
					width: 588,
					callback: function() {
						if (typeof FB == 'object') {
							var share = $('.scavenger-share-button');
							if (share.exists()) {
								FB.XFBML.parse(share.get(0));
							}
						}
					}
				}
			);
		});
	},

	onVisualEditorClick: function(e) {
		e.preventDefault();

		var form = $('#scavenger-form');
		var gameData = {
			spriteURL: form.find('input[name=spriteImg]').val(),
			progressBarBg: {
				name: 'progressBarBackgroundSprite',
				pos: {
					x: form.find('input[name=progressBarBackgroundSpriteX]').val(),
					y: form.find('input[name=progressBarBackgroundSpriteY]').val()
				},
				spriteTL: {
					x: form.find('input[name=progressBarBackgroundSpriteX1]').val(),
					y: form.find('input[name=progressBarBackgroundSpriteY1]').val()
				},
				spriteBR: {
					x: form.find('input[name=progressBarBackgroundSpriteX2]').val(),
					y: form.find('input[name=progressBarBackgroundSpriteY2]').val()
				}
			},
			progressBarClose: {
				name: 'progressBarExitSprite',
				pos: {
					x: form.find('input[name=progressBarExitSpriteX]').val(),
					y: form.find('input[name=progressBarExitSpriteY]').val()
				},
				spriteTL: {
					x: form.find('input[name=progressBarExitSpriteX1]').val(),
					y: form.find('input[name=progressBarExitSpriteY1]').val()
				},
				spriteBR: {
					x: form.find('input[name=progressBarExitSpriteX2]').val(),
					y: form.find('input[name=progressBarExitSpriteY2]').val()
				}
			},
			startingDialog: {
				name: 'startPopupSprite',
				pos: {
					x: form.find('input[name=startPopupSpriteX]').val(),
					y: form.find('input[name=startPopupSpriteY]').val()
				},
				spriteTL: {
					x: form.find('input[name=startPopupSpriteX1]').val(),
					y: form.find('input[name=startPopupSpriteY1]').val()
				},
				spriteBR: {
					x: form.find('input[name=startPopupSpriteX2]').val(),
					y: form.find('input[name=startPopupSpriteY2]').val()
				}
			},
			goodbyeDialog: {
				name: 'finishPopupSprite',
				pos: {
					x: form.find('input[name=finishPopupSpriteX]').val(),
					y: form.find('input[name=finishPopupSpriteY]').val()
				},
				spriteTL: {
					x: form.find('input[name=finishPopupSpriteX1]').val(),
					y: form.find('input[name=finishPopupSpriteY1]').val()
				},
				spriteBR: {
					x: form.find('input[name=finishPopupSpriteX2]').val(),
					y: form.find('input[name=finishPopupSpriteY2]').val()
				}
			}
		};

		gameData.inGame = {};
		//add ingame elements
		form.find('.scavenger-ingame').each(function() {
				var element = $(this);
				var index = element.data('index');
				SpecialScavengerHunt.log('index = ' + index);

				gameData.inGame[index] = {
					huntItem: {
						name: 'spriteNotFound',
						pos: {
							x: element.find('input[name="spriteNotFoundX[' + index + ']"]').val(),
							y: element.find('input[name="spriteNotFoundY[' + index + ']"]').val()
						},
						spriteTL: {
							x: element.find('input[name="spriteNotFoundX1[' + index + ']"]').val(),
							y: element.find('input[name="spriteNotFoundY1[' + index + ']"]').val()
						},
						spriteBR: {
							x: element.find('input[name="spriteNotFoundX2[' + index + ']"]').val(),
							y: element.find('input[name="spriteNotFoundY2[' + index + ']"]').val()
						}
					},
					notFound: {
						name: 'spriteInProgressBarNotFound',
						pos: {
							x: element.find('input[name="spriteInProgressBarNotFoundX[' + index + ']"]').val(),
							y: element.find('input[name="spriteInProgressBarNotFoundY[' + index + ']"]').val()
						},
						spriteTL: {
							x: element.find('input[name="spriteInProgressBarNotFoundX1[' + index + ']"]').val(),
							y: element.find('input[name="spriteInProgressBarNotFoundY1[' + index + ']"]').val()
						},
						spriteBR: {
							x: element.find('input[name="spriteInProgressBarNotFoundX2[' + index + ']"]').val(),
							y: element.find('input[name="spriteInProgressBarNotFoundY2[' + index + ']"]').val()
						}
					},
					found: {
						name: 'spriteInProgressBar',
						pos: {
							x: element.find('input[name="spriteInProgressBarX[' + index + ']"]').val(),
							y: element.find('input[name="spriteInProgressBarY[' + index + ']"]').val()
						},
						spriteTL: {
							x: element.find('input[name="spriteInProgressBarX1[' + index + ']"]').val(),
							y: element.find('input[name="spriteInProgressBarY1[' + index + ']"]').val()
						},
						spriteBR: {
							x: element.find('input[name="spriteInProgressBarX2[' + index + ']"]').val(),
							y: element.find('input[name="spriteInProgressBarY2[' + index + ']"]').val()
						}
					},
					active: {
						name: 'spriteInProgressBarHover',
						pos: {
							x: element.find('input[name="spriteInProgressBarHoverX[' + index + ']"]').val(),
							y: element.find('input[name="spriteInProgressBarHoverY[' + index + ']"]').val()
						},
						spriteTL: {
							x: element.find('input[name="spriteInProgressBarHoverX1[' + index + ']"]').val(),
							y: element.find('input[name="spriteInProgressBarHoverY1[' + index + ']"]').val()
						},
						spriteBR: {
							x: element.find('input[name="spriteInProgressBarHoverX2[' + index + ']"]').val(),
							y: element.find('input[name="spriteInProgressBarHoverY2[' + index + ']"]').val()
						}
					}
				};
		});

		SpecialScavengerHunt.log(gameData);

		var wrapper = $('<div id="scavenger-hunt-progress-preview">').appendTo('#WikiaPage');
		var editorInfo = $('<div id="scavenger-hunt-progress-info">');
		var itemCheckboxes = '<h3>items</h3>';

		var spriteUrl = 'url("' + gameData.spriteURL + '")';
		var centerX = Math.round($(window).width() / 2);
		var centerY = Math.round($(window).height() / 2);
		var zIndex = 1001; //z-index of progress bar = 1000

		//general
		for (property in gameData) {
			SpecialScavengerHunt.log(gameData[property]);
			if (gameData[property].name) {
				itemCheckboxes += '<label><input type="checkbox" value="' + gameData[property].name + '">' + gameData[property].name + '</label><br>';
				//at start show assets on the center of the screen - for easier movement
				SpecialScavengerHunt.log('x = ' + gameData[property].pos.x);
				var left = gameData[property].pos.x == 0 ? -centerX : gameData[property].pos.x;
				var top = gameData[property].pos.y == 0 ? -centerY : gameData[property].pos.y;
				$('<div>')
					.data('name', gameData[property].name)
					.addClass('scavenger-progress-image')
					.css({
						backgroundImage: spriteUrl,
						backgroundPosition: '-' + gameData[property].spriteTL.x + 'px -' + gameData[property].spriteTL.y + 'px',
						left: left + 'px',
						top: top + 'px',
						height: (gameData[property].spriteBR.y - gameData[property].spriteTL.y) + 'px',
						width: (gameData[property].spriteBR.x - gameData[property].spriteTL.x) + 'px',
						zIndex: zIndex++
					})
					.draggable({
						start: function(ev, ui) {
							editorInfo.find('span').text('moving: ' + $(ev.target).data('name'));
						}
					})
					.appendTo(wrapper);
			}
		}

		//in game
		var types = ['notFound', 'found', 'active', 'huntItem'];
		itemCheckboxes += '<h3>inGame</h3>';

		for (property in gameData.inGame) {
			SpecialScavengerHunt.log('inGame:');
			SpecialScavengerHunt.log(gameData.inGame[property]);
			for (type in types) {
				var item = gameData.inGame[property][types[type]];
				itemCheckboxes += '<label><input type="checkbox" value="' + item.name + '">' + item.name + '</label><br>';
				SpecialScavengerHunt.log('type = ' + type);
				SpecialScavengerHunt.log('gameData.inGame[property][types[type]]:');
				SpecialScavengerHunt.log(item);
				//at start show assets on the center of the screen - for easier movement
				SpecialScavengerHunt.log('x = ' + item.pos.x);
				var left = item.pos.x == 0 ? centerX : item.pos.x;
				var top = item.pos.y == 0 ? centerY : item.pos.y;
				SpecialScavengerHunt.log('width = ' + (item.spriteBR.y - item.spriteTL.y));
				$('<div>')
					.data('name', item.name)
					.addClass('scavenger-ingame-image')
					.css({
						backgroundImage: spriteUrl,
						backgroundPosition: '-' + item.spriteTL.x + 'px -' + item.spriteTL.y + 'px',
						left: left + 'px',
						top: top + 'px',
						height: (item.spriteBR.y - item.spriteTL.y) + 'px',
						width: (item.spriteBR.x - item.spriteTL.x) + 'px',
						zIndex: zIndex++
					})
					.draggable({
						start: function(ev, ui) {
							editorInfo.find('span').text('moving: ' + $(ev.target).data('name'));
						}
					})
					.appendTo('#WikiaPage');
			}
		}

		editorInfo
			.html('Move images in proper position, then click here to close interavtive editor<div id="scavenger-hunt-progress-info-items">' + itemCheckboxes + '</div><span></span>')
			.click(SpecialScavengerHunt.onVisualEditorClose)
//			.delegate('input', function(ev) {
//				alert($(this).attr('name'));
//			})
			.appendTo('#WikiaPage');
	},

	onVisualEditorClose: function(e) {
		if ($(e.target).is('input')) {
			//do not close on checkboxes click
			return;
		}
		var preview = $('#scavenger-hunt-progress-preview');

		var assets = preview.find('div');
		$.each(assets, function(k, v) {
			var asset = $(v);
			$('input[name=' + asset.data('name') + 'X]').val(asset.position().left);
			$('input[name=' + asset.data('name') + 'Y]').val(asset.position().top);
			SpecialScavengerHunt.log('image "' + $(v).data('name') + '" has X=' + asset.position().left + ', Y=' + asset.position().top);
		});

		//clear items
		preview.remove();
		$('#scavenger-hunt-progress-info').remove();
		$('.scavenger-ingame-image').remove();
	},

	onImageCheckClick: function(e) {
		e.preventDefault();

		var fieldset = $(this).closest('fieldset');
		var image = fieldset.find('[name="articleHiddenImage[]"]').val();
		var top = fieldset.find('[name="articleHiddenImageTopOffset[]"]').val();
		var left = fieldset.find('[name="articleHiddenImageLeftOffset[]"]').val();
		SpecialScavengerHunt.log('displaying image at top:' + top + 'px, left:' + left + 'px');
		$('.scavenger-hidden-image').remove();
		$('<img>')
			.attr('src', image)
			.click(function() {$(this).remove();})
			.addClass('scavenger-hidden-image')
			.css({left: left + 'px', top: top + 'px'})
			.appendTo('#WikiaPage');
	},

	onAddSectionClick: function(e) {
		SpecialScavengerHunt.log('adding new section');
		var newSection = SpecialScavengerHunt.inGameBox.clone();
		var newIndex = SpecialScavengerHunt.inGameBoxIndex++;
		SpecialScavengerHunt.log(newSection);
		newSection.attr('data-index', newIndex)
			.find('[name]').each(function(i, el) {
				$(el).attr('name', $(el).attr('name').replace(/\[\d]/, '[' + newIndex + ']'));
			});
		$('#addSection').parent().before(newSection);
	},

	onRemoveSectionClick: function(e) {
		e.preventDefault();

		$(e.target).closest('.scavenger-ingame').remove();
	}
};

$($.loadJQueryUI(SpecialScavengerHunt.init));
