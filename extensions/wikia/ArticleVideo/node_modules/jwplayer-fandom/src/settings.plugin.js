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
}

wikiaJWPlayerSettingsPlugin.prototype.isSettingsMenuOrSettingsButton = function (element) {
	var button = this.player.getContainer().querySelector('[button=' + this.buttonID + ']');
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
	var settingsIcon = domParser.parseFromString(wikiaJWPlayerIcons.settings, "image/svg+xml").documentElement;
	settingsIcon.classList.add('jw-svg-icon');
	settingsIcon.classList.add('jw-svg-icon-wikia-settings');

	this.player.addButton(settingsIcon.outerHTML, 'Settings', function () {
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
 * hides the entire plugin (button and settings menu_
 */
wikiaJWPlayerSettingsPlugin.prototype.hide = function () {
	this.close();
	this.removeButton();
};

/**
 * shows back the entire plugin (adds button back)
 */
wikiaJWPlayerSettingsPlugin.prototype.show = function () {
	if (!this.player.getContainer().querySelector('[button=' + this.buttonID + ']')) {
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
	}

	return settingsList;
};

wikiaJWPlayerSettingsPlugin.prototype.createQualityButton = function () {
	var qualityButton = document.createElement('li');

	qualityButton.classList.add('wikia-jw-settings__quality-button');
	var rightArrowIcon = domParser.parseFromString(wikiaJWPlayerIcons.back, "image/svg+xml").documentElement;
	rightArrowIcon.classList.add('wikia-jw-settings__right-arrow-icon');
	qualityButton.innerHTML = 'Video Quality' + rightArrowIcon.outerHTML;
	qualityButton.addEventListener('click', this.showQualityLevelsList.bind(this));

	return qualityButton;
};

wikiaJWPlayerSettingsPlugin.prototype.createAutoplayToggle = function () {
	var autoplayToggle = document.createElement('li'),
		toggleInput = document.createElement('input'),
		toggleLabel = document.createElement('label'),
		playerInstance = this.player,
		toggleID = playerInstance.getContainer().id + '-videoAutoplayToggle';

	autoplayToggle.classList.add('wikia-jw-settings__autoplay-toggle');

	toggleInput.setAttribute('type', 'checkbox');
	toggleInput.setAttribute('id', toggleID);
	toggleInput.classList.add('wds-toggle__input');

	if (this.config.autoplay) {
		toggleInput.setAttribute('checked', '');
	}

	toggleLabel.setAttribute('for', toggleID);
	toggleLabel.classList.add('wds-toggle__label');
	toggleLabel.appendChild(document.createTextNode("Autoplay Videos"));
	toggleLabel.addEventListener('click', function (event) {
		playerInstance.trigger('autoplayToggle', {
			enabled: !event.target.previousSibling.checked
		});
	});

	autoplayToggle.appendChild(toggleInput);
	autoplayToggle.appendChild(toggleLabel);

	return autoplayToggle;
};

wikiaJWPlayerSettingsPlugin.prototype.createQualityLevelsList = function () {
	var playerInstance = this.player,
		backIcon = domParser.parseFromString(wikiaJWPlayerIcons.back, "image/svg+xml").documentElement;

	backIcon.classList.add('wikia-jw-settings__back-icon');

	this.backButton = document.createElement('li');
	this.qualityLevelsList = document.createElement('ul');

	this.qualityLevelsList.classList.add('wikia-jw-settings__quality-levels');
	this.qualityLevelsList.classList.add('wds-list');
	this.backButton.classList.add('wikia-jw-settings__back');
	this.backButton.innerHTML = backIcon.outerHTML + ' Back';
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
	} else {
		this.hide();
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

wikiaJWPlayerSettingsPlugin.register = function () {
	jwplayer().registerPlugin('wikiaSettings', '8.0.0', wikiaJWPlayerSettingsPlugin);
};
