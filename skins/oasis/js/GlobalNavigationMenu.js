
require([ 'jquery', 'wikia.ui.factory', 'wikia.nirvana', 'wikia.mustache' ], function ($, uiFactory, nirvana, mustache) {
	'use strict';

	$('#GlobalNavigation').remove();
	$('<li id="GlobalNavigationMenuButton">Menu</li>').insertBefore('li.WikiaLogo');

	var menuPromise,
		drawerPromise,
		buildSubMenus,
		buildMainMenu,
		// TODO: We should change it to one server-based template when we'll be implementing it on production
		TMPL_MENU_UL = '<ul id="drawerGlobalNavigation">{{{items}}}</ul>',
		TMPL_MENU_LI = '<li class="{{className}}" data-id="{{id}}"><a href="{{href}}">{{text}}</a></li>',
		TMPL_SUBMENU_HEADER = '<header class="drawerSubmenu {{className}}"><a href="{{href}}">{{text}}</a></header>',
		TMPL_SUBMENU_UL_START = '<ul class="drawerSubmenu {{className}}">',
		TMPL_SUBMENU_UL_END = '</ul>',
		TMPL_SUBMENU_LI_HEADER = '<li><header>{{text}}</header></li>',
		TMPL_SUBMENU_LI_WITH_CLASS = '<li class="{{className}}"><a href="{{href}}">{{text}}</a></li>',
		TMPL_SUBMENU_LI_WITHOUT_CLASS = '<li><a href="{{href}}">{{text}}</a></li>';

	menuPromise = nirvana.sendRequest({
		controller: 'GlobalHeaderController',
		method: 'getGlobalMenuItems',
		format: 'json',
		type: 'GET'
	});

	drawerPromise = uiFactory.init([ 'drawer' ]);

	buildSubMenus = function (menuItemsObj) {
		var subMenus = [];

		$.each(menuItemsObj, function () {
			var subMenu = [],
				extraClassName = this.specialAttr || '';

			subMenu.push(mustache.render(TMPL_SUBMENU_HEADER, {
				className: extraClassName,
				href: this.href,
				text: this.text
			}));

			$.each(this.children, function () {
				subMenu.push(mustache.render(TMPL_SUBMENU_UL_START, {
					className: extraClassName
				}));

				subMenu.push(mustache.render(TMPL_SUBMENU_LI_HEADER, {
					text: this.text
				}));

				$.each(this.children, function () {
					if (this.specialAttr) {
						subMenu.push(mustache.render(TMPL_SUBMENU_LI_WITH_CLASS, {
							className: this.specialAttr,
							href: this.href,
							text: this.text
						}));
					} else {
						subMenu.push(mustache.render(TMPL_SUBMENU_LI_WITHOUT_CLASS, {
							href: this.href,
							text: this.text
						}));
					}
				});

				subMenu.push(TMPL_SUBMENU_UL_END);
			});
			subMenus.push(subMenu.join(''));
		});

		return subMenus;
	};

	buildMainMenu = function (menuItemsObj) {
		var menu = [];

		$.each(menuItemsObj, function (i) {
			menu.push(mustache.render(TMPL_MENU_LI, {
				className: this.specialAttr,
				id: i,
				href: this.href,
				text: this.text
			}));
		});

		return mustache.render(TMPL_MENU_UL, {
			items: menu.join('')
		});
	};

	$.when(menuPromise, drawerPromise).done(function (menuXhr, uiDrawer) {
		var menuItems = menuXhr[0],
			mainMenu = buildMainMenu(menuItems),
			subMenus = buildSubMenus(menuItems),
			drawerConfig = {
				vars: {
					closeText: 'Close',
					side: 'left',
					content: mainMenu
				}
			};

		uiDrawer.createComponent(drawerConfig, function (drawer) {
			var delay = 250,
				timer;

			window.GlobalNavigationMenu = drawer;

			$('#drawerGlobalNavigation li').click(function (e) {
				e.preventDefault();

				clearTimeout(timer);

				var $self = $(this),
					id = $self.data('id');

				timer = setTimeout(function () {
					if (!$self.hasClass('active')) {
						$('#drawerGlobalNavigation').find('li').removeClass('active');
						$self.addClass('active');

						drawer.swipeSub(subMenus[id]);
					}
				}, delay);
			});

			$('#WikiaHeader').on('click', '#GlobalNavigationMenuButton', function (e) {
				e.preventDefault();

				drawer.open();
			});
		});
	});
});
