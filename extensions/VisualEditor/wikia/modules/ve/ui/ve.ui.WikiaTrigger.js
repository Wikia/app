/*!
 * VisualEditor UserInterface Trigger class.
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

/*global mw */

/**
 * Key trigger.
 *
 * @class
 *
 * @constructor
 * @param {jQuery.Event|string} [e] Event or string to create trigger from
 * @param {boolean} [allowInvalidPrimary] Allow invalid primary keys
 *
 * @extends ve.ui.Trigger
 */
ve.ui.WikiaTrigger = function VeUiWikiaTrigger( e, allowInvalidPrimary ) {
	// Parent constructor
	ve.ui.WikiaTrigger.super.call( this, e, allowInvalidPrimary );
};

/* Inheritance */

OO.inheritClass( ve.ui.WikiaTrigger, ve.ui.Trigger );

/* Static Properties */

ve.ui.WikiaTrigger.static.accessKeyPrefix = mw.util.tooltipAccessKeyPrefix.replace( /-/g, ' + ' );
