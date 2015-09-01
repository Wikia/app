/*!
 * VisualEditor UserInterface LinkAction class.
 *
 * @copyright 2011-2015 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Link action.
 * This action transforms or inspects links (or potential links).
 *
 * @class
 * @extends ve.ui.Action
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.LinkAction = function VeUiLinkAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

OO.inheritClass( ve.ui.LinkAction, ve.ui.Action );

/* Static Properties */

ve.ui.LinkAction.static.name = 'link';

/**
 * RegExp matching an autolink + trailing space.
 * @property {RegExp}
 * @private
 */
ve.ui.LinkAction.static.autolinkRegExp = null; // Initialized below.

/**
 * List of allowed methods for the action.
 *
 * @static
 * @property
 */
ve.ui.LinkAction.static.methods = [ 'autolinkUrl' ];

/* Methods */

/**
 * Autolink the selected URL (which may have trailing whitespace).
 *
 * @method
 * @return {boolean}
 *   True if the selection is a valid URL and the autolink action was
 *   executed; otherwise false.
 */
ve.ui.LinkAction.prototype.autolinkUrl = function () {
	return this.autolink( function ( linktext ) {
		// Make sure we still have a real URL after trail removal, and not
		// a bare protocol (or no protocol at all, if we stripped the last
		// colon from the protocol)
		return ve.ui.LinkAction.static.autolinkRegExp.test( linktext + ' ' );
	} );
};

/**
 * Autolink the selection, which may have trailing whitespace.
 *
 * @method
 * @private
 * @param {Function} validateFunc
 *   A function used to validate the given linktext.
 * @param {string} validateFunc.linktext
 *   Linktext with trailing whitespace and punctuation stripped.
 * @param {boolean} validateFunc.return
 *   True iff the given linktext is valid.  If false, no linking will be done.
 * @return {boolean} Selection was valid and link action was executed.
 */
ve.ui.LinkAction.prototype.autolink = function ( validateFunc ) {
	var range, rangeEnd, linktext, i,
		surfaceModel = this.surface.getModel(),
		documentModel = surfaceModel.getDocument(),
		selection = surfaceModel.getSelection();

	function isLinkAnnotation( annotation ) {
		return /^link/.test( annotation.name );
	}

	if ( !( selection instanceof ve.dm.LinearSelection ) ) {
		return false;
	}

	range = selection.getRange();
	rangeEnd = range.end;

	linktext = documentModel.data.getText( true, range );

	// Eliminate trailing whitespace.
	linktext = linktext.replace( /\s+$/, '' );

	// Eliminate trailing punctuation.
	linktext = linktext.replace( this.getTrailingPunctuation( linktext ), '' );

	// Validate the stripped text.
	if ( !validateFunc( linktext ) ) {
		// Don't autolink this.
		return false;
	}

	// Shrink range to match new linktext.
	range = range.truncate( linktext.length );

	// Check that none of the range has an existing link annotation.
	// Otherwise we could autolink an internal link, which would be ungood.
	for ( i = range.start; i < range.end; i++ ) {
		if ( documentModel.data.getAnnotationsFromOffset( i ).containsMatching( isLinkAnnotation ) ) {
			// Don't autolink this.
			return false;
		}
	}

	// Make sure `undo` doesn't expose the selected linktext.
	surfaceModel.setLinearSelection( new ve.Range( rangeEnd, rangeEnd ) );

	// Annotate the (previous) range.
	surfaceModel.change(
		ve.dm.Transaction.newFromAnnotation(
			documentModel,
			range,
			'set',
			this.getLinkAnnotation( linktext )
		),
		surfaceModel.getSelection()
	);

	return true;
};

/**
 * Return an appropriate "trailing punctuation" set, which will
 * get stripped from possible autolinks.
 *
 * @param {string} candidate
 *   The candidate text.  Some users may not wish to include closing
 *   brackets/braces/parentheses in the stripped character class if an
 *   opening bracket/brace/parenthesis in present in the candidate link
 *   text.
 * @return {RegExp}
 *   A regular expression matching trailing punctuation which will be
 *   stripped from an autolink.
 */
ve.ui.LinkAction.prototype.getTrailingPunctuation = function ( candidate ) {
	/* jshint unused: false */
	return /[,;.:!?)\]\}"'”’»]+$/;
};

/**
 * Return an appropriate annotation for the given link text.
 *
 * @method
 * @param {string} linktext The link text to annotate.
 * @return {ve.dm.LinkAnnotation} The annotation to use.
 */
ve.ui.LinkAction.prototype.getLinkAnnotation = function ( linktext ) {
	return new ve.dm.LinkAnnotation( {
		type: 'link',
		attributes: {
			href: linktext
		}
	} );
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.LinkAction );

// Delayed initialization (wait until ve.init.platform exists)
ve.init.Platform.static.initializedPromise.then( function () {

	ve.ui.LinkAction.static.autolinkRegExp =
		new RegExp(
			'\\b' + ve.init.platform.getUnanchoredExternalLinkUrlProtocolsRegExp().source + '\\S+(\\s|\\n\\n)$',
			'i'
		);

	ve.ui.sequenceRegistry.register(
		new ve.ui.Sequence( 'autolinkUrl', 'autolinkUrl', ve.ui.LinkAction.static.autolinkRegExp, 0, true )
	);
} );
