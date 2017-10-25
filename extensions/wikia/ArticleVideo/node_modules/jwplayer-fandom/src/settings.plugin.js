function wikiaJWPlayerSettingsPlugin(player, config, div) {
	this.player = player;
	this.wikiaSettingsElement = div;
	this.buttonID = 'wikiaSettings';
	this.config = config;
	this.documentClickHandler = this.documentClickHandler.bind(this);

	this.addSettingsContent(this.wikiaSettingsElement);

	document.addEventListener('click', this.documentClickHandler);
}

wikiaJWPlayerSettingsPlugin.prototype.documentClickHandler = function (event) {
	// check if user didn't click the settings menu or settings button and if settings menu is open
	if (!event.target.closest('.wikia-jw-settings, .wikia-jw-settings-button') && this.wikiaSettingsElement.style.display) {
		this.close();
	}
};

wikiaJWPlayerSettingsPlugin.prototype.addButton = function () {
	var settingsIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="jw-svg-icon' +
			' jw-svg-icon-wikia-settings" viewBox="0 0 24 24">' + wikiaJWPlayerIcons.settings + '</svg>';

	this.player.addButton(settingsIcon, 'Settings', function () {
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
	this.wikiaSettingsElement.style.display = null;
	this.player.getContainer().classList.remove('wikia-jw-settings-open');
};

/**
 * opens settings menu
 */
wikiaJWPlayerSettingsPlugin.prototype.open = function () {
	this.wikiaSettingsElement.style.display = 'block';
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
	this.addButton();
};

wikiaJWPlayerSettingsPlugin.prototype.showQualityLevelsList = function () {
	this.settingsList.style.display = 'none';
	this.qualityLevelsList.style.display = 'block';
};

wikiaJWPlayerSettingsPlugin.prototype.showSettingsList = function () {
	this.settingsList.style.display = 'block';
	this.qualityLevelsList.style.display = 'none';
};

wikiaJWPlayerSettingsPlugin.prototype.addSettingsContent = function (div) {
	div.classList.add('wikia-jw-settings');
	div.classList.remove('jw-reset', 'jw-plugin');
	this.settingsList = this.createSettingsListElement();
	this.qualityLevelsList = this.createQualityLevelsList();

	div.appendChild(this.settingsList);
	div.appendChild(this.qualityLevelsList);

	return div;
};

wikiaJWPlayerSettingsPlugin.prototype.createSettingsListElement = function () {
	var settingsList = document.createElement('ul');

	settingsList.classList.add('wikia-jw-settings__list');
	settingsList.appendChild(this.createQualityButton());
	if (this.config.showToggle) {
		settingsList.appendChild(this.createAutoplayToggle());
	}

	return settingsList;
};

wikiaJWPlayerSettingsPlugin.prototype.createQualityButton = function () {
	var qualityButton = document.createElement('li');

	qualityButton.classList.add('wikia-jw-settings__quality-button');
	qualityButton.innerHTML = wikiaJWPlayerIcons.quality + ' Video Quality';
	qualityButton.addEventListener('click', this.showQualityLevelsList.bind(this));

	return qualityButton;
};

wikiaJWPlayerSettingsPlugin.prototype.createAutoplayToggle = function () {
	var autoplayToggle = document.createElement('li'),
		toggleInput = document.createElement('input'),
		toggleLabel = document.createElement('label'),
		toggleID = 'featuredVideoAutoplayToggle',
		playerInstance = this.player;

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
	var qualityLevelsList = document.createElement('ul'),
		backButton = document.createElement('li'),
		playerInstance = this.player,
		isActiveClass = 'is-active',
		isQualityListEmptyClass = 'is-quality-list-empty';

	qualityLevelsList.classList.add('wikia-jw-settings__quality-levels');
	backButton.classList.add('wikia-jw-settings__back');
	backButton.innerHTML = '<svg class="wikia-jw-settings__back-icon" width="18" height="18"' +
		' viewBox="0 0 18 18">' + wikiaJWPlayerIcons.back + '</svg> Back';
	backButton.addEventListener('click', this.showSettingsList.bind(this));
	qualityLevelsList.appendChild(backButton);

	playerInstance.on('levels', function (data) {
		// in Safari in data.levels array there is one element with label = '0'
		var isQualityListEmpty = !data.levels.length || (data.levels.length === 1 && data.levels[0].label === '0'),
			shouldShowSettingsButton = !isQualityListEmpty || this.config.showToggle;

		this.wikiaSettingsElement.classList.toggle(isQualityListEmptyClass, isQualityListEmpty);
		if (shouldShowSettingsButton) {
			this.show();
		} else {
			this.hide();
		}
		this.updateQualityLevelsList(qualityLevelsList, data.levels, isActiveClass, backButton);
	}.bind(this));

	playerInstance.on('levelsChanged', this.updateCurrentQuality.bind(this, qualityLevelsList, isActiveClass));

	return qualityLevelsList;
};

wikiaJWPlayerSettingsPlugin.prototype.updateQualityLevelsList = function (qualityLevelsList, newLevels, isActiveClass, backButton) {
	var playerInstance = this.player;

	while (qualityLevelsList.childElementCount > 1) {
		qualityLevelsList.removeChild(qualityLevelsList.firstChild);
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
		qualityLevelsList.insertBefore(qualityLevelItem, backButton);
	}, this);
};

wikiaJWPlayerSettingsPlugin.prototype.updateCurrentQuality = function (qualityLevelsList, isActiveClass, data) {
	qualityLevelsList.childNodes.forEach(function (node, index) {
		if (data.currentQuality === index) {
			node.classList.add(isActiveClass);
		} else {
			node.classList.remove(isActiveClass);
		}
	});
};

wikiaJWPlayerSettingsPlugin.register = function () {
	jwplayer().registerPlugin('wikiaSettings', '8.0.0', wikiaJWPlayerSettingsPlugin);
};
