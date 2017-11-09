var isActiveClass = 'is-active',
	domParser = new DOMParser();

function wikiaJWPlayerSettingsPlugin(player, config, div) {
	this.player = player;
	this.container = div;
	this.wikiaSettingsElement = document.createElement('div');
	this.buttonID = 'wikiaSettings';
	this.config = config;
	this.documentClickHandler = this.documentClickHandler.bind(this);

	this.container.classList.add('wikia-jw-settings__plugin');
	this.wikiaSettingsElement.classList.add('wikia-jw-settings');
	this.addSettingsContent(this.wikiaSettingsElement);
	this.container.appendChild(this.wikiaSettingsElement);

	this.player.on('levels', this.onQualityLevelsChange.bind(this));

	document.addEventListener('click', this.documentClickHandler);
	// fixes issue when opening the menu on iPhone 5, executing documentClickHandler twice doesn't break anything
	document.addEventListener('touchend', this.documentClickHandler);
}

wikiaJWPlayerSettingsPlugin.prototype.isSettingsMenuOrSettingsButton = function (element) {
	var button = this.getSettingsButtonElement();

	return button === element ||
		button.contains(element) ||
		this.wikiaSettingsElement === element ||
		this.wikiaSettingsElement.contains(element);
};

wikiaJWPlayerSettingsPlugin.prototype.documentClickHandler = function (event) {
	// check if user didn't click the settings menu or settings button and if settings menu is open
	if (!this.isSettingsMenuOrSettingsButton(event.target) && this.container.style.display) {
		this.close();
	}
};

wikiaJWPlayerSettingsPlugin.prototype.addButton = function () {
	var settingsIcon = this.createSVG(wikiaJWPlayerIcons.settings);
	settingsIcon.classList.add('jw-svg-icon');
	settingsIcon.classList.add('jw-svg-icon-wikia-settings');

	this.player.addButton(settingsIcon.outerHTML, this.config.i18n.settings, function () {
		if (!this.wikiaSettingsElement.style.display) {
			this.open();
		} else {
			this.close();
		}
	}.bind(this), this.buttonID, 'wikia-jw-settings-button');
};

wikiaJWPlayerSettingsPlugin.prototype.removeButton = function () {
	this.player.removeButton(this.buttonID);
};

/**
 * closes settings menu
 */
wikiaJWPlayerSettingsPlugin.prototype.close = function () {
	this.showSettingsList();
	this.container.style.display = null;
	this.player.getContainer().classList.remove('wikia-jw-settings-open');
};

/**
 * opens settings menu
 */
wikiaJWPlayerSettingsPlugin.prototype.open = function () {
	this.container.style.display = 'block';
	this.player.getContainer().classList.add('wikia-jw-settings-open');
};

/**
 * hides the entire plugin (button and settings menu)
 */
wikiaJWPlayerSettingsPlugin.prototype.hide = function () {
	this.close();
	this.removeButton();
};

/**
 * shows back the entire plugin (adds button back)
 */
wikiaJWPlayerSettingsPlugin.prototype.show = function () {
	if (!this.getSettingsButtonElement()) {
		this.addButton();
	}
};

wikiaJWPlayerSettingsPlugin.prototype.showQualityLevelsList = function () {
	this.settingsList.style.display = 'none';
	if (this.qualityLevelsList) {
		this.qualityLevelsList.style.display = 'block';
	}
};

wikiaJWPlayerSettingsPlugin.prototype.showSettingsList = function () {
	this.settingsList.style.display = 'block';
	if (this.qualityLevelsList) {
		this.qualityLevelsList.style.display = 'none';
	}
};

wikiaJWPlayerSettingsPlugin.prototype.addSettingsContent = function (div) {
	div.classList.add('wikia-jw-settings');
	div.classList.remove('jw-reset');
	div.classList.remove('jw-plugin');
	this.settingsList = this.createSettingsListElement();
	div.appendChild(this.settingsList);

	if (this.config.showQuality) {
		this.createQualityLevelsList();
		div.appendChild(this.qualityLevelsList);
	}

	return div;
};

wikiaJWPlayerSettingsPlugin.prototype.createSettingsListElement = function () {
	var settingsList = document.createElement('ul');

	settingsList.classList.add('wikia-jw-settings__list');
	settingsList.classList.add('wds-list');

	if (this.config.showQuality) {
		settingsList.appendChild(this.createQualityButton());
	}

	if (this.config.showAutoplayToggle) {
		settingsList.appendChild(this.createAutoplayToggle());
		this.show();
	}

	if (this.config.showCaptionsToggle) {
		settingsList.appendChild(this.createCaptionsButton());
		this.addCaptionListener();
	}

	return settingsList;
};

wikiaJWPlayerSettingsPlugin.prototype.createSVG = function (svgHtml) {
	return domParser.parseFromString(svgHtml, 'image/svg+xml').documentElement;
};

wikiaJWPlayerSettingsPlugin.prototype.createQualityButton = function () {
	var rightArrowIcon = this.createSVG(wikiaJWPlayerIcons.back);
	var qualityButton = document.createElement('li');

	rightArrowIcon.classList.add('wikia-jw-settings__right-arrow-icon');
	qualityButton.classList.add('wikia-jw-settings__quality-button');
	qualityButton.innerHTML = this.config.i18n.videoQuality + rightArrowIcon.outerHTML;
	qualityButton.addEventListener('click', this.showQualityLevelsList.bind(this));

	return qualityButton;
};

wikiaJWPlayerSettingsPlugin.prototype.createAutoplayToggle = function () {
	var autoplayToggle = createToggle({
			id: this.player.getContainer().id + '-videoAutoplayToggle',
			label: this.config.i18n.autoplayVideos,
			checked: this.config.autoplay
		});

	this.getLabelElement(autoplayToggle)
		.addEventListener('click', function (event) {
			this.player.trigger('autoplayToggle', {
				enabled: !event.target.previousSibling.checked
			});
		}.bind(this));

	return autoplayToggle;
};

wikiaJWPlayerSettingsPlugin.prototype.createQualityLevelsList = function () {
	var playerInstance = this.player,
		backIcon = this.createSVG(wikiaJWPlayerIcons.back);

	backIcon.classList.add('wikia-jw-settings__back-icon');

	this.backButton = document.createElement('li');
	this.qualityLevelsList = document.createElement('ul');

	this.qualityLevelsList.classList.add('wikia-jw-settings__quality-levels');
	this.qualityLevelsList.classList.add('wds-list');
	this.backButton.classList.add('wikia-jw-settings__back');
	this.backButton.innerHTML = backIcon.outerHTML + ' ' + this.config.i18n.back;
	this.backButton.addEventListener('click', this.showSettingsList.bind(this));
	this.qualityLevelsList.appendChild(this.backButton);

	playerInstance.on('levelsChanged', this.updateCurrentQuality.bind(this));
};

wikiaJWPlayerSettingsPlugin.prototype.onQualityLevelsChange = function (data) {
	// in Safari in data.levels array there is one element with label = '0'
	var isQualityListEmpty = !data.levels.length || (data.levels.length === 1 && data.levels[0].label === '0'),
		shouldShowSettingsButton = (!isQualityListEmpty && this.config.showQuality) || this.config.showAutoplayToggle,
		isQualityListEmptyClass = 'is-quality-list-empty';

	if (isQualityListEmpty) {
		this.wikiaSettingsElement.classList.add(isQualityListEmptyClass)
	} else {
		this.wikiaSettingsElement.classList.remove(isQualityListEmptyClass)
	}

	if (shouldShowSettingsButton) {
		this.show();
	}

	if (this.qualityLevelsList) {
		this.updateQualityLevelsList(data.levels);
	}
};

wikiaJWPlayerSettingsPlugin.prototype.updateQualityLevelsList = function (newLevels) {
	var playerInstance = this.player;

	while (this.qualityLevelsList.childElementCount > 1) {
		this.qualityLevelsList.removeChild(this.qualityLevelsList.firstChild);
	}

	newLevels.forEach(function (level, index) {
		var qualityLevelItem = document.createElement('li');

		qualityLevelItem.addEventListener('click', function () {
			playerInstance.setCurrentQuality(index);
			this.close();
		}.bind(this));

		if (playerInstance.getCurrentQuality() === index) {
			qualityLevelItem.classList.add(isActiveClass);
		}

		qualityLevelItem.appendChild(document.createTextNode(level.label));
		this.qualityLevelsList.insertBefore(qualityLevelItem, this.backButton);
	}, this);
};

wikiaJWPlayerSettingsPlugin.prototype.updateCurrentQuality = function (data) {
	for (var i = 0; i < this.qualityLevelsList.childNodes.length; i++) {
		var node = this.qualityLevelsList.childNodes[i];
		if (data.currentQuality === i) {
			node.classList.add(isActiveClass);
		} else {
			node.classList.remove(isActiveClass);
		}
	}
};

wikiaJWPlayerSettingsPlugin.prototype.addCaptionListener = function () {
	var clickHandler = this.captionsClickHandler.bind(this);

	this.player.on('captionsList', function (event) {
		// tracks always include "off" item
		if (event.tracks.length > 1) {
			this.currentlySelectedCaptions = this.getSuitableCaptionsIndex(
				this.captionLangMap[this.getUserLang()],
				event.tracks
			);

			this.getLabelElement(this.captionsToggle)
				.addEventListener('click', clickHandler);

			this.wikiaSettingsElement.classList.remove('are-captions-empty');
			this.show();

			if (this.config.captions.enabled) {
				this.player.setCurrentCaptions(this.currentlySelectedCaptions);
			}

			if (this.config.captions.styles && Object.keys(this.config.captions.styles).length) {
				this.player.setCaptions(this.config.captions.styles);
			}
		} else {
			this.getLabelElement(this.captionsToggle)
				.removeEventListener('click', clickHandler);

			this.wikiaSettingsElement.classList.add('are-captions-empty');
		}
	}.bind(this));
};

wikiaJWPlayerSettingsPlugin.prototype.createCaptionsButton = function () {
	this.captionsToggle = createToggle({
			id: this.player.getContainer().id + '-videoCaptionsToggle',
			label: this.config.i18n.captions,
			checked: this.config.captions.enabled
		});

	this.captionsToggle.classList.add('wikia-jw-settings__captions-button');

	return this.captionsToggle;
};

wikiaJWPlayerSettingsPlugin.prototype.captionsClickHandler = function () {
	var nextSelectedTrack = this.areCaptionsOff(this.player.getCurrentCaptions()) ? this.currentlySelectedCaptions : 0;

	this.player.setCurrentCaptions(nextSelectedTrack);
	this.player.trigger('captionsSelected', {
		enabled: nextSelectedTrack
	});
};

wikiaJWPlayerSettingsPlugin.prototype.areCaptionsOff = function(captionIndex) {
	// "off" always has first position in tracks array
	return captionIndex === 0;
};

wikiaJWPlayerSettingsPlugin.prototype.getUserLang = function() {
	return (window.navigator.userLanguage || window.navigator.language).slice(0, 2);
};

wikiaJWPlayerSettingsPlugin.prototype.getSuitableCaptionsIndex = function(userLang, captionTracks) {
	// use findIndex when ES6+ will be available
	return captionTracks
		.map(function (track) {
			return track.label;
		})
		.indexOf(userLang);
};

wikiaJWPlayerSettingsPlugin.prototype.captionLangMap = {
	en: 'English',
	pl: 'Polski',
	fr: 'Français',
	de: 'Deutsch',
	it: 'Italiano',
	ja: '日本語',
	pt: 'Português',
	ru: 'Русский язык',
	es: 'Español',
	zh: '中文'
};

wikiaJWPlayerSettingsPlugin.prototype.getLabelElement = function (wrapper) {
	return wrapper.querySelector('label');
};

wikiaJWPlayerSettingsPlugin.prototype.getSettingsButtonElement = function () {
	return this.player.getContainer().querySelector('[button=' + this.buttonID + ']');
};

wikiaJWPlayerSettingsPlugin.register = function () {
	jwplayer().registerPlugin('wikiaSettings', '8.0.0', wikiaJWPlayerSettingsPlugin);
};

function createToggle(params) {
	var toggleWrapper = document.createElement('li'),
		toggleInput = document.createElement('input'),
		toggleLabel = document.createElement('label');

	toggleWrapper.className = 'wikia-jw-settings__toggle';

	toggleInput.setAttribute('type', 'checkbox');
	toggleInput.setAttribute('id', params.id);
	toggleInput.className = 'wds-toggle__input';

	if (params.checked) {
		toggleInput.checked = true;
	}

	toggleLabel.setAttribute('for', params.id);
	toggleLabel.className = 'wds-toggle__label';
	toggleLabel.appendChild(document.createTextNode(params.label));

	toggleWrapper.appendChild(toggleInput);
	toggleWrapper.appendChild(toggleLabel);

	return toggleWrapper;
}

