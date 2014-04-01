require([ 'jquery', 'wikia.ui.factory', 'wikia.nirvana' ], function ($, uiFactory, nirvana) {
	'use strict';


	var menuPromise = nirvana.sendRequest({
			controller: 'GlobalHeaderController',
			method: 'getGlobalMenuItems',
			format: 'json',
			type: 'GET',
			data: {
				cb: Date.now()
			}
		}),
		drawerPromise = uiFactory.init([ 'drawer' ]),
		buildSubMenus = function (menuItemsObj) {
			var subMenus = [];

			$.each(menuItemsObj, function () {
				var subMenu = [],
					extraClassName = this.specialAttr;

				$.each(this.children, function () {
					subMenu.push('<ul class="drawerSubmenu ' + extraClassName + '">');
					subMenu.push('<li><header>' + this.text + '</header></li>');

					$.each(this.children, function () {
						subMenu.push('<li class="' + this.specialAttr + '" ><a href="' + this.href + '">' + this.text + '</a></li>');
					});

					subMenu.push('</ul>');
				});
				subMenus.push(subMenu.join(''));
			});

			return subMenus;
		},
		buildMainMenu = function (menuItemsObj) {
			var menu = [];

			$.each(menuItemsObj, function (i) {
				menu.push('<li class="' + this.specialAttr + '" data-id="' + i + '"><a href="' + this.href + '">' + this.text + '</a></li>');
			});

			return '<ul id="drawerGlobalNavigation">' + menu.join('') + '</ul>';
		};

	$.when(menuPromise, drawerPromise).done(function (menuXhr, uiDrawer) {
		var menuItems = menuXhr[0],
			mainMenu = buildMainMenu( menuItems ),
			subMenus = buildSubMenus( menuItems ),
			drawerConfig = {
				vars: {
					//style: 'fixed',
					closeText: 'Close',
					side: 'left',
					content: mainMenu
				}
			};

		$('#GlobalNavigation').remove();

		uiDrawer.createComponent(drawerConfig, function (drawer) {
			var delay = 300,
				timer;

			window.GlobalNavigationDrawer = drawer;

			$('#drawerGlobalNavigation li').hover(function (e) {
				var $self = $(this),
					id = $self.data('id');

				timer = setTimeout(function () {
					if (!$self.hasClass('active')) {
						$('#drawerGlobalNavigation').find('li').removeClass('active');
						$self.addClass('active');

						drawer.swipeSub(subMenus[id]);
					}
				}, delay);
			}, function (e) {
				clearTimeout(timer);
			});

			$('.WikiaLogo').on('click', function (e) {
				e.preventDefault();

				drawer.open();
			});
		});
	});
});
