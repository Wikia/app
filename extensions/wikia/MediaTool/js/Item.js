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
		if(thumbHtml != false) {
			this.thumbHtml = thumbHtml;
		}
		else {
			this.renderThumbHtml();
		}
	},

	renderThumbHtml: function() {
		var renderer = new MediaTool.Renderer();
		this.thumbHtml = renderer.getMediaThumb(this);
	}

});
