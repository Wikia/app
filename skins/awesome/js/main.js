//macbre: moved here from onejstorule.js
var $G = YAHOO.util.Dom.get;

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
		sUrl = wgServer + wgScriptPath + '?action=ajax&rs=getSuggestedArticleURL&rsargs=' + encodeURIComponent(Dom.get('search_field').value);
		var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, submitAutoComplete_callback);
	}

	Event.addListener('search_field', 'keypress', function(e) {if(e.keyCode==13) {Dom.get('searchform').submit();}});

	// Init datasource
	var oDataSource = new YAHOO.widget.DS_XHR(wgServer + wgScriptPath, ["\n"]);
	oDataSource.responseType = YAHOO.widget.DS_XHR.TYPE_FLAT;
	oDataSource.scriptQueryAppend = "action=ajax&rs=getLinkSuggest";

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

/*
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
		// #3374
		Event.addListener(buttonId, 'mouseover', function() {
			clearTimeout(headerButtonTimer);
			clearTimeout(headerMenuTimer);
		});
		Event.addListener(menuId, 'mouseover', function() {
			clearTimeout(headerButtonTimer);
			clearTimeout(headerMenuTimer);
		});
	}
	//pos('headerMenuUser', 'headerButtonUser', 'right');
	//pos('headerMenuHub', 'headerButtonHub', 'left');
});

Event.onDOMReady(function() {
	Event.addListener('body', 'mouseover', clearMenu);
});
*/

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
		if ($G(last_over)) YAHOO.util.Dom.removeClass(last_over, "navigation-hover");
		last_over = source_id;
		YAHOO.util.Dom.addClass(source_id, "navigation-hover");
		check_item_in_array(menuitem_array[source_id], source_id);
	}
}
function check_item_in_array(item, source_id) {
	clearTimeout(m_timer);
	var sub_menu_item = 'sub-menu' + item;
	if (last_displayed == '' || ((sub_menu_item.indexOf(last_displayed + '_') != -1) && (sub_menu_item != last_displayed + '_'))) {
		do_menuItemAction(item, source_id);
	} else {
		var exit = false;
		count = 0;
		var the_last_displayed;
		while( !exit && displayed_menus.length > 0 ) {
			the_last_displayed = displayed_menus.pop();
			if ((sub_menu_item.indexOf(the_last_displayed.item + '_') == -1)) {
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
	if ($G('sub-menu'+item)) {
		$G('sub-menu'+item).style.display="block";
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
	if (source_id && $G(source_id) && menuitem_array[source_id]) {
		YAHOO.util.Dom.removeClass(source_id, "navigation-hover");
		clearMenu(e);
	}
}
function clearMenu(e) {
	clearTimeout(m_timer);
	m_timer = setTimeout(function() { doClearAll(); }, 300);
}
function doClear(item, type) {
	if ($G(type+item)) {
		$G(type+item).style.display="none";
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

// By Inez
var menuInitCalled = false;
var submenu_array = new Array();
var submenuitem_array = new Array();
var menuitem_array = new Array();
var magicItemsCounter = 0;
var menuInitCalled = false;
var magicCounter = 1000;
var editthispage = false;
function menuInit() {
	if(menuInitCalled) {
		return;
	}
	menuInitCalled = true;
	if($G('ca-edit')) {
		editthispage = $G('ca-edit').href;
	}
	if(typeof wgMenuEdit != 'undefined') menuArray[2000] = {'href' : YAHOO.util.Dom.hasClass('navigation', 'userMenu') ? wgScript + '?title=User:'+wgUserName+'/Monaco-sidebar&action=edit' : wgScript + '?title=MediaWiki:Monaco-sidebar&action=edit', 'text' : wgMenuEdit, 'className' : 'Monaco-sidebar_edit'};
	for(var i in menuArray.mainMenu) {
		var out = '<div class="sub-menu widget" id="sub-menu_'+i+'" style="display:none">';
		var items = new Array();
		if(typeof menuArray.mainMenu[i] == 'object') {
			if(typeof wgMenuEdit != 'undefined') menuArray.mainMenu[i].push(2000);
			for(var j = 0; j < menuArray.mainMenu[i].length; j++) {
				var id = menuArray.mainMenu[i][j];
				if(menuArray[id]['href'] == 'editthispage') {
					if(editthispage) {
						menuArray[id]['href'] = editthispage;
					} else {
						continue;
					}
				}
				out += '<div class="menu-item'+(j == menuArray.mainMenu[i].length-1 ? ' border-fix' : '')+'" id="sub-menu-item_'+i+'_'+id+'">';
				out += '<a'+(menuArray[id]['className'] ? ' class="'+menuArray[id]['className']+'"' : '')+' id="a-sub-menu-item_'+i+'_'+id+'" href="'+menuArray[id]['href']+'" rel="nofollow">'+menuArray[id]['text']+(menuArray[id]['children'] || menuArray[id]['magic'] ? '<em>&rsaquo;</em>' : '')+'</a>';
				out += '</div>';
				submenuitem_array['sub-menu-item_'+i+'_'+id] = '_'+i+'_'+id;
				items.push('a-sub-menu-item_'+i+'_'+id);
			}
		} else {
			for(var j = 0; j < magicWords[menuArray.mainMenu[i]].length; j++) {
				if(magicWords[menuArray.mainMenu[i]][j]['text'] == '-edit-') {
					if(typeof wgMenuEdit == 'undefined') continue;
					magicWords[menuArray.mainMenu[i]][j]['text'] = wgMenuEdit;
				} else if(magicWords[menuArray.mainMenu[i]][j]['text'] == '-more-') {
					magicWords[menuArray.mainMenu[i]][j]['text'] = wgMenuMore;
				}
				out += '<div class="menu-item'+(j == magicWords[menuArray.mainMenu[i]].length-1 ? ' border-fix' : '')+'" id="sub-menu-item_'+i+'_'+magicCounter+'">';
				out += '<a'+(magicWords[menuArray.mainMenu[i]][j]['className'] ? ' class="'+magicWords[menuArray.mainMenu[i]][j]['className']+'"' : '')+' id="a-sub-menu-item_'+i+'_'+magicCounter+'" href="'+magicWords[menuArray.mainMenu[i]][j]['url']+'" rel="nofollow">'+magicWords[menuArray.mainMenu[i]][j]['text']+'</a>';
				out += '</div>';
				submenuitem_array['sub-menu-item_'+i+'_'+magicCounter] = '_'+i+'_'+magicCounter;
				items.push('a-sub-menu-item_'+i+'_'+magicCounter);
				magicCounter++
			}
		}
		out += '</div>';
		var div = document.createElement('div');
		div.id = 'navigation_'+i;
		div.innerHTML = out;
		YAHOO.util.Dom.insertAfter(div, $G('a-menu-item_'+i));
		submenu_array['sub-menu_'+i] = '_'+i;
		$G('sub-menu_'+i).onmouseout = clearMenu;
		if($G('sub-menu_'+i).captureEvents) $G('sub-menu_'+i).captureEvents(Event.MOUSEOUT);
		YAHOO.util.Event.on(items, 'mouseover', sub_menuItemAction_wrap)
		menuitem_array['menu-item_'+i]= '_'+i;
		$G('a-menu-item_'+i).onmouseover = menuItemAction;
		if($G('a-menu-item_'+i).captureEvents) $G('a-menu-item_'+i).captureEvents(Event.MOUSEOVER);
		$G('a-menu-item_'+i).onmouseout = clearBackground;
		if($G('a-menu-item_'+i).captureEvents) $G('a-menu-item_'+i).captureEvents(Event.MOUSEOUT);
	}
	$G('navigation_widget').onmouseout = clearMenu;
}
function sub_menuItemAction_wrap(e) {
	if(!e) var e = window.event;
	var elId = YAHOO.util.Event.getTarget(e).id;
	var menu_id = elId.split('_');
	menu_id = menu_id[menu_id.length-1];

	if(menuArray[menu_id] && (menuArray[menu_id].children || menuArray[menu_id].magic)) {
		var name_part = submenuitem_array[elId.substring(2)];
		var out = '<div class="sub-menu widget" id="sub-menu'+name_part+'" style="display:none">';
		var items = new Array();
		if(menuArray[menu_id].children) {
			for(var j = 0; j < menuArray[menu_id].children.length; j++) {
				var id = menuArray[menu_id].children[j];
				out += '<div class="menu-item'+(j == menuArray[menu_id].children.length-1 ? ' border-fix' : '')+'" id="sub-menu-item'+name_part+'_'+id+'">';
				out += '<a id="a-sub-menu-item'+name_part+'_'+id+'" href="'+menuArray[id].href+'" rel="nofollow">'+menuArray[id].text+(menuArray[id].children || menuArray[id].magic ? '<em>&rsaquo;</em>' : '')+'</a>';
				out += '</div>';
				submenuitem_array['sub-menu-item'+name_part+'_'+id] = name_part+'_'+id;
				items.push('a-sub-menu-item'+name_part+'_'+id);
			}
		} else {
			for(var j = 0; j < magicWords[menuArray[menu_id].magic].length; j++) {
				if(magicWords[menuArray[menu_id].magic][j]['text'] == '-edit-') {
					if(typeof wgMenuEdit == 'undefined') continue;
					magicWords[menuArray[menu_id].magic][j]['text'] = wgMenuEdit;
				} else if(magicWords[menuArray[menu_id].magic][j]['text'] == '-more-') {
					magicWords[menuArray[menu_id].magic][j]['text'] = wgMenuMore;
				}
				out += '<div class="menu-item'+(j == magicWords[menuArray[menu_id].magic].length-1 ? ' border-fix' : '')+'" id="sub-menu-item'+name_part+'_'+magicCounter+'">';
				out += '<a'+(magicWords[menuArray[menu_id].magic][j]['className'] ? ' class="'+magicWords[menuArray[menu_id].magic][j]['className']+'"' : '')+' id="a-sub-menu-item'+name_part+'_'+magicCounter+'" href="'+magicWords[menuArray[menu_id].magic][j]['url']+'" rel="nofollow">'+magicWords[menuArray[menu_id].magic][j]['text']+'</a>';
				out += '</div>';
				submenuitem_array['sub-menu-item'+name_part+'_'+j] = name_part+'_'+magicCounter;
				items.push('a-sub-menu-item'+name_part+'_'+magicCounter);
				magicCounter++
			}
		}
		out += '</div>';
		var div = document.createElement('div');
		div.id = 'navigation'+name_part;
		div.innerHTML = out;
		YAHOO.util.Dom.insertAfter(div, $G('a-sub-menu-item'+name_part));
		submenu_array['sub-menu'+name_part+'_'+menu_id] = name_part+'_'+menu_id;
		YAHOO.util.Event.on(items, 'mouseover', sub_menuItemAction_wrap);
		menuArray[menu_id].children = false;
		menuArray[menu_id].magic = false;
	}
	return sub_menuItemAction(e);
}


//
// macbre: add Christian's code for LeanMonaco
//

//@see http://jamazon.co.uk/web/2008/07/21/jquerygetscript-does-not-cache 
$.ajaxSetup({cache: true});

//Attach DOM-Ready handlers
$(function() {
	$("#headerButtonHub").bind("click.headerMenu", openHubMenu);
	$("#headerButtonUser").bind("click.headerMenu", openUserMenu);
	//$("[rel='manage_widgets']").click(openCockpit);
	$('.ajaxLogin').click(openLogin);
	$(document).ajaxSend(startAjax).ajaxComplete(stopAjax);
	//$("#search_field").autocomplete({ajax: "http://muppet.wikia.com/?query=" + $("#search_field").val() + "&action=ajax&rs=getLinkSuggest"})
	/*
	$("#search_field").autocomplete({ 
		list: ["hello", "hello person", "goodbye"],
		timeout: 300
	});
	*/
	setupVoting();
});

//Ajax Wait Indicator
function startAjax() {
	$("body").addClass("ajax");	
}
function stopAjax() {
	$("body").removeClass("ajax");	
}
/*
//Widget Cockpit
function openCockpit(event) {
	event.preventDefault();
	$.get("cockpit.html", function(html) {
		$("#positioned_elements").append(html);
	});
}
*/

//Hub Menu
function openHubMenu(event) {
	event.preventDefault();
	headerMenuFunction = openHubMenu;
	$.get(wgScript + '?action=ajax&rs=GetHubMenu&cb=' + wgMWrevId + '-' + wgStyleVersion, function(html) {
		$("#positioned_elements").append(html);
	});	
}

//User Menu
function openUserMenu(event) {
	event.preventDefault();
	headerMenuFunction = openUserMenu;
	$.get(wgScript + '?action=ajax&rs=GetUserMenu&rsargs[]='+ wgUserName +'&uselang='+ wgUserLanguage + '&cb=' + wgMWrevId + '-' + wgStyleVersion, function(html) {
		$("#positioned_elements").append(html);
	});	
}

// AjaxLogin
function openLogin(event) {
	// check wgEnableAjaxLogin
	if ( (typeof wgEnableAjaxLogin == 'undefined') || !wgEnableAjaxLogin) {
		$().log('AjaxLogin: wgEnableAjaxLogin is false, going to Special:Userlogin...');
		return;
	}

	event.preventDefault();

	$.get(window.wgScript + '?action=ajax&rs=GetAjaxLogin&uselang=' + window.wgUserLanguage, function(html) {
		$("#positioned_elements").append(html);
	});
}

//Modal
$.fn.extend({
  makeModal: function(options) {
	var settings = { width: 400 };
	if (options) {
		$.extend(settings, options);
	}    
   	   	
   	this.addClass('modalInside').wrap('<div class="modalWrapper"></div>');

   	var wrapper = this.closest(".modalWrapper");
	
	// let's have it dynamically generated, so every newly created modal will be on the top 
	var zIndex = ($('.blackout').length+1) * 1000;
		
	function getModalTop() {
		var modalTop = (($(window).height() - wrapper.outerHeight()) / 2) + $(window).scrollTop();
		if (modalTop < $(window).scrollTop() + 20) {
			return $(window).scrollTop() + 20;
		} else {
			return modalTop;	
		}
	}
   	
   	wrapper
   		.prepend('<h1 class="modalTitle color1"><div style="background-image: url(http://images.wikia.com/common/skins/monaco/images/sprite.png);"></div>' + this.attr('title') + '</h1>')
   		.width(settings.width)
   		.css({
   			marginLeft: -wrapper.outerWidth() / 2,
			top: getModalTop(),
			zIndex: zIndex + 1
   		})
   		.fadeIn("fast");

	$("h1.modalTitle div").bind("click", function() {
		wrapper.closeModal(te()).getTime()
	});

   	$(window)
   		.bind("keypress.modal", function(event) {
   			if (event.keyCode == 27) {
   				wrapper.closeModal();
   			}	
   		})
   		.bind("resize.modal", function() {
   			wrapper.css("top", getModalTop());
   			$(".blackout:last").height($(document).height());
   		});

   	$("#positioned_elements").append('<div class="blackout"></div>');
   	$(".blackout:last")
   		.height($(document).height())
		.css({zIndex: zIndex})
   		.fadeTo("fast", 0.65)
   		.bind("click", function() {
   			wrapper.closeModal();
   		});
  },
  closeModal: function() {
  	$(window).unbind(".modal");
  	this.animate({
  		top: this.offset()["top"] + 100,
  		opacity: 0
  	}, "fast", function() {
  		$(this).remove();
  	});
  	$(".blackout:last").fadeOut("fast", function() {
  		$(this).remove();
  	})  	
  } 
});

//Header Menu
$.fn.extend({
	makeHeaderMenu: function(trigger, options) {
		if (!trigger) {
			//adding error logging here
			$(this).remove();
		} else {
			trigger = $("#"+trigger);
		}

		var menu = $(this);
  		var headerMenuTimer;
		var settings = { 
    			delay: 500,
    			edge: 10,
    			attach_to: "#wikia_header",
    			attach_at: "bottom",
    		};
		if (options) {
			$.extend(settings, options);
		}
				
		//make the trigger unclickable for now - will bound again when menu is closed
		trigger.unbind(".headerMenu");

		//calculate left position
		var center = trigger.offset().left + ( trigger.outerWidth() / 2 );
		var menuWidth = menu.outerWidth();
		var targetLeft = center - ( menuWidth / 2 );
		if (targetLeft < settings.edge) {
			targetLeft = settings.edge;
		}

		//calculate top position
		var targetTop = $(settings.attach_to).offset().top;
		if (settings.attach_at == "bottom") {
			targetTop += $(settings.attach_to).outerHeight();
		}
		
		//show menu, set mouseenter/mouseleave handlers
		menu.css("left", targetLeft).css("top", targetTop).slideDown("fast").mouseleave(function() {
			headerMenuTimer = setTimeout(function() {
				menu.closeHeaderMenu(trigger, menu);
			}, settings.delay);
		}).mouseenter(function() {
			clearTimeout(headerMenuTimer);
		});

		//close menu by clicking anywhere		
		$(document).bind("click.headerMenu", function() {
			menu.closeHeaderMenu(trigger, menu);
		});

		menu.click(function(event) {
			event.stopPropagation();
		});
  	},
	closeHeaderMenu: function(trigger, menu) {
		$(document).unbind(".headerMenu");
		trigger.bind("click.headerMenu", headerMenuFunction);
		menu.slideUp("fast", function() {
			menu.remove();
		});
	}
});

/*
//Navigation
monacoNavigationInitCalled = false;
function monacoNavigationInit() {
	if (monacoNavigationInitCalled) {
		return;	
	}
	monacoNavigationInitCalled = true;
	var html = '';
	
	function monacoNavigationRender(i, item, append) {
		html += '<div class="sub-menu widget" style="display: none;">';
		$.each(item, function(i, item) {
			//does this item have children?
			var children = '';
			if (menuArray[item].children) {
				children = '<em>›</em>';
			}
			//render div for this item
			html += '<div class="menu-item"><a href="' + menuArray[item].href + '" rel="nofollow">' + menuArray[item].text + children + '</a>';
				if (children != '') {
					monacoNavigationRender(menuArray[item], menuArray[item].children);
				}
			html += '</div>';
		});
		html += '</div>';
		if (append) {
			$("#menu-item_" + i).append(html);
		}
	};
	
	$.each(menuArray.mainMenu, function (i, item) {
		monacoNavigationRender(i, item, true);	
	});
	//no border on last item in sub-menus
	$(".sub-menu").each(function() {
		$(this).children("div:last").css("border", 0);
	});
	monacoNavigationHoverActions();
}

var menutimer;
function monacoNavigationHoverActions() {
	$("#navigation .menu-item").hover(function() {
		$(this).addClass("navigation-hover").children(".sub-menu").show();
		$(this).siblings().removeClass("navigation-hover").find(".sub-menu").hide().end().find(".menu-item").removeClass("navigation-hover");
	});
	$("#navigation").mouseleave(function() {
		$(this).find(".menu-item").removeClass("navigation-hover");
		menutimer = setTimeout(function() {
			$("#navigation").find(".sub-menu").hide();
		}, 500);
	}).mouseover(function() {
		clearTimeout(menutimer);
	});
}
*/

function setupVoting() {
	var callback = function(data) {
		$('#star-rating').removeClass('star-rating-progress');

		// show current rating
		$('#current-rating').css('width', Math.round(data.item.wkvoteart[0].avgvote * 17) + 'px');
		$('#star-rating a').css('display', data.item.wkvoteart[0].remove ? '' : 'none');
		$('#unrateLink').css('display', data.item.wkvoteart[0].remove ? 'none' : '');

		// purge current page
		$.post(window.location.href, {action: 'purge'});
	};

	$('#star-rating a').click(function(ev) {
		ev.preventDefault();

		var rating = this.id.substr(4,1);
		$('#star-rating').addClass('star-rating-progress');
		$.getJSON(wgScriptPath+'/api.php?action=insert&list=wkvoteart&format=json&wkvote='+rating+'&wkpage='+wgArticleId, callback);

		// todo: YAHOO.Wikia.Tracker.trackByStr(e, 'ArticleFooter/vote/' + rating);
	});

	$('#unrateLink').click(function(ev) {
		ev.preventDefault();

		$('#star-rating').addClass('star-rating-progress');
		$('#unrateLink').css('display', 'none');
		$.getJSON(wgScriptPath+'/api.php?action=wdelete&list=wkvoteart&format=json&wkpage='+wgArticleId, callback);

		// todo: YAHOO.Wikia.Tracker.trackByStr(e, 'ArticleFooter/vote/unrate');
	});
}
