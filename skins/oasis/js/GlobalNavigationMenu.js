require([ 'jquery', 'wikia.ui.factory', 'wikia.nirvana' ], function ($, uiFactory, nirvana) {
	'use strict';

	var menuPromise = nirvana.sendRequest({
				controller: 'GlobalHeaderController',
				method: 'getGlobalMenuItems',
				format: 'json',
				type: 'GET',
				data: {
					version: '2'
				}
			}),
			hamburgerButton = '<svg xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" version="1.1" id="Layer_1" x="0px" y="0px" viewBox="0 0 44 66" enable-background="new 0 0 44 66" xml:space="preserve" width="100%" height="100%"><rect x="0" id="rect5" height="3" width="28" y="27" /><rect x="0" id="rect7" height="2.9690001" width="28" y="33" /><polygon id="polygon9" points="28,41.969 0,41.963 0,39.031 28,39.031 " /><polygon id="svg-chevron" points="44,33.011 39,38 34,33.011 " /></svg>',
			$globalNavigationNav,
			initialize = function(){
				$('#GlobalNavigation').remove();
				$('<li id="GlobalNavigationMenuButton">' + hamburgerButton + '</li>').insertBefore('li.WikiaLogo');
				$('<div class="GlobalNavigationContainer"><nav><div class="hubs"></div></nav></div>').insertAfter('.WikiaHeader');
				$globalNavigationNav = $('.GlobalNavigationContainer nav');
			},
			buildMenu = function(verticalData) {
				var $hubsMenu = $globalNavigationNav.find('.hubs');
				//
				$globalNavigationNav.addClass('count-' + verticalData.menu.length).data('active', verticalData.active);
				//
				$.each(verticalData.menu, function() {
					var $elem = $('<nav class="' + this.type + ' hub"><span class="icon" />' +
						'<span class="border" /><span class="label" /></nav>');

					$elem.data('data', this.data).find('.label').text(this.label);
					$elem.appendTo($hubsMenu);
				});
				//
				$globalNavigationNav
					.append('<section data-submenu="0" />')
					.append('<section data-submenu="1" />');
			},
			attachEvents = function() {
				var $hub = $globalNavigationNav.find('.hub'),
					$submenu0 = $globalNavigationNav.find('[data-submenu=0]'),
					$submenu1 = $globalNavigationNav.find('[data-submenu=1]');

				$globalNavigationNav.on('mouseenter', '.hub', function (e) {
					e.preventDefault();
					$hub.removeClass('active');

					var $this = $(this),
						data = $this.data('data');

					$this.addClass('active');
					$submenu0.html(data[0]);
					$submenu1.html(data[1]);

				}).on('mouseleave', function(){
					$('#GlobalNavigationMenuButton').removeClass('active');
					$('.GlobalNavigationContainer').hide();
				});

				$('#WikiaHeader').on('mouseover click', '#GlobalNavigationMenuButton', function (e) {
					e.preventDefault();
					//
					$globalNavigationNav.find('.hub.' + $globalNavigationNav.data('active')).mouseenter();

					$('#GlobalNavigationMenuButton').addClass('active');
					$('.GlobalNavigationContainer').show();
				});
			};

	$.when(menuPromise).done(function(verticalMenuData) {
			initialize();
			buildMenu(verticalMenuData);
			attachEvents();
	});
});
