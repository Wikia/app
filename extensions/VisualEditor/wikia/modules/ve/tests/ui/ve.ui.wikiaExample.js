/*!
 * VisualEditor UesrInterface Wikia example data sets.
 */

/**
 * @class
 * @singleton
 * @ignore
 */
ve.ui.wikiaExample = {};

ve.ui.wikiaExample.sortTemplateTitlesCases = [
	{
		data: [],
		expected: []
	},
	{
		data: [
			{
				label: 'Infobox Character',
				title: 'Infobox_Character'
			},
			{
				label: 'InfoboxCharacter',
				title: 'InfoboxCharacter'
			},
			{
				label: 'Infobox  Character',
				title: 'Infobox__Character'
			},
			{
				label: 'Character',
				title: 'Character'
			},
			{
				label: 'Some Title',
				title: 'Some_Title'
			}
		],
		expected: [
			{
				label: 'Character',
				title: 'Character'
			},
			{
				label: 'InfoboxCharacter',
				title: 'InfoboxCharacter'
			},
			{
				label: 'Infobox Character',
				title: 'Infobox_Character'
			},
			{
				label: 'Infobox  Character',
				title: 'Infobox__Character'
			},
			{
				label: 'Some Title',
				title: 'Some_Title'
			}
		]
	}
];
