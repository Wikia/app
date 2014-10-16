/*!
 * VisualEditor ContentEditable View class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/**
 * Generic base class for CE views.
 *
 * @abstract
 * @extends OO.ui.Element
 * @mixins OO.EventEmitter
 *
 * @constructor
 * @param {ve.dm.Model} model Model to observe
 * @param {Object} [config] Configuration options
 */
ve.ce.View = function VeCeView( model, config ) {
	// Setting this property before calling the parent constructor allows overriden #getTagName
	// methods in view classes to have access to the model when they are called for the first time
	// inside of OO.ui.Element
	this.model = model;

	// Parent constructor
	OO.ui.Element.call( this, config );

	// Mixin constructors
	OO.EventEmitter.call( this );

	// Properties
	this.live = false;

	// Events
	this.connect( this, {
		'setup': 'onSetup',
		'teardown': 'onTeardown'
	} );

	// Initialization
	this.renderAttributes();
};

/* Inheritance */

OO.inheritClass( ve.ce.View, OO.ui.Element );

OO.mixinClass( ve.ce.View, OO.EventEmitter );

/* Events */

/**
 * @event live
 * @param {boolean} live The view is being set live
 */

/**
 * @event setup
 */

/**
 * @event teardown
 */

/* Static members */

/**
 * Allowed attributes for DOM elements, in the same format as ve.dm.Model#storeHtmlAttributes
 *
 * This list includes attributes that are generally safe to include in HTML loaded from a
 * foreign source and displaying it inside the browser. It doesn't include any event attributes,
 * for instance, which would allow arbitrary JavaScript execution. This alone is not enough to
 * make HTML safe to display, but it helps.
 *
 * TODO: Rather than use a single global list, set these on a per-view basis to something that makes
 * sense for that view in particular.
 *
 * @static
 * @property {boolean|string|RegExp|Array|Object}
 * @inheritable
 */
ve.ce.View.static.renderHtmlAttributes = [
	'abbr', 'about', 'align', 'alt', 'axis', 'bgcolor', 'border', 'cellpadding', 'cellspacing',
	'char', 'charoff', 'cite', 'class', 'clear', 'color', 'colspan', 'datatype', 'datetime',
	'dir', 'face', 'frame', 'headers', 'height', 'href', 'id', 'itemid', 'itemprop', 'itemref',
	'itemscope', 'itemtype', 'lang', 'noshade', 'nowrap', 'property', 'rbspan', 'rel',
	'resource', 'rev', 'rowspan', 'rules', 'scope', 'size', 'span', 'src', 'start', 'style',
	'summary', 'title', 'type', 'typeof', 'valign', 'value', 'width'
];

/* Methods */

/**
 * Get an HTML document from the model, to use for URL resolution.
 *
 * The default implementation returns null; subclasses should override this if they can provide
 * a resolution document.
 *
 * @see #getResolvedAttribute
 * @returns {HTMLDocument|null} HTML document to use for resolution, or null if not available
 */
ve.ce.View.prototype.getModelHtmlDocument = function () {
	return null;
};

/**
 * Handle setup event.
 *
 * @method
 */
ve.ce.View.prototype.onSetup = function () {
	this.$element.data( 'view', this );
};

/**
 * Handle teardown event.
 *
 * @method
 */
ve.ce.View.prototype.onTeardown = function () {
	this.$element.removeData( 'view' );
};

/**
 * Get the model the view observes.
 *
 * @method
 * @returns {ve.dm.Model} Model the view observes
 */
ve.ce.View.prototype.getModel = function () {
	return this.model;
};

/**
 * Check if the view is attached to the live DOM.
 *
 * @method
 * @returns {boolean} View is attached to the live DOM
 */
ve.ce.View.prototype.isLive = function () {
	return this.live;
};

/**
 * Set live state.
 *
 * @method
 * @param {boolean} live The view has been attached to the live DOM (use false on detach)
 * @fires live
 * @fires setup
 * @fires teardown
 */
ve.ce.View.prototype.setLive = function ( live ) {
	this.live = live;
	this.emit( 'live', this.live );
	if ( this.live ) {
		this.emit( 'setup' );
	} else {
		this.emit( 'teardown' );
	}
};

/**
 * Render an HTML attribute list onto this.$element
 *
 * If no attributeList is given, the attribute list stored in the linear model will be used.
 *
 * @param {Object[]} [attributeList] HTML attribute list, see ve.dm.Converter#buildHtmlAttributeList
 */
ve.ce.View.prototype.renderAttributes = function ( attributeList ) {
	ve.dm.Converter.renderHtmlAttributeList(
		attributeList || this.model.getHtmlAttributes(),
		this.$element,
		this.constructor.static.renderHtmlAttributes,
		true // computed attributes
	);
};

/**
 * Get a resolved URL from a model attribute.
 *
 * @abstract
 * @method
 * @param {string} key Attribute name whose value is a URL
 * @returns {string} URL resolved according to the document's base
 */
ve.ce.View.prototype.getResolvedAttribute = function ( key ) {
	var plainValue = this.model.getAttribute( key ),
		doc = this.getModelHtmlDocument();
	return doc && typeof plainValue === 'string' ? ve.resolveUrl( plainValue, doc ) : plainValue;
};
