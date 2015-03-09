/*!
 * VisualEditor DataModel MWReferenceModel class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * MediaWiki reference model.
 *
 * @class
 * @mixins OO.EventEmitter
 *
 * @constructor
 */
ve.dm.MWReferenceModel = function VeDmMWReferenceModel() {
	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.listKey = '';
	this.listGroup = '';
	this.listIndex = null;
	this.group = '';
	this.doc = null;
	this.deferDoc = null;
	this.dir = null;
	this.lang = null;
};

/* Inheritance */

OO.mixinClass( ve.dm.MWReferenceModel, OO.EventEmitter );

/* Static Methods */

/**
 * Create a reference model from a reference internal item.
 *
 * @param {ve.dm.MWReferenceNode} node Reference node
 * @return {ve.dm.MWReferenceModel} Reference model
 */
ve.dm.MWReferenceModel.static.newFromReferenceNode = function ( node ) {
	var doc = node.getDocument(),
		internalList = doc.getInternalList(),
		attr = node.getAttributes(),
		ref = new ve.dm.MWReferenceModel();

	ref.setListKey( attr.listKey );
	ref.setListGroup( attr.listGroup );
	ref.setListIndex( attr.listIndex );
	ref.setGroup( attr.refGroup );
	ref.setDir( doc.getDir() );
	ref.setLang( doc.getLang() );
	ref.deferDoc = function () {
		// cloneFromRange is very expensive, so lazy evaluate it
		return doc.cloneFromRange( internalList.getItemNode( attr.listIndex ).getRange() );
	};

	return ref;
};

/* Methods */

/**
 * Find matching item in a surface.
 *
 * @param {ve.dm.Surface} surfaceModel Surface reference is in
 * @returns {ve.dm.InternalItemNode|null} Internal reference item, null if none exists
 */
ve.dm.MWReferenceModel.prototype.findInternalItem = function ( surfaceModel ) {
	if ( this.listIndex !== null ) {
		return surfaceModel.getDocument().getInternalList().getItemNode( this.listIndex );
	}
	return null;
};

/**
 * Insert reference internal item into a surface.
 *
 * If the internal item for this reference doesn't exist, use this method to create one.
 * The inserted reference is empty and auto-numbered.
 *
 * @param {ve.dm.Surface} surfaceModel Surface model of main document
 */
ve.dm.MWReferenceModel.prototype.insertInternalItem = function ( surfaceModel ) {
	// Create new internal item
	var item,
		doc = surfaceModel.getDocument(),
		internalList = doc.getInternalList();

	// Fill in data
	this.setListKey( 'auto/' + internalList.getNextUniqueNumber() );
	this.setListGroup( 'mwReference/' + this.group );

	// Insert internal reference item into document
	item = internalList.getItemInsertion( this.listGroup, this.listKey, [] );
	surfaceModel.change( item.transaction );
	this.setListIndex( item.index );

	// Inject reference document into internal reference item
	surfaceModel.change(
		ve.dm.Transaction.newFromDocumentInsertion(
			doc,
			internalList.getItemNode( item.index ).getRange().start,
			this.getDocument()
		)
	);
};

/**
 * Update an internal reference item.
 *
 * An internal item for the reference will be created if no `ref` argument is given.
 *
 * @param {ve.dm.Surface} surfaceModel Surface model of main document
 */
ve.dm.MWReferenceModel.prototype.updateInternalItem = function ( surfaceModel ) {
	var i, len, txs, group, refNodes, keyIndex, itemNodeRange,
		doc = surfaceModel.getDocument(),
		internalList = doc.getInternalList(),
		listGroup = 'mwReference/' + this.group;

	// Group/key has changed
	if ( this.listGroup !== listGroup ) {
		// Get all reference nodes with the same group and key
		group = internalList.getNodeGroup( this.listGroup );
		refNodes = group.keyedNodes[this.listKey] ?
			group.keyedNodes[this.listKey].slice() :
			[ group.firstNodes[this.listIndex] ];
		// Check for name collision when moving items between groups
		keyIndex = internalList.getKeyIndex( this.listGroup, this.listKey );
		if ( keyIndex !== undefined ) {
			// Resolve name collision by generating a new list key
			this.listKey = 'auto/' + internalList.getNextUniqueNumber();
		}
		// Update the group name of all references nodes with the same group and key
		txs = [];
		for ( i = 0, len = refNodes.length; i < len; i++ ) {
			// HACK: Removing and re-inserting nodes to/from the internal list is done
			// because internal list doesn't yet support attribute changes
			refNodes[i].removeFromInternalList();
			txs.push( ve.dm.Transaction.newFromAttributeChanges(
				doc,
				refNodes[i].getOuterRange().start,
				{ refGroup: this.group, listGroup: listGroup }
			) );
		}
		surfaceModel.change( txs );
		// HACK: Same as above, internal list issues
		for ( i = 0, len = refNodes.length; i < len; i++ ) {
			refNodes[i].addToInternalList();
		}
		this.listGroup = listGroup;
	}
	// Update internal node content
	itemNodeRange = internalList.getItemNode( this.listIndex ).getRange();
	surfaceModel.change( ve.dm.Transaction.newFromRemoval( doc, itemNodeRange, true ) );
	surfaceModel.change(
		ve.dm.Transaction.newFromDocumentInsertion( doc, itemNodeRange.start, this.getDocument() )
	);
};

/**
 * Insert reference at the end of a surface fragment.
 *
 * @param {ve.dm.SurfaceFragment} surfaceModel Surface fragment to insert at
 */
ve.dm.MWReferenceModel.prototype.insertReferenceNode = function ( surfaceFragment ) {
	surfaceFragment
		.insertContent( [
			{
				type: 'mwReference',
				attributes: {
					listKey: this.listKey,
					listGroup: this.listGroup,
					listIndex: this.listIndex,
					refGroup: this.group
				}
			},
			{ type: '/mwReference' }
		] );
};

/**
 * Get the key of a reference in the references list.
 *
 * @returns {string} Reference's list key
 */
ve.dm.MWReferenceModel.prototype.getListKey = function () {
	return this.listKey;
};

/**
 * Get the name of the group a references list is in.
 *
 * @returns {string} References list's group
 */
ve.dm.MWReferenceModel.prototype.getListGroup = function () {
	return this.listGroup;
};

/**
 * Get the index of reference in the references list.
 *
 * @returns {string} Reference's index
 */
ve.dm.MWReferenceModel.prototype.getListIndex = function () {
	return this.listIndex;
};

/**
 * Get the name of the group a reference is in.
 *
 * @returns {string} Reference's group
 */
ve.dm.MWReferenceModel.prototype.getGroup = function () {
	return this.group;
};

/**
 * Get reference document.
 *
 * Auto-generates a blank document if no document exists.
 *
 * @returns {ve.dm.Document} Reference document
 */
ve.dm.MWReferenceModel.prototype.getDocument = function () {
	if ( !this.doc ) {
		if ( this.deferDoc ) {
			this.doc = this.deferDoc();
		} else {
			this.doc = new ve.dm.Document( [
				{ type: 'paragraph', internal: { generated: 'wrapper' } },
				{ type: '/paragraph' },
				{ type: 'internalList' },
				{ type: '/internalList' }
			],
			/* htmlDocument */ null,
			/* parentDocument */ null,
			/* internalList */ null,
			/* innerWhitespace */ null,
			/* lang */ this.getLang(),
			/* dir */ this.getDir() );
		}
	}
	return this.doc;
};

/**
 * Set the directionality of the reference document
 * @param {string} dir Document directionality
 */
ve.dm.MWReferenceModel.prototype.setDir = function ( dir ) {
	this.dir = dir;
};

/**
 * Get the directionality of the reference document
 * @returns {string} Document directionality
 */
ve.dm.MWReferenceModel.prototype.getDir = function () {
	return this.dir;
};

/**
 * Set the language of the reference document
 * @param {string} lang Document language
 */
ve.dm.MWReferenceModel.prototype.setLang = function ( lang ) {
	this.lang = lang;
};

/**
 * Get the language of the reference document
 * @returns {string} Document language
 */
ve.dm.MWReferenceModel.prototype.getLang = function () {
	return this.lang;
};

/**
 * Set key of reference in list.
 *
 * @param {string} Reference's list key
 */
ve.dm.MWReferenceModel.prototype.setListKey = function ( listKey ) {
	this.listKey = listKey;
};

/**
 * Set name of the group a references list is in.
 *
 * @param {string} References list's group
 */
ve.dm.MWReferenceModel.prototype.setListGroup = function ( listGroup ) {
	this.listGroup = listGroup;
};

/**
 * Set the index of reference in list.
 *
 * @param {string} Reference's list index
 */
ve.dm.MWReferenceModel.prototype.setListIndex = function ( listIndex ) {
	this.listIndex = listIndex;
};

/**
 * Set the name of the group a reference is in.
 *
 * @param {string} group Reference's group
 */
ve.dm.MWReferenceModel.prototype.setGroup = function ( group ) {
	this.group = group;
};

/**
 * Set the reference document.
 *
 * @param {ve.dm.Document} Reference document
 */
ve.dm.MWReferenceModel.prototype.setDocument = function ( doc ) {
	this.doc = doc;
};
