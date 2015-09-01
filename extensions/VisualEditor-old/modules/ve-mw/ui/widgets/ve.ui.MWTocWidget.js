/*!
 * VisualEditor UserInterface MWTocWidget class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Creates a ve.ui.MWTocWidget object.
 *
 * @class
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {ve.ui.Surface} surface
 * @param {Object} [config] Configuration options
 */
ve.ui.MWTocWidget = function VeUiMWTocWidget( surface, config ) {
	// Parent constructor
	OO.ui.Widget.call( this, config );

	// Properties
	this.surface = surface;
	this.doc = surface.getModel().getDocument();
	this.metaList = surface.getModel().metaList;
	// Topic level 0 lives inside of a toc item
	this.topics = new ve.ui.MWTocItemWidget();
	// Place for a cloned previous toc to live while rebuilding.
	this.$tempTopics = this.$( '<ul>' );
	// Section keyed item map
	this.items = {};
	this.initialized = false;
	// Page settings cache
	this.mwTOCForce = false;
	this.mwTOCDisable = false;

	// TODO: fix i18n
	this.toggle = {
		hideMsg: ve.msg( 'hidetoc' ),
		showMsg: ve.msg( 'showtoc' ),
		$link: this.$( '<a class="internal" id="togglelink"></a>' ).text( ve.msg( 'hidetoc' ) ),
		open: true
	};
	this.$element.addClass( 'toc ve-ui-mwTocWidget' ).append(
		this.$( '<div>' ).attr( 'id', 'toctitle' ).append(
			this.$( '<h2>' ).text( ve.msg( 'toc' ) ),
			this.$( '<span>' ).addClass( 'toctoggle' ).append( this.toggle.$link )
		),
		this.topics.$group, this.$tempTopics
	);
	// Place in bodyContent element, which is close to where the TOC normally lives in the dom
	// Integration ignores hiding the TOC widget, though continues to hide the real page TOC
	$( '#bodyContent' ).append( this.$element );

	this.toggle.$link.on( 'click', function () {
		if ( this.toggle.open ) {
			this.toggle.$link.text( this.toggle.showMsg );
			this.toggle.open = false;
		} else {
			this.toggle.$link.text( this.toggle.hideMsg );
			this.toggle.open = true;
		}
		this.topics.$group.add( this.$tempTopics ).slideToggle();
	}.bind( this ) );

	this.metaList.connect( this, {
		insert: 'onMetaListInsert',
		remove: 'onMetaListRemove'
	} );

	this.initFromMetaList();
	this.build();
};

/* Inheritance */

OO.inheritClass( ve.ui.MWTocWidget, OO.ui.Widget );

/**
 * Bound to MetaList insert event to set TOC display options
 *
 * @param {ve.dm.MetaItem} metaItem
 */
 ve.ui.MWTocWidget.prototype.onMetaListInsert = function ( metaItem ) {
	// Responsible for adding UI components
	if ( metaItem instanceof ve.dm.MWTOCForceMetaItem ) {
		// show
		this.mwTOCForce = true;
	} else if ( metaItem instanceof ve.dm.MWTOCDisableMetaItem ) {
		// hide
		this.mwTOCDisable = true;
	}
	this.hideOrShow();
};

/**
 * Bound to MetaList insert event to set TOC display options
 *
 * @param {ve.dm.MetaItem} metaItem
 */
ve.ui.MWTocWidget.prototype.onMetaListRemove = function ( metaItem ) {
	if ( metaItem instanceof ve.dm.MWTOCForceMetaItem ) {
		this.mwTOCForce = false;
	} else if ( metaItem instanceof ve.dm.MWTOCDisableMetaItem ) {
		this.mwTOCDisable = false;
	}
	this.hideOrShow();
};

/**
 * Initialize TOC based on the presense of magic words
 */
ve.ui.MWTocWidget.prototype.initFromMetaList = function () {
	var i = 0,
		items = this.metaList.getItemsInGroup( 'mwTOC' ),
		len = items.length;
	if ( len > 0 ) {
		for ( ; i < len; i++ ) {
			if ( items[i] instanceof ve.dm.MWTOCForceMetaItem ) {
				this.mwTOCForce = true;
			}
			// Needs testing
			if ( items[i] instanceof ve.dm.MWTOCDisableMetaItem ) {
				this.mwTOCDisable = true;
			}
		}
		this.hideOrShow();
	}
};

/**
 * Hides or shows the TOC based on page and default settings
 */
ve.ui.MWTocWidget.prototype.hideOrShow = function () {
	// In MediaWiki if __FORCETOC__ is anywhere TOC is always displayed
	// ... Even if there is a __NOTOC__ in the article
	if ( !this.mwTOCDisable && ( this.mwTOCForce || this.topics.items.length >= 3 ) ) {
		this.$element.show();
	} else {
		this.$element.hide();
	}
};

/**
 * Rebuild TOC on ve.ce.MWHeadingNode teardown or setup
 * Rebuilds on both teardown and setup of a node, so rebuild is debounced
 */
ve.ui.MWTocWidget.prototype.rebuild = ve.debounce( function () {
	// Only rebuild when initialized
	if ( this.surface.mwTocWidget.initialized ) {
		this.$tempTopics.append( this.topics.$group.children().clone() );
		this.teardownItems();
		// Build after transactions
		setTimeout( function () {
			this.build();
			this.$tempTopics.empty();
		}.bind( this ), 0 );
	}
}, 0 );

/**
 * Teardown all of the TOC items
 */
ve.ui.MWTocWidget.prototype.teardownItems = function () {
	var item;
	for ( item in this.items ) {
		this.items[item].remove();
		delete this.items[item];
	}
	this.items = {};
};

/**
 * Teardown the widget and remove it from the dom
 */
ve.ui.MWTocWidget.prototype.teardown = function () {
	this.teardownItems();
	this.$element.remove();
};

/**
 * Build TOC from mwHeading dm nodes
 */
ve.ui.MWTocWidget.prototype.build = function () {
	var nodes = this.doc.selectNodes( new ve.Range( 0, this.doc.getDocumentNode().getLength() ), 'leaves' ),
		i = 0,
		headingLevel = 0,
		previousHeadingNode = null,
		previousHeadingLevel = 0,
		parentHeadingLevel = 0,
		levelSkipped = false,
		tocNumber = 0,
		tocLevel = 0,
		tocSection = 0,
		tocIndex = 0,
		sectionPrefix = [],
		parentSectionArray,
		key,
		parent,
		config,
		headingOuterRange,
		ceNode;
	for ( ; i < nodes.length; i++ ) {
		if ( nodes[i].node.parent === previousHeadingNode ) {
			// Duplicate heading
			continue;
		}
		if ( nodes[i].node.parent.getType() === 'mwHeading' ) {
			tocIndex++;
			headingLevel = nodes[i].node.parent.getAttribute( 'level' );
			// MW TOC Generation
			// The first heading will always be be a zero level topic, even heading levels > 2
			// If heading level is 1 then it is definitely a zero level topic
			// If heading level is 2 then it is a zero level topic, unless a child of a 1 level
			// If heading went up and skipped a number, the following headings of the skipped number are in the same level
			if ( this.topics.items.length === 0 || headingLevel === 1 || ( headingLevel === 2 && parentHeadingLevel !== 1 ) ) {
				tocSection++;
				sectionPrefix = [ tocSection ];
				tocLevel = 0;
				// reset t
				levelSkipped = false;
				parent = this.topics;
				parentHeadingLevel = headingLevel;
			} else {
				// If previously skipped a level, place this heading in the same level as the previous higher one
				if ( headingLevel === previousHeadingLevel || headingLevel < previousHeadingLevel && levelSkipped ) {
					tocNumber++;
					sectionPrefix.pop();
					sectionPrefix.push( tocNumber );
					// Only remove the flag if the heading level has dropped but we skipped to a higher number previously
					if ( headingLevel < previousHeadingLevel ) {
						levelSkipped = false;
					}
				} else {
					tocNumber = 1;
					// Heading not the same as before
					if ( headingLevel > previousHeadingLevel ) {
						// Did we skip a level? Flag in case we drop down a number
						if ( headingLevel - previousHeadingLevel > 1 ) {
							levelSkipped = true;
						}
						tocLevel++;
						sectionPrefix.push( tocNumber );
					// Step to lower level unless we are at 1
					} else if ( headingLevel < previousHeadingLevel && tocLevel !== 1 ) {
						tocLevel--;
						sectionPrefix.pop();
						tocNumber = sectionPrefix[sectionPrefix.length - 1] + 1;
						sectionPrefix.pop();
						sectionPrefix.push( tocNumber );
					}
				}
			}
			// Determine parent
			parentSectionArray = sectionPrefix.slice( 0 );
			parentSectionArray.pop();
			if ( parentSectionArray.length > 0 ) {
				key = parentSectionArray.join( '.' );
				parent = this.items[key];
			} else {
				// Topic level is zero
				parent = this.topics;
			}
			// TODO: Cleanup config generation, merge local vars into config object
			// Get CE node for the heading
			headingOuterRange = nodes[i].nodeOuterRange;
			ceNode = this.surface.getView().getDocument().getBranchNodeFromOffset( headingOuterRange.end );
			config = {
				node: ceNode,
				tocIndex: tocIndex,
				parent: parent,
				tocLevel: tocLevel,
				tocSection: tocSection,
				sectionPrefix: sectionPrefix.join( '.' ),
				insertIndex: sectionPrefix[sectionPrefix.length - 1]
			};
			// Add item
			this.items[sectionPrefix.join( '.' )] = new ve.ui.MWTocItemWidget( config );
			config.parent.addItems( [this.items[sectionPrefix.join( '.' )]], config.insertIndex );
			previousHeadingLevel = headingLevel;
			previousHeadingNode = nodes[i].node.parent;
		}
	}
	this.initialized = true;
	this.hideOrShow();
};
