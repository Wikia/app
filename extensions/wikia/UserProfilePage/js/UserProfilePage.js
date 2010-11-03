$(function() {
	UserProfilePage._init();
});

var UserProfilePage = {
	_topWikisWrapper: null,
	_topPagesWrapper: null,
	_hiddenWikisWrapper: null,
	_hiddenTopPagesWrapper: null,
	_aboutSection: null,
	
	_init: function() {
		UserProfilePage._topWikisWrapper = $('#profile-top-wikis-body');
		UserProfilePage._topPagesWrapper = $('#profile-top-pages-body');
		UserProfilePage._aboutSection = $('#profile-content').find('.user-about-section');
		UserProfilePage._hiddenWikisWrapper = $('#profile-top-wikis-hidden');
		UserProfilePage._hiddenTopPagesWrapper = $('#profile-top-pages-hidden');
		UserProfilePage.attachEvents();
		UserProfilePage.enrichAboutSection();
		$().log(UserProfilePage._aboutSection);
	},
	
	doAction: function(name, type, value) {
		var wrapper = ( type === 'wiki' ) ? UserProfilePage._topWikisWrapper : UserProfilePage._topPagesWrapper;
		wrapper.addClass('busy');
		wrapper.find('*').click(function(event){event.preventDefault()});
		
		$.getJSON(wgScript,
				{
					'action': 'ajax',
					'rs': 'UserProfilePageHelper::doAction',
					'name': name,
					'type': type,
					'value': value
				},
				function(response) {
					$().log(response);
					if(response.result === true) {
						if( response.type === 'page' ) {
							UserProfilePage._topPagesWrapper.replaceWith( response.html );
							UserProfilePage._topPagesWrapper = $('#profile-top-pages-body');
						}
						if( response.type === 'wiki' ) {
							UserProfilePage._topWikisWrapper.replaceWith( response.html );
							UserProfilePage._topWikisWrapper = $('#profile-top-wikis-body');
						}
					}
				}
			);
	},

	attachEvents: function() {
		//handle click outside hidden elements popup menu
		$('#profile-top-wikis-hidden').find('a.more').click(function(){
			if(!UserProfilePage._hiddenWikisWrapper.hasClass('user-profile-box')){
				UserProfilePage._hiddenWikisWrapper.addClass('user-profile-box');

				$('body').unbind('click.UserProfilePage_boxClose').bind('click.boxClose', function(event) {
					if (!$(event.target).closest('#profile-top-wikis-hidden').length) {
						UserProfilePage._hiddenWikisWrapper.removeClass('user-profile-box');
					};
				});
			}
		});

		//handle click outside hidden elements popup menu
		$('#profile-top-pages-hidden').find('a.more').click(function(){
			if(!UserProfilePage._hiddenTopPagesWrapper.hasClass('user-profile-box')){
				UserProfilePage._hiddenTopPagesWrapper.addClass('user-profile-box');

				$('body').unbind('click.UserProfilePage_boxClose').bind('click.boxClose', function(event) {
					if (!$(event.target).closest('#profile-top-pages-hidden').length) {
						UserProfilePage._hiddenTopPagesWrapper.removeClass('user-profile-box');
					};
				});
			}
		});

		UserProfilePage._topWikisWrapper.find('.HideButton').bind('click', function(){
			UserProfilePage.doAction('hide', 'wiki', $(this).attr('data-id' ));
		});

		UserProfilePage._topWikisWrapper.find('.UnhideButton').bind('click', function(){
			UserProfilePage._hiddenWikisWrapper.removeClass('user-profile-box');
			UserProfilePage.doAction('unhide', 'wiki', $(this).attr('data-id' ));
		});

		UserProfilePage._topPagesWrapper.find('.HideButton').bind('click', function(){
			UserProfilePage.doAction('hide', 'page', $(this).attr('data-id' ));
		});

		UserProfilePage._topPagesWrapper.find('.UnhideButton').bind('click', function(){
			UserProfilePage._hiddenTopPagesWrapper.removeClass('user-profile-box');
			UserProfilePage.doAction('unhide', 'page', $(this).attr('data-id' ));
		});
	},

	enrichAboutSection: function(){
		var section = UserProfilePage._aboutSection;
		
		section.find('.answer,.question').each(function(){
			var elm = $(this);
			elm.parent().prepend($('<img src="' + section.attr('data-' + ((elm.hasClass('question')) ? 'generic' : 'user') + '-avatar') + '">'));
		});
	}

};
