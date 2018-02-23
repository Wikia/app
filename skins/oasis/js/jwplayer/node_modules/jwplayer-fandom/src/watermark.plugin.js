function WikiaJWPlayerWatermarkPlugin(player, config, div) {
	this.player = player;
	this.container = div;
	this.config = config;
	this.watermarkElement = this.getWatermarkElement();
	this.watermarkElement.addEventListener('click', function () {
		player.trigger('watermarkClicked');
	});

	this.container.classList.add('wikia-watermark-container');
	this.container.appendChild(this.watermarkElement);

	this.isEnabled = !!this.player.getPlaylistItem(0).watermark;

	this.player.on('play', this.update.bind(this));
	this.player.on('pause', this.update.bind(this));
	this.player.on('idle', this.update.bind(this));
	this.player.on('relatedVideoPlay', this.onVideoChange.bind(this));
}

/**
 * prepares watermark link with icon
 */
WikiaJWPlayerWatermarkPlugin.prototype.getWatermarkElement = function () {
	var watermarkImage = wikiaJWPlayerIcons['fandomLogo'];

	var watermarkElement = document.createElement('a');
	watermarkElement.classList.add('wikia-watermark');
	watermarkElement.innerHTML = watermarkImage;
	watermarkElement.href = 'https://fandom.com';

	return watermarkElement;
};

WikiaJWPlayerWatermarkPlugin.prototype.update = function () {
	if(this.isEnabled && this.player.getState() === 'playing') {
		this.container.style.display = 'block';
	} else {
		this.container.style.display = '';
	}
};

/**
 * hides the entire plugin (button and settings menu)
 */
WikiaJWPlayerWatermarkPlugin.prototype.onVideoChange = function (data) {
	this.isEnabled = !!data.item.watermark;
	this.update();
};

WikiaJWPlayerWatermarkPlugin.register = function () {
	jwplayer().registerPlugin('wikiaWatermark', '8.0.0', WikiaJWPlayerWatermarkPlugin);
};
