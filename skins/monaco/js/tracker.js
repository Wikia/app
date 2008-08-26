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

	if(wgID == 2428) {
		Event.addListener(['realAd0','realAd1'], 'click', function(e) {
			var el = Event.getTarget(e);
			if(el.innerHTML == 'Close ad') {
				if(wgIsMainpage) {
					Tracker.trackByStr(e, 'CloseAd/MainPage');
				} else {
					Tracker.trackByStr(e, 'CloseAd/ArticlePage');
				}
			}
		});
	}

	// Request Wiki
	Event.addListener('request_wiki', 'click', function(e) {
		Tracker.trackByStr(e, 'RequestWiki/initiate_click');
	});

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

		// Login - community widget
		Event.addListener('community_login', 'click', this.trackById);
		// Create an account - community widget
		Event.addListener('community_register', 'click', this.trackById);


		// Login/register process
		Event.addListener(['wpLoginattempt','wpMailmypassword','wpCreateaccount','wpAjaxRegister'], 'click', function(e) {
			Tracker.trackByStr(e, 'loginActions/' + this.id.substring(2).toLowerCase());
		});

	} else {
		Event.addListener(['userData','headerMenuUser'], 'click', function(e) {
			var el = Event.getTarget(e);
			if(el.nodeName == 'A') {
				parentId = el.parentNode.id;
				Tracker.trackByStr(e, 'userMenu/' + (parentId == 'header_username' ? 'userPage/' : '') + el.innerHTML);
			}
		});
		Event.addListener('headerButtonUser', 'click', this.trackByStr, 'userMenu/more');
	}

	// CategoryList
	Event.addListener('headerMenuHub', 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'A') {
			if ( el.id == 'goToHub' )  {
				Tracker.trackByStr(e, 'categoryList/moredotdotdot');
			}
			else if (el.id != '') {
				Tracker.trackByStr(e, 'categoryList/'+ el.id.split('-')[1]  + '/' + el.innerHTML);
			}
		}
	});
	Event.addListener('headerButtonHub', 'click', this.trackByStr, 'categoryList/more');

	// Wikia & Wiki top left logo
	Event.addListener(['wikia_logo','wiki_logo'], 'click', this.trackById);

	// Navigation - sidebar
	Event.addListener('navigation', 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'A') {
			var str = '';
			id = el.id;
			idA = id.split('-');

			if(idA[1] == 'menu') {
				menuId    = id.split('_')[1];
				str = '/' + menuId + '_' + el.innerHTML;
				if(str.indexOf('<') > 0) str = str.substring(0, str.indexOf('<'));
			} else {
				submenuA = idA[idA.length - 1].split('_');
				key = '';
				for(var i = 1; i < submenuA.length; i++) {
					if(i == 1) {
						key += '_' + submenuA[i];
						temp = '/' + submenuA[i] + '_' + Dom.get('a-menu-item_' + submenuA[i]).innerHTML;
						if(temp.indexOf('<') > 0) temp = temp.substring(0, temp.indexOf('<'));
						str += temp;
					} else {
						key += '_' + submenuA[i];
						temp = '/' + submenuA[i] + '_' + Dom.get('a-sub-menu-item' + key).innerHTML;
						if(temp.indexOf('<') > 0) temp = temp.substring(0, temp.indexOf('<'));
						str += temp;
					}
				}
			}
			Tracker.trackByStr(e, 'sidebar' + str);
		}
	});

	// Navigation - toolbox
	Event.addListener('link_box', 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'A') {
			Tracker.trackByStr(e, 'toolbox/' + el.innerHTML);
		}
	});


	// User Engagement
	Event.addListener('ue_msg', 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'A') {
			Tracker.trackByStr(e, 'userengagement/msg_click_' + el.id);
		}
	});

	// Article content actions
	Event.addListener(['page_controls','page_tabs'], 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'A') {
			Tracker.trackByStr(e, 'articleAction/' + el.id.substring(3).replace(/nstab-/, 'view/'));
		}
	});

	// Article footer
	Event.addListener(['articleFooterActions', 'articleFooterActions2'], 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'IMG') {
			el = el.parentNode;
		}
		if(el.nodeName == 'A') {
			Tracker.trackByStr(e, 'ArticleFooter/' + el.id.split('_')[1]);
		}
	});

	Event.addListener('share', 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'A') {
			Tracker.trackByStr(e, 'ArticleFooter/share/' + el.id.substring(5,el.id.length-2));
		}
	});

	// Footer links
	Event.addListener('wikia_footer', 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'A') {
			Tracker.trackByStr(e, ((el.parentNode.id == 'wikia_corporate_footer') ? 'wikiaFooter/' : 'footer/') + el.innerHTML);
		}
	});

	// Widgets
	Event.addListener(Dom.getElementsByClassName('widget', 'dl'), 'click', function(e) {
		var el = Event.getTarget(e);
		if(el.nodeName == 'A') {
			var classA = this.className.split(' ');
			Tracker.trackByStr(e, 'widget/' + classA[1] + '/' + el.innerHTML);
		}
	});

	// Search
	Event.addListener('searchform', 'submit', function(e) {
		Tracker.trackByStr(e, 'search/submit/enter/' +  escape(Dom.get('search_field').value.replace(/ /g, '_')));
	});

	Event.addListener('search_button', 'click', function(e) {
		Tracker.trackByStr(e, 'search/submit/click/' +  escape(Dom.get('search_field').value.replace(/ /g, '_')));
	});

	// Spotlights
	footerSpotlights = Dom.get('spotlight_footer').getElementsByTagName('div');
	sidebarSpotlight = Dom.get('102_content');

	// Advertiser Widget
	if (sidebarSpotlight) {
		sidebarSpotlight = sidebarSpotlight.getElementsByTagName('div');
	}

	if (footerSpotlights && footerSpotlights.length > 0) {
		for (s=0; s < footerSpotlights.length; s++) {
			var id = parseInt(footerSpotlights[s].id.substr( footerSpotlights[s].id.length - 1 ));
			Event.addListener('realAd' + id, 'click', function(e, id) {
				Tracker.trackByStr(e, 'spotlights/footer' + (id+1));
			}, s);
		}
	}

	if (sidebarSpotlight && sidebarSpotlight.length > 0) {
		var id = sidebarSpotlight[0].id.substr( sidebarSpotlight[0].id.length - 1 );
		Event.addListener('realAd' + id, 'click', function(e) {
			Tracker.trackByStr(e, 'spotlights/sidebar1');
		});
	}

};
