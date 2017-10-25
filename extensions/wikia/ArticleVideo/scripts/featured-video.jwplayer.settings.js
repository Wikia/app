define('wikia.articleVideo.featuredVideo.jwplayer.plugin.settings', ['wikia.articleVideo.featuredVideo.autoplay'], function (featuredVideoAutoplay) {

	function WikiaJWPlayerSettings(player, config, div) {
		this.player = player;
		this.wikiaSettingsElement = div;
		this.buttonID = 'wikiaSettings';
		this.documentClickHandler = this.documentClickHandler.bind(this);

		this.addSettingsContent(this.wikiaSettingsElement);
		this.addButton();

		document.addEventListener('click', this.documentClickHandler);
	}

	WikiaJWPlayerSettings.prototype.documentClickHandler = function (event) {
		// check if user didn't click the settings menu or settings button and if settings menu is open
		if (!event.target.closest('.wikia-jw-settings, .wikia-jw-settings-button') && this.wikiaSettingsElement.style.display) {
			this.close();
		}
	};

	WikiaJWPlayerSettings.prototype.addButton = function () {
		var // wds-icons-gear-small.svg
			settingsIcon = '<svg xmlns="http://www.w3.org/2000/svg" class="jw-svg-icon jw-svg-icon-wikia-settings" viewBox="0 0 24 24"><path d="M9 7.09a1.909 1.909 0 1 1 0 3.819A1.909 1.909 0 0 1 9 7.09m-4.702-.03a1.07 1.07 0 0 1-.99.667h-.672A.637.637 0 0 0 2 8.364v1.272c0 .352.285.637.636.637h.672c.436 0 .824.264.99.667l.006.013c.167.403.08.864-.229 1.172L3.6 12.6a.636.636 0 0 0 0 .9l.9.9a.636.636 0 0 0 .9 0l.475-.475a1.072 1.072 0 0 1 1.185-.223c.403.166.667.554.667.99v.672c0 .35.285.636.637.636h1.272a.637.637 0 0 0 .637-.636v-.672c0-.436.264-.824.667-.99l.013-.006a1.07 1.07 0 0 1 1.172.229l.475.475a.636.636 0 0 0 .9 0l.9-.9a.636.636 0 0 0 0-.9l-.475-.475a1.072 1.072 0 0 1-.229-1.172l.006-.013a1.07 1.07 0 0 1 .99-.667h.672A.637.637 0 0 0 16 9.636V8.364a.637.637 0 0 0-.636-.637h-.672a1.07 1.07 0 0 1-.996-.68 1.072 1.072 0 0 1 .229-1.172L14.4 5.4a.636.636 0 0 0 0-.9l-.9-.9a.636.636 0 0 0-.9 0l-.475.475c-.308.308-.77.396-1.172.229l-.013-.006a1.07 1.07 0 0 1-.667-.99v-.672A.637.637 0 0 0 9.636 2H8.364a.637.637 0 0 0-.637.636v.672a1.07 1.07 0 0 1-.68.996 1.07 1.07 0 0 1-1.172-.229L5.4 3.6a.636.636 0 0 0-.9 0l-.9.9a.636.636 0 0 0 0 .9l.475.475a1.072 1.072 0 0 1 .223 1.185" fill-rule="evenodd"/></svg>';

		this.player.addButton(settingsIcon, 'Settings', function () {
			if (!this.wikiaSettingsElement.style.display) {
				this.open();
			} else {
				this.close();
			}
		}.bind(this), this.buttonID, 'wikia-jw-settings-button');
	};

	WikiaJWPlayerSettings.prototype.removeButton = function () {
		this.player.removeButton(this.buttonID);
	};

	/**
	 * closes settings menu
	 */
	WikiaJWPlayerSettings.prototype.close = function () {
		this.showSettingsList();
		this.wikiaSettingsElement.style.display = null;
		this.player.getContainer().classList.remove('wikia-jw-settings-open');
	};

	/**
	 * opens settings menu
	 */
	WikiaJWPlayerSettings.prototype.open = function () {
		this.wikiaSettingsElement.style.display = 'block';
		this.player.getContainer().classList.add('wikia-jw-settings-open');
	};

	/**
	 * hides the entire plugin (button and settings menu_
	 */
	WikiaJWPlayerSettings.prototype.hide = function () {
		this.close();
		this.removeButton();
	};

	/**
	 * shows back the entire plugin (adds button back)
	 */
	WikiaJWPlayerSettings.prototype.show = function () {
		this.addButton();
	};

	WikiaJWPlayerSettings.prototype.showQualityLevelsList = function () {
		this.settingsList.style.display = 'none';
		this.qualityLevelsList.style.display = 'block';
	};

	WikiaJWPlayerSettings.prototype.showSettingsList = function () {
		this.settingsList.style.display = 'block';
		this.qualityLevelsList.style.display = 'none';
	};

	WikiaJWPlayerSettings.prototype.addSettingsContent = function (div) {
		div.classList.add('wikia-jw-settings');
		div.classList.remove('jw-reset', 'jw-plugin');
		this.settingsList = this.createSettingsListElement();
		this.qualityLevelsList = this.createQualityLevelsList();

		div.appendChild(this.settingsList);
		div.appendChild(this.qualityLevelsList);

		return div;
	};

	WikiaJWPlayerSettings.prototype.createSettingsListElement = function () {
		var settingsList = document.createElement('ul');

		settingsList.classList.add('wikia-jw-settings__list');
		settingsList.appendChild(this.createQualityButton());
		settingsList.appendChild(this.createAutoplayToggle());

		return settingsList;
	};

	WikiaJWPlayerSettings.prototype.createQualityButton = function () {
		var qualityButton = document.createElement('li');

		qualityButton.classList.add('wikia-jw-settings__quality-button');
		qualityButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="jw-svg-icon jw-svg-icon-quality-100" viewBox="0 0 240 240"><path d="M55,200H35c-3,0-5-2-5-4c0,0,0,0,0-1v-30c0-3,2-5,4-5c0,0,0,0,1,0h20c3,0,5,2,5,4c0,0,0,0,0,1v30C60,198,58,200,55,200L55,200z M110,195v-70c0-3-2-5-4-5c0,0,0,0-1,0H85c-3,0-5,2-5,4c0,0,0,0,0,1v70c0,3,2,5,4,5c0,0,0,0,1,0h20C108,200,110,198,110,195L110,195z M160,195V85c0-3-2-5-4-5c0,0,0,0-1,0h-20c-3,0-5,2-5,4c0,0,0,0,0,1v110c0,3,2,5,4,5c0,0,0,0,1,0h20C158,200,160,198,160,195L160,195z M210,195V45c0-3-2-5-4-5c0,0,0,0-1,0h-20c-3,0-5,2-5,4c0,0,0,0,0,1v150c0,3,2,5,4,5c0,0,0,0,1,0h20C208,200,210,198,210,195L210,195z"></path></svg> Video Quality';
		qualityButton.addEventListener('click', this.showQualityLevelsList.bind(this));

		return qualityButton;
	};

	WikiaJWPlayerSettings.prototype.createAutoplayToggle = function () {
		var autoplayToggle = document.createElement('li'),
			toggleInput = document.createElement('input'),
			toggleLabel = document.createElement('label'),
			toggleID = 'featuredVideoAutoplayToggle',
			playerInstance = this.player;

		toggleInput.setAttribute('type', 'checkbox');
		toggleInput.setAttribute('id', toggleID);
		toggleInput.classList.add('wds-toggle__input');
		if (featuredVideoAutoplay.isAutoplayEnabled()) {
			toggleInput.setAttribute('checked', '');
		}

		toggleLabel.setAttribute('for', toggleID);
		toggleLabel.classList.add('wds-toggle__label');
		toggleLabel.appendChild(document.createTextNode("Autoplay Videos"));
		toggleLabel.addEventListener('click', function (event) {
			featuredVideoAutoplay.toggleAutoplay(!event.target.previousSibling.checked);
			playerInstance.trigger('autoplayToggle', { enabled: !event.target.previousSibling.checked });
		});

		autoplayToggle.appendChild(toggleInput);
		autoplayToggle.appendChild(toggleLabel);

		return autoplayToggle;
	};

	WikiaJWPlayerSettings.prototype.createQualityLevelsList = function () {
		var qualityLevelsList = document.createElement('ul'),
			backButton = document.createElement('li'),
			playerInstance = this.player,
			isActiveClass = 'is-active',
			isQualityListEmptyClass = 'is-quality-list-empty';

		qualityLevelsList.classList.add('wikia-jw-settings__quality-levels');
		backButton.classList.add('wikia-jw-settings__back');
		backButton.innerHTML = '<svg class="wikia-jw-settings__back-icon" width="18" height="18" viewBox="0 0 18 18" data-reactid=".0.0.5.3.1.$quality.0.0.0.0.1.0"><path d="M9 14a.997.997 0 0 1-.707-.293l-7-7a.999.999 0 1 1 1.414-1.414L9 11.586l6.293-6.293a.999.999 0 1 1 1.414 1.414l-7 7A.997.997 0 0 1 9 14" data-reactid=".0.0.5.3.1.$quality.0.0.0.0.1.0.0"></path></svg> Back';
		backButton.addEventListener('click', this.showSettingsList.bind(this));
		qualityLevelsList.appendChild(backButton);

		playerInstance.on('levels', function (data) {
			// in Safari in data.levels array there is one element with label = '0'
			var isQualityListEmpty = !data.levels.length || (data.levels.length === 1 && data.levels[0].label === '0');

			this.wikiaSettingsElement.classList.toggle(isQualityListEmptyClass, isQualityListEmpty);
			this.updateQualityLevelsList(qualityLevelsList, data.levels, isActiveClass, backButton);
		}.bind(this));

		playerInstance.on('levelsChanged', this.updateCurrentQuality.bind(this, qualityLevelsList, isActiveClass));

		return qualityLevelsList;
	};

	WikiaJWPlayerSettings.prototype.updateQualityLevelsList = function (qualityLevelsList, newLevels, isActiveClass, backButton) {
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

	WikiaJWPlayerSettings.prototype.updateCurrentQuality = function (qualityLevelsList, isActiveClass, data) {
		qualityLevelsList.childNodes.forEach(function (node, index) {
			if (data.currentQuality === index) {
				node.classList.add(isActiveClass);
			} else {
				node.classList.remove(isActiveClass);
			}
		});
	};

	return function () {
		jwplayer().registerPlugin('wikiaSettings', '8.0.0', WikiaJWPlayerSettings);
	};
});
