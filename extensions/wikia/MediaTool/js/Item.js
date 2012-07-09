MediaTool.Item = $.createClass(Observable,{

	id: null,
	video: null,
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
			var renderer = new MediaTool.Renderer();
			this.thumbHtml = renderer.getMediaThumb(this);
		}
	}

});
