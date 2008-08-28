(function() {
var Dom = YAHOO.util.Dom;
var Event = YAHOO.util.Event;
var DDM = YAHOO.util.DragDropMgr;

/**
 * @author Inez Korczynski
 */
var value = null;
Event.onDOMReady(function() {
	searchField = Dom.get('search_field');

	defaultValue = searchField.title;
	doBlur = true;

	if (searchField.value == '') {
		searchField.value = searchField.title;
	}
	else if (searchField.value != searchField.title) {
		Dom.addClass(searchField, 'field_active');
		doBlur = false; // allow user to continue typing after page is loaded
	}
	Event.addListener(searchField, 'click', function() {
		if(defaultValue == null || defaultValue == searchField.value) {
			searchField.value = '';
			Dom.addClass(searchField, 'field_active');
		}
		searchField.focus();
	});
	// solves strange issue described in #3083
	Event.addListener(searchField, 'keypress', function() {
		if(defaultValue == null || defaultValue == searchField.value) {
			searchField.value = '';
			Dom.addClass(searchField, 'field_active');
		}
	});

	Event.addListener(searchField, 'blur', function() {
		if(searchField.value == '') {
			searchField.value = defaultValue;
			Dom.removeClass(searchField, 'field_active');
		}
	});
	Event.addListener('search_button', 'click', function() {
		if (searchField.value == defaultValue) {
			searchField.value = '';
		}

		Dom.get('searchform').submit();
	});

	// #3083: blur() is buggy in IE
	if (doBlur) {
		searchField.disabled = true;
		searchField.disabled = false;
	}

	var submitAutoComplete_callback = {
		success: function(o) {
			if(o.responseText !== undefined) {
				window.location.href=o.responseText;
			}
		}
	}

	var submitAutoComplete = function(comp, resultListItem) {
		YAHOO.Wikia.Tracker.trackByStr(null, 'search/suggestItem/' + escape(YAHOO.util.Dom.get('search_field').value.replace(/ /g, '_')));
		sUrl = wgServer + wgScriptPath + '?action=ajax&rs=getSuggestedArticleURL&rsargs=' + encodeURI(Dom.get('search_field').value);
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, submitAutoComplete_callback);
	}

	Event.addListener('search_field', 'keypress', function(e) {if(e.keyCode==13) {Dom.get('searchform').submit();}});

	// Init datasource
	var oDataSource = new YAHOO.widget.DS_XHR(wgServer + wgScriptPath, [ "\n" ]);
	oDataSource.responseType = YAHOO.widget.DS_XHR.TYPE_FLAT;
	oDataSource.scriptQueryParam = "rsargs";
	oDataSource.scriptQueryAppend = "action=ajax&rs=searchSuggest";

	// Init AutoComplete object and assign datasource object to it
	var oAutoComp = new YAHOO.widget.AutoComplete('search_field','searchSuggestContainer', oDataSource);
	oAutoComp.highlightClassName = oAutoComp.prehighlightClassName = 'navigation-hover';
	oAutoComp.autoHighlight = false;
	oAutoComp.typeAhead = true;
	oAutoComp.queryDelay = 1;
	oAutoComp.itemSelectEvent.subscribe(submitAutoComplete);
});

/**
 * @author Inez Korczynski
 */
//Event.onContentReady("navigation", function() {
//	var navMenu = new YAHOO.widget.Menu("navigation", { position: "static", showdelay: 0, hidedelay: 750 });
//	navMenu.render();
//	Dom.addClass("navigation", "navLoaded");
//});

/**
 * @author Christian Williams, Inez Korczynski
 */
Event.onContentReady("background_strip", function() {
	function pos(menuId, buttonId, side) {
		Event.addListener(buttonId, 'click', function() {

			// #3187
			var headerY = parseInt(Dom.getY('wikia_header'));
			Dom.setStyle(menuId, 'top', headerY + (menuId == 'headerMenuHub' ? 50 : 32) + 'px');

			// #3108
			if (Dom.hasClass('body', 'rtl')) {
				if(menuId == 'headerMenuUser') {
					var buttonCenter = Dom.getViewportWidth() - (Dom.getX(this) + this.offsetWidth/2) - 10;
				} else {
					var buttonCenter = YAHOO.util.Dom.getX(this) + this.offsetWidth/2;
				}
				var menuWidth = Dom.get(menuId).offsetWidth;
				if((buttonCenter - (menuWidth/2)) < 10) {
					targetRight = 10;
				} else {
					targetRight = buttonCenter - (menuWidth/2);
				}
				Dom.setStyle(menuId, side, targetRight + 'px');
			}

			if (Dom.getStyle(menuId, 'visibility') == 'visible') {
				Dom.setStyle(menuId, 'visibility', 'hidden');
			} else {
				Dom.setStyle(menuId, 'visibility', 'visible');
			}
		});
		var headerMenuTimer, headerButtonTimer;
		Event.addListener(buttonId, 'mouseout', function() {
			headerButtonTimer = setTimeout("YAHOO.util.Dom.get('"+menuId+"').style.visibility = 'hidden';", 1500);
		});
		Event.addListener(menuId, 'mouseout', function() {
			headerMenuTimer = setTimeout("YAHOO.util.Dom.get('"+menuId+"').style.visibility = 'hidden';", 300);
		});
		Event.addListener(menuId, 'mouseover', function() {
			clearTimeout(headerButtonTimer);
			clearTimeout(headerMenuTimer);
		});
	}
	pos('headerMenuUser', 'headerButtonUser', 'right');
	pos('headerMenuHub', 'headerButtonHub', 'left');
});

/**
 * @author Inez Korczynski
 */
Event.onDOMReady(function() {
	var callback = {
		success: function(o) {
			o = YAHOO.Tools.JSONParse(o.responseText);
			Dom.setStyle('current-rating', 'width', Math.round(o.item.wkvoteart[0].avgvote * 17)+'px');
			Dom.setStyle(['star1','star2','star3','star4','star5'], 'display', o.item.wkvoteart[0].remove ? '' : 'none');
			Dom.setStyle('unrateLink', 'display', o.item.wkvoteart[0].remove ? 'none' : '');
			YAHOO.util.Dom.removeClass('star-rating', 'star-rating-progress');
			YAHOO.util.Connect.asyncRequest('POST', window.location.href, null, "action=purge");
		}
	}
	Event.addListener('unrateLink', 'click', function(e) {
		Event.preventDefault(e);
		YAHOO.util.Connect.asyncRequest('GET', wgScriptPath+'/api.php?action=delete&list=wkvoteart&format=json&wkpage='+wgArticleId, callback);
		YAHOO.util.Dom.addClass('star-rating', 'star-rating-progress');
		Dom.setStyle('unrateLink', 'display', 'none');
		YAHOO.Wikia.Tracker.trackByStr(e, 'ArticleFooter/vote/unrate');
	});
	Event.addListener(['star1','star2','star3','star4','star5'], 'click', function(e) {
		Event.preventDefault(e);
		var rating = this.id.substr(4,1);
		YAHOO.util.Connect.asyncRequest('GET', wgScriptPath+'/api.php?action=insert&list=wkvoteart&format=json&wkvote='+rating+'&wkpage='+wgArticleId, callback);
		YAHOO.util.Dom.addClass('star-rating', 'star-rating-progress');
		YAHOO.Wikia.Tracker.trackByStr(e, 'ArticleFooter/vote/' + rating);
	});

	// fix for IE6(#1843)
	if (YAHOO.env.ua.ie == 6) {
		Event.addListener(['star1','star2','star3','star4','star5'], 'mouseover', function(e) {
			var rating = this.id.substr(4,1);
			YAHOO.util.Dom.addClass(this, 'hover');
			YAHOO.util.Dom.setStyle(this, 'width', parseInt(rating*17) + 'px');
		});
		Event.addListener(['star1','star2','star3','star4','star5'], 'mouseout', function(e) {
			YAHOO.util.Dom.removeClass(this, 'hover');
			YAHOO.util.Dom.setStyle(this, 'width', '17px');
		});
	}
});

Event.onDOMReady(function() {
	Event.addListener('body', 'mouseover', clearMenu);
});

})();

//Edit Tips
var editorMode = 'normal';
function editorAnimate(editorModeRequest) {
	var animationSpeed = .75;
	var easing = YAHOO.util.Easing.easeOut;
	if (editorModeRequest == editorMode) {
		var sidebarAnim = new YAHOO.util.Anim('widget_sidebar', {
			left: { to: 5 }
		}, animationSpeed, easing);
		var pageAnim = new YAHOO.util.Anim('wikia_page', {
			marginLeft: { to: 221 }
		}, animationSpeed, easing);
		var editorAnim = new YAHOO.util.Anim(['editTipWrapper2', 'wikiPreview'], {
			marginLeft: { to: 0 }
		}, animationSpeed, easing);
		var previewAnim = new YAHOO.util.Anim(['wikiPreview', 'wikiPreview'], {
			marginLeft: { to: 0 }
		}, animationSpeed, easing);

		sidebarAnim.animate();
		pageAnim.animate();
		editorAnim.animate();
		previewAnim.animate();
		YAHOO.util.Dom.get('editTipsLink').innerHTML = 'Show Editing Tips';
		YAHOO.util.Dom.get('editWideLink').innerHTML = 'Go Widescreen';
		AccordionMenu.seriouslyCollapseAll('editTips');
		editorMode = 'normal';
	} else if (editorModeRequest == 'tips') {
		var sidebarAnim = new YAHOO.util.Anim('widget_sidebar', {
			left: { to: -211 }
		}, animationSpeed, easing);
		var pageAnim = new YAHOO.util.Anim('wikia_page', {
			marginLeft: { to: 5 }
		}, animationSpeed, easing);
		var editorAnim = new YAHOO.util.Anim('editTipWrapper2', {
			marginLeft: { to: 216 }
		}, animationSpeed, easing);
		var previewAnim = new YAHOO.util.Anim('wikiPreview', {
			marginLeft: { to: 216 }
		}, animationSpeed, easing);

		sidebarAnim.animate();
		pageAnim.animate();
		editorAnim.animate();
		previewAnim.animate();
		YAHOO.util.Dom.get('editTipsLink').innerHTML = 'Show Navigation';
		YAHOO.util.Dom.get('editWideLink').innerHTML = 'Go Widescreen';
		editorMode = 'tips';
	} else if (editorModeRequest == 'wide') {
		var sidebarAnim = new YAHOO.util.Anim('widget_sidebar', {
			left: { to: -211 }
		}, animationSpeed, easing);
		var pageAnim = new YAHOO.util.Anim('wikia_page', {
			marginLeft: { to: 5 }
		}, animationSpeed, easing);
		var editorAnim = new YAHOO.util.Anim('editTipWrapper2', {
			marginLeft: { to: 0 }
		}, animationSpeed, easing);
		var previewAnim = new YAHOO.util.Anim(['wikiPreview', 'wikiPreview'], {
			marginLeft: { to: 216 }
		}, animationSpeed, easing);

		sidebarAnim.animate();
		pageAnim.animate();
		editorAnim.animate();
		previewAnim.animate();
		YAHOO.util.Dom.get('editTipsLink').innerHTML = 'Show Editing Tips';
		YAHOO.util.Dom.get('editWideLink').innerHTML = 'Exit Widescreen';
		AccordionMenu.seriouslyCollapseAll('editTips');
		editorMode = 'wide';
	}
}
//Skin Navigation
var m_timer;
var displayed_menus = new Array();
var last_displayed = '';
var last_over = '';
function menuItemAction(e) {
	clearTimeout(m_timer);
	if (!e) var e = window.event;
	e.cancelBubble = true;
	if (e.stopPropagation) e.stopPropagation();
	var source_id = '*';
	try {source_id = e.target.id;}
	catch (ex) {source_id = e.srcElement.id}
	if (source_id.indexOf("a-") == 0) {
		source_id = source_id.substr(2);
	}
	if (source_id && menuitem_array[source_id]) {
		if ($(last_over)) YAHOO.util.Dom.removeClass(last_over, "navigation-hover");
		last_over = source_id;
		YAHOO.util.Dom.addClass(source_id, "navigation-hover");
		check_item_in_array(menuitem_array[source_id], source_id);
	}
}
function check_item_in_array(item, source_id) {
	clearTimeout(m_timer);
	var sub_menu_item = 'sub-menu' + item;
	if (last_displayed == '' || ((sub_menu_item.indexOf(last_displayed) != -1) && (sub_menu_item != last_displayed))) {
		do_menuItemAction(item, source_id);
	} else {
		var exit = false;
		count = 0;
		var the_last_displayed;
		while( !exit && displayed_menus.length > 0 ) {
			the_last_displayed = displayed_menus.pop();
			if ((sub_menu_item.indexOf(the_last_displayed.item) == -1)) {
				doClear(the_last_displayed.item, '');
				YAHOO.util.Dom.removeClass(the_last_displayed.source, "navigation-hover");
			}
			else {
				displayed_menus.push(the_last_displayed);
				exit = true;
				//do_menuItemAction(item, source_id);
			}
			count++;
		}
		do_menuItemAction(item, source_id);
	}
}
function do_menuItemAction(item, source_id) {
	if ($('sub-menu'+item)) {
		$('sub-menu'+item).style.display="block";
		YAHOO.util.Dom.addClass(source_id, "navigation-hover");
		displayed_menus.push({"item":'sub-menu'+item,"source":source_id});
		last_displayed = 'sub-menu'+item;
	}
}
function sub_menuItemAction(e) {
	clearTimeout(m_timer);
	if (!e) var e = window.event;
	e.cancelBubble = true;
	if (e.stopPropagation) e.stopPropagation();
	var source_id = '*';
	try {source_id = e.target.id;}
	catch (ex) {source_id = e.srcElement.id}
	if (source_id.indexOf("a-") == 0) {
		source_id = source_id.substr(2);
	}
	if (source_id && submenuitem_array[source_id]) {
		check_item_in_array(submenuitem_array[source_id], source_id);
		for (var i=0; i<displayed_menus.length; i++) {
			YAHOO.util.Dom.addClass(displayed_menus[i].source, "navigation-hover");
		}
	}
}
function clearBackground(e) {
	if (!e) var e = window.event;
	e.cancelBubble = true;
	if (e.stopPropagation) e.stopPropagation();
	var source_id = '*';
	try {source_id = e.target.id;}
	catch (ex) {source_id = e.srcElement.id}
	var source_id = (source_id.indexOf("a-") == 0) ? source_id.substr(2) : source_id;
	if (source_id && $(source_id) && menuitem_array[source_id]) {
		YAHOO.util.Dom.removeClass(source_id, "navigation-hover");
		clearMenu(e);
	}
}
function clearMenu(e) {
	clearTimeout(m_timer);
	m_timer = setTimeout(function() { doClearAll(); }, 300);
}
function doClear(item, type) {
	if ($(type+item)) {
		$(type+item).style.display="none";
	}
}
function doClearAll() {
	var the_last_displayed;
	while( displayed_menus.length > 0 ) {
		the_last_displayed = displayed_menus.pop();
		doClear(the_last_displayed.item, '');
		YAHOO.util.Dom.removeClass(the_last_displayed.source, "navigation-hover");
	}
	last_displayed = '';
}
