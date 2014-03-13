/*!
 * VisualEditor UserInterface MWReferenceSearchWidget class.
 *
 * @copyright 2011-2013 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWReferenceSearchWidget object.
 *
 * @class
 * @extends OO.ui.SearchWidget
 *
 * @constructor
 * @param {ve.ui.Surface} [varname] [description]
 * @param {Object} [config] Configuration options
 */
ve.ui.MWReferenceSearchWidget = function VeUiMWReferenceSearchWidget( surface, config ) {
	// Configuration intialization
	config = ve.extendObject( {
		'placeholder': ve.msg( 'visualeditor-reference-input-placeholder' )
	}, config );

	// Parent constructor
	OO.ui.SearchWidget.call( this, config );

	// Properties
	this.surface = surface;
	this.index = [];

	// Initialization
	this.$element.addClass( 've-ui-mwReferenceSearchWidget' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWReferenceSearchWidget, OO.ui.SearchWidget );

/* Events */

/**
 * @event select
 * @param {Object|string|null} data Reference node attributes, command string (e.g. 'create') or
 *  null if no item is selected
 */

/* Methods */

/**
 * Handle query change events.
 *
 * @method
 * @param {string} value New value
 */
ve.ui.MWReferenceSearchWidget.prototype.onQueryChange = function () {
	// Parent method
	OO.ui.SearchWidget.prototype.onQueryChange.call( this );

	// Populate
	this.addResults();
};

/**
 * Handle select widget select events.
 *
 * @method
 * @param {OO.ui.OptionWidget} item Selected item
 * @fires select
 */
ve.ui.MWReferenceSearchWidget.prototype.onResultsSelect = function ( item ) {
	var data;

	if ( item ) {
		data = item.getData();
		// Resolve indexed values
		if ( this.index[data] ) {
			data = this.index[data].attributes;
		}
	} else {
		data = null;
	}

	this.emit( 'select', data );
};

/**
 * Build a serchable index of references.
 *
 * @method
 */
ve.ui.MWReferenceSearchWidget.prototype.buildIndex = function () {
	var i, iLen, j, jLen, group, groupName, groupNames, view, text, attr, firstNodes, indexOrder,
		refnode, matches, name, citation,
		internalList = this.surface.getModel().getDocument().getInternalList(),
		groups = internalList.getNodeGroups();

	function extractAttrs() {
		text += ' ' + $(this).attr( 'href' );
	}

	this.index = [];
	groupNames = ve.getObjectKeys( groups ).sort();

	for ( i = 0, iLen = groupNames.length; i < iLen; i++ ) {
		groupName = groupNames[i];
		if ( groupName.lastIndexOf( 'mwReference/' ) !== 0 ) {
			continue;
		}
		group = groups[groupName];
		firstNodes = group.firstNodes;
		indexOrder = group.indexOrder;
		for ( j = 0, jLen = indexOrder.length; j < jLen; j++ ) {
			refnode = firstNodes[indexOrder[j]];
			attr = ve.copy( refnode.getAttributes() );
			view = new ve.ce.InternalItemNode( internalList.getItemNode( attr.listIndex ) );

			// HACK: PHP parser doesn't wrap single lines in a paragraph
			if ( view.$element.children().length === 1 && view.$element.children( 'p' ).length === 1 ) {
				// unwrap inner
				view.$element.children().replaceWith( view.$element.children().contents() );
			}

			citation = ( attr.refGroup.length ? attr.refGroup + ' ' : '' ) + ( j + 1 );
			matches = attr.listKey.match( /^literal\/(.*)$/ );
			name = matches && matches[1] || '';
			// Make visible text, citation and reference name searchable
			text = [ view.$element.text().toLowerCase(), citation, name ].join( ' ' );
			// Make URLs searchable
			view.$element.find( 'a[href]' ).each( extractAttrs );

			this.index.push( {
				'$': view.$element.clone().show(),
				'text': text,
				'attributes': attr,
				'citation': citation,
				'name': name
			} );
			view.destroy();
		}
	}

	// Re-populate
	this.onQueryChange();
};

/**
 * Handle media query response events.
 *
 * @method
 */
ve.ui.MWReferenceSearchWidget.prototype.addResults = function () {
	var i, len, item, $citation, $name,
		value = this.query.getValue(),
		query = value.toLowerCase(),
		items = [];

	for ( i = 0, len = this.index.length; i < len; i++ ) {
		item = this.index[i];
		if ( item.text.indexOf( query ) >= 0 ) {
			$citation = this.$( '<div>' )
				.addClass( 've-ui-mwReferenceSearchWidget-citation' )
				.text( '[' + item.citation + ']' );
			$name = this.$( '<div>' )
				.addClass( 've-ui-mwReferenceSearchWidget-name' )
				.text( item.name );
			items.push(
				new ve.ui.MWReferenceResultWidget( i, {
					'$': this.$, 'label': $citation.add( $name ).add( item.$element )
				} )
			);
		}
	}

	this.results.addItems( items );
};
