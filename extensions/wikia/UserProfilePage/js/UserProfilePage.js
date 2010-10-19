$(function() {
	UserProfilePage._init();
});

var UserProfilePage = {
	_topWikisWrapper: null,
	_topPagesWrapper: null,
	_init: function() {
		UserProfilePage._topWikisWrapper = $('#profile-top-wikis-body');
		UserProfilePage._topPagesWrapper = $('#profile-top-pages-body');
		UserProfilePage.attachEvents();
	},
	
	doAction: function(name, type, value) {
		$.getJSON(wgScript,
				{
					'action': 'ajax',
					'rs': 'UserProfilePageHelper::doAction',
					'name': name,
					'type': type,
					'value': value
				},
				function(response) {
					if(response.result === true) {
						if( response.type == 'page' ) {
							UserProfilePage._topPagesWrapper.replaceWith( response.html );
							UserProfilePage._topPagesWrapper = $('#profile-top-pages-body');
						}
						if( response.type == 'wiki' ) {
							UserProfilePage._topWikisWrapper.replaceWith( response.html );
							UserProfilePage._topWikisWrapper = $('#profile-top-wikis-body');
						}
					}
				}
			);
	},

	attachEvents: function() {
		UserProfilePage._topWikisWrapper.find('.HideButton').bind('click', function() { UserProfilePage.doAction( 'hide', 'wiki', this.title ); } );
		UserProfilePage._topPagesWrapper.find('.HideButton').bind('click', function() { UserProfilePage.doAction( 'hide', 'page', this.title ); } );
		UserProfilePage._topPagesWrapper.find('.UnhideButton').bind('click', function() { UserProfilePage.doAction( 'unhide', 'page', this.title ); } );
	}

};
