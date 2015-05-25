/*!
 * VisualEditor MediaWiki CommandRegistry registrations.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* MW Command Registrations */

ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'link', 'mwlink', 'open', { supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'gallery', 'window', 'open',
		{ args: ['gallery'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'media', 'window', 'open',
		{ args: ['media'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'referencesList', 'window', 'open',
		{ args: ['referencesList'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'reference', 'window', 'open',
		{ args: ['reference'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'transclusion', 'window', 'open',
		{ args: ['transclusion'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'alienExtension', 'window', 'open',
		{ args: ['alienExtension'], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'meta', 'window', 'open',
		{ args: ['meta'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'meta/settings', 'window', 'open',
		{ args: [ 'meta', { page: 'settings' } ] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'meta/advanced', 'window', 'open',
		{ args: [ 'meta', { page: 'advancedSettings' } ] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'meta/categories', 'window', 'open',
		{ args: [ 'meta', { page: 'categories' } ] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'meta/languages', 'window', 'open',
		{ args: [ 'meta', { page: 'languages' } ] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'heading1', 'format', 'convert',
		{ args: [ 'mwHeading', { level: 1 } ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'heading2', 'format', 'convert',
		{ args: [ 'mwHeading', { level: 2 } ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'heading3', 'format', 'convert',
		{ args: [ 'mwHeading', { level: 3 } ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'heading4', 'format', 'convert',
		{ args: [ 'mwHeading', { level: 4 } ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'heading5', 'format', 'convert',
		{ args: [ 'mwHeading', { level: 5 } ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'heading6', 'format', 'convert',
		{ args: [ 'mwHeading', { level: 6 } ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command(
		'preformatted', 'format', 'convert',
		{ args: [ 'mwPreformatted' ], supportedSelections: ['linear'] }
	)
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'insertTable', 'table', 'create',
		{
			args: [ {
				header: true,
				rows: 3,
				cols: 4,
				type: 'mwTable',
				attributes: { 'article-table': true }
			} ],
			supportedSelections: ['linear']
		}
	)
);
