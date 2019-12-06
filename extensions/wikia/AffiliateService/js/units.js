define('ext.wikia.AffiliateService.units', [], function () {
	var units = [
		{
			category: 'disney2',
			campaign: 'disneyplus2',
			name: 'test unit2',
			country: ['US', 'CA', 'NL', 'AU', 'NZ'],
			header: 'Header 2',
			subheader: 'This is subheader 2',
			link: 'https://fandom.com',
		},
		{
			category: 'disney',
			campaign: 'disneyplus',
			name: 'test unit',
			country: ['US', 'CA', 'NL', 'AU', 'NZ'],
			header: 'Header',
			subheader: 'This is subheader',
			link: 'https://fandom.com',
		},
		{
			category: 'ddb',
			campaign: 'ddb',
			name: 'test unit',
			header: 'Header',
			subheader: 'This is subheader',
			link: 'https://ddb.com',
		}
	];

	return units;
});
