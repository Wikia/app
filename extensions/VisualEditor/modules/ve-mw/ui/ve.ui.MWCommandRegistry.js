/*!
 * VisualEditor CommandRegistry class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/* MW Command Registrations */

ve.ui.commandRegistry.register(
	new ve.ui.Command( 'gallery', 'inspector', 'open', 'gallery' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'mediaEdit', 'dialog', 'open', 'mediaEdit' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'mediaInsert', 'dialog', 'open', 'mediaInsert' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'referenceList', 'dialog', 'open', 'referenceList' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'reference', 'dialog', 'open', 'reference' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'transclusion', 'dialog', 'open', 'transclusion' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'alienExtension', 'inspector', 'open', 'alienExtension' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'hiero', 'inspector', 'open', 'hiero' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'meta', 'dialog', 'open', 'meta' )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'meta/settings', 'dialog', 'open', 'meta', { 'page': 'settings' } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'meta/advanced', 'dialog', 'open', 'meta', { 'page': 'advanced' } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'meta/categories', 'dialog', 'open', 'meta', { 'page': 'categories' } )
);
ve.ui.commandRegistry.register(
	new ve.ui.Command( 'meta/languages', 'dialog', 'open', 'meta', { 'page': 'languages' } )
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
