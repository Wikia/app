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
		console.log( UserProfilePage._topPagesWrapper );
	},
	
	doAction: function(name, type, value) {
		console.log( name +' '+ type +' '+ value );

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
						console.log( response );
						//UserProfilePage._topWikisWrapper.replaceWith(response.listBody);
						//UserProfilePage._topWikisWrapper = $('#toplists-list-body');
						//UserProfilePage._topWikisWrapper.find('#' + response.votedId).closest('li').find('.ItemNumber')
					}
				}
			);

	},

	attachEvents: function() {
		UserProfilePage._topWikisWrapper.find('.HideButton').bind('click', function() { UserProfilePage.doAction( 'hide', 'wiki', this.title ); } );
		UserProfilePage._topPagesWrapper.find('.HideButton').bind('click', function() { UserProfilePage.doAction( 'hide', 'page', this.title ); } );
	}

};
