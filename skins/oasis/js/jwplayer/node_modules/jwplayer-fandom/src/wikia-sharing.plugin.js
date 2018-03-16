var isActiveClass = 'is-active',
	domParser = new DOMParser();

function wikiaJWPlayerSharingPlugin(player, config, div) {
	this.player = player;
	this.container = div;
	this.wikiaSharingElement = document.createElement('div');
	this.buttonID = 'wikiaSharing';
	this.config = config;
	this.documentClickHandler = this.documentClickHandler.bind(this);

	this.container.classList.add('wikia-jw-sharing__plugin');
	this.wikiaSharingElement.classList.add('wikia-jw-sharing');
	this.addSharingContent(this.wikiaSharingElement);
	this.container.appendChild(this.wikiaSharingElement);

	document.addEventListener('click', this.documentClickHandler);
	// fixes issue when opening the menu on iPhone 5, executing documentClickHandler twice doesn't break anything
	document.addEventListener('touchend', this.documentClickHandler);
}

wikiaJWPlayerSharingPlugin.prototype.isSharingMenuOrSharingButton = function (element) {
	var button = this.getSharingButtonElement();

	return button && (button === element ||
		button.contains(element) ||
		this.wikiaSharingElement === element ||
		this.wikiaSharingElement.contains(element));
};

wikiaJWPlayerSharingPlugin.prototype.getSharingButtonElement = function () {
	return this.player.getContainer().querySelector('[button=' + this.buttonID + ']');
};

wikiaJWPlayerSharingPlugin.prototype.documentClickHandler = function (event) {
	// check if user didn't click the sharing menu or sharing button and if sharing menu is open
	if (!this.isSharingMenuOrSharingButton(event.target) && this.container.style.display) {
		this.close();
	}
};

wikiaJWPlayerSharingPlugin.prototype.addButton = function () {
	var sharingIcon = createSVG(wikiaJWPlayerIcons.sharing);

	sharingIcon.classList.add('jw-svg-icon');
	sharingIcon.classList.add('jw-svg-icon-wikia-sharing');

	this.player.addButton(sharingIcon.outerHTML, this.config.i18n.sharing, function () {
		if (!this.wikiaSharingElement.style.display) {
			this.open();
		} else {
			this.close();
		}
	}.bind(this), this.buttonID, 'wikia-jw-sharing-button');
};

wikiaJWPlayerSharingPlugin.prototype.removeButton = function () {
	this.player.removeButton(this.buttonID);
};

/**
 * closes sharing menu
 */
wikiaJWPlayerSharingPlugin.prototype.close = function () {
	this.container.style.display = null;
	this.player.getContainer().classList.remove('wikia-jw-sharing-open');
};

/**
 * opens sharing menu
 */
wikiaJWPlayerSharingPlugin.prototype.open = function () {
	this.wikiaSharingElement.innerHTML = '';
	this.wikiaSharingElement.appendChild(this.createSharingListElement());
	showElement(this.container);
	this.player.trigger('wikiaShareMenuExpanded');
	this.player.getContainer().classList.add('wikia-jw-sharing-open');
};

/**
 * hides the entire plugin (button and sharing menu)
 */
wikiaJWPlayerSharingPlugin.prototype.hide = function () {
	this.close();
	this.removeButton();
};

/**
 * shows back the entire plugin (adds button back)
 */
wikiaJWPlayerSharingPlugin.prototype.show = function () {
	if (!this.getSharingButtonElement()) {
		this.addButton();
	}
};

wikiaJWPlayerSharingPlugin.prototype.addSharingContent = function (div) {
	div.classList.add('wikia-jw-sharing');
	div.classList.remove('jw-reset');
	div.classList.remove('jw-plugin');

	this.show();
};

wikiaJWPlayerSharingPlugin.prototype.createSharingListElement = function () {
	var sharingList = document.createElement('ul');

	sharingList.className = 'wikia-jw-sharing__list wds-list';

	var userLang = this.getUserLang(),
		socialNetworks = this.socialNetworks[userLang];

	if (socialNetworks) {
		socialNetworks.forEach(function (socialNetwork) {
			sharingList.appendChild(this.getSocialNetworkButton(socialNetwork));
		}.bind(this));
	}

	return sharingList;
};

wikiaJWPlayerSharingPlugin.prototype.getSocialNetworkButton = function (socialNetwork) {
	var button = document.createElement('button');

	button.className = 'wds-is-square wds-is-' + socialNetwork + '-color wds-button';
	button.appendChild(createSVG(wikiaJWPlayerIcons[socialNetwork]));
	button.addEventListener('click', function () {
		this.player.trigger('socialNetworkClicked', {socialNetwork: socialNetwork});
		window.open(this[socialNetwork]());
	}.bind(this));

	return button;
};

wikiaJWPlayerSharingPlugin.prototype.getUserLang = function() {
	return (window.navigator.userLanguage || window.navigator.language).slice(0, 2);
};

wikiaJWPlayerSharingPlugin.prototype.socialNetworks = {
	en: [
		'facebook',
		'twitter',
		'reddit',
		'tumblr'
	],
	ja: [
		'facebook',
		'twitter',
		'google',
		'line'
	],
	'pt-br': [
		'facebook',
		'twitter',
		'reddit',
		'tumblr'
	],
	zh: [
		'facebook',
		'weibo'
	],
	de: [
		'facebook',
		'twitter',
		'tumblr'
	],
	fr: [
		'facebook',
		'twitter'
	],
	es: [
		'facebook',
		'twitter',
		'meneame',
		'tumblr'
	],
	ru: [
		'vkontakte',
		'facebook',
		'odnoklassniki',
		'twitter'
	],
	pl: [
		'facebook',
		'twitter',
		'nk',
		'wykop'
	]
};

wikiaJWPlayerSharingPlugin.prototype.getVideoPageUrl = function () {
	return 'https://fandom.wikia.com/video/' + this.player.getPlaylistItem().mediaId;
};

wikiaJWPlayerSharingPlugin.prototype.getVideoTitle = function () {
	return this.player.getPlaylistItem().title;
};

/**
 * link generator for sharing a url on line
 * @returns {string}
 */
wikiaJWPlayerSharingPlugin.prototype.line = function () {
	return 'http://line.me/R/msg/text/?' + encodeURIComponent(this.getVideoTitle() +
		' ' + this.getVideoPageUrl());
};

/**
 * link generator for sharing a url on facebook
 * @returns {string}
 */
wikiaJWPlayerSharingPlugin.prototype.facebook = function () {
	return 'http://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(this.getVideoPageUrl());
};

/**
 * link generator for sharing a url on twitter
 * @returns {string}
 */
wikiaJWPlayerSharingPlugin.prototype.twitter = function () {
	return 'https://twitter.com/share?url=' + encodeURIComponent(this.getVideoPageUrl());
};

/**
 * link generator for sharing a url on google
 * @returns {string}
 */
wikiaJWPlayerSharingPlugin.prototype.google = function () {
	return 'https://plus.google.com/share?url=' + encodeURIComponent(this.getVideoPageUrl());
};

/**
 * link generator for sharing a url on reddit
 * @returns {string}
 */
wikiaJWPlayerSharingPlugin.prototype.reddit = function () {
	return 'http://www.reddit.com/submit?url=' + encodeURIComponent(this.getVideoPageUrl()) +
		'&title=' + encodeURIComponent(this.getVideoTitle());
};

/**
 * link generator for sharing a url on tumblr
 * @returns {string}
 */
wikiaJWPlayerSharingPlugin.prototype.tumblr = function () {
	return 'http://www.tumblr.com/share/link?url=' + encodeURIComponent(this.getVideoPageUrl()) +
		'&name=' + encodeURIComponent(this.getVideoTitle());
};

/**
 * link generator for sharing a url on weibo
 * @returns {string}
 */
wikiaJWPlayerSharingPlugin.prototype.weibo = function () {
	return 'http://service.weibo.com/share/share.php?url=' +
		encodeURIComponent(this.getVideoPageUrl()) +
		'&title=' + encodeURIComponent(this.getVideoTitle());
};

/**
 * link generator for sharing a url on vkontakte
 * @returns {string}
 */
wikiaJWPlayerSharingPlugin.prototype.vkontakte = function () {
	return 'http://vk.com/share.php?url=' + encodeURIComponent(this.getVideoPageUrl()) +
		'&title=' + encodeURIComponent(this.getVideoTitle());
};

/**
 * link generator for sharing a url on odnoklassniki
 * @returns {string}
 */
wikiaJWPlayerSharingPlugin.prototype.odnoklassniki = function () {
	return 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st._surl=' +
		encodeURIComponent(this.getVideoPageUrl());
};

/**
 * link generator for sharing a url on nk
 * @returns {string}
 */
wikiaJWPlayerSharingPlugin.prototype.nk = function () {
	return 'http://nk.pl/sledzik?shout=' + encodeURIComponent(this.getVideoPageUrl());
};

/**
 * link generator for sharing a url on wykop
 * @returns {string}
 */
wikiaJWPlayerSharingPlugin.prototype.wykop = function () {
	return 'http://www.wykop.pl/dodaj/link/' +
		'?url=' + encodeURIComponent(this.getVideoPageUrl()) +
		'&title=' + encodeURIComponent(this.getVideoTitle());
};

/**
 * link generator for sharing a url on meneame
 * @returns {string}
 */
wikiaJWPlayerSharingPlugin.prototype.meneame = function () {
	return 'https://www.meneame.net/submit.php?url=' + encodeURIComponent(this.getVideoPageUrl());
};

wikiaJWPlayerSharingPlugin.register = function () {
	jwplayer().registerPlugin('wikiaSharing', '8.0.0', wikiaJWPlayerSharingPlugin);
};
