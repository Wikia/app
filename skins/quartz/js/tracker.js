/*
Copyright (c) 2007, Wikia Inc.
Author: Inez Korczynski (inez (at) wikia.com)
Version: 1.1
*/

var initTracker = function() {

	var Tracker = YAHOO.Wikia.Tracker;
	var Dom = YAHOO.util.Dom;
	var Event = YAHOO.util.Event;
	var lang = YAHOO.lang;

	// Links on edit page
	Event.addListener(['wpMinoredit','wpWatchthis','wpSave','wpPreview','wpDiff','wpCancel','wpEdithelp'], 'click', function(e) {
		var str  = 'editpage/' + this.id.substring(2).toLowerCase();
		Tracker.trackByStr(e, str);
	});

	// Edit links for sections
	var WysyWigDone = false;
	var editSections = Dom.getElementsByClassName('editsection', 'span', Dom.get('bodyContent'));
	Event.addListener(editSections, 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'A') {
			Tracker.trackByStr(e, 'articleAction/editSection');
		}
	});

	if( lang.isNull( wgUserName ) ) {
		// Login - top left corner
		Event.addListener('login', 'click', this.trackById);
		// Create an account - top left corner
		Event.addListener('register', 'click', this.trackById);
	} else {
		// User menu toggle and all user menu items - top left corner
		Event.addListener('userMenuToggle', 'click', function(e) {
			var elId = Event.getTarget(e).id;
			if(elId == 'um-cockpit_show') { elId = 'widgets/cockpitShow'; }
			else if(elId != 'userMenuToggle') { elId = 'userMenu/' + elId.substring(3); }
			Tracker.trackByStr(e, elId);
		});
		// Logout - top left corner
		Event.addListener('logout', 'click', this.trackById);
		// Hide widget cockpit
		Event.addListener('cockpit_hide', 'click', this.trackByStr, 'widgets/cockpitHide');
	}

	// Wiki logo
	Event.addListener('wikiLogoLink', 'click', this.trackByStr, 'wikiLogo');

	// Wikia footer logo
	Event.addListener('wikiaFooterLogo', 'click', this.trackByStr, 'wikiaFooterLogo');

	// Navigation links - 1st & 2nd sections
	if(Dom.get('navLinks1')) {
		var navLinks1Items = Dom.get('navLinks1').getElementsByTagName('a');
		for ( var i = 0; i < navLinks1Items.length; i++ ) {
			Event.addListener(navLinks1Items[i], 'click', this.trackByStr, 'navLinks1/' + (i+1) + '_' + escape(navLinks1Items[i].innerHTML.replace(/ /g, '_')));
		}
	}
	if(Dom.get('navLinks2')) {
		var navLinks2Items = Dom.get('navLinks2').getElementsByTagName('a');
		for ( var i = 0; i < navLinks2Items.length; i++ ) {
			Event.addListener(navLinks2Items[i], 'click', this.trackByStr, 'navLinks2/' + (i+1) + '_' + escape(navLinks2Items[i].innerHTML.replace(/ /g, '_')));
		}
	}

	// Article content actions
	Event.addListener(Dom.get('articleWrapper').childNodes[1].getElementsByTagName('a'), 'click', function(e) {
		var str = 'articleAction/' + this.id.substring(3).replace(/nstab-/, 'view/');
		Tracker.trackByStr(e, str);
	});

	// All links in footer
	Event.addListener('wikiafooter', 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'A' && el.id != 'wikiaFooterLogo') {
			if(lang.isObject(el.parentNode)) {
				if(el.parentNode.parentNode.nodeName == "TD") { Tracker.trackByStr(e, el.parentNode.parentNode.id + '/' + escape(el.innerHTML.replace(/ /g, '_')));	}
				else if(el.parentNode.nodeName == "TD") { Tracker.trackByStr(e, el.parentNode.id + '/' + escape(el.innerHTML.replace(/ /g, '_'))); }
			}
		}
	});

	// Login/register process
	Event.addListener(['wpLoginattempt','wpMailmypassword','wpCreateaccount','wpAjaxRegister'], 'click', function(e) {
		var str  = 'loginActions/' + this.id.substring(2).toLowerCase();

		/* A/B begin */
		group = YAHOO.Tools.getCookie('wikicitiesg');
		if(group != null) {
			str += '/' + group;
		}
		/* A/B end */

		Tracker.trackByStr(e, str);
	});

	// Links in widgets
	var widgets = Dom.getElementsByClassName('widget', 'li', Dom.get('widgets_2'));
	Event.addListener(widgets, 'click', function(e) {
		var el = Event.getTarget(e);

		if(el.nodeName == 'A' && el.id.substring(0,3) == 'tb_') {
			// it is for links from toolbox
			Tracker.trackByStr(e, 'toolbox/' + el.id.substring(3));
		} else if(el.nodeName == 'A' && Dom.hasClass(el.parentNode.parentNode.parentNode, 'widgetTopContent')) {
			// it is for links from top content sections
			contentType = el.parentNode.parentNode.id.substring(0,el.parentNode.parentNode.id.lastIndexOf('_'));
			if(el.href.indexOf(contentType) > 0) {
				elementType = 'see_more';
			} else {
				var needed = el.parentNode;
				var neededIndex = 0;
				var tempIndex = 0;
				Dom.getElementsBy(function(o) {
					tempIndex++;
					if(needed==o) { neededIndex = tempIndex; }
				 }, 'li', el.parentNode.parentNode);
				elementType = neededIndex;
			}
			if(elementType) {
				Tracker.trackByStr(e, 'topcontent/' + contentType + '/' + elementType);
			}
		} else if(el.nodeName == 'OPTION' && Dom.hasClass(el.parentNode.parentNode.parentNode, 'widgetTopContent')) {
			// it is for toggle section in top content
			Tracker.trackByStr(e, 'topcontentToggle/' + el.value);
		} else if(el.nodeName == 'A' && Dom.hasClass(el.parentNode.parentNode.parentNode, 'widgetSidebar')) {
			// it is for links in sidebar
			Tracker.trackByStr(e, 'sidebarLink/' + el.innerHTML);
		}
	});

	// Search submit (enter)
	Event.addListener('searchform', 'submit', function(e) {
		Tracker.trackByStr(e, 'search/submit/enter/' +  escape(Dom.get('searchfield').value.replace(/ /g, '_')));
	});

	// Search submit (click)
	Event.addListener('searchSubmit', 'click', function(e) {
		Tracker.trackByStr(e, 'search/submit/click/' +  escape(Dom.get('searchfield').value.replace(/ /g, '_')));
	});

	// BreadCrumbs
	Event.addListener('breadCrumb', 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == "A" && !lang.isNull(el.innerHTML)) {
			Tracker.trackByStr(e, 'breadCrumbs/' +  escape(el.innerHTML.replace(/ /g, '_')));
		}
	});

	// Language dropdown menu
	Event.addListener(['languageMenuToggle'], 'click', function(e) {
		var el = Event.getTarget(e);
		if(el == this || el.parentNode == this) {
			Tracker.trackByStr(e, 'languageMenu');
		} else if (el.nodeName == 'A') {
			Tracker.trackByStr(e, 'languageMenuItem/' + escape(el.innerHTML.replace(/ /g, '_')));
		}
	});

	Event.addListener('articleFooter', 'click', function(e) {
		var el = Event.getTarget(e);

		if(el.id == 'star1' || el.id == 'star2' || el.id == 'star3' || el.id == 'star4' || el.id == 'star5') {
			Tracker.trackByStr(e, 'articleRating/rate');
		} else if(el.id == 'unrate') {
			Tracker.trackByStr(e, 'articleRating/unrate');
		} else if(el.id == 'shareDelicious_img') {
			Tracker.trackByStr(e, 'share/delicious/img');
		} else if(el.id == 'shareDelicious_a') {
			Tracker.trackByStr(e, 'share/delicious/a');
		} else if(el.id == 'shareStumble_img') {
			Tracker.trackByStr(e, 'share/stumble/img');
		} else if(el.id == 'shareStumble_a') {
			Tracker.trackByStr(e, 'share/stumble/a');
		} else if(el.id == 'shareDigg_img') {
			Tracker.trackByStr(e, 'share/digg/img');
		} else if(el.id == 'shareDigg_a') {
			Tracker.trackByStr(e, 'share/digg/a');
		} else if(el.id == 'shareEmail_img') {
			Tracker.trackByStr(e, 'share/shareemail/img');
		} else if(el.id == 'shareEmail_a') {
			Tracker.trackByStr(e, 'share/shareemail/a');
		} else {
			id = el.id;
			if(el.id == "") {
				id = el.parentNode.id;
			}
			id_parts = id.split('_');
			if(id_parts[0] == "fe" && id_parts.length == 3) {
				Tracker.trackByStr(e, 'articleFooter/' + id_parts[1] + '/' + id_parts[2]);
			}
		}
	});
};