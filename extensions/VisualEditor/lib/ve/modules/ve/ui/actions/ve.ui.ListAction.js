/*!
 * VisualEditor UserInterface ListAction class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * List action.
 *
 * @class
 * @extends ve.ui.Action
 * @constructor
 * @param {ve.ui.Surface} surface Surface to act on
 */
ve.ui.ListAction = function VeUiListAction( surface ) {
	// Parent constructor
	ve.ui.Action.call( this, surface );
};

/* Inheritance */

OO.inheritClass( ve.ui.ListAction, ve.ui.Action );

/* Static Properties */

ve.ui.ListAction.static.name = 'list';

/**
 * List of allowed methods for the action.
 *
 * @static
 * @property
 */
ve.ui.ListAction.static.methods = [ 'wrap', 'unwrap', 'toggle' ];

/* Methods */

/**
 * Toggle a list around content.
 *
 * @method
 * @param {string} style List style, e.g. 'number' or 'bullet'
 */
ve.ui.ListAction.prototype.toggle = function ( style ) {
	var i, len,
		nodes = this.surface.getModel().getFragment().getLeafNodes(),
		all = !!nodes.length;

	for ( i = 0, len = nodes.length; i < len; i++ ) {
		if (
			( len === 1 || !nodes[i].range || nodes[i].range.getLength() ) &&
			!nodes[i].node.hasMatchingAncestor( 'list', { 'style': style } )
		) {
			all = false;
			break;
		}
	}
	this[all ? 'unwrap' : 'wrap']( style );
};

/**
 * Add a list around content.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @method
 * @param {string} style List style, e.g. 'number' or 'bullet'
 */
ve.ui.ListAction.prototype.wrap = function ( style ) {
	var tx, i, previousList, groupRange, group,
		surfaceModel = this.surface.getModel(),
		documentModel = surfaceModel.getDocument(),
		selection = surfaceModel.getSelection(),
		groups;

	surfaceModel.breakpoint();

	// TODO: Would be good to refactor at some point and avoid/abstract path split for block slug
	// and not block slug.

	if (
		selection.isCollapsed() &&
		!documentModel.data.isContentOffset( selection.to ) &&
		this.surface.view.documentView.getSlugAtOffset( selection.to )
	) {
		// Inside block level slug
		surfaceModel.change( ve.dm.Transaction.newFromInsertion(
			documentModel,
			selection.from,
			[
				{ 'type': 'list', 'attributes': { 'style': style } },
				{ 'type': 'listItem' },
				{ 'type': 'paragraph' },
				{ 'type': '/paragraph' },
				{ 'type': '/listItem' },
				{ 'type': '/list' }

			]
		), new ve.Range( selection.to + 3 ) );
	} else {
		groups = documentModel.getCoveredSiblingGroups( selection );
		for ( i = 0; i < groups.length; i++ ) {
			group = groups[i];
			if ( group.grandparent && group.grandparent.getType() === 'list' ) {
				if ( group.grandparent !== previousList ) {
					// Change the list style
					surfaceModel.change(
						ve.dm.Transaction.newFromAttributeChanges(
							documentModel, group.grandparent.getOffset(), { 'style': style }
						),
						selection
					);
					// Skip this one next time
					previousList = group.grandparent;
				}
			} else {
				// Get a range that covers the whole group
				groupRange = new ve.Range(
					group.nodes[0].getOuterRange().start,
					group.nodes[group.nodes.length - 1].getOuterRange().end
				);
				// Convert everything to paragraphs first
				surfaceModel.change(
					ve.dm.Transaction.newFromContentBranchConversion(
						documentModel, groupRange, 'paragraph'
					),
					selection
				);
				// Wrap everything in a list and each content branch in a listItem
				tx = ve.dm.Transaction.newFromWrap(
					documentModel,
					groupRange,
					[],
					[{ 'type': 'list', 'attributes': { 'style': style } }],
					[],
					[{ 'type': 'listItem' }]
				);
				surfaceModel.change( tx, tx.translateRange( selection ) );
			}
		}
	}
	surfaceModel.breakpoint();
	this.surface.getView().focus();
};

/**
 * Remove list around content.
 *
 * TODO: Refactor functionality into {ve.dm.SurfaceFragment}.
 *
 * @method
 */
ve.ui.ListAction.prototype.unwrap = function () {
	var node,
		surfaceModel = this.surface.getModel(),
		documentModel = surfaceModel.getDocument();

	surfaceModel.breakpoint();

	do {
		node = documentModel.getNodeFromOffset( surfaceModel.getSelection().start );
	} while ( node.hasMatchingAncestor( 'list' ) && this.surface.execute( 'indentation', 'decrease' ) );

	surfaceModel.breakpoint();
	this.surface.getView().focus();
};

/* Registration */

ve.ui.actionFactory.register( ve.ui.ListAction );
