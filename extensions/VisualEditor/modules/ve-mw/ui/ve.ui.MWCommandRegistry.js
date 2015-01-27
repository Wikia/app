/*!
 * VisualEditor CommandRegistry class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* MW Command Registrations */

ve.ui.commandRegistry.register(
	new ve.ui.Command( 'linkNode', 'window', 'open', 'linkNode' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'gallery', 'window', 'open', 'gallery' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'mediaEdit', 'window', 'open', 'mediaEdit' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'mediaInsert', 'window', 'open', 'mediaInsert' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'referenceList', 'window', 'open', 'referenceList' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'reference', 'window', 'open', 'reference' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'reference/existing', 'window', 'open', 'reference', { 'useExisting': true } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'transclusion', 'window', 'open', 'transclusion' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'alienExtension', 'window', 'open', 'alienExtension' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'meta', 'window', 'open', 'meta' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'meta/settings', 'window', 'open', 'meta', { 'page': 'settings' } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'meta/advanced', 'window', 'open', 'meta', { 'page': 'advancedSettings' } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'meta/categories', 'window', 'open', 'meta', { 'page': 'categories' } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'meta/languages', 'window', 'open', 'meta', { 'page': 'languages' } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'heading1', 'format', 'convert', 'mwHeading', { 'level': 1 } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'heading2', 'format', 'convert', 'mwHeading', { 'level': 2 } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'heading3', 'format', 'convert', 'mwHeading', { 'level': 3 } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'heading4', 'format', 'convert', 'mwHeading', { 'level': 4 } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'heading5', 'format', 'convert', 'mwHeading', { 'level': 5 } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'heading6', 'format', 'convert', 'mwHeading', { 'level': 6 } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'preformatted', 'format', 'convert', 'mwPreformatted' )
);
