/*!
 * VisualEditor UserInterface MWLinkAction class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see http://ve.mit-license.org
 */

/**
 * Link action.
 *
 * Opens either MWLinkAnnotationInspector or MWLinkNodeInspector depending on what is selected.
 *
 * @class
 * @extends ve.ui.Action
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.MWLinkAction = function VeUiMWLinkAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWLinkAction, ve.ui.Action );

/* Static Properties */

ve.ui.MWLinkAction.static.name = 'mwlink';

/**
 * List of allowed methods for the action.
 *
 * @static
 * @property
 */
ve.ui.MWLinkAction.static.methods = [ 'open' ];

/* Methods */

/**
 * Open either the 'link' or 'linkNode' window, depending on what is selected.
 *
 * @method
 * @return {boolean} Action was executed
 */
ve.ui.MWLinkAction.prototype.open = function () {
	var fragment = this.surface.getModel().getFragment(),
		windowName = 'link';

	if ( fragment.getSelectedNode() instanceof ve.dm.MWNumberedExternalLinkNode ) {
		windowName = 'linkNode';
	}
	this.surface.execute( 'window', 'open', windowName );
	return true;
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.MWLinkAction );
