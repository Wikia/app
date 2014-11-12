ve.dm.WikiaImageCartItem = function VeDmWikiaImageCartItem( title, url ) {
	this.title = title;
	this.url = url;
};

ve.dm.WikiaImageCartItem.prototype.getId = function () {
	return this.title;
};
