/*
Copyright (c) 2007, Wikia Inc.
Author: Inez Korczynski (inez (at) wikia.com)
Version: 1.1
*/

var initTracker = function() {

	var Tracker = YAHOO.Wikia.Tracker;
	var Dom = YAHOO.util.Dom;
	var Event = YAHOO.util.Event;

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

	// Footer links
	Event.addListener('footer', 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'A') {
			str = el.parentNode.id;
		} else if(el.nodeName == 'IMG') {
			str = el.parentNode.parentNode.id;
		}
		Tracker.trackByStr(e, 'footerLinks/' + str);
	});
	
		// User Engagement
	Event.addListener('ue_msg', 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'A') {
			Tracker.trackByStr(e, 'userengagement/msg_' + el.id);
		}
	});

	// Logo, personal links, content action links, sidebar links
	Event.addListener('column-one', 'click', function(e) {
		var el = Event.getTarget(e);

		if(el.id == 'searchGoButton') {
			Tracker.trackByStr(e, 'search/go/' +  escape(Dom.get('searchInput').value.replace(/ /g, '_')));
		} else if(el.id == 'mw-searchButton') {
			Tracker.trackByStr(e, 'search/search/' +  escape(Dom.get('searchInput').value.replace(/ /g, '_')));
		} else if(el.parentNode.id == 'p-logo') {
			Tracker.trackByStr(e, 'wikiLogo');
		} else if(el.parentNode.parentNode.parentNode.parentNode.id == 'p-personal') {
			Tracker.trackByStr(e, 'userMenu/' + el.parentNode.id.substring(3));
		} else if(el.parentNode.parentNode.parentNode.parentNode.id == 'p-cactions') {
			Tracker.trackByStr(e, 'articleAction/' + el.parentNode.id.substring(3).replace(/nstab-/, 'view/'));
		} else if(el.nodeName == 'A' && el.parentNode.nodeName == 'LI') {
			Tracker.trackByStr(e, 'sidebar/' + el.parentNode.parentNode.parentNode.parentNode.id.substring(2) + '/' + el.parentNode.id.substring(2));
		}
	});

};