require([ 'jquery', 'wikia.ui.factory', 'wikia.nirvana', 'wikia.mustache' ], function ($, uiFactory, nirvana, mustache) {
	'use strict';

	$('#GlobalNavigation').remove();
	$('<li id="GlobalNavigationMenuButton">&lt;INSERT MENU HERE&gt;</li>').insertBefore('li.WikiaLogo');
	$('<div class="GlobalNavigationContainer"><table class="GlobalNavigationDropdown"/></div>').appendTo('body');

	var $globalNavigationDropdown = $('.GlobalNavigationDropdown'),
		verticalMenuData = '<h2>Title</h2><ul>' +
			'<li><a href="google.com">Item</a></li>' +
			'<li><a href="google.com">Item</a></li>' +
			'<li><a href="google.com">Item</a></li>' +
			'<li><a href="google.com">Item</a></li>' +
			'<li><a href="google.com">Item</a></li>' +
			'</ul>',
		verticalMenu = [
			{
				'menu': 'books',
				'type': 'books',
				'active': true,
				'data': [verticalMenuData + verticalMenuData, verticalMenuData + verticalMenuData]
			},
			{
				'menu': 'comics',
				'type': 'comics',
				'data': [verticalMenuData + verticalMenuData, verticalMenuData + verticalMenuData]
			},
			{
				'menu': 'games',
				'type': 'games',
				'data': [verticalMenuData + verticalMenuData, verticalMenuData + verticalMenuData]
			},
			{
				'menu': 'lifestyle',
				'type': 'lifestyle',
				'data': [verticalMenuData + verticalMenuData, verticalMenuData + verticalMenuData]
			},
			{
				'menu': 'movies',
				'type': 'movies',
				'data': [verticalMenuData + verticalMenuData, verticalMenuData + verticalMenuData]
			},
			{
				'menu': 'music',
				'type': 'music',
				'data': [verticalMenuData + verticalMenuData, verticalMenuData + verticalMenuData]
			},
			{
				'menu': 'tv',
				'type': 'tv',
				'data': [verticalMenuData + verticalMenuData, verticalMenuData + verticalMenuData]
			}
		];

	// build menu
	// 2. prepare table markup
	$.each(verticalMenu, function(index) {
		$globalNavigationDropdown.append('<tr data-row="' + index + '"></tr>');
	});
	// 2. populate main menu + dave submenu data in data
	$.each(verticalMenu, function(index) {
		var $elem = $('<td class="' + this.type + ' hub"></td>'),
			$tr = $globalNavigationDropdown.find('[data-row=' + index + ']'),
			icon = '<span class="icon" />',
			border = '<span class="border" />';

		if (this.active) {
			$tr.addClass('active');
		}

		$elem.html(icon + border + this.menu);
		$tr.append($elem);
	});
	// 3. finish table markup - add place for submenu

	$globalNavigationDropdown.find('[data-row=0]')
		.append('<td rowspan="' + verticalMenu.length + '" data-submenu="1"><span style="height:' + (verticalMenu.length * 62) + 'px" />')
		.append('<td rowspan="' + verticalMenu.length + '" data-submenu="2"><span style="height:' + (verticalMenu.length * 62) + 'px" />');
	//
	$globalNavigationDropdown.find('[data-submenu=1] span').text("The path of the righteous man is beset on all sides by the iniquities of the selfish and the tyranny of evil men. Blessed is he who, in the name of charity and good will, shepherds the weak through the valley of darkness, for he is truly his brother's keeper and the finder of lost children. And I will strike down upon thee with great vengeance and furious anger those who would attempt to poison and destroy My brothers. And you will know My name is the Lord when I lay My vengeance upon thee.");
	$globalNavigationDropdown.find('[data-submenu=2] span').text("The path of the righteous man is beset on all sides by the iniquities of the selfish and the tyranny of evil men. Blessed is he who, in the name of charity and good will, shepherds the weak through the valley of darkness, for he is truly his brother's keeper and the finder of lost children. And I will strike down upon thee with great vengeance and furious anger those who would attempt to poison and destroy My brothers. And you will know My name is the Lord when I lay My vengeance upon thee.");


	$globalNavigationDropdown.on('click', 'td.hub', function (e) {
		e.preventDefault();

		$globalNavigationDropdown.find('tr').removeClass('active');
		$(this).parent().addClass('active');
	});

	$('#WikiaHeader').on('click', '#GlobalNavigationMenuButton', function (e) {
		e.preventDefault();

		$('.GlobalNavigationContainer').toggle();
	});
});
