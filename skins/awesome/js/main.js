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

//	Event.addListener('search_field', 'keypress', function(e) {if(e.keyCode==13) {Dom.get('searchform').submit();}});

	// Init datasource
	var oDataSource = new YAHOO.widget.DS_XHR(wgServer + wgScriptPath, ["\n"]);
	oDataSource.responseType = YAHOO.widget.DS_XHR.TYPE_FLAT;
	oDataSource.scriptQueryAppend = "action=ajax&rs=getLinkSuggest";

	// Init AutoComplete object and assign datasource object to it
/*	var oAutoComp = new YAHOO.widget.AutoComplete('search_field','searchSuggestContainer', oDataSource);
	oAutoComp.highlightClassName = oAutoComp.prehighlightClassName = 'navigation-hover';
	oAutoComp.autoHighlight = false;
	oAutoComp.typeAhead = true;
	oAutoComp.queryDelay = 1;
	oAutoComp.itemSelectEvent.subscribe(submitAutoComplete);
*/
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

//
// macbre: add Christian's code for LeanMonaco
//

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

//Search Field
function monacoSearchField(event) {
	if (event.type == 'focus') {
		if ($("#search_field").val() == $("#search_field").attr("title")) {
			$("#search_field").val('').addClass("field_active");
		}
	} else if (event.type == 'blur') {
		if ($("#search_field").val() == '') {
			$("#search_field").val($("#search_field").attr("title")).removeClass("field_active");
		}
	}
}

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

	if ($('#AjaxLogin').length > 0) {
		// show ajax login dialog if already in DOM
		$('#AjaxLogin').showModal();
	}
	else {
		// make modal persistent, so it won't be removed from DOM
		$().getModal(window.wgScript + '?action=ajax&rs=GetAjaxLogin&uselang=' + window.wgUserLanguage + '&cb=' + wgMWrevId + '-' + wgStyleVersion, '#AjaxLogin', 
		{
			width: 300,
			persistent: true,
			callback: function() {
				$.getScript(wgExtensionsPath + '/wikia/AjaxLogin/AwesomeAjaxLogin.js?' + wgStyleVersion, function() {
					$().log( AjaxLogin );
					AjaxLogin.init( $('#AjaxLogin form') );
				});
			}
		});
	}
}

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
    			attach_at: "bottom"
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

//Navigation
monacoNavigationInitCalled = false;
function menuInit() {
	if (monacoNavigationInitCalled) {
		return;
	}
	monacoNavigationInitCalled = true;

	function monacoNavigationRender(i, item, append) {
		//if appending a new chain of menus to the top-level nav, reset html var
		if (append) {
			html = '';
		}
		//create a sub-menu
		html += '<div class="sub-menu widget" style="display: none;">';
		if (typeof item != 'object') {
			$.each(magicWords[item], function() {
				classname = '';
				text = this.text;
				if (this.className) {
					classname = ' class="' + this.className + '"';
					if (this.className == 'Monaco-sidebar_more') {
						text = wgMenuMore;
					} else if (this.className == 'Monaco-sidebar_edit') {
						if (typeof wgMenuEdit != 'undefined') {
							text = wgMenuEdit;
						} else {
							return true;
						}
					}
				}
				html += '<div class="menu-item"><a href="' + this.url + '" rel="nofollow"' + classname +'>' + text +'</a></div>';
			});
		} else {
			$.each(item, function(i, item) {
				//does this item have children?
				var children = '';
				if (menuArray[item].children || menuArray[item].magic) {
					children = '<em>&rsaquo;</em>';
				}
				//render div for this item
				html += '<div class="menu-item"><a href="' + menuArray[item].href + '" rel="nofollow">' + menuArray[item].text + children + '</a>';
					if (menuArray[item].children) {
						monacoNavigationRender(menuArray[item], menuArray[item].children);
					} else if (menuArray[item].magic) {
						monacoNavigationRender(menuArray[item], menuArray[item].magic);
					}
				html += '</div>';
			});
		}
		html += '</div>';
		if (append) {
			$("#menu-item_" + i).append(html);
		}
	};
	$.each(menuArray.mainMenu, function (i, item) {
		monacoNavigationRender(i, item, true);
	});
	$(".sub-menu").each(function() {
		//add "Edit this menu" to all sub-menus, except for those that were generated by magic menus
		if (typeof wgMenuEdit != 'undefined' && $(this).children("div:last").children("a:not(\".Monaco-sidebar_edit\")").length) {
			href = ($("#navigation").hasClass("userMenu")) ? '?title=User:' + wgUserName + '/Monaco-sidebar&action=edit' : '?title=MediaWiki:Monaco-sidebar&action=edit';
			$(this).append('<div class="menu-item"><a href="' + wgScript + href + '" class="Monaco-sidebar_edit">' + wgMenuEdit + '</a></div>');
		}
		//no border on last item in sub-menus
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
