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
		$('#profile-top-wikis-hidden').find('a.more').click(function(){
			if(!$('#profile-top-wikis-hidden').hasClass('user-profile-box')){
				$('#profile-top-wikis-hidden').addClass('user-profile-box');

				$('body').unbind('click.UserProfilePage_boxClose').bind('click.boxClose', function(event) {
					if (!$(event.target).closest('#profile-top-wikis-hidden').length) {
						$('#profile-top-wikis-hidden').removeClass('user-profile-box');
					};
				});
			}
		});

		$('#profile-top-pages-hidden').find('a.more').click(function(){
			if(!$('#profile-top-pages-hidden').hasClass('user-profile-box')){
				$('#profile-top-pages-hidden').addClass('user-profile-box');

				$('body').unbind('click.UserProfilePage_boxClose').bind('click.boxClose', function(event) {
					if (!$(event.target).closest('#profile-top-pages-hidden').length) {
						$('#profile-top-pages-hidden').removeClass('user-profile-box');
					};
				});
			}
		});

		/*UserProfilePage._topPagesWrapper.find('.HideButton').bind('click', function() {UserProfilePage.doAction( 'hide', 'page', this.title );} );
		UserProfilePage._topPagesWrapper.find('.UnhideButton').bind('click', function() {UserProfilePage.doAction( 'unhide', 'page', this.title );} );*/
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
