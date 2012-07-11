MediaTool.User = $.createClass(Observable,{

	id: 0,
	name: null,
	userPageUrl: null,
	avatarUrl: null,

	constructor: function(id, name, userPageUrl, avatarUrl) {
		MediaTool.User.superclass.constructor.call(this);

		this.id = id;
		this.name = name;
		this.userPageUrl = userPageUrl;
		this.avatarUrl = avatarUrl;
	}

});