/*
Copyright (c) 2007, Wikia Inc.
Author: Inez Korczynski (inez (at) wikia.com)
*/
function initUserMenu() {
	var userMenu = new YAHOO.widget.Menu("userMenuMain" , { hidedelay: 800 });
	userMenu.render();
	YAHOO.util.Event.addListener("userMenuToggle", "click", userMenu.show, null, userMenu);
};
YAHOO.util.Event.onContentReady("userMenuMain", initUserMenu);