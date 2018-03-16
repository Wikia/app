function wikiaJWPlayerSmallPlayerControls(player, config, div) {
	this.player = player;
	this.container = div;
	this.config = config;
	this.muteIcon = createSVG(wikiaJWPlayerIcons.volumeOff);
	this.playIcon = createSVG(wikiaJWPlayerIcons.play);
	this.pauseIcon = createSVG(wikiaJWPlayerIcons.pause);
	this.container.classList.add('wikia-jw-small-player-controls-plugin');
	this.wikiaControlsElement = document.createElement('div');
	this.wikiaControlsElement.appendChild(this.muteIcon);
	this.wikiaControlsElement.appendChild(this.pauseIcon);

	this.unmuteHandler = this.unmuteHandler.bind(this);
	this.playHandler = this.playHandler.bind(this);
	this.pauseHandler = this.pauseHandler.bind(this);
	this.readyHandler = this.readyHandler.bind(this);
	this.resizeHandler = this.resizeHandler.bind(this);

	this.container.addEventListener('click', this.unmuteHandler);
	this.pauseIcon.addEventListener('click', this.pauseHandler);
	this.playIcon.addEventListener('click', this.playHandler);

	this.player.on('resize', this.resizeHandler);
	this.player.on('ready', this.readyHandler);
}

wikiaJWPlayerSmallPlayerControls.prototype.readyHandler = function () {
	if (this.player.getWidth() <= 250) {
		this.player.getContainer().classList.add('wikia-jw-small-player-controls');
		this.container.appendChild(this.wikiaControlsElement);
	}
};

wikiaJWPlayerSmallPlayerControls.prototype.unmuteHandler = function () {
	this.player.setMute(false);
};

wikiaJWPlayerSmallPlayerControls.prototype.pauseHandler = function () {
	var icon = this.container.firstChild.childNodes[1];

	icon.parentNode.replaceChild(this.playIcon, icon);
	this.player.pause();
};

wikiaJWPlayerSmallPlayerControls.prototype.playHandler = function () {
	var icon = this.container.firstChild.childNodes[1];

	icon.parentNode.replaceChild(this.pauseIcon, icon);
	this.player.play();
};

wikiaJWPlayerSmallPlayerControls.prototype.resizeHandler = function (playerDimensions) {
	if (playerDimensions.width > 250) {
		this.player.getContainer().classList.remove('wikia-jw-small-player-controls');
	}
};

wikiaJWPlayerSmallPlayerControls.register = function () {
	jwplayer().registerPlugin('smallPlayerControls', '8.0.0', wikiaJWPlayerSmallPlayerControls);
};