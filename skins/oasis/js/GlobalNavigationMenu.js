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
				'menu': 'Games',
				'type': 'games',
				'active': true,
				'data': [verticalMenuData + verticalMenuData, verticalMenuData + verticalMenuData]
			},
			{
				'menu': 'Comics',
				'type': 'comics',
				'data': [verticalMenuData + verticalMenuData, verticalMenuData + verticalMenuData]
			},
			{
				'menu': 'Games',
				'type': 'games',
				'data': [verticalMenuData + verticalMenuData, verticalMenuData + verticalMenuData]
			},
			{
				'menu': 'Comics',
				'type': 'comics',
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
			htmlContent = this.menu;

		if (this.active) {
			$elem.addClass('active');
		}

		$elem.html(htmlContent);
		$globalNavigationDropdown.find('[data-row=' + index + ']').append($elem);
	});
	// 3. finish table markup - add place for submenu

	$globalNavigationDropdown.find('[data-row=0]')
		.append('<td rowspan="' + verticalMenu.length + '" data-submenu="1"><span style="height:' + (verticalMenu.length * 62) + 'px" />')
		.append('<td rowspan="' + verticalMenu.length + '" data-submenu="2"><span style="height:' + (verticalMenu.length * 62) + 'px" />');
	//
	$globalNavigationDropdown.find('[data-submenu=1] span').text("The path of the righteous man is beset on all sides by the iniquities of the selfish and the tyranny of evil men. Blessed is he who, in the name of charity and good will, shepherds the weak through the valley of darkness, for he is truly his brother's keeper and the finder of lost children. And I will strike down upon thee with great vengeance and furious anger those who would attempt to poison and destroy My brothers. And you will know My name is the Lord when I lay My vengeance upon thee.");
	$globalNavigationDropdown.find('[data-submenu=2] span').text("The path of the righteous man is beset on all sides by the iniquities of the selfish and the tyranny of evil men. Blessed is he who, in the name of charity and good will, shepherds the weak through the valley of darkness, for he is truly his brother's keeper and the finder of lost children. And I will strike down upon thee with great vengeance and furious anger those who would attempt to poison and destroy My brothers. And you will know My name is the Lord when I lay My vengeance upon thee.");


	$('#WikiaHeader').on('click', '#GlobalNavigationMenuButton', function (e) {
		e.preventDefault();

		$('.GlobalNavigationContainer').toggle();
	});
});
