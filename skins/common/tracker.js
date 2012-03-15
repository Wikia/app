/*
Copyright (c) 2007, Wikia Inc.
Author: Inez Korczynski (inez (at) wikia.com)
Version: 1.1

This file is used by Monobook only!
*/

YAHOO.namespace('Wikia');

(function() {

var Dom = YAHOO.util.Dom;
var Event = YAHOO.util.Event;

YAHOO.Wikia.Tracker = {

	initTracker: window.initTracker,

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

		// CreatePage extension
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
			var lists = Dom.get('bodyContent').getElementsByClassName('mw-search-results');

			if (lists && lists.length > 0) {

				var listNames = ['title', 'text'];

				// parse URL to get offset value
				var re = (/\&offset\=(\d+)/).exec(document.location),
					offset = re ? (parseInt(re[1]) + 1) : 1;

				for (var m=0; m < lists.length; m++) {
					var anchors = lists[m].getElementsByTagName('a');
					for (var a=0; a < anchors.length; a++) {
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

	trackStr: function(str, account) {
		/**
		if(typeof account != 'undefined') {
			//_gaq.push(['_setAccount', account]);
		}
		**/
		//_gaq.push(['_trackPageview', str]);
		YAHOO.log(str, "info", "tracker");
	},

	track: function(fakeurl, e) {
		var fakeurlArray = fakeurl.split('/'),
			skinname = false,
			username;

		for(var i = 0, len = fakeurlArray.length; i < len; i++) {
			if( !YAHOO.lang.isString(fakeurlArray[i]) || fakeurlArray[i].length < 1 ) {
				return;
			}
		}

		if(skin == 'monobook') { skinname = 'monobook';}
		else if (skin == 'quartz') { skinname = 'vs2'; }
		else if (skin == 'monaco') { skinname = 'monaco'; }
		else if (skin == 'home') { skinname = 'home'; }
		else if (skin == 'answers') { skinname = 'answers'; }

		if(skinname !== false) {
			username = wgUserName == null ? 'anon' : 'user';
			//YAHOO.Wikia.Tracker.trackStr('/1_' + skinname + '/' + username + '/' + fakeurl, 'UA-2871474-1');
			_wtq.push(['/1_' + skinname + '/' + username + '/' + fakeurl, 'main.sampled']);
			if(typeof wgPrivateTracker!="undefined") {
				//YAHOO.Wikia.Tracker.trackStr('/1_' + skinname + '/' + wgDBname + '/' + username + '/' + fakeurl);
				_wtq.push(['/1_' + skinname + '/' + wgDBname + '/' + username + '/' + fakeurl, 'main.sampled']);
			}
			/**
			if(wgServer.indexOf('-abc') > 0) {
				//YAHOO.Wikia.Tracker.trackStr('/1_' + skinname + '/abc-' + wgDBname + '/' + username + '/' + fakeurl);
			}
			**/
		}

	}

};

YAHOO.widget.Logger.enableBrowserConsole();
Event.onDOMReady(YAHOO.Wikia.Tracker.init, YAHOO.Wikia.Tracker, true);
})();

function onYouTubePlayerReady(playerid) {
	var ytplayer = document.getElementById("YT_" + playerid);
	ytplayer.addEventListener("onStateChange", "onytplayerStateChange");
}

function onytplayerStateChange(newState) {
	var event;
	if(newState == 0) {
		event = "ended";
	} else if(newState == 1) {
		event = "playing";
	}
	if(event) {
		YAHOO.Wikia.Tracker.trackByStr(null, "youtube/"+event);
	}
}

// Temporary dummies for tracking - Inez
if(!window.WET) {
	var WET = {
		byStr : function(str){
			YAHOO.Wikia.Tracker.trackByStr(null, str);
		},
		byId : function(e){
			YAHOO.Wikia.Tracker.trackById(e);
		}
	}
}
