require([ 'jquery', 'wikia.ui.factory', 'wikia.nirvana', 'wikia.mustache' ], function ($, uiFactory, nirvana, mustache) {
	'use strict';

	$('#GlobalNavigation').remove();
	$('<li id="GlobalNavigationMenuButton">&lt;INSERT MENU HERE&gt;</li>').insertBefore('li.WikiaLogo');
	$('<div class="GlobalNavigationContainer"><nav><div class="hubs"></div></nav></div>').insertAfter('.WikiaHeader');

	var $globalNavigationNav = $('.GlobalNavigationContainer nav'),
		$hubsMenu = $globalNavigationNav.find('.hubs'),
		rnd = function() {
			return Math.floor(Math.random() * 1000);
		},
		verticalMenuData = function() {
			return '<h2>Title ' + rnd() + '</h2><ul>' +
			'<li><a href="google.com">Item ' + rnd() + '</a></li>' +
			'<li><a href="google.com">Item ' + rnd() + '</a></li>' +
			'<li><a href="google.com">Item ' + rnd() + '</a></li>' +
			'<li><a href="google.com">Item ' + rnd() + '</a></li>' +
			'<li><a href="google.com">Item ' + rnd() + '</a></li>' +
			'</ul>'; },
		verticalData = {
			activeType: 'comics',
			menu: [
				{
					'label': 'Books',
					'type': 'books',
					'data': [verticalMenuData() + verticalMenuData(), verticalMenuData() + verticalMenuData()]
				},
				{
					'label': 'ComiX',
					'type': 'comics',
					'data': [verticalMenuData() + verticalMenuData(), verticalMenuData() + verticalMenuData()]
				},
				{
					'label': 'Games!',
					'type': 'games',
					'data': [verticalMenuData() + verticalMenuData(), verticalMenuData() + verticalMenuData()]
				},
				{
					'label': 'LiveStyle',
					'type': 'lifestyle',
					'data': [verticalMenuData() + verticalMenuData(), verticalMenuData() + verticalMenuData()]
				},
				{
					'label': 'Moovies',
					'type': 'movies',
					'data': [verticalMenuData() + verticalMenuData(), verticalMenuData() + verticalMenuData()]
				},
				{
					'label': 'Musique',
					'type': 'music',
					'data': [verticalMenuData() + verticalMenuData(), verticalMenuData() + verticalMenuData()]
				},
				{
					'label': 'T.V.',
					'type': 'tv',
					'data': [verticalMenuData() + verticalMenuData(), verticalMenuData() + verticalMenuData()]
				}
			]
		};
	// build menu
	// 1. prepare table markup
//	$.each(verticalMenu, function(index) {
//		$globalNavigationNav.append('<tr data-row="' + index + '"></tr>');
//	});
	$globalNavigationNav.addClass('count-' + verticalData.menu.length);
	// 2. populate main menu + dave submenu data in data
	$.each(verticalData.menu, function() {
		var $elem = $('<nav class="' + this.type + ' hub"><span class="icon" />' +
			'<span class="border" /><span class="label" /></nav>');

		$elem.data('data', this.data).find('.label').text(this.label);
		$elem.appendTo($hubsMenu);
	});
	// 3. finish table markup - add place for submenu
	$globalNavigationNav
		.append('<section data-submenu="0" />')
		.append('<section data-submenu="1" />');
	//

	$globalNavigationNav.on('click', '.hub', function (e) {
		e.preventDefault();
		$globalNavigationNav.find('.hub').removeClass('active');

		var $this = $(this),
			data = $this.data('data');

		$this.addClass('active');
		$globalNavigationNav.find('[data-submenu=0]').html(data[0]);
		$globalNavigationNav.find('[data-submenu=1]').html(data[1]);
	}).find('.hub.' + verticalData.activeType).click();

	$('#WikiaHeader').on('click', '#GlobalNavigationMenuButton', function (e) {
		e.preventDefault();

		$('.GlobalNavigationContainer').toggle();
	});
});
