MediaTool.Item = $.createClass(Observable,{

	id: null,
	video: null,
	file: null,
	thumbHtml: null,
	editable: false,

	constructor: function(id, video, file, thumbHtml) {
		MediaTool.Item.superclass.constructor.call(this);

		this.id = id;
		this.video = video;
		this.file = file;
		this.thumbHtml = thumbHtml;
	}

});
