MediaTool.Item = $.createClass(Observable,{

	id: null,
	video: null,
	duration: '00:00',
	file: null,
	thumbHtml: null,
	editable: false,
	origin: 'wiki',

	constructor: function(id, video, file, thumbHtml) {
		MediaTool.Item.superclass.constructor.call(this);

		this.id = id;
		this.video = video;
		this.file = file;
		this.thumbHtml = thumbHtml;
	},

	renderThumbHtml: function() {
		if(this.thumbHtml == false) {
			var renderer = new MediaTool.Renderer();
			this.thumbHtml = renderer.getMediaThumb(this);
		}
	},

	renderPreview: function() {
		var renderer = new MediaTool.Renderer();
		return renderer.getPreview(this);
	}

});
