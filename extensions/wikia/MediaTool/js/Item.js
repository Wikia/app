MediaTool.Item = $.createClass(Observable,{

	id: null,
	title: null,
	thumbHtml: null,
	thumbUrl: null,
	remoteUrl: null,
	editable: false,
	origin: 'local',
	changed: false,
	isVideo: true,
	duration: '00:00',
	renderer: null,
	ratio: 1,
	uploader: null,
	caption: '',
	isFollowed: null,
	name: null,
	description: null,

	constructor: function( itemData ) {
		MediaTool.Item.superclass.constructor.call(this);
		this.renderer = new MediaTool.Renderer();

		this.id = MediaTool.Item.createId( itemData.origin, itemData.hash );
		this.title = itemData.title;
		this.thumbHtml = itemData.thumbHtml;
		this.thumbUrl = itemData.thumbUrl;
		this.isVideo = itemData.isVideo;
		this.origin = itemData.origin;
		this.caption = itemData.caption;
		if (this.origin === "local") {
			this.isFollowed =  itemData.isFollowed;
		} else if (this.origin === "online") {
			this.isFollowed =  MediaTool.getUserFollowSetting();
		}
		this.description = itemData.description;
		this.name = itemData.name;

		this.uploader = new MediaTool.User(itemData.uploaderId, itemData.uploaderName, itemData.uploaderPage, itemData.uploaderAvatar);

		this.ratio = 1.7777778; // 16/9
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

MediaTool.Item.createId = function( origin, hash ) {
	if (origin !== "online") origin = "wiki";
	return origin + '-' + hash;
}