/*!
 * VisualEditor MediaWiki SequenceRegistry registrations.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'wikitextLink', 'link', '[[', 2 )
);
ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'wikitextTemplate', 'wikiaTemplateInsert', '{{', 2 )
);
ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'wikitextItalic', 'mwWikitextWarning', '\'\'' )
);
ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'wikitextNowiki', 'mwWikitextWarning', '<nowiki' )
);
ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'wikitextRef', 'mwWikitextWarning', '<ref' )
);
ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'wikitextSig', 'mwWikitextWarning', '~~~' )
);
ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'wikitextHeading', 'heading2', [ { type: 'paragraph' }, '=', '=' ], 2 )
);
ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'numberHash', 'numberWrapOnce', [ { type: 'paragraph' }, '#', ' ' ], 2 )
);
ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'wikitextDefinition', 'mwWikitextWarning',  [ { type: 'paragraph' }, ';' ] )
);
ve.ui.sequenceRegistry.register(
	new ve.ui.Sequence( 'wikitextDescription', 'blockquote',  [ { type: 'paragraph' }, ':' ], 1 )
);
