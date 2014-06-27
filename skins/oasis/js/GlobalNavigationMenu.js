require([ 'jquery', 'wikia.ui.factory', 'wikia.nirvana' ], function ($, uiFactory, nirvana) {
	'use strict';

	var menuPromise = nirvana.sendRequest({
				controller: 'GlobalHeaderController',
				method: 'getGlobalMenuItems',
				format: 'json',
				type: 'GET'
			}),
			hamburgerButton = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="0 0 44 66" enable-background="new 0 0 44 66" xml:space="preserve" width="100%" height="100%"><rect x="0" id="rect5" height="3" width="28" y="27" /><rect x="0" id="rect7" height="2.9690001" width="28" y="33" /><polygon id="polygon9" points="28,41.969 0,41.963 0,39.031 28,39.031 " /><polygon id="svg-chevron" points="44,33.011 39,38 34,33.011 " /></svg>',
			$globalNavigationNav,
			initialize = function() {
				$('#GlobalNavigation').remove();
				$('<li id="GlobalNavigationMenuButton">' + hamburgerButton + '</li>').insertBefore('li.WikiaLogo');
				$('<div class="GlobalNavigationContainer"><nav><div class="hubs"></div></nav></div>').insertAfter('.WikiaHeader');
				$globalNavigationNav = $('.GlobalNavigationContainer nav');
			},
			buildMenu = function(verticalData) {
				var $hubsMenu = $globalNavigationNav.find('.hubs' ),
					active = verticalData.active || 'comics';
				//
				$globalNavigationNav.addClass('count-' + verticalData.menu.length).data('active', active);
				//
				$.each(verticalData.menu, function() {
					var $elem = $('<nav class="' + this.specialAttr + ' hub"><span class="icon" />' +
						'<span class="border" /><span class="label" /></nav>');

					$elem.data('submenus', this.children).find('.label').text(this.text);
					$elem.appendTo($hubsMenu);
						});
				//
				$globalNavigationNav
					.append('<section data-submenu="0" />')
					.append('<section data-submenu="1" />');
			},
			attachEvents = function() {
				var $hub = $globalNavigationNav.find('.hub'),
					submenu0 = $globalNavigationNav.find('[data-submenu=0]')[0],
					submenu1 = $globalNavigationNav.find('[data-submenu=1]')[0];

				$globalNavigationNav.on('mouseenter', '.hub', function(e) {
					e.preventDefault();
					$hub.removeClass('active');

					var $this = $(this),
						submenus = $this.data('submenus'),
						html = ['', ''],
						column = 0;

					$this.addClass('active');

					$.each(submenus, function(i) {
						column = Math.floor(i / 2);
						html[column] += '<h2>' + this.text + '</h2><ul>';
						$.each(this.children, function() {
							html[column] += '<li><a href="' + this.href + '">' +  this.text + '</a></li>';
						});
						html[column] += '</ul>';
					});
					submenu0.innerHTML = html[0];
					submenu1.innerHTML = html[1];

				}).on('mouseleave', function(){
					$('#GlobalNavigationMenuButton').removeClass('active');
					$('.GlobalNavigationContainer').hide();
				});

				$('#WikiaHeader').on('mouseover click', '#GlobalNavigationMenuButton', function(e) {
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
