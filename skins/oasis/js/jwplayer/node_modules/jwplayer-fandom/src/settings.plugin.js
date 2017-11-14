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
	this.player.on('captionsList', this.onCaptionsChange.bind(this));

	document.addEventListener('click', this.documentClickHandler);
	// fixes issue when opening the menu on iPhone 5, executing documentClickHandler twice doesn't break anything
	document.addEventListener('touchend', this.documentClickHandler);
}

wikiaJWPlayerSettingsPlugin.prototype.isSettingsMenuOrSettingsButton = function (element) {
	var button = this.getSettingsButtonElement();

	return button && (button === element ||
		button.contains(element) ||
		this.wikiaSettingsElement === element ||
		this.wikiaSettingsElement.contains(element));
};

wikiaJWPlayerSettingsPlugin.prototype.getSettingsButtonElement = function () {
	return this.player.getContainer().querySelector('[button=' + this.buttonID + ']');
};

wikiaJWPlayerSettingsPlugin.prototype.documentClickHandler = function (event) {
	// check if user didn't click the settings menu or settings button and if settings menu is open
	if (!this.isSettingsMenuOrSettingsButton(event.target) && this.container.style.display) {
		this.close();
	}
};

wikiaJWPlayerSettingsPlugin.prototype.addButton = function () {
	var settingsIcon = createSVG(wikiaJWPlayerIcons.settings);
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
	showElement(this.container);
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

wikiaJWPlayerSettingsPlugin.prototype.showSettingsList = function () {
	showElement(this.settingsList);
	hideElement(this.qualityLevelsList);
	hideElement(this.captionsList);
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

	if (this.config.showCaptions) {
		this.createCaptionsList();
		div.appendChild(this.captionsList);
	}

	return div;
};

wikiaJWPlayerSettingsPlugin.prototype.createSettingsListElement = function () {
	var settingsList = document.createElement('ul');

	settingsList.className = 'wikia-jw-settings__list wds-list';

	if (this.config.showQuality) {
		settingsList.appendChild(this.createQualityButton());
	}

	if (this.config.showCaptions) {
		settingsList.appendChild(this.createCaptionsButton());
	}

	if (this.config.showAutoplayToggle) {
		settingsList.appendChild(this.createAutoplayToggle());
		this.show();
	}

	return settingsList;
};

wikiaJWPlayerSettingsPlugin.prototype.createSubmenuWrapper = function () {
	var backElement = document.createElement('li'),
		submenuWrapper = document.createElement('ul');

	backElement.className = 'wikia-jw-settings__back';
	backElement.innerHTML = createArrowIcon('left').outerHTML + ' ' + this.config.i18n.back;
	backElement.addEventListener('click', this.showSettingsList.bind(this));

	submenuWrapper.className = 'wikia-jw-settings__submenu wds-list';
	submenuWrapper.appendChild(backElement);

	return submenuWrapper;
};

// autoplay button specific methods
wikiaJWPlayerSettingsPlugin.prototype.createAutoplayToggle = function () {
	var autoplayToggle = createToggle({
			id: this.player.getContainer().id + '-videoAutoplayToggle',
			label: this.config.i18n.autoplayVideos,
			checked: this.config.autoplay
		});

	autoplayToggle.querySelector('label')
		.addEventListener('click', function (event) {
			this.player.trigger('autoplayToggle', {
				enabled: !event.target.previousSibling.checked
			});
		}.bind(this));

	return autoplayToggle;
};
// end autoplay

// quality button specific methods
wikiaJWPlayerSettingsPlugin.prototype.createQualityButton = function () {
	var qualityElement = document.createElement('li');

	qualityElement.className = 'wikia-jw-settings__quality-button';
	qualityElement.innerHTML = this.config.i18n.videoQuality + createArrowIcon('right').outerHTML;
	qualityElement.addEventListener('click', function () {
		hideElement(this.settingsList);
		showElement(this.qualityLevelsList);
	}.bind(this));

	return qualityElement;
};

wikiaJWPlayerSettingsPlugin.prototype.createQualityLevelsList = function () {
	this.qualityLevelsList = this.createSubmenuWrapper();

	this.player.on('levelsChanged', this.updateCurrentQuality.bind(this));
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
	clearListElement(this.qualityLevelsList);

	newLevels.forEach(function (level, index) {
		var qualityLevelItem = document.createElement('li');

		qualityLevelItem.addEventListener('click', function () {
			this.player.setCurrentQuality(index);
			this.close();
		}.bind(this));

		if (this.player.getCurrentQuality() === index) {
			qualityLevelItem.classList.add(isActiveClass);
		}

		qualityLevelItem.appendChild(document.createTextNode(level.label));
		this.qualityLevelsList.insertBefore(qualityLevelItem, this.qualityLevelsList.lastElementChild);
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
// end quality

// captions button specific methods
wikiaJWPlayerSettingsPlugin.prototype.onCaptionsChange = function (event) {
	var emptyCaptionsClass = 'are-captions-empty',
		suitableCaptionsTrack = this.getSuitableCaptionsIndex(
			this.config.selectedCaptionsLanguage || this.captionLangMap[this.getUserLang()],
			event.tracks
		);

	clearListElement(this.captionsList);

	// tracks always include "off" item
	if (this.captionsList && event.tracks.length > 1) {
		event.tracks.forEach(this.createCaptionsListItem, this);

		this.wikiaSettingsElement.classList.remove(emptyCaptionsClass);
		this.show();

		// 'false' is used specifically to turn captions off
		if (this.config.selectedCaptionsLanguage !== false && suitableCaptionsTrack !== -1) {
			this.player.setCurrentCaptions(suitableCaptionsTrack);
		} else {
			// "off" track is always the first one
			this.player.setCurrentCaptions(0);
		}
	} else {
		this.wikiaSettingsElement.classList.add(emptyCaptionsClass);
	}
};

wikiaJWPlayerSettingsPlugin.prototype.createCaptionsList = function () {
	this.captionsList = this.createSubmenuWrapper();

	this.player.on('captionsChanged', this.updateCurrentCaptions.bind(this))
};

wikiaJWPlayerSettingsPlugin.prototype.createCaptionsListItem = function (track, index) {
	var captionItem = document.createElement('li'),
		normalizedLabel = track.label === 'Off' ? 'No captions' : track.label;

	captionItem.dataset.track = index;
	captionItem.addEventListener('click', function () {
		this.player.setCurrentCaptions(index);
		this.close();
		this.player.trigger('captionsSelected', {
			selectedLang: track.label
		});
	}.bind(this));

	captionItem.appendChild(document.createTextNode(normalizedLabel));
	this.captionsList.insertBefore(captionItem, this.captionsList.firstElementChild);
};

wikiaJWPlayerSettingsPlugin.prototype.createCaptionsButton = function () {
	var captionsButton = document.createElement('li');

	captionsButton.className = 'wikia-jw-settings__captions-button';
	captionsButton.innerHTML = this.config.i18n.captions + createArrowIcon('right').outerHTML;

	captionsButton.addEventListener('click', function () {
		hideElement(this.settingsList);
		showElement(this.captionsList);
	}.bind(this));

	return captionsButton;
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

wikiaJWPlayerSettingsPlugin.prototype.updateCurrentCaptions = function (data) {
	for (var i = 0; i < this.captionsList.childNodes.length; i++) {
		this.captionsList.childNodes[i].classList.remove(isActiveClass);
	}

	this.captionsList.querySelector('[data-track="' + data.track + '"]').classList.add(isActiveClass);
};

wikiaJWPlayerSettingsPlugin.prototype.captionLangMap = {
	en: 'English',
	pl: 'Polish',
	fr: 'French',
	de: 'German',
	it: 'Italian',
	ja: 'Japanese',
	pt: 'Portuguese',
	ru: 'Russian',
	es: 'Spanish',
	zh: 'Chinese'
};
// end captions

wikiaJWPlayerSettingsPlugin.register = function () {
	jwplayer().registerPlugin('wikiaSettings', '8.0.0', wikiaJWPlayerSettingsPlugin);
};
