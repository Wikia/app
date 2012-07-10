MediaTool.Item = $.createClass(Observable,{

	id: null,
	title: null,
	thumbHtml: null,
	thumbUrl: null,
	remoteUrl: null,
	editable: false,
	origin: 'wiki',
	isVideo: true,
	duration: '00:00',
	renderer: null,

	constructor: function(id, title, thumbHtml, thumbUrl) {
		MediaTool.Item.superclass.constructor.call(this);
		this.renderer = new MediaTool.Renderer();

		this.id = id;
		this.title = title;
		this.thumbHtml = thumbHtml;
		this.thumbUrl = thumbUrl;
	},

	renderThumbHtml: function() {
		if(this.thumbHtml == false) {
			this.thumbHtml = this.renderer.getMediaThumb(this);
		}
	},

	renderPreview: function(itemPreviewTpl) {
		return this.renderer.getPreview(this, itemPreviewTpl);
	}

});
