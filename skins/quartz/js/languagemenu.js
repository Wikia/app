/*
Copyright (c) 2007, Wikia Inc.
Author: Inez Korczynski (inez (at) wikia.com)

function initLanguageMenu() {
	var toggleLanguageMenu = function () {
		if(YAHOO.util.Dom.getStyle("languageMenu", "display") == "none") {
			YAHOO.util.Dom.setStyle("languageMenu", "display", "block");
		} else {
			YAHOO.util.Dom.setStyle("languageMenu", "display", "none");
		}
	}
	YAHOO.util.Event.addListener("languageMenuToggle", "click", toggleLanguageMenu);
};
YAHOO.util.Event.onContentReady("languageMenu", initLanguageMenu);
*/


function initLangMenu() {
	var langMenu = new YAHOO.widget.Menu("languageMenuMain" , { hidedelay: 800 });
	langMenu.render();
	YAHOO.util.Event.addListener("languageMenuToggle", "click", langMenu.show, null, langMenu);
};
YAHOO.util.Event.onContentReady("languageMenuMain", initLangMenu);