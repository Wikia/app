/*
Copyright (c) 2007, Wikia Inc.
Author: Inez Korczynski (inez (at) wikia.com)
Version: 1.1
*/

YAHOO.namespace('Wikia');

(function() {

var Dom = YAHOO.util.Dom;
var Event = YAHOO.util.Event;

YAHOO.Wikia.Tracker = {

	initTracker: initTracker,

	init: function() {
		this.initTracker();

		// Page view
		if(wgIsArticle) {
			this.trackByStr(null, 'view');
		}

		// Edit page
		if(wgArticleId != 0 && wgAction == 'edit') {
			this.trackByStr(null, 'editpage/view');
		}

		// EditSimilar extension - result links (Bartek)
		Event.addListener('editsimilar_links', 'click', function(e) {
			var el = Event.getTarget(e);
			if((el.nodeName == 'A') && (el.id != 'editsimilar_preferences')) {
				YAHOO.Wikia.Tracker.trackByStr(e, 'userengagement/editSimilar_click');
			}
		});

		// EditSimilar extension - preferences link (Bartek)
		Event.addListener('editsimilar_preferences', 'click', function(e) {
			YAHOO.Wikia.Tracker.trackByStr(e, 'userengagement/editSimilar/editSimilarPrefs');
		});

		// CreateAPage extension (Bartek)
		var cpform = Dom.get('createpageform');
		if(cpform) {
			Event.addListener('wpSave', 'click', YAHOO.Wikia.Tracker.trackByStr, 'createPage/save');
			Event.addListener('wpPreview', 'click', YAHOO.Wikia.Tracker.trackByStr, 'createPage/preview');
			Event.addListener('wpAdvancedEdit', 'click', YAHOO.Wikia.Tracker.trackByStr, 'createPage/advancedEdit');
		}

		// Special:Userlogin (Macbre)
		if ( wgCanonicalSpecialPageName && wgCanonicalSpecialPageName == 'Userlogin' ) {
			Event.addListener($('userloginlink').getElementsByTagName('a')[0], 'click', YAHOO.Wikia.Tracker.trackByStr, 'loginActions/goToSignup');
		}

		// Special:Search (Macbre)
		if ( wgCanonicalSpecialPageName && wgCanonicalSpecialPageName == 'Search' ) {
			lists = Dom.get('bodyContent').getElementsByClassName('mw-search-results');

			if (lists && lists.length > 0) {

				listNames = ['title', 'text'];

				// parse URL to get offset value
				re = (/\&offset\=(\d+)/).exec(document.location);
				offset = re ? (parseInt(re[1]) + 1) : 1;

				for (m=0; m < lists.length; m++) {
					anchors = lists[m].getElementsByTagName('a');
					for (a=0; a < anchors.length; a++) {
						Event.addListener(anchors[a], 'click', YAHOO.Wikia.Tracker.trackByStr, 'search/searchResults/' + listNames[m] + 'Match/' + (offset + a));
					}
				}

				// #3439
				this.trackByStr(null, 'search/searchResults/view');
			}
		}
	},

	trackByStr: function(e, str) {
		YAHOO.Wikia.Tracker.track(str, e);
	},

	trackById: function(e) {
		YAHOO.Wikia.Tracker.track(this.id, e);
	},

	track: function(fakeurl, e) {

		fakeurlArray = fakeurl.split('/');
		for(i = 0; i < fakeurlArray.length; i++) {
			if( !YAHOO.lang.isString(fakeurlArray[i]) || fakeurlArray[i].length < 1 ) {
				return;
			}
		}

		if(skin == 'monobook') { skinname = 'monobook';}
		else if (skin == 'quartz') { skinname = 'vs2'; }
		else if (skin == 'monaco') { skinname = 'monaco'; }

		if(window.skinname && YAHOO.lang.isFunction(urchinTracker)) {
			_uacct = "UA-2871474-1";

			username = wgUserName == null ? 'anon' : 'user';

			fake = '/1_' + skinname + '/' + username + '/' + fakeurl;
			urchinTracker(fake);
			YAHOO.log(fake, "info", "tracker");

			if(wgPrivateTracker) {
				fake = '/1_' + skinname + '/' + wgDB + '/' + username + '/' + fakeurl;
				urchinTracker(fake);
				YAHOO.log(fake, "info", "tracker");
			}

			if(wgServer.indexOf('-gamespot') > 0) {
				fake = '/1_' + skinname + '/gamespot-' + wgDB + '/' + username + '/' + fakeurl;
				urchinTracker(fake);
				YAHOO.log(fake, "info", "tracker");
			}

			if(wgServer.indexOf('-abc') > 0) {
				fake = '/1_' + skinname + '/abc-' + wgDB + '/' + username + '/' + fakeurl;
				urchinTracker(fake);
				YAHOO.log(fake, "info", "tracker");
			}
		}
	}

};

YAHOO.widget.Logger.enableBrowserConsole();
Event.onDOMReady(YAHOO.Wikia.Tracker.init, YAHOO.Wikia.Tracker, true);

})();
