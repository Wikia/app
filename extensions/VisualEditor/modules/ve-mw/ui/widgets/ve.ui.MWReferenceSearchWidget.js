/*!
 * VisualEditor UserInterface MWReferenceSearchWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates an ve.ui.MWReferenceSearchWidget object.
 *
 * @class
 * @extends OO.ui.SearchWidget
 *
 * @constructor
 * @param {Object} [config] Configuration options
 */
ve.ui.MWReferenceSearchWidget = function VeUiMWReferenceSearchWidget( config ) {
	// Configuration initialization
	config = ve.extendObject( {
		placeholder: ve.msg( 'visualeditor-reference-input-placeholder' )
	}, config );

	// Parent constructor
	OO.ui.SearchWidget.call( this, config );

	// Properties
	this.index = [];
	this.indexEmpty = true;
	this.built = false;

	// Initialization
	this.$element.addClass( 've-ui-mwReferenceSearchWidget' );
};

/* Inheritance */

OO.inheritClass( ve.ui.MWReferenceSearchWidget, OO.ui.SearchWidget );

/* Events */

/**
 * @event select
 * @param {ve.dm.MWReferenceModel|null} data Reference model, null if no item is selected
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
			data = this.index[data].reference;
		}
	} else {
		data = null;
	}

	this.emit( 'select', data );
};

/**
 * Set the internal list and check if it contains any references
 * @param {ve.dm.InternalList} internalList Internal list
 */
ve.ui.MWReferenceSearchWidget.prototype.setInternalList = function ( internalList ) {
	var i, iLen, groupNames, groupName, groups = internalList.getNodeGroups();

	if ( this.results.getSelectedItem() ) {
		this.results.getSelectedItem().setSelected( false );
	}

	this.internalList = internalList;
	this.internalList.connect( this, { update: 'onInternalListUpdate' } );
	this.internalList.getListNode().connect( this, { update: 'onListNodeUpdate' } );

	groupNames = ve.getObjectKeys( groups );
	for ( i = 0, iLen = groupNames.length; i < iLen; i++ ) {
		groupName = groupNames[i];
		if ( groupName.lastIndexOf( 'mwReference/' ) !== 0 ) {
			continue;
		}
		if ( groups[groupName].indexOrder.length ) {
			this.indexEmpty = false;
			return;
		}
	}
	this.indexEmpty = true;
};

/**
 * Handle the updating of the InternalList object.
 *
 * This will occur after a document transaction.
 *
 * @method
 * @param {string[]} groupsChanged A list of groups which have changed in this transaction
 */
ve.ui.MWReferenceSearchWidget.prototype.onInternalListUpdate = function ( groupsChanged ) {
	for ( var i = 0, len = groupsChanged.length; i < len; i++ ) {
		if ( groupsChanged[i].indexOf( 'mwReference/' ) === 0 ) {
			this.built = false;
			break;
		}
	}
};

/**
 * Handle the updating of the InternalListNode.
 *
 * This will occur after changes to any InternalItemNode.
 *
 * @method
 */
ve.ui.MWReferenceSearchWidget.prototype.onListNodeUpdate = function () {
	this.built = false;
};

/**
 * Build a searchable index of references.
 *
 * @method
 */
ve.ui.MWReferenceSearchWidget.prototype.buildIndex = function () {
	if ( this.built ) {
		return;
	}

	var i, iLen, j, jLen, ref, group, groupName, groupNames, view, text, firstNodes, indexOrder,
		refGroup, refNode, matches, name, citation,
		groups = this.internalList.getNodeGroups();

	function extractAttrs() {
		text += ' ' + this.getAttribute( 'href' );
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
			refNode = firstNodes[indexOrder[j]];
			ref = ve.dm.MWReferenceModel.static.newFromReferenceNode( refNode );
			view = new ve.ce.InternalItemNode( this.internalList.getItemNode( ref.getListIndex() ) );

			// HACK: PHP parser doesn't wrap single lines in a paragraph
			if ( view.$element.children().length === 1 && view.$element.children( 'p' ).length === 1 ) {
				// unwrap inner
				view.$element.children().replaceWith( view.$element.children().contents() );
			}

			refGroup = ref.getGroup();
			citation = ( refGroup && refGroup.length ? refGroup + ' ' : '' ) + ( j + 1 );
			matches = ref.getListKey().match( /^literal\/(.*)$/ );
			name = matches && matches[1] || '';
			// Hide previously auto-generated reference names
			if ( name.match( /^:[0-9]+$/ ) ) {
				name = '';
			}
			// Make visible text, citation and reference name searchable
			text = [ view.$element.text().toLowerCase(), citation, name ].join( ' ' );
			// Make URLs searchable
			view.$element.find( 'a[href]' ).each( extractAttrs );

			this.index.push( {
				$element: view.$element,
				text: text,
				reference: ref,
				citation: citation,
				name: name
			} );
			view.destroy();
		}
	}

	// Re-populate
	this.onQueryChange();

	this.built = true;
};

/**
 * Check whether buildIndex will create an empty index based on the current internalList.
 *
 * @returns {boolean} Index is empty
 */
ve.ui.MWReferenceSearchWidget.prototype.isIndexEmpty = function () {
	return this.indexEmpty;
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
				new ve.ui.MWReferenceResultWidget( {
					$: this.$,
					data: i,
					label: $citation.add( $name ).add( item.$element )
				} )
			);
		}
	}

	this.results.addItems( items );
};
