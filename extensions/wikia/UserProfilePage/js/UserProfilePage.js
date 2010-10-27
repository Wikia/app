$(function() {
	UserProfilePage._init();
});

var UserProfilePage = {
	_topWikisWrapper: null,
	_topPagesWrapper: null,
	_aboutSection: null,
	
	_init: function() {
		UserProfilePage._topWikisWrapper = $('#profile-top-wikis-body');
		UserProfilePage._topPagesWrapper = $('#profile-top-pages-body');
		UserProfilePage._aboutSection = $('#profile-content').find('.user-about-section');
		UserProfilePage.attachEvents();
		UserProfilePage.enrichAboutSection();
		$().log(UserProfilePage._aboutSection);
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
		UserProfilePage._topWikisWrapper.find('.HideButton').bind('click', function() {UserProfilePage.doAction( 'hide', 'wiki', this.title );} );
		UserProfilePage._topPagesWrapper.find('.HideButton').bind('click', function() {UserProfilePage.doAction( 'hide', 'page', this.title );} );
		UserProfilePage._topPagesWrapper.find('.UnhideButton').bind('click', function() {UserProfilePage.doAction( 'unhide', 'page', this.title );} );
	},

	enrichAboutSection: function(){
		var section = UserProfilePage._aboutSection;
		
		section.find('.answer,.question').each(function(){
			var elm = $(this);

			//elm.html($('<img src="' + section.attr('data-' + ((index % 2 != 0) ? 'generic' : 'user') + '-avatar') + '"><div class="' + ((index % 2 != 0) ? 'answer' : 'question') + '">' + elm.html() + '</div>'));
			elm.parent().prepend($('<img src="' + section.attr('data-' + ((elm.hasClass('question')) ? 'generic' : 'user') + '-avatar') + '">'));
		});
	}

};
