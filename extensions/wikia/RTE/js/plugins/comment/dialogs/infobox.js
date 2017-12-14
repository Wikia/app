CKEDITOR.dialog.add( 'infobox-dialog', function( editor ) {
	return {
		title: 'Abbreviation Properties',
		minWidth: 400,
		minHeight: 200,

		contents: [
			{
				id: 'tab-basic',
				label: 'Basic Settings',
				elements: [
					// UI elements of the first tab will be defined here.
				]
			},
			{
				id: 'tab-adv',
				label: 'Advanced Settings',
				elements: [
					// UI elements of the second tab will be defined here.
				]
			}
		]
	};
});
