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
	ratio: 1,
	uploader: null,

	constructor: function(id, title, thumbHtml, thumbUrl) {
		MediaTool.Item.superclass.constructor.call(this);
		this.renderer = new MediaTool.Renderer();

		this.id = id;
		this.title = title;
		this.thumbHtml = thumbHtml;
		this.thumbUrl = thumbUrl;
		this.ratio = 16/9;
	},

	renderThumbHtml: function() {
		if(this.thumbHtml == false) {
			this.thumbHtml = this.renderer.getMediaThumb(this);
		}
	},

	renderPreview: function( params ) {
		return this.renderer.getPreview(this, params);
	},

	getHeight: function( width ) {
		return Math.floor( width / this.ratio );
	}

});
