/*
Copyright (c) 2009, Wikia Inc.
Author: Inez Korczynski (inez (at) wikia.com)
Description: WET == Wikia Event Tracker
*/

var WET = function() {

	// Initialize tracking for elements shared between skins

	if(skin == 'monobook') {
		WET.skinname = 'monobook';
	} else if(skin == 'quartz') {
		WET.skinname = 'vs2';
	} else if(skin == 'monaco' || skin == 'awesome') {
		WET.skinname = 'monaco';
	} else if(skin == 'home') {
		WET.skinname = 'home';
	} else {
		return;
	}

	WET.username = wgUserName == null ? 'anon' : 'user';

	// track the article page view
	if(wgIsArticle) {
		WET.byStr('view');
	}

	// track the article edit page view
	if(wgArticleId != 0 && wgAction == 'edit') {
		WET.byStr('editpage/view');
	}

	// TODO: check if works
	// track for EditSimilar links
	$('#editsimilar_links').children('a').click(function(e) {
		if(this.id == 'editsimilar_preferences') {
			WET.byStr('userengagement/editSimilar/editSimilarPrefs')
		} else {
			WET.byStr('userengagement/editSimilar_click')
		}
	});

	// TODO: check if works
	// track for Create a Page extension
	$('#createpageform').find('#wpSave, #wpPreview, #wpAdvancedEdit').click(function(e) { WET.byStr('createPage/' + this.id.substring(2).toLowerCase()); });

	if(wgCanonicalSpecialPageName) {
		// track the create an account link on login page
		if(wgCanonicalSpecialPageName == 'Userlogin') {
			$('#userloginlink a:first').click(function(e) { WET.byStr('loginActions/goToSignup'); });
		}

		// track clicks on search results links
		if(wgCanonicalSpecialPageName == 'Search') {
			var listNames = ['title', 'text'];
			// parse URL to get offset value
			var re = (/\&offset\=(\d+)/).exec(document.location);
			var offset = re ? (parseInt(re[1]) + 1) : 1;

			$('#bodyContent .mw-search-results').each(function(i) {
				$(this).find('a').each(function(j) {
					$(this).click(function() {
						WET.byStr('search/searchResults/' + listNames[i] + 'Match/' + (offset + j));
					});
				});
				if(i == 0) {
					WET.byStr('search/searchResults/view');
				}
			});
		}
	}

	// Links on edit page
	$('#wpMinoredit, #wpWatchthis, #wpSave, #wpPreview, #wpDiff, #wpCancel, #wpEdithelp').click(function(e) {
		WET.byStr('editpage/' + this.id.substring(2).toLowerCase());
	});

	// Initialize tracking for specific skin
	if(typeof initTracker != 'undefined') {
		initTracker();
	}

};

WET.skinname;

WET.username;

WET.byStr = function(message) {
	WET.track(message);
};

WET.byId = function(e) {
	WET.track(this.id);
};

WET.track = function(fakeurl) {
	if(WET.skinname != '' && typeof urchinTracker != 'undefined') {
		_uacct = 'UA-2871474-1';
		var fake = '/1_' + WET.skinname + '/' + WET.username + '/' + fakeurl;
		urchinTracker(fake);
		if(wgPrivateTracker) {
			fake = '/1_' + WET.skinname + '/' + wgDB + '/' + WET.username + '/' + fakeurl
			urchinTracker(fake);
		}
	}
}

$(WET);